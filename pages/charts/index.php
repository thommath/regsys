<?php


function sanitizeUsage($categories, $key){
  foreach ($categories as $category => $value) {
    if($value[$key] == 0){
      unset($categories[$category]);
    }
  }
  return $categories;
}
function sanitizeUsageTwo($categories, $key, $key2){
  foreach ($categories as $category => $value) {
    if($value[$key] == 0 && $value[$key2] == 0){
      unset($categories[$category]);
    }
  }
  return $categories;
}
/*Æ
function getTotalIncome($monthChange){
  $sum = 0;
  $income = getIncome($monthChange);
  foreach ($income as $key => $value) {
    $sum += $value['value'];
  }
  return $sum;
}
function getTotalUsage($monthChange){
  $sum = 0;
  $usage = getUsage($monthChange);
  foreach ($usage as $key => $value) {
    $sum += $value['value'];
  }
  return $sum;
}

function getStack($categories){
  $stack = [];
  foreach ($categories as $key => $value) {
    array_push($stack, [$value['usage'], $value['income']]);
  }
  return $stack;
}
*/
?>
<script src="/js/Chart.js"></script>
