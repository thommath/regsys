<section>
  <form action="/components/login/login.php" method="post" class="form-horizontal">
    <h3>Log In</h3>

    <div class="form-group">
      <label for="username" class="col-sm-2 control-label">Username</label>
      <div class="col-sm-10">
        <input type="text" name="username" class="form-control" value="<?php echo $_SESSION['post']['username'];?>" placeholder="Username"></input>
      </div>
    </div>

    <div class="form-group">
      <label for="password2" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" name="password" value="" class="form-control" placeholder="Password"></input>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Log in</button>
      </div>
    </div>
  </form>
  <a href="?p=login/register">
    <p>
      Click here to register
    </p>
  </a>
  <a href="?p=login/reset">
    <p>
      Forgot your password?
    </p>
  </a>
</section>
