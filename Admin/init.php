<?php
    
    //Routes
    $templates = 'includes/templates/';
    $cssAdmin = 'layout/css/';
    $jsAdmin = 'layout/js/';
    $translate = 'includes/languages/';
    $func     = 'includes/functions/';
    //Include The Important Files
    include 'connect.php';
    include $translate . 'English.php'; //first Thing to include
    include $func      . 'functions.php';
    include $templates . 'header.php';
    //Check if the Variabe not existed Will include the Navbar
    if(!isset($noNavbar)):
     include $templates . 'navbar.php';
    endif;