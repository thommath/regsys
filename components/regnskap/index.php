<?php
  $conn = getConnection();

  $dateWidth = "8%";
  $totalWidth = "8%";

  $monthChange = 0;

  if(isset($_GET['month'])){
    $monthChange = $_GET['month'];
  }

  //Round month down and up
  $data = getData();
  $width = 84/count($data['categories']) . "%";
?>


<section id="regnskap">
  <section class="nav-month">
    <a href="<?php echo "?p=regnskap&month=" . (intval($monthChange)-1);?>"><span class="glyphicon glyphicon-arrow-left btn-lg" aria-hidden="true"></span></a>
    <h3 class="center-block"><?php echo monthToString(calculateMonth($monthChange));?></h3>
    <a href="<?php echo "?p=regnskap&month=" . (intval($monthChange)+1);?>"><span class="glyphicon glyphicon-arrow-right btn-lg" aria-hidden="true"></span></a>
  </section>

  <table class="table table-striped table-bordered">
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

      <!--Table row Printing all bills-->
      <?php if(isset($data['month'][calculateMonth($monthChange)])):?>
        <?php foreach ($data['month'][calculateMonth($monthChange)]['bills'] as $key => $billValue): ?>
          <tr data-toggle="modal" data-target="#regnskapModal" data-date="<?php echo $billValue['date'];?>"
                                                               data-desc="<?php echo $billValue['description'];?>"
                                                               data-sum="<?php echo $billValue['sum'];?>"
                                                               data-category="<?php echo getCategoryFromId($data, $billValue['category'])['name'];?>"
                                                               data-categoryid="<?php echo getCategoryFromId($data, $billValue['category'])['id'];?>"
                                                               data-billid="<?php echo $billValue['id'];?>">
            <td width="<?php echo $width;?>">
              <?php echo date('d.M', strtotime($billValue['date']));?>
            </td>
            <?php foreach ($data['categories'] as $category => $categoryValue):?>

              <?php if($billValue['category'] == $categoryValue['id']):?>
                <td width="<?php echo $width;?>"<?php if($billValue['sum'] < 0){echo " class=\"negative\"";}?>>
                  <?php echo $billValue['sum'];?>
                </td>
              <?php else : ;?>
              <td width="<?php echo $width;?>"></td>
              <?php endif;?>

            <?php endforeach;?>
            <td width="<?php echo $totalWidth;?>"></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <p>
          You have no data for this periode
        </p>
      <?php endif;?>

      <!--Table row Printing all totals-->
      <tr>
        <th width="<?php echo $dateWidth;?>">Sum</th>
        <?php
        $total = 0;
          foreach ($data['month'][calculateMonth($monthChange)]['categories'] as $category => $value):
            $sum = $value['income'] - $value['usage'];
            $total += $sum;?>
            <th width="<?php echo $wdth;?>"<?php if($sum < 0){echo " class=\"negative\"";}?>>
              <?php echo $sum;?>
            </th>
          <?php endforeach;?>
        <th width="<?php echo $totalWidth;?>"<?php if($total < 0){echo " class=\"negative\"";}?>>
          <?php echo $total;?>
        </th>
      </tr>
  </table>
</section>
