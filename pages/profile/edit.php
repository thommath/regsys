<section>
  <form action="save.php" method="post" class="form-horizontal">
    <h3>Register</h3>

    <div class="form-group">
      <label for="username" class="col-sm-2 control-label">Username</label>
      <div class="col-sm-10">
        <input type="text" name="username" class="form-control" value="<?php echo $_SESSION['post']['username'];?>" placeholder="Username"></input>
      </div>
    </div>

    <div class="form-group">
      <label for="password2" class="col-sm-2 control-label">Password*</label>
      <div class="col-sm-10">
        <input type="password" name="password2" value="" class="form-control" placeholder="Password"></input>
      </div>
    </div>

    <div class="form-group">
      <label for="email" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="email" name="email" class="form-control" value="<?php echo $_SESSION['post']['email'];?>" placeholder="lorem@ipsum.com"></input>
      </div>
    </div>

    <div class="form-group">
      <label for="password" class="col-sm-2 control-label">Repeat Password*</label>
      <div class="col-sm-10">
        <input type="password" name="password" value="" class="form-control" placeholder="Password"></input><br>
      </div>
    </div>

    <div class="form-group">
      <label for="firstname" class="col-sm-2 control-label">First Name</label>
      <div class="col-sm-10">
        <input type="text" name="firstname" class="form-control" value="<?php echo $_SESSION['post']['firstname'];?>" placeholder="Ole"></input>
      </div>
    </div>

    <div class="form-group">
      <label for="lastname" class="col-sm-2 control-label">Last Name</label>
      <div class="col-sm-10">
        <input type="text" name="lastname" class="form-control" value="<?php echo $_SESSION['post']['lastname'];?>" placeholder="Nordmann"></input>
      </div>
    </div>

    <div class="form-group">
      <label for="gender" class="col-sm-2 control-label">Gender</label>
      <div class="col-sm-10">
        <label class="radio-inline"><input type="radio" name="gender" value="male" <?php if($_SESSION['post']['gender'] == "male"){echo "checked";}?>>Male </label>
        <label class="radio-inline"><input type="radio" name="gender" value="female" <?php if($_SESSION['post']['gender'] == "female"){echo "checked";}?>>Female </label>
        <label class="radio-inline"><input type="radio" name="gender" value="other" <?php if($_SESSION['post']['gender'] == "other"){echo "checked";}?>>Other </label>
      </div>
    </div>

    <div class="form-group">
      <label for="year" class="col-sm-2 control-label">Birthyear</label>
      <div class="col-sm-10">
        <input type="text" name="year" class="form-control" value="<?php echo $_SESSION['post']['year'];?>" placeholder="1995"></input>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Register</button>
      </div>
    </div>
  </form>
</section>
