<?php
session_start();
//MyVariables
$pageTitle = "Dashboard";
include 'init.php';
if(isset($_SESSION['username'])){
	echo "Welcome " . $_SESSION['username'];
} else{
	header('location: index.php'); //if there's no Session return to the login Page
	exit();
}
include $templates . 'footer.php';