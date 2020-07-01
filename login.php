<?php 
ob_start();
  if(isset($_SESSION['user'])){
  	header('location: index.php');
 }
  include 'init.php';
  	//Check if The User Coming from HTTP POST Method
  	if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
  		$count = $stmt-> rowCount();
  		// echo $count; if the record is existed then it gives 1
  		//Check if the Record is existed 
  		if($count > 0){
  		$_SESSION['user']      = $user; //Register Session Name
  		$_SESSION['pass-user'] = $pass; //Register Session Name
  			header('location: index.php');
  			exit(); //Stop the Script 
  		}
  	}

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
				     	<input type="submit" value="Login" 
				     	class="btn btn-primary btn-block">
				    </div>
				</div>
				
			</form>
			<!--End Login Form-->
			<!--Start Signup-->
			<form class="form-horizontal signup">
				<div class="form-group">
					<div class="col-sm-12">
				     	<input type="text" name="username" class="form-control"
				     	placeholder="Type a username" autocomplete="off"
				     	 required="required">
				    </div>
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="password" name="password" 
				     	class="form-control"
				     	placeholder="Type a Strong Password" autocomplete="new-password" required="required">
				    </div> 
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="password" name="con-password" 
				     	class="form-control"
				     	placeholder="Confirm Your Password"
				     	 autocomplete="new-password" required="required">
				    </div> 
				</div>
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="email" name="email" 
				     	class="form-control"
				     	placeholder="Type a Valid Email"
				     	required="required">
				    </div> 
				</div>				
					<div class="form-group">
					<div class="col-sm-12">
				     	<input type="submit" value="Signup" 
				     	class="btn btn-success btn-block">
				    </div>
				</div>
			</form>
			<!--End Signup-->
			
	</div>
</section>
<?php include $templates . 'footer.php';
  ob_end_flush();
 ?>