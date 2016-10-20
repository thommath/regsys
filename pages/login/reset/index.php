<section>
  <form action="reset.php" method="post" class="form-horizontal">
    <h3>Reset password</h3>

    <div class="form-group">
      <label for="input" class="col-sm-2 control-label">Username or email</label>
      <div class="col-sm-10">
        <input type="text" name="input" class="form-control" value="<?php echo $_SESSION['post']['input'];?>" placeholder=""></input>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Get link</button>
      </div>
    </div>
  </form>
</section>
