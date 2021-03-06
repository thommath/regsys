dep:regnskap.js;style.css;modalBill.php;modalCategory.php;
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
    <a href="?month=<?php echo (intval($monthChange)-1);?>"><span class="glyphicon glyphicon-arrow-left btn-lg" aria-hidden="true"></span></a>
    <h3 class="center-block"><?php echo monthToString(substr($month, 5, 6));?></h3>
    <a href="?&month=<?php echo (intval($monthChange)+1);?>"><span class="glyphicon glyphicon-arrow-right btn-lg" aria-hidden="true"></span></a>
  </section>

  <table class="table table-striped table-bordered">
    <?php if(isset($data['month'][$month])):?>
    <!--Table header Printing all categories-->
      <tr>
        <th width="<?php echo $dateWidth;?>">Date</th>
        <?php foreach ($data['categories'] as $key => $value):?>
          <th width="<?php echo $width;?>"
                                  class="masterTooltip"
                                  title="<?php echo $value['description'];?>"
                                  data-toggle="modal"
                                  data-target="#categoryModal"
                                  data-name="<?php echo $value['name'];?>"
                                  data-desc="<?php echo $value['description'];?>"
                                  data-categoryid="<?php echo $value['id'];?>">
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
          <tr>

            <td width="<?php echo $dateWidth;?>">
              <?php echo date('d.M', strtotime($billValue['date']));?>
            </td>
            <?php foreach ($data['categories'] as $category => $categoryValue):?>

              <?php if($billValue['category'] == $categoryValue['id']):?>
                <td width="<?php echo $width;?>" class="masterTooltip <?php if($billValue['sum'] < 0){echo "negative";}?>"
                                                                    title="<?php echo $billValue['description'];?>"
                                                                    data-toggle="modal" data-target="#billModal"
                                                                    data-date="<?php echo $billValue['date'];?>"
                                                                    data-desc="<?php echo $billValue['description'];?>"
                                                                    data-sum="<?php echo $billValue['sum'];?>"
                                                                    data-category="<?php echo getCategoryFromId($data, $billValue['category'])['name'];?>"
                                                                    data-categoryid="<?php echo getCategoryFromId($data, $billValue['category'])['id'];?>"
                                                                    data-billid="<?php echo $billValue['id'];?>">
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
