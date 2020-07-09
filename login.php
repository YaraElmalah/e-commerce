<?php 
  include 'init.php';
ob_start();
 if(isset($_SESSION['user'])){
  	header('location: index.php');
 }
  	//Check if The User Coming from HTTP POST Method
  	if($_SERVER['REQUEST_METHOD'] == 'POST'){
  		if(isset($_POST['login'])){
  			//Getting The Info From the Form
  		$user       = $_POST['username'];
  		$pass       = $_POST['password'];
  		$securePass = sha1($pass);
  		
  		//Check if the user existed on the database
  		$stmt = $connect->prepare("
        SELECT username, Password, UserID 
        from `shop-users` 
        where username =? And Password =? 
        ");
  		$stmt->execute(array($user, $securePass));
  		$userInfo = $stmt->fetch();
  		$count = $stmt-> rowCount();
  		// echo $count; if the record is existed then it gives 1
  		//Check if the Record is existed 
  		if($count > 0){
  		$_SESSION['user']      = $user; //Register Session Name
  		$_SESSION['pass-user'] = $pass; //Register Session Name
  		$_SESSION['iduser']    = $userInfo['UserID'];
  			header('location: index.php');
  			exit(); //Stop the Script 
  		}
  	} else{ //here signup form POST
  		$username      = $_POST['username'];
  		$password      = $_POST['password'];
  		$confirmPass   = $_POST['con-password'];
  		$email         = $_POST['email'];
  		$formErrors    = array();
  		if(isset($username)){
  			$filteredUsername = filter_var($username, FILTER_SANITIZE_STRING);
  			if(strlen($filteredUsername) < 4){
  				$formErrors[] = "The username can't be less than 4 characters";
  			}
  		}
  		if(isset($password) && isset($confirmPass)){
  			if(empty($password)){
  				$formErrors[] = "The Password can't be empty";
  			}
  			$pass1 = sha1($password);
  			$pass2 = sha1($confirmPass);
  			if($pass1 !== $pass2){
  				$formErrors[] = "The Two Passwords are not identical";
  			}
  		}
  		if(isset($email)){
  			$filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
  			if(filter_var($filteredEmail , FILTER_VALIDATE_EMAIL) 
  				!= true ){
  				$formErrors[] = "Enter a valid Email";
  			}
  		}
  		//Database Query
			//Check if There is no errors 
			if(empty($formErrors)){
				$check = checkItem('username','`shop-users`', 
					$filteredUsername);
	            if($check == 1){
		            $formErrors[] = "The Username is already exist";
	             }else{
	             	//Insert this info into Database 
				   	$stmt =  $connect->prepare("INSERT INTO `shop-users`(username, Password, Email, RegStatus ,date) 
				   		VALUES (:user, :pass, :mail , 0 ,now())");
				   	$stmt->execute(array(
				   		':user' => $filteredUsername,
				   		':pass' => $pass1,
				   		':mail' => $filteredEmail
				   	));
			     	//Echo Success Message
			     $success = "<div class='alert alert-success'>You are Now Part of our family &#10084;</div>";
				}
		    
  } 
}
} //END BIG ELSE
?> 
<section class="login-form">
	<div class="container">
		<h1 class="text-center text-capitalize"><span 
			class="login selected" data-class='.login'>login </span> 
			|<span class="signup" data-class='.signup'> signup </span></h1>
			<!--Start Login Form-->
			<form class="form-horizontal login" method="POST" 
			action= "<?php echo $_SERVER['PHP_SELF']?>">
				<div class="form-group">
					<div class="col-sm-12">
				     	<input type="text" name="username" class="form-control"
				     	placeholder="Username" autocomplete="off">
				    </div>
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="password" name="password" 
				     	class="form-control"
				     	placeholder="Password" autocomplete="new-password">
				    </div>
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="submit" name="login" value="Login" 
				     	class="btn btn-primary btn-block">
				    </div>
				</div>
				
			</form>
			<!--End Login Form-->
			<!--Start Signup-->
			<form class="form-horizontal signup" method="POST" 
			action= "<?php echo $_SERVER['PHP_SELF']?>">
				<div class="form-group">
					<div class="col-sm-12">
				     	<input 
				     	pattern=".{4,}" 
				     	title="username must be more than 4 characters" 
				     	type="text" name="username" class="form-control"
				     	placeholder="Type a username" autocomplete="off"
				     	required="required"
				     	value="<?php if(isset($_POST['username'])): echo
				     	 $_POST['username'];
				     	  endif; ?>" 
				     	>
				    </div>
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input 
				     	minlength="3" 
				     	title="password should be more than 3 characters" 
				     	type="password" name="password" 
				     	class="form-control"
				     	placeholder="Type a Strong Password" autocomplete="new-password" 
				     	required="required">
				    </div> 
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input minlength="3" 
				     	type="password" name="con-password" 
				     	class="form-control"
				     	placeholder="Confirm Your Password"
				     	 autocomplete="new-password" 
				     	 required="required">
				    </div> 
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="email" name="email" 
				     	class="form-control"
				     	placeholder="Type a Valid Email"
				        required="required"
				        value="<?php if(isset($_POST['email'])): echo
				     	 $_POST['email'];
				     	  endif; ?>">

				    </div> 
				</div>				
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="submit" name="signup" value="Signup" 
				     	class="btn btn-success btn-block">
				    </div>
				</div>
			</form>
			<!--End Signup-->
			<!--Start Errors Show -->
			<div class="signup-errors text-center">
				
				<?php
					if(!empty($formErrors)){
						echo "<div class='alert alert-danger'>";
						foreach ($formErrors as $error) {
							echo "<p>" .  $error . "</p>";
						}
						echo "</div>";
					}
				    if(isset($success)){
				    	echo $success;
				    }
				?>
			
			</div>
			<!--End Errors Show -->
			
	</div>
</section>
<?php include $templates . 'footer.php';
  ob_end_flush();
 ?>