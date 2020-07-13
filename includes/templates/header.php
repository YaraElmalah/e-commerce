<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <!--Start Css Files-->
  <link rel="stylesheet" 
  href= "<?php echo $cssAdmin ?>bootstrap-min.css" />
  <link rel="stylesheet" href= "<?php echo $cssAdmin ?>icons.min.css" />
  <link rel="stylesheet" href= "<?php echo $cssAdmin ?>jquery.selectBoxIt.css" />
  <link rel="stylesheet" href= "<?php echo $cssAdmin ?>main-front.css" />
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans&display=swap" >
  <title><?php  getTitle(); ?></title>
</head>
<body>
  <!--Upper Navbar-->
  <div class="upper-bar">
    <div class="container">
      <?php 
      session_start();
        if (isset($_SESSION['user'])){
          echo "<span class='welcome-message'> Welcome back, " . $_SESSION['user'] . " .. <i class=\"fab fa-pagelines\"></i> </span>";
          ?>
            <div class="btn-group navbar-nav navbar-right">
              <span class="btn dropdown-toggle" data-toggle="dropdown">
                  <?php echo  $_SESSION['user'] ?> 
                  <span class="caret"></span>
              </span>
              <div class="dropdown-menu text-capitalize">
                 <?php
          
            if(checkUserStatus($_SESSION['user']) == 0 ){?>
              <li><a href='#'><i class="far fa-laugh-beam"></i> not activated</a></li>
                  <?php }
                  ?>
                  <li><a href="profile.php"><i class="far fa-user-circle"></i> profile</a></li>
                  <li><a href="profile.php#call-ads"><i class="fas fa-map-pin"></i> my ads</a></li>
                  <li><a href="additem.php"><i class="fas fa-folder-plus"></i> New Ad</a></li>
                  <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> logout</a></li>
              </div>
            </div>
            <img src="item-avatar.png" alt="person" class="img-circle img-thumbnail navbar-right" height="35px" width="32px">
          <?php
        } else{

            echo "<span class=\"pull-right text-capitalize text-primary\"><a href='login.php'>don't miss a hit ! login or signup now</a></span>";
        }
      ?>
      
    </div>
  </div>
	<!--Start Navbar-->
	<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-toggle" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?php echo lang('brand') ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="nav-toggle">
      <ul class="nav navbar-nav navbar-right">
            <?php 
                foreach (getCats() as $cat) {
                  echo "<li><a href='categories.php?pageid=" . $cat['ID'] . '&pagename='. str_replace(' ', '-', $cat['Name']) . "'>" 
                  . $cat['Name'] . "</a></li>";
                }
            ?>
              </ul>
    </div>
  </div>
</nav>
<!--End Navbar-->