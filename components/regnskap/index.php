<?php
  $conn = getConnection();

  $dateWidth = "8%";
  $totalWidth = "8%";

  $monthChange = 0;

  if(isset($_GET['month'])){
    $monthChange = $_GET['month'];
  }
  $month = calculateMonth($monthChange);

  //Round month down and up
  $data = $_SESSION['data'];
  $width = 84/count($data['categories']) . "%";
?>


<section id="regnskap">
  <section class="nav-month">
    <a href="<?php echo "?p=regnskap&month=" . (intval($monthChange)-1);?>"><span class="glyphicon glyphicon-arrow-left btn-lg" aria-hidden="true"></span></a>
    <h3 class="center-block"><?php echo monthToString($monthChange);?></h3>
    <a href="<?php echo "?p=regnskap&month=" . (intval($monthChange)+1);?>"><span class="glyphicon glyphicon-arrow-right btn-lg" aria-hidden="true"></span></a>
  </section>

  <table class="table table-striped table-bordered">
    <?php if(isset($data['month'][$month])):?>
    <!--Table header Printing all categories-->
      <tr>
        <th width="<?php echo $dateWidth;?>">Date</th>
        <?php foreach ($data['categories'] as $key => $value):?>
          <th width="<?php echo $width;?>">
            <?php echo $value['name'];?>
          </th>
        <?php endforeach;?>
        <th width="<?php echo $totalWidth;?>">Total</th>
      </tr>

      <!--Optional first row with total from last month-->
      <?php if($data['settings']['keepTotal'] == 1 && isset($data['month'][changeMonth($month, -1)]['total'])):?>
        <tr>
          <td width="<?php echo $width;?>"></td>
          <?php foreach ($data['categories'] as $category => $categoryValue):?>
            <td width="<?php echo $width;?>"></td>
          <?php endforeach;?>
          <?php $sum = $data['month'][changeMonth($month, -1)]['total'];?>
          <td width="<?php echo $width;?>" class="masterTooltip <?php if($sum < 0){echo "negative";}?>"
            title="Total from last month">
            <?php echo $sum;?>
          </td>
        </tr>
      <?php endif;?>


      <!--Table row Printing all bills-->
        <?php foreach ($data['month'][$month]['bills'] as $key => $billValue): ?>
          <tr data-toggle="modal" data-target="#regnskapModal"
                                                               data-date="<?php echo $billValue['date'];?>"
                                                               data-desc="<?php echo $billValue['description'];?>"
                                                               data-sum="<?php echo $billValue['sum'];?>"
                                                               data-category="<?php echo getCategoryFromId($data, $billValue['category'])['name'];?>"
                                                               data-categoryid="<?php echo getCategoryFromId($data, $billValue['category'])['id'];?>"
                                                               data-billid="<?php echo $billValue['id'];?>">
            <td width="<?php echo $dateWidth;?>">
              <?php echo date('d.M', strtotime($billValue['date']));?>
            </td>
            <?php foreach ($data['categories'] as $category => $categoryValue):?>

              <?php if($billValue['category'] == $categoryValue['id']):?>
                <td width="<?php echo $width;?>" class="masterTooltip <?php if($billValue['sum'] < 0){echo "negative";}?>"
                                                                     title="<?php echo $billValue['description'];?>">
                  <?php echo $billValue['sum'];?>
                </td>
              <?php else : ;?>
              <td width="<?php echo $width;?>"></td>
              <?php endif;?>

            <?php endforeach;?>
            <td width="<?php echo $totalWidth;?>"></td>
          </tr>
        <?php endforeach; ?>

      <!--Table row Printing all totals-->
      <tr>
        <th width="<?php echo $dateWidth;?>">Sum</th>
        <?php
        $total = $data['month'][$month]['total'];

        foreach ($data['month'][$month]['categories'] as $category => $value):
          $sum = $value['total'];?>
          <th width="<?php echo $wdth;?>"<?php if($sum < 0){echo " class=\"negative\"";}?>>
            <?php echo $sum;?>
          </th>
        <?php endforeach;?>
        <th width="<?php echo $totalWidth;?>"<?php if($data['month'][$month]['total'] < 0){echo " class=\"negative\"";}?>>
          <?php echo $total;?>
        </th>
      </tr>

    <?php else: ?>
      <p>
        You have no bills for this month
      </p>
    <?php endif;?>
  </table>
</section>

<script type="text/javascript">
$(document).ready(function() {
// Tooltip only Text
$('.masterTooltip').hover(function(){
        // Hover over code
        var title = $(this).attr('title');
        $(this).data('tipText', title).removeAttr('title');
        $('<p class="desc"></p>')
        .text(title)
        .appendTo('body')
        .fadeIn('slow');
}, function() {
        // Hover out code
        $(this).attr('title', $(this).data('tipText'));
        $('.desc').remove();
}).mousemove(function(e) {
        var mousex = e.pageX + 20; //Get X coordinates
        var mousey = e.pageY + 10; //Get Y coordinates
        $('.desc')
        .css({ top: mousey, left: mousex })
});
});
</script>
