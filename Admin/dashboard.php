<?php
ob_start(); //Output Buffering Start
session_start();
if(isset($_SESSION['username'])){
//MyVariables
$pageTitle = "Dashboard";
include 'init.php';
$order = 10;
$LatestMembers =  getLatest('*', '`shop-users`', 'UserID', $order);
$LatestItems   =  getLatest('*', 'items', 'itemID', $order);
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
						<a href="items.php?do=Manage">
						<h3 class="text-capitalize">total items</h3>
						<span><?php echo countAndSelect('itemID', 'items')?> </span>
					</a>
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
							<ul class="list-unstyled latest-users">
							<?php 
							foreach ($LatestMembers as $member) {
								echo "<li>" .  $member['username'];
								echo "<a href='members.php?do=Edit&userid=" . 
						 $member['UserID'] .  "' class='btn btn-success pull-right'> <i class=\"fas fa-user-edit\"></i> Edit</a>  " . 
					"<a href='members.php?do=Delete&userid=" . $member['UserID'] . "' class='btn btn-danger confirm pull-right'> <i class=\"fas fa-user-slash\"></i> Delete</a>"; 
						if($member['RegStatus'] == 0){

						echo " <a href='members.php?do=Active&userid=" . $member['UserID'] . " ' class='btn btn-info activate pull-right'><i class=\"fas fa-skiing\"></i> Activate </a>";

						}
						echo "</li>";
						

							}
							 ?> 
							</ul>
						</div>
					</div>	
				</div>
				<!--Second Panel-->
					<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading text-capitalize">
							<i class="fas fa-shopping-bag"></i>
							 latest <?php echo $order; ?> added items 
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
							<?php 
							foreach ($LatestItems as $item) {
								echo "<li>" .  $item['Name'];
								echo "<a href='items.php?do=Edit&itemid=" . 
						 $item['itemID'] .  "' class='btn btn-success pull-right'> <i class=\"fas fa-edit\"></i> Edit</a>  " . 
					"<a href='items.php?do=Delete&itemid=" . $item['itemID'] . "' class='btn btn-danger confirm pull-right'> <i class=\"fas fa-trash-alt\"></i> Delete</a>"; 
						echo "</li>";
						

							}
							 ?> 
							</ul>
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
ob_end_flush(); //Release the output
?>