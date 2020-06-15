<?php
session_start();
if(isset($_SESSION['username'])){
//MyVariables
$pageTitle = "Dashboard";
include 'init.php';
$order = 5;
$LatestMembers =  getLatest('*', '`shop-users`', 'UserID', $order);
/*Start Dashboard Page*/
?>
	<!--Start Statistics of the Web-->
	<section class="home-stats text-center">
		<div class="container">
			<h1 class="text-capitalize">admin dashboard</h1>
			<div class="row">
				<div class="col-sm-3">
					<div class="stat st-members">
						<a href="members.php">
							<h3 class="text-capitalize">total members</h3>
							<span>
								<?php 
								echo countAndSelect('UserID', '`shop-users`');?>
								</span>
						</a>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="stat st-pending">
						<a href="members.php?do=Manage&page=Pending">
						<h3 class="text-capitalize">pending members</h3>
						<span><?php 
						echo countAndSelect('RegStatus', '`shop-users`', 0); 
						?></span>
					    </a>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="stat st-items">
						<h3 class="text-capitalize">total items</h3>
						<span>1500</span>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="stat st-comments">
						<h3 class="text-capitalize">total comments</h3>
						<span>3500</span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End Statistics of the Web-->
	<!--Start Latest News -->
	<section class="latest">
		<div class="container">
			<div class="row">
				<!--First Panel-->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading text-capitalize">
							<i class="fas fa-users"></i>
							latest <?php echo $order; ?>  registered users
						</div>
						<div class="panel-body">
							<?php 
							foreach ($LatestMembers as $member) {
								echo $member['username'] . "<br>";
							}
							 ?> 
						</div>
					</div>	
				</div>
				<!--Second Panel-->
					<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading text-capitalize">
							<i class="fas fa-shopping-bag"></i>
							latest items
						</div>
						<div class="panel-body">
							Test
						</div>
					</div>	
				</div>
			</div>
		</div>
	</section>
	<!--End Latest News -->
<?php
/*End Dashboard Page*/
include $templates . 'footer.php';

} else{
	header('location: index.php'); //if there's no Session return to the login Page
	exit();
}
