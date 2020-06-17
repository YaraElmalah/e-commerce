<?php
ob_start();
  session_start();
  //MyVariables
   $noNavbar = '';
  if(isset($_SESSION['username'])):
  	header('location: dashboard.php');
  endif;
  include 'init.php';
  	 //To Not Include Navbar here
  	//Check if The User Coming from HTTP POST Method
  	if($_SERVER['REQUEST_METHOD'] == 'POST'):
  			//Getting The Info From the Form
  		$username   = $_POST['user'];
  		$pass       = $_POST['pass'];
  		$securePass = sha1($pass);
  		
  		//Check if the user existed on the database
  		$stmt = $connect->prepare("
        SELECT username, Password, UserID 
        from `shop-users` 
        where username =? And Password =? And groupID = 1 
        LIMIT 1");
  		$stmt->execute(array($username, $securePass));
      $row = $stmt-> fetch(); //get the Data That You Get in An Array Form
  		$count = $stmt-> rowCount();
  		// echo $count; if the record is existed then it gives 1
  		//Check if the Record is existed 
  		if($count > 0):
  			$_SESSION['username'] = $username; //Register Session Name
        $_SESSION['id'] = $row['UserID']; //get the info from the Database then register it inside the Array
  			header('location: dashboard.php'); //go to the dashboard
  			exit(); //Stop the Script 
  		endif;

  	endif;


 ?>
  	<!--Start Login Form-->
 	<form class="login" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
 		<h4 class="text-capitalize text-center">admin login</h4>
 		<input class="form-control input-lg" type="text" name="user"
 		 autocomplete="off" placeholder="Username">
 		<input class="form-control input-lg" type="password" name="pass" autocomplete="new-password" placeholder="Password">
 		<input class="btn btn-primary btn-block" type="submit" value="Login">
 	</form>
 	<!--End Login Form-->
<?php
  include $templates . 'footer.php';
  ob_end_flush();
 ?>
