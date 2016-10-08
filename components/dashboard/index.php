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

      <canvas id="doubleChart" width="400" height="400"></canvas>
</section>


<script>
<?php
/*
echo "var usageData = " . html_entity_decode(arrayToStringWithKey(sanitizeUsage($categories, 'usage'), 'usage', false)) . ";";
echo "var usageLabels = " . html_entity_decode(arrayToStringWithKey(sanitizeUsage($categories, 'usage'), 'name', true)) . ";";
echo "var incomeData = " . html_entity_decode(arrayToStringWithKey(sanitizeUsage($categories, 'income'), 'income', false)) . ";";
echo "var incomeLabels = " . html_entity_decode(arrayToStringWithKey(sanitizeUsage($categories, 'income'), 'name', true)) . ";";
*/
?>

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
//var stackChartElement = document.getElementById("stackChart");
var doubleChartElement = document.getElementById("doubleChart");
/*
var usageChart = new Chart(usageChartElement, {
    type: 'bar',
    data: {
        labels: ["Usage"],
        datasets: [
          <?php foreach (sanitizeUsage($data['categories'], 'usage') as $key => $value): ?>
          {
            label: "<? echo html_entity_decode($value['name']);?>",
            data: [<? echo $value['usage'];?>],
            backgroundColor: "<?php echo $value['colors'][0]?>",
            borderColor: "<?php echo $value['colors'][1];?>",
            borderWidth: 1
        } ,
        <?php endforeach; ?>
      ]
    },
    options: options
});

var incomeChart = new Chart(incomeChartElement, {
    type: 'bar',
    data: {
        labels: ["Income"],
        datasets: [
          <?php foreach (sanitizeUsage($data['categories'], 'income') as $key => $value): ?>
          {
            label: "<? echo html_entity_decode($value['name']);?>",
            data: [<? echo $value['income'];?>],
            backgroundColor: "<?php echo $value['colors'][0]?>",
            borderColor: "<?php echo $value['colors'][1];?>",
            borderWidth: 1
        } ,
        <?php endforeach; ?>
      ]
    },
    options: options
});

var stackChart = new Chart(stackChartElement, {
    type: 'bar',
    data: {
        labels: ["Usage", "Income"],
        datasets: [
          <?php foreach ($data['categories'] as $key => $value): ?>
          {
            label: "<? echo html_entity_decode($value['name']);?>",
            data: <? echo arrayToString([$value['usage'], $value['income']], false);?>,
            backgroundColor: "<?php echo $value['colors'][0]?>",
            borderColor: "<?php echo $value['colors'][1];?>",
            borderWidth: 1
        } ,
        <?php endforeach; ?>
      ]
    },
    options: {
        scales: {
            xAxes: [{
                stacked: true
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    beginAtZero:true
                  }
            }]
        }
    }
});
*/
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
