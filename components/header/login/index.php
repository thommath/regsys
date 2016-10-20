<section id="user_header">
  <form action="/login/login.php" method="post">
    Username <input type="text" name="username" value="<?php echo $_SESSION['post']['username'];?>" placeholder="Username"></input>
    Password <input type="password" name="password" value="" placeholder="Password"></input>
    <input type="submit" value="Submit">
  </form>
</section>
