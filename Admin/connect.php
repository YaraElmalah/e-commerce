<?php
/*
The Difference between connect.php and config.php that:
config ==> configuration ==> settings which the connection can be Part from /**
 but connect.php contains only the connection
 */
$dsn = "mysql:host=localhost;dbname=shop";
$user = "root";
$pass = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);
try{
  $connect  = new PDO($dsn, $user, $pass, $option);
  $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
  echo "Failed to Connect " . $e -> getMessage();
}
