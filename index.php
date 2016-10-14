<?php require_once("php/essentials.php");session_start();?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>RegSys</title>
    <script src="js/jquery.js" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" title="no title">
    <link rel="stylesheet" href="css/main.css" media="screen" title="no title">
    <link rel="stylesheet" href="components/header/style.css" media="screen" title="no title">
    <link rel="stylesheet" href="css/content.css" media="screen" title="no title">
    <link rel="stylesheet" href="components/<?php echo $_GET['p'];?>/style.css" media="screen" title="no title">
  </head>

  <body>
    <header>
      <section id="header_container">
        <a href="/"><section id="logo">RegSys</section></a>
          <?php
            if(isset($_SESSION['user'])){
              require_once("components/header/user/index.php");
            }else{
          //    require_once("components/header/login/index.php");
            }
            ?>
      </section>
    </header>

    <section id="content">
      <section id="left">
        <section id="menu">
          <nav>
            <a href="/?p=dashboard"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Dashboard</a>
            <a href="/?p=regnskap"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>Regnskap</a>
            <a href="/?p=addBill"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>Add Bill</a>
            <a href="/?p=addCategory"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>Add Category</a>
          </nav>
        </section>
      </section>
      <section id="center">

        <?php if(isset($_SESSION['error'])):?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          <?php
          //Error message
            foreach ($_SESSION['error'] as $key => $value) {
              echo $value . "\n";
            }
          ?>
          </div>
        <?php unset($_SESSION['error']); endif;?>
        <?php if(isset($_SESSION['message'])):?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $_SESSION['message'];?>
          </div>

          <?php unset($_SESSION['message']); endif;?>

        <?php
        //Load component
        if(isset($_SESSION['user'])){

          //Load data if doesn't exist
          if(!isset($_SESSION['data']) || $_SESSION['success'] == true){
            setupData();
          }

          if(isset($_GET['p'])){
            require_once("components/" . $_GET['p'] . "/index.php");
          }else{
            require_once("components/dashboard/index.php");
          }
        }else{//Not logged in give access for all login subfolders
          if(isset($_GET['p']) && startsWith($_GET['p'], "login")){
            require_once("components/" . $_GET['p'] . "/index.php");
          }else{
            require_once("components/login/index.php");
          }
        }
        unset($_SESSION['post']);
        unset($_SESSION['from']);
        unset($_SESSION['success']);
        ?>
      </section>
    </section>
    <?php if(isset($_GET['p']) && $_GET['p'] == 'regnskap'){require_once("components/regnskap/modal.php");}?>
  </body>
</html>
