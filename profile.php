<?php include 'init.php';
if(isset($_SESSION['user'])){
?>
<section class="profile">
	<div class="container">
		<h1 class="text-center text-capitalize">your profile</h1>
		<!--Start About Me-->
		<div class="information">
			<div class="panel panel-primary">
				<div class="panel-heading">
					About Me
				</div>
				<div class="panel-body">
					Name: Yara
				</div>
			</div>
		</div>
		<!--End About Me-->
		<!--Start My Ads-->
		<div class="ads">
			<div class="panel panel-primary">
				<div class="panel-heading">
					My Ads
				</div>
				<div class="panel-body">
					Item: Iphone
				</div>
			</div>
		</div>
		<!--End My Ads-->
		<!--Start Latest Comments-->
		<div class="comments">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Latest Comments
				</div>
				<div class="panel-body">
					This a good Product
				</div>
			</div>
		</div>
		<!--End Latest Comments-->
		
	</div>
</section>
<?php } else{
	header('location:login.php');
}
?>
<?php include $templates . 'footer.php'; ?>