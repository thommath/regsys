<?php
    $conn = getConnection();

    $errorList = [];

    $reset = $conn->query("SELECT * FROM ResetPassword WHERE `link_key`='" . $_GET['key'] . "' AND `link_limit`>='" . date("Y-m-d h:i:s") . "' AND `used`=0");

    if($reset->num_rows >= 1):
      $reset = $reset->fetch_assoc();?>
      <section>
        <form action="updatePassword.php" method="post" class="form-horizontal">
          <h3>Please enter your new password</h3>

          <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" name="password" class="form-control" value="" placeholder=""></input>
            </div>
          </div>
          <div class="form-group">
            <label for="password2" class="col-sm-2 control-label">Repeat Password</label>
            <div class="col-sm-10">
              <input type="password" name="password2" class="form-control" value="" placeholder=""></input>
            </div>
          </div>

          <input type="hidden" name="key" value="<?php echo $_GET['key'];?>">

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Change Password</button>
            </div>
          </div>
        </form>
      </section>
    <?php else:?>
      <section>
        <h2>Invalid key</h2>
        <p>
          Sorry, but the key you are using is either invalid, used or expired. If you want to reset your password get a new link.
        </p>
        <a class="btn btn-primary btn-lg" href="/login/reset" role="button">Get link</a>

      </section>
    <?php endif;
?>
