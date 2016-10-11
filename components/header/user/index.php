<section id="user_header">
  <!--   Min profil, Settings, Log ut,   -->
  <div class="dropdown">
    <button class="" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
      <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
      <?php echo $_SESSION['username'];?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
      <li><a href="?p=profile"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Profile</a></li>
      <li><a href="#">Another action</a></li>
      <li><a href="?p=settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Settings</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="/components/login/logout/logout.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>Log out</a></li>
    </ul>
  </div>
</section>
