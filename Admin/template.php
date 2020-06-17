<?php
/*=======
======= Page Name: Template =======
=======*/
ob_start(); //Output Buffering Start
session_start();
$pageTitle = '';
if(isset($_SESSION['username'])){  
	include 'init.php';
		//Page Content
	//Write The Short if Condition
$do = isset($_GET['do'])? $_GET['do']: $do = 'Manage'; 
//Assign do;
//Create Our Page Depends on the $_GET
	if($do == 'Manage'){ //Manage Page
	} elseif($do == 'Add'){
		#code ..
	} elseif ($do == 'Insert'){
		#code ..
	} elseif ($do == 'Edit'){
		# code...
	} elseif ($do == 'Update'){
		# code...
	} elseif($do == 'Delete'){
		#code..
	}
	else{
	$error = " 
	            <div class='container'>
	            <h1 class='text-center'>Error 404</h1>
	            <div class='alert alert-danger'>There's no Page With this Name</div>
	            ";
			redirectHome($error);
}
	include $templates . 'footer.php';

} else{
	header('location:index.php');
	exit(); 
}
ob_end_flush(); //Release The Output
?>