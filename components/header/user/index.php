<section id="user_header">
  <!--   Min profil, Settings, Log ut,   -->
  <div class="dropdown">
    <button class="" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
      <img src="http://placehold.it/30" alt="Portrait">
      <?php echo $_SESSION['username'];?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
      <li><a href="?p=profile">Profile</a></li>
      <li><a href="#">Another action</a></li>
      <li><a href="?p=settings">Settings</a></li>
      <li role="separator" class="divider"></li>
      <li><a href="/components/login/logout/logout.php">Log out</a></li>
    </ul>
  </div>
</section>
