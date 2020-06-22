<?php
/*=======
======= Page Name: Items =======
=======*/
ob_start(); //Output Buffering Start
session_start();
$pageTitle = 'Items';
if(isset($_SESSION['username'])){  
	include 'init.php';
		//Page Content
	//Write The Short if Condition
$do = isset($_GET['do'])? $_GET['do']: $do = 'Manage'; 
//Assign do;
//Create Our Page Depends on the $_GET
	if($do == 'Manage'){ //Manage Page ?>
		<div class="categories">
	     <div class="container">
			<h1 class="text-center">Manage Items</h1>
		    <a href='items.php?do=Add' class="btn btn-primary">
		    <i class="fas fa-folder-plus"></i> New Item</a>
		 </div>
	    </div>

		    <?php

	} elseif($do == 'Add'){ //Add New Item Page?>

	<h1 class="text-center">Add New Item</h1>
	<div class="container">
		<form class="form-horizontal form-lg" action="?do=Insert" method="POST">
			<div class="form-group">
				<!--Start item name-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Item Name
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control"  required="required"
						 placeholder="The Name of this Item">
					</div>
				</div>
				<!--End Item Name-->
				<!--Start Description-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Description
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="text" name="desc" class="form-control" placeholder="Describe This Item" required="required">
				</div>
				</div>
				<!--End Description-->
				<!--Start Price Field-->
					<div class="form-group">
						<label class="col-sm-2 control-label"> Price
				   </label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="price" class="form-control" placeholder="The Price of the Item" required="required">
					</div>
					</div>
				<!--End Price Field-->
				<!--Start Country Made Field-->
					<div class="form-group">
						<label class="col-sm-2 control-label"> Made In
				   </label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="country" class="form-control" placeholder="The Country that the Item Made in" required="required">
					</div>
					</div>
				<!--End Country Made Field-->
				<!--Start Status Field-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> Status
			   </label>
				<div class="col-sm-10 col-md-6">
					<select name="status">
						<option value="0"></option>
						<option value="1">New</option>
						<option value="2">Like New</option>
						<option value="3">Used</option>
						<option value="4">Old</option>

					</select>
				</div>
				</div>
			<!--End Status Field-->
			<!--Start Member Field-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> Seller: 
			   </label>
				<div class="col-sm-10 col-md-6">
					<select name="member">
						<option value="0"></option>
						<?php 
							$stmt = $connect->prepare("SELECT 
								* FROM `shop-users`");
							$stmt->execute(); 
							$users = $stmt->fetchAll();
						foreach ($users as $user) {
							echo "<option value='". $user['UserID'] . "'>" .
							 $user['username'] . "</option>";
						}
				?>
					</select>
				</div>
				</div>
			   <!--End Member Field-->
			   <!--Start Category Field-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> Category: 
			   </label>
				<div class="col-sm-10 col-md-6">
					<select name="category">
						<option value="0"></option>
						<?php 
							$stmt2 = $connect->prepare("SELECT 
								* FROM categories");
							$stmt2->execute(); 
							$cats = $stmt2->fetchAll();
						foreach ($cats as $cat) {
							echo "<option value='". $cat['ID'] . "'>" .
							 $cat['Name'] . "</option>";
						}
				?>
					</select>
				</div>
				</div>
			   <!--End Category Field-->
			   
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Add Item" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End Submit-->
				
			</div>
		</form>
	</div>

<?php
	} elseif ($do == 'Insert'){ //Insert Page
       if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Insert </h1>"; 
		//Get Variables From the Form
		$name        = $_POST['name'];
		$desc        = $_POST['desc'];
		$price       = $_POST['price'];
		$country     = $_POST['country'];
		$status      = $_POST['status'];
		$members     = $_POST['member'];
		$categories  = $_POST['category'];
		//Validate The Form
		$formErrors = [];

		if(empty($name)){
			$formErrors[] = "Name can't <strong>empty</strong>";
		} 
		if (empty($desc)) {
			$formErrors[] = "Description can't <strong>empty</strong>";
		}
		if (empty($price)) {
			$formErrors[] = "Price can't <strong>empty</strong>";
		} 	
		if (empty($country)) {
			$formErrors[] = "Country Filed can't <strong>empty</strong>";
		} 
		if ($status == 0) {
			$formErrors[] = "You Should chose the status of The Item";
		}
		if ($members == 0) {
			$formErrors[] = "You Should chose the Seller of The Item";
		}
		if ($categories == 0) {
			$formErrors[] = "You Should chose the Category of The Item";
		}
		//Database Query
			//Check if There is no errors 
			if(empty($formErrors)){
	           
	             	//Insert this info into Database 
				   	$stmt =  $connect->prepare("INSERT INTO items 
				   		(Name , Description, Price, Origin, Status , MemberID, CatID , `Date`) 
				   		VALUES 
				   		(:item, :des , :price, :country, :status, :members, :cats , now())");
				   	$stmt->execute(array(
				   		':item'    => $name,
				   		':des'     => $desc,
				   		':price'   => $price,
				   		':country' => $country,
				   		':status'  => $status,
				   		':members' => $members,
				   		':cats'    => $categories

				   	));
			     	//Echo Success Message
			     	$success = "<div class='container'>
			     	            <div class='alert alert-success'>" .  $stmt->rowCount() . " Item Added</div>";
			     	redirectHome($success, 'back');
				} else{
				//Get The Errors
				echo "<div class='container'>";
	          foreach ($formErrors as $error) {
				echo "<div class='alert alert-danger'>"  . 
				$error . "</div>";
			 }
				$editMsg = "<div class='alert alert-info'> Please refill the inputs to complete the Process</div>";
				redirectHome($editMsg, 'back' , 5);

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
	}elseif($do == 'Approve'){
		#code
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