<?php
unset($_SESSION['post']);
unset($_SESSION['from']);
unset($_SESSION['success']);
?>
</section>
</section>
<?php if(isset($_GET['p']) && $_GET['p'] == 'regnskap'){require_once("components/regnskap/modal.php");}?>
</body>
</html>
