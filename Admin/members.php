<?php
$pageTitle = "Members";
/*=====
	Manage Member Page 
	As You Can Add / Edit / Delete members from Here
====*/
session_start(); //Should be in All the Pages
if(isset($_SESSION['username'])){ 
   //If there is a session Continue
	include 'init.php';
		//Page Content
	//Write The Short if Condition
$do = isset($_GET['do'])? $_GET['do']: $do = 'Manage'; 
//Assign do;
//Create Our Page Depends on the $_GET
if($do == 'Manage'){
	echo "Welcome To Manage Page";
} elseif($do == 'Add'){
	echo "Welcome to the Add Page";
} elseif ($do == "Edit") {?>
	<h1 class="text-center">Edit Profile</h1>
	<div class="container">
		<form class="form-horizontal form-lg">
			<div class="form-group">
				<!--Start Username-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Username
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" autocomplete="off">
					</div>
				</div>
				<!--End Username-->
				<!--Start Password-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Password
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="password" name="password" class="form-control" autocomplete="new-password">
					</div>
				</div>
				<!--End Password-->
				<!--Start Email-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Email
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="email" name="email" class="form-control" autocomplete="off">
					</div>
				</div>
				<!--End Email-->
				<!--Start FullName-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Full-Name
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="full-name" class="form-control" autocomplete="off">
					</div>
				</div>
				<!--End FullName-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="save" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End FullName-->
				
			</div>
		</form>
	</div>
<?php } 
elseif ($do == "Update") {
	echo "Update";
} 

elseif ($do == "Add") {
	echo "Add";
} 
elseif ($do == "Insert") {
	echo "Insert";
} 
elseif ($do == "Delete") {
	echo "Delete";
} 
elseif ($do == "Stats") {
	echo "Stats";
} else{
	echo "Error There's no Page With this Name";
}
	include $templates . 'footer.php';
} else{
	header('location:index.php');
	exit(); //Stop the Script
	 //Redirect To the Login Page if there is no  Session
}