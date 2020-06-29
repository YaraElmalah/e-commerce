<?php include 'init.php'; ?> 
<section class="login-form">
	<div class="container">
		<h1 class="text-center text-capitalize"><span 
			class="login selected" data-class='.login'>login </span> 
			|<span class="signup" data-class='.signup'> signup </span></h1>
			<form class="form-horizontal login">
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
			
	</div>
</section>
<?php include $templates . 'footer.php'; ?>