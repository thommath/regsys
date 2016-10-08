<?php
  require_once("components/charts/index.php");

  $monthChange = 0;

  if(isset($_GET['month'])){
    $monthChange = $_GET['month'];
  }
  $data = $_SESSION['data'];
//  $totalMonthIncomeData = getTotalIncome($monthIncome);
//  $totalMonthUsageData = getTotalUsage($monthUsage);
//  $stack = getStack($categories);
//  var_dump($categories);
?>

<section>
  <section class="nav-month">
    <a href="<?php echo "?p=dashboard&month=" . (intval($monthChange)-1);?>"><span class="glyphicon glyphicon-arrow-left btn-lg" aria-hidden="true"></span></a>
    <h3 class="center-block"><?php echo monthToString($monthChange);?></h3>
    <a href="<?php echo "?p=dashboard&month=" . (intval($monthChange)+1);?>"><span class="glyphicon glyphicon-arrow-right btn-lg" aria-hidden="true"></span></a>
  </section>

  <canvas id="doubleChart"></canvas>
  <canvas id="yearChart"></canvas>
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

//var usageChartElement = document.getElementById("usageChart");
//var incomeChartElement = document.getElementById("incomeChart");
var yearChartElement = document.getElementById("yearChart");
var doubleChartElement = document.getElementById("doubleChart");

//Year

<?php
  $diff = [];
  foreach($data['month'] as $key => $value){
    array_push($diff, intval($value['income'])-intval($value['usage']));
  }

?>

<?php if($data[month] != null):?>
var yearChart = new Chart(yearChartElement, {
    type: 'line',
    data: {
        labels: <?php echo arrayToStringKey($data['month'], true);?>,
        datasets: [
          {
            label: ["usage"],
            data: <?php echo arrayToStringWithKey($data['month'], 'usage', false);?>,
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: "#00f",
            borderWidth: 1
          } ,{
            label: ["income"],
            data: <?php echo arrayToStringWithKey($data['month'], 'income', false);?>,
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: "#f00",
            borderWidth: 1
          } ,{
            label: ["Difference"],
            data: <?php echo arrayToString($diff, false);?>,
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: "#000",
            borderWidth: 1
          }
      ]
    },
    options: options
});
<?php endif;?>

//Month
<?php if(sanitizeUsageTwo($data['month'][calculateMonth($monthChange)]['categories'], 'income', 'usage') != null):?>
var doubleChart = new Chart(doubleChartElement, {
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


</script>
