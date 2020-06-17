<?php
/*=======
======= Page Name: Template =======
=======*/
ob_start(); //Output Buffering Start
session_start();
$pageTitle = 'Categories';
if(isset($_SESSION['username'])){  
	include 'init.php';
		//Page Content
	//Write The Short if Condition
$do = isset($_GET['do'])? $_GET['do']: $do = 'Manage'; 
//Assign do;
//Create Our Page Depends on the $_GET
	if($do == 'Manage'){ //Manage Page ?>
<div class="container">
		<h1 class="text-center">Manage Categories</h1>
	    <a href='categories.php?do=Add' class="btn btn-primary">
	    <i class="fas fa-cart-plus fa-lg"></i> New Category</a>
	<?php
	} elseif($do == 'Add'){ //Add New Category Page?>

	<h1 class="text-center">Add New Category</h1>
	<div class="container">
		<form class="form-horizontal form-lg" action="?do=Insert" method="POST">
			<div class="form-group">
				<!--Start Category name-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Category Name
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control"  required="required"
						 placeholder="The Name of this Gategory">
					</div>
				</div>
				<!--End Category Name-->
				<!--Start Description-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Description
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="text" name="desc" class="form-control" placeholder="Describe This Gategory">
				</div>
				</div>
				<!--End Description-->
				<!--Start Ordering-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Order
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="number" name="order" class="form-control"  
						 placeholder="Enter the Order You Want to show this Category off">
					</div>
				</div>
				<!--End Ordering-->
				<!--Start Visibility-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Visibility
				</label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="vis-yes" name="visibility" value="1" checked>
						<label for="vis-yes">Yes</label>
					</div>
					<div>
						<input type="radio"  id="vis-no" name="visibility" value="0">
						<label for="vis-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Visibility-->
				<!--Start Allow Comments-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Allow Comments
				 </label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="com-yes" name="comment" value="1" checked>
						<label for="com-yes">Yes</label>
					</div>
					<div>
						<input type="radio"  id="com-no" name="comment" value="0">
						<label for="com-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Allow Comments-->
				<!--Start Allow Ads-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Allow Ads
				</label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="ads-yes" name="ads" value="1" checked>
						<label for="ads-yes">Yes</label>
					</div>
					<div >
						<input type="radio"  id="ads-no" name="ads" value="0">
						<label for="ads-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Allow Ads-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Add Gategory" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End FullName-->
				
			</div>
		</form>
	</div>

<?php
	} elseif ($do == 'Insert'){ 
	//Insert Page
       if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Insert New Category</h1>"; 
		//Get Variables From the Form
		$name = $_POST['name'];
		$desc = $_POST['desc'];
		$order = $_POST['order'];
		$visibility = $_POST['visibility'];
		$allowComment = $_POST['comment'];
		$allowAds = $_POST['ads'];
		//Check if Category Exists
		if(!empty($name)){
		$check = countAndSelect('name', 'Categories' , $name);
		
		//Database Query
			//Check if There is no errors 
	            if($check == 1){
		             $error =  "<div class='container'>
		                        <div class='alert alert-danger'>The Category is already existed</div>";
		             redirectHome($error, 'back');
	            } else{
	             	//Insert this info into Database 
				   	$stmt =  $connect->prepare("INSERT INTO `categories`(Name, `desc-box`, Ordering, Visible, Allow_Comment, Allow_Ads) 
				   		VALUES (:name, :des, :order, :vis, :comm , :ads)");
				   	$stmt->execute(array(
				   		':name'  => $name,
				   		':des'   => $desc,
				   		':order' => $order,
				   		':vis'   => $visibility,
				   		':comm'  => $allowComment,
				   		':ads'   => $allowAds
				   	));
			     	//Echo Success Message
			     	$success = "<div class='container'>
			     	            <div class='alert alert-success'>" .  $stmt->rowCount() . " Category Added</div>";
			     	redirectHome($success, 'back');
				}
			} else{
				$error = "<div class='container'>
				<div class='alert alert-danger'>The name Can't be Empty !</div>";
				redirectHome($error, 5);
			}
			

      } else{
      	$error = " <div class='container'>
      	            <div class='alert alert-danger'>You are not Allowed to browse this Page</div>
      	            ";
		redirectHome($error, 3);
		
	}
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