<section>
  <h3>Settings</h3>

  <form class="form-horizontal" action="/components/settings/editSettings.php" method="post">
    <div class="form-group">
      <label for="startDay" class="col-sm-2 control-label">Startday </label>
      <div class="col-sm-10">
        <input type="number" name="startDay" id="startDay" class="form-control" value="<?php if(isset($_POST['startDay'])){echo $_POST['startDay'];}else{echo $_SESSION['data']['settings']['startDay'];}?>"></input>
      </div>
    </div>
    <div class="form-group">
      <label for="keepTotal" class="col-sm-2 control-label">Keep Total (0 for false, 1 for true)</label>
      <div class="col-sm-10">
        <input type="number" name="keepTotal" id="keepTotal" class="form-control" value="<?php if(isset($_POST['keepTotal'])){echo $_POST['keepTotal'];}else{echo $_SESSION['data']['settings']['keepTotal'];}?>"></input>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</section>
