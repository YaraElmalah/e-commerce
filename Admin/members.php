<?php
ob_start();
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
if($do == 'Manage'){ //Manage Page
	if(isset($_GET['page'])){
		$query = "AND RegStatus = 0";
	} else{
		$query = "";
	}
	//We can add to the querry (WHERE groupID != 1 as no the the Admin included)
	     $rows = getAllFrom("*", '`shop-users`', 'WHERE groupID != 1' .
	            $query, 'UserID');
						if(!empty($rows)){
	?>

	<div class="container">
		<h1 class="text-center">Manage Members</h1>
	<a href='members.php?do=Add' class="btn btn-primary">
	 <i class="fas fa-user-plus"></i> New Member</a>
	<div class="table-responsive">
		<table class="table table-bordered text-center main-table">
			<tr>
				<th class="text-uppercase">#id</th>
				<th class="text-uppercase">avatar</th>
				<th class="text-capitalize">username</th>
				<th class="text-capitalize">email</th>
				<th class="text-capitalize">full name</th>
				<th class="text-capitalize">register date</th>
				<th class="text-capitalize">control</th>
			</tr>
				<?php 
					foreach ($rows as $row) {
						 echo "<tr>";
						 echo "<td>" . $row['UserID'] . "</td>";
						 if(!empty($row['avatar'])){
						 echo "<td>" . "<img src='Uploads\Avatars\\" .$row['avatar'] ."'> </td>";
						} else{
							echo "<td> <img src='../item-avatar.png'></td>";
						}
						 echo "<td>" . $row['username'] . "</td>";
						 echo "<td>" . $row['Email'] . "</td>";
						 echo "<td>" . $row['Full-Name'] . "</td>";
						 echo "<td>" . $row['date'] . "</td>";
						 echo "<td>" . "<a href='members.php?do=Edit&userid=" . 
						 $row['UserID'] .  "' class='btn btn-success'> <i class=\"fas fa-user-edit\"></i> Edit</a> " . 
					"<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'> <i class=\"fas fa-user-slash\"></i> Delete</a>"; 
						if($row['RegStatus'] == 0){

						echo " <a href='members.php?do=Active&userid=" . $row['UserID'] . " ' class='btn btn-info activate'><i class=\"fas fa-skiing\"></i> Activate </a>";

						}

						 echo "</tr>";
					}

			?>
			
		</table>
	</div>
<?php } else{
		echo "<div class='empty-message'> There is no Pending Members </div>";
} ?>
     </div>
<?php } elseif($do == 'Add'){ //Add Member Page?>

	<h1 class="text-center">Add New Member</h1>
	<div class="container">
		<form class="form-horizontal form-lg" action="?do=Insert" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<!--Start Username-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Username
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="The user will login with">
					</div>
				</div>
				<!--End Username-->
				<!--Start Password-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Password
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="password" name="password" class="form-control password" placeholder="Enter Strong Password"
				autocomplete="new-password" required="required" > <i class="fas fa-low-vision"></i>
				</div>
				</div>
				<!--End Password-->
				<!--Start Email-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Email
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="email" name="email" class="form-control" autocomplete="off" 
						required="required" placeholder="Enter a Valid Email">
					</div>
				</div>
				<!--End Email-->
				<!--Start FullName-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Full-Name
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="full-name" class="form-control" autocomplete="off" required="required" placeholder="Your Full Name that Appear in Your Profile">
					</div>
				</div>
				<!--End FullName-->
				<!--Start Avatar-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					User Avatar
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="file" name="avatar" class="form-control" autocomplete="off" placeholder="Your Full Name that Appear in Your Profile">
					</div>
				</div>
				<!--End Avatar-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Add" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End Submit-->
				
			</div>
		</form>
	</div>

<?php } elseif ($do == "Edit") { //Edit Page
	//Edit from the id with short if condition
	$userid = isset($_GET['userid']) 
		&& is_numeric($_GET['userid'])? 
		intval($_GET['userid']): 0; //That is our user that we would deal with
		//Now We get the Record from database
		$stmt = $connect->prepare("SELECT * from `shop-users`
			WHERE UserID = ? 
			LIMIT 1"); //get this user
		$stmt->execute(array($userid));
		$row = $stmt->fetch();
		$count = $stmt-> rowCount();
		//if We have a record then it must be > 0
		if($count > 0 ){ ?>
			<h1 class="text-center">Edit Profile</h1>
	<div class="container">
		<form class="form-horizontal form-lg" action="?do=Update" method="POST">
			<div class="form-group">
				<input type="hidden" name="userid" value="<?php echo $userid; ?>">
				<!--Start Username-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Username
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" autocomplete="off" required="required" 
						value="<?php echo $row['username']; ?>">
					</div>
				</div>
				<!--End Username-->
				<!--Start Password-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Password
				</label>
					<input type="hidden" value="<?php 
					echo $row['Password']; ?>" name="old-pass">
					<div class="col-sm-10 col-md-6">
						<input type="password" name="new-pass" class="form-control" placeholder="Leave it blank if you don't want to change Your Password" 
						autocomplete="new-password">
					</div>
				</div>
				<!--End Password-->
				<!--Start Email-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Email
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="email" name="email" class="form-control" autocomplete="off" 
						required="required"
						value="<?php echo $row['Email']; ?>">
					</div>
				</div>
				<!--End Email-->
				<!--Start FullName-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Full-Name
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="full-name" class="form-control" autocomplete="off" required="required"
						value="<?php echo $row['Full-Name']; ?>">
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
				<!--End Submit-->
				
			</div>
		</form>
	</div> <?php
		} else{
			$errorMsg =  "Wrong There is no such user";
			redirectHome($errorMsg);
		}
	
        } 
elseif ($do == "Update") {
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Update </h1>"; 
		//Get Variables From the Form
		$id = $_POST['userid'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$full = $_POST['full-name'];
		//Password Trick
		$pass = empty($_POST['new-pass'])? $_POST['old-pass'] :sha1($_POST['new-pass']);
		//Validate The Form
		$formErrors = [];

		if(empty($username)){
			$formErrors[] = "Username can't <strong>empty</strong>";
		} 
		if (empty($email)) {
			$formErrors[] = "Username can't <strong>empty</strong>";
		}
		if (empty($full)) {
			$formErrors[] = "Full Name can't <strong>empty</strong>";
		} 
		if (strlen($username) < 4) {
			$formErrors[] = "Full Name can't be smaller than<strong> 4 Characters</strong>";
		}
	     	
			//Database Query
			//Check if There is no errors 
			if(empty($formErrors)){
               $myCheck = $connect->prepare("SELECT * FROM `shop-users`
               	WHERE username = ? AND UserID != ?");
               $myCheck->execute(array($username, $id));
               $myCheck->fetch();
               $check = $myCheck->rowCount();
	            if($check == 1){
		             $error =  "<div class='container'>
		                        <div class='alert alert-danger'>The username is already existed</div>";
		             redirectHome($error, 'back');
		         } else{
		         	//Update Database with this info
			     $stmt = $connect->prepare("UPDATE `shop-users` 
				SET username = ? , Email = ? ,  `Full-Name` = ?  WHERE UserID = ?");
		     	$stmt->execute(array($username, $email, $full, $id));
		     	//Echo Success Message
		     	$success =  " <div class='container'>
		     	              <div class='alert alert-success'>" .  $stmt->rowCount() . " Record Updated </div>";
		     	redirectHome($success);
		         }
		    
			} else{
				//Get The Errors
	          foreach ($formErrors as $error) {
				echo "<div class='alert alert-danger'>"  . 
				$error . "</div>";
			}
			$myError = "<div class='alert alert-success'>Please Refill The Form</div>";
			redirectHome($myError, 'back');
			}
			
		
	
	} else{
		header('location: members.php');
	}
} 

elseif ($do == "Insert") { //Insert Page
       if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Insert </h1>"; 
		//Get Variables From the Form
		$username     = $_POST['username'];
		$email        = $_POST['email'];
		$full         = $_POST['full-name'];
		$pass         = $_POST['password'];
		$hashedPass   = sha1($pass);
		$avatar       = $_FILES['avatar']; //gives You all the info about name, size, extension, path
		$avatarName   = $_FILES['avatar']['name'];
		$avatarSize   = $_FILES['avatar']['size'];
		$avatarTemp   = $_FILES['avatar']['tmp_name'];
		$avatarType   = $_FILES['avatar']['type'];
		//List of Allowed Extensions(type of the img)
		$allowedavatarExtension = array("jpeg", "jpg", "png", "gif"); //important for security
		//get Avatar Extension 
		$avatarExtension = end(explode('.' , $avatarName));
		//Validate The Form
		$formErrors = [];
		if(!empty($avatarExtension) && !in_array($avatarExtension, $allowedavatarExtension)){
			$formErrors[] = "This Extension is not allowed";

		}
		if($avatarSize > 4194304){
					$formErrors[] = 'Avatar Can not be larger than <strong> 4 MB </strong>';
				}

		if(empty($username)){
			$formErrors[] = "Username can't <strong>empty</strong>";
		} 
		if (empty($email)) {
			$formErrors[] = "Username can't <strong>empty</strong>";
		}
		if (empty($full)) {
			$formErrors[] = "Full Name can't <strong>empty</strong>";
		} 	
		if (empty($pass)) {
			$formErrors[] = "Password can't <strong>empty</strong>";
		} 
		if (strlen($username) < 4) {
			$formErrors[] = "Full Name can't be smaller than<strong> 4 Characters</strong>";
		}
		if (strlen($full) > 14) {
			$formErrors[] = "Full Name can't be larger than<strong> 14 Characters</strong>";
		} 
		//Database Query
			//Check if There is no errors 
			if(empty($formErrors)){
				$avatar = rand(0, 10000000000) . '_' . $avatarName;
				move_uploaded_file($avatarTemp, "Uploads\Avatars\\" . $avatar);
				$check = checkItem('username','`shop-users`', $username);
	            if($check == 1){
		             $error =  "<div class='container'>
		                        <div class='alert alert-danger'>The username is already existed</div>";
		             redirectHome($error, 'back');
	            } else{
	             	//Insert this info into Database 
				   	$stmt =  $connect->prepare("INSERT INTO `shop-users`(username, Password, Email, `Full-Name`,RegStatus ,date , avatar) 
				   		VALUES (:user, :pass, :mail, :full, 1 ,now(), :av)");
				   	$stmt->execute(array(
				   		':user' => $username,
				   		':pass' => $hashedPass,
				   		':mail' => $email,
				   		':full' => $full,
				   		':av'   => $avatar
				   	));
			     	//Echo Success Message
			     	$success = "<div class='container'>
			     	            <div class='alert alert-success'>" .  $stmt->rowCount() . " Member Added</div>";
			     	redirectHome($success, 'back');
				}
		    
			}  else{
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
}
elseif ($do == "Delete") { //Delete Page ?>

			   <div class="container">
				<h1 class="text-center">Delete Member</h1>
			
 <?php
		$userid = isset($_GET['userid']) 
		&& is_numeric($_GET['userid'])? 
		intval($_GET['userid']): 0; //That is our user that we would deal with
		//Now We get the Record from database
		$check = checkItem( 'UserID' , '`shop-users`', $userid);
		//if We have a record then it must be > 0
		if($check > 0){ // User Existed
			//Delete Query
				$stmt = $connect->prepare("DELETE FROM `shop-users` WHERE
					                       UserID = :user");
				$stmt->bindParam(":user" , $userid);
				$stmt->execute();
				//Echo Success Message
			 $success =  "<div class='container'>
			                <div class='alert alert-success'>" .  $stmt->rowCount() . " Record Deleted </div> </div>";
			 redirectHome($success);
		} else{
			$error = " <div class='container'>
			               <div class='alert alert-danger'>There is No Such User</div> 
			            ";
			redirectHome($error, 'back');
		}
} 
elseif ($do == "Active") { //Activate Page ?>
	          <div class="container">
				<h1 class="text-center">Activate Member</h1>
			
 <?php
		$userid = isset($_GET['userid']) 
		&& is_numeric($_GET['userid'])? 
		intval($_GET['userid']): 0; //That is our user that we would deal with
		//Now We get the Record from database
		$check = checkItem( 'UserID' , '`shop-users`', $userid);
		//if We have a record then it must be > 0
		if($check > 0){ // User Existed
			//Delete Query
				$stmt = $connect->prepare("	UPDATE `shop-users`SET RegStatus = 1 WHERE  UserID = :user");
				$stmt->bindParam(":user" , $userid);
				$stmt->execute();
				//Echo Success Message
			 $success =  "<div class='container'>
			                <div class='alert alert-success'>" .  $stmt->rowCount() . " Record Activated </div> </div>";
			 redirectHome($success, 'back');
		} else{
			$error = " <div class='container'>
			               <div class='alert alert-danger'>There is No Such User</div> 
			            ";
			redirectHome($error, 'back');
		}
	
} else{
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
	exit(); //Stop the Script
	 //Redirect To the Login Page if there is no  Session
}
ob_end_flush();
?>