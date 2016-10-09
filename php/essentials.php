<?php
require_once("login.php");


function setupData(){
  $conn = getConnection();

  //settings
  $settingsQuerry = $conn->query("SELECT * FROM Settings WHERE id=" . $_SESSION['user']);
  $settings;
  if($settingsQuerry->num_rows >= 1){
    $settings = $settingsQuerry->fetch_assoc();
  }else{
    $conn->query("INSERT INTO `Settings`(`user`) VALUES (" . $user['id'] . ")");
    $settings = $conn->query("SELECT * FROM Settings WHERE id=" . $_SESSION['user'])->fetch_assoc();
  }


  //Categories
  $colors = [["rgba(88, 43, 0, 0.2)", "rgba(88, 43, 0, 1)"],
            ["rgba(194, 0, 132, 0.2)", "rgba(194, 0, 132, 1)"],
            ["rgba(0, 255, 164, 0.2)", "rgba(0, 255, 164, 1)"],
            ["rgba(0, 23, 232, 0.2)", "rgba(0, 23, 232, 1)"],
            ["rgba(206, 245, 0, 0.2)", "rgba(206, 245, 0, 1)"],
            ["rgba(88, 0, 2, 0.2)", "rgba(88, 0, 2, 1)"],
            ["rgba(50, 0, 194, 0.2)", "rgba(50, 0, 194, 1)"],
            ["rgba(97, 255, 0, 0.2)", "rgba(97, 255, 0, 1)"],
            ["rgba(0, 229, 232, 0.2)", "rgba(0, 229, 232, 1)"],
            ["rgba(245, 173, 0, 0.2)", "rgba(245, 173, 0, 1)"]];


  $categoriesQuery = $conn->query("SELECT * FROM Category WHERE `user`=" . $_SESSION['user']);
  $categories = [];
  if($categoriesQuery->num_rows >= 1){
    $i = 0;
    while($row = $categoriesQuery->fetch_assoc()){
      $categories[$row['id']] = $row;
      $categories[$row['id']]['value'] = 0;
      $categories[$row['id']]['colors'] = $colors[$i];
      $i++;
    }
    unset($i);
  }

  //Bills
  $billsResult = $conn->query("SELECT * FROM Bill WHERE `user`=" . $_SESSION['user'] . " ORDER BY date ASC");
  $bills = [];
  $month = [];
  $data['usage'] = 0;
  $data['income'] = 0;
  $data['sum'] = 0;
  $startCategories = $categories;

  if($billsResult->num_rows >= 1){
    while($row = $billsResult->fetch_assoc()){
      //Find out what month it belogs to
      if(intval(substr($row['date'], 8, 9)) < $settings['startDay']){
        $date = changeMonth($row['date'], 0);
      }else{
        $date = changeMonth($row['date'], 1);
      }
      //If doesn't exist, make it
      if(!isset($month[$date])){
        $month[$date]['bills'] = [];
        $month[$date]['categories'] = $startCategories;
      }
      //Add it to month
      array_push($month[$date]['bills'], $row);


      //find highest Voucher
      $data['voucher'] = max($row['voucher'], $data['voucher']);

      //sum usage and income
      $data['usage'] += max(-$row['sum'], 0);
      $data['income'] += max($row['sum'], 0);
      $data['sum'] += $row['sum'];

      $categories[$row['category']]['usage'] += max(-$row['sum'], 0);
      $categories[$row['category']]['income'] += max($row['sum'], 0);

      $month[$date]['usage'] += max(-$row['sum'], 0);
      $month[$date]['income'] += max($row['sum'], 0);
      $month[$date]['categories'][$row['category']]['usage'] += max(-$row['sum'], 0);
      $month[$date]['categories'][$row['category']]['income'] += max($row['sum'], 0);
    }
  }
  /*
  Also exiastant:
  $data['usage'];
  $data['income'];
  $data['sum'];
  */
  $data['categories'] = $categories;
  $data['month'] = $month;
  $data['settings'] = $settings;
  $_SESSION['data'] = $data;
}

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function getMonthStart(){
  return $_SESSION['data']['settings']['startDay'];
}

function changeMonth($date, $monthChange){
  $month['m'] = (intval(substr($date, 5, 6))+intval($monthChange)+(12*1000))%12;
  if($month['m'] < 10){
    $month['m'] = '0' . $month['m'];
  }
  $month['Y'] = intval(substr($date, 0, 4))+floor((intval(substr($date, 5, 6))+intval($monthChange)+12)/12)-1;
  return $month['Y'] . "-" . $month['m'];
}

function calculateMonth($monthChange){
    $month['m'] = (intval(date("m"))+intval($monthChange)+12*1000)%12;
    if($month['m'] < 10){
      $month['m'] = '0' . $month['m'];
    }
    $month['Y'] = intval(date('Y'))+floor((intval(date("m"))+intval($monthChange)+12)/12)-1;
    return $month['Y'] . "-" . $month['m'];
}


function monthToString($monthChange){
  $names = ["January" , "February" , "March" , "April", "May",
        "June", "July", "August", "September", "October",
        "November", "December"];
  if(getMonthStart() == 1){
    return $names[intval(date("m"))+intval($monthChange)-1];
  }else {
    return substr($names[(intval(date("m"))+intval($monthChange)-2+12*1000)%12], 0, 3) . "/" . substr($names[(intval(date("m"))+intval($monthChange)-1+12*1000)%12], 0, 3);
  }
}

function arrayToString($arr, $isString){
  if(count($arr) == 0){
    return "[]";
  }
  $str = "[";
  foreach ($arr as $key => $value) {
    if($isString){
      $str .= "\"";
    }
    if($value == Null){
      $value = 0;
    }
    $str .= $value;
    if($isString){
      $str .= "\"";
    }
    $str .= ", ";
  }
  return substr($str, 0, count($str)-3) . "]";
}

function arrayKeyToString($arr, $isString){
  if(count($arr) == 0){
    return "[]";
  }
  $str = "[";
  foreach ($arr as $key => $value) {
    if($isString){
      $str .= "\"";
    }
    if($key == Null){
      $value = 0;
    }
    $str .= $key;
    if($isString){
      $str .= "\"";
    }
    $str .= ", ";
  }
  return substr($str, 0, count($str)-3) . "]";
}

function arrayToStringWithKey($arr, $inKey, $isString){
  if(count($arr) == 0){
    return "[]";
  }

  $str = "[";
  foreach ($arr as $key => $value) {
    if($isString){
      $str .= "\"";
    }
    if($value[$inKey] == Null){
      $value[$inKey] = 0;
    }
    $str .= $value[$inKey];
    if($isString){
      $str .= "\"";
    }
    $str .= ", ";
  }
  return substr($str, 0, count($str)-3) . "]";
}

function getCategoryFromId($data, $id){
  foreach ($data['categories'] as $key => $value) {
    if($value['id'] == $id){
      return $value;
    }
  }
}

?>
