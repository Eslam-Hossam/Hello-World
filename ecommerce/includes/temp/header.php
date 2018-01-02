<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> <?php drawTitle() ?> </title>
	<link rel="stylesheet" type="text/css" href="<?php echo $css;?>bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $css;?>bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $css;?>font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $css;?>jquery-ui.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $css;?>jquery.selectBoxIt.css"/>

	<link rel="stylesheet" type="text/css" href="<?php echo $css;?>mystylefront.css"/>
</head>
<body>
  <div class="upper-bar">
    <div class="container">
      <?php

        if ( isset($_SESSION['user']) ) {

          if ( checkuserstatus($_SESSION['user']) == 1 ) {

            echo " Your Membership Need To Activate By Admin";
            echo '<span class="pull-right"><a href="logout.php">Logout</a> </span>';

          
          } else {

            echo "Welcome " . $_SESSION['user'] ;
            echo "<span class='pull-right'>";
            echo '<a href="profile.php"> My Profile</a>';
            echo ' - <a href="newad.php"> New Ad</a>';
            echo ' - <a href="logout.php"> Logout</a>';
            echo "</span>";

          }
        
        } else {

          echo
            ' <a href="login.php">
              <span class="pull-right">Login/Signup</span> 
              </a> 
            ';
        }
  	   
      ?>
    </div>
  </div>
  <nav class="navbar navbar-inverse">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><?php echo lang('home_n')?></a>
      </div>
      <div class="collapse navbar-collapse" id="app-nav">
        <ul class="nav navbar-nav navbar-right">
          <?php 

              $gets  = getcat();

              foreach ($gets as $get) {
                
                echo "<li><a href='categories.php?pageid=" . $get['ID'] . "&pagename=" .str_replace(' ','-',$get['Name']) . "'>" . $get['Name'] . "</a></li>";

              }
          ?>
        </ul>
      </div>
    </div>
  </nav>
