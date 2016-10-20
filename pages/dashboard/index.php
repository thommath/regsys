require_once("components/charts/index.php");
<?php

  $monthChange = 0;

  if(isset($_GET['month'])){
    $monthChange = $_GET['month'];
  }
  $data = $_SESSION['data'];
  $month = calculateMonth($monthChange);

  $showMonth = false;
?>

<section id="dashboard">

  <?php
    echo "Difference: " . ($data['month'][$month]['income']-$data['month'][$month]['usage']) . "<br>";
  //  echo "Difference: " . ($data['month'][$month]['income']-$data['month'][$month]['usage']) . "<br>";
  ?>

  <?php if($showMonth):?>
    <section class="nav-month">
      <a href="?month=<?php echo (intval($monthChange)-1);?>"><span class="glyphicon glyphicon-arrow-left btn-lg" aria-hidden="true"></span></a>
      <h3 class="center-block"><?php echo monthToString($monthChange);?></h3>
      <a href="?month=<?php echo (intval($monthChange)+1);?>"><span class="glyphicon glyphicon-arrow-right btn-lg" aria-hidden="true"></span></a>
    </section>
  <?php endif;?>

</section>


<script>

var options = {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero:true
            }
        }]
    }
  };

//Month
<?php if(sanitizeUsageTwo($data['month'][calculateMonth($monthChange)]['categories'], 'income', 'usage') != null && $showMonth):?>
var monthCanvas = document.createElement('canvas');
monthCanvas.id = "yearChart";
document.getElementById('dashboard').appendChild(monthCanvas);
var doubleChart = new Chart(monthCanvas, {
    type: 'bar',
    data: {
        labels: ["Usage", "Income"],
        datasets: [
          <?php foreach (sanitizeUsageTwo($data['month'][calculateMonth($monthChange)]['categories'], 'income', 'usage') as $key => $value): ?>
          {
            label: ["<?php echo html_entity_decode($value['name']);?>"],
            data: [<?php echo $value['usage'] . ", " . $value['income'];?>],
            backgroundColor: "<?php echo $value['colors'][0]?>",
            borderColor: "<?php echo $value['colors'][1];?>",
            borderWidth: 1
        } ,
        <?php endforeach; ?>
      ]
    },
    options: options
});
<?php endif;?>


//Year
<?php
  $diff = [];
  foreach($data['month'] as $key => $value){
    array_push($diff, intval($value['income'])-intval($value['usage']));
  }

?>

<?php if($data[month] != null):?>
var yearCanvas = document.createElement('canvas');
yearCanvas.id = "yearChart";
document.getElementById('dashboard').appendChild(yearCanvas);
var yearChart = new Chart(yearCanvas, {
    type: 'line',
    data: {
        labels: <?php echo arrayKeyToString($data['month'], true);?>,
        datasets: [
          {
            label: ["usage"],
            data: <?php echo arrayToStringWithKey($data['month'], 'usage', false);?>,
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: "#f00",
            borderWidth: 1
          } ,{
            label: ["income"],
            data: <?php echo arrayToStringWithKey($data['month'], 'income', false);?>,
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: "#0f0",
            borderWidth: 1
          } ,{
            label: ["Difference"],
            data: <?php echo arrayToString($diff, false);?>,
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: "#000",
            borderWidth: 1
          } <?php if($data['settings']['keepTotal'] == 1):?>,{
            label: ["Saldo"],
            data: <?php echo arrayToStringWithKey($data['month'], 'total', false);?>,
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: "#00f",
            borderWidth: 1
          }<?php endif;?>
      ]
    },
    options: options
});
<?php endif;?>

</script>
