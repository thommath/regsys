<?php
$conn = getConnection();
$user = $conn->query("SELECT * FROM User WHERE `id`=" . $_SESSION['user'])->fetch_assoc();

 ?>
<section>
  <h3>Profile</h3>
  <div class="col-sm-8">
    <div class="">
      <strong>Username: </strong>
      <?php echo $user['username'];?>
    </div>
    <div class="">
      <strong>Name: </strong>
      <?php echo $user['firstname'] . " " . $user['lastname'];?>
    </div>
    <div class="">
      <strong>Email:</strong>
      <?php echo $user['email'];?>
    </div>
    <div class="">
      <strong>Gender:</strong>
      <?php echo $user['gender'];?>
    </div>
  </div>
  <div class="col-sm-4">
    <img src="http://placehold.it/300" alt="" />
  </div>
</section>
