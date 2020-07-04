<?php
    //Error Reporting
    ini_set('display_errors' , 'On');
    error_reporting(E_ALL);
    //Routes
    $templates = 'includes/templates/';
    $cssAdmin = 'layout/css/';
    $jsAdmin = 'layout/js/';
    $translate = 'includes/languages/';
    $func     = 'includes/functions/';
    //Include The Important Files
    include 'Admin/connect.php';
    include $translate . 'English.php'; //first Thing to include
    include $func      . 'functions.php';
    include $templates . 'header.php';
    $sessionUser  = '';
    if(isset($_SESSION['user'])){
        $sessionUser = $_SESSION['user'];
    }
    ?>