

<section>
  <h3>Add Bill</h3>
  <form class="form-horizontal" action="/components/addBill/addBill.php" method="post">
    <div class="form-group">
      <label for="date" class="col-sm-2 control-label">Date </label>
      <div class="col-sm-10">
        <input type="date" name="date" id="date" class="form-control" value="<?php echo date("Y-m-d");?>"></input>
      </div>
    </div>
    <div class="form-group">
      <label for="date" class="col-sm-2 control-label">Category </label>
      <div class="col-sm-10">
        <select name="category" class="form-control" id="category">
          <?php
          //Printing categories
          $conn = getConnection();
          $categoriesQuery = $conn->query("SELECT * FROM Category WHERE `user`=" . $_SESSION['user']);
          if($categoriesQuery->num_rows >= 1){
            while($row = $categoriesQuery->fetch_assoc()){
              echo "<option value=\"" . $row['id'] . "\"> " . $row['name'] . "</option>\n";
            }
          }else{
            echo "";
          }
          ?>
        </select>
      </div>
    </div>

    <!-- Voucher -->
    <div class="form-group">
      <label for="voucher" class="col-sm-2 control-label">Voucher </label>
      <div class="col-sm-10">
        <input type="number" name="voucher" value="<?php echo intval($_SESSION['data']['voucher'])+1;?>" class="form-control" id="voucher"></input>
      </div>
    </div>

    <div class="form-group">
      <label for="description" class="col-sm-2 control-label">Description </label>
      <div class="col-sm-10">
        <input type="text" name="description" class="form-control" value="" placeholder="Description" id="description"></input>
      </div>
    </div>

    <div class="form-group">
      <label for="sum" class="col-sm-2 control-label">Sum </label>
      <div class="col-sm-10">
        <input type="number" name="sum" value=""class="form-control"  placeholder="Eks. 100.32" id="sum" step="any"></input>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</section>
