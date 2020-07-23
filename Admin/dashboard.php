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
							<div class="info">
							<i class="fas fa-users"></i>
							<span class="pull-right">
								<?php 
								echo countAndSelect('UserID', '`shop-users`');?>
								</span>
							</div>
						</a>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="stat st-pending">
						<a href="members.php?do=Manage&page=Pending">
						<h3 class="text-capitalize">pending members</h3>
						<div class="info">
						<i class="fas fa-pause"></i>
						<span class="pull-right"><?php 
						echo countAndSelect('RegStatus', '`shop-users`', 0); 
						?></span>
					</div>
					    </a>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="stat st-items">
						<a href="items.php?do=Manage">
						<h3 class="text-capitalize">total items</h3>
						<div class="info">
						<i class="fas fa-shopping-cart"></i>
						<span class="pull-right"><?php echo countAndSelect('itemID', 'items')?> </span>

					</div>
					</a>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="stat st-comments">
						<a href="comments.php">
						<h3 class="text-capitalize">total comments</h3>
					   <div class="info">
						<i class="fas fa-comments"></i>
						<span class="pull-right">
							<?php echo countAndSelect('c_id', 'comments') ?> 
						</span>
					</div>
				</a>
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
							<span class="pull-right toggle-show">
								<i class="fas fa-plus"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-data">
							<?php 
							if(!empty($LatestMembers)){
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
						} else{
							echo "There is no users to show";
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
							 <span class="pull-right toggle-show">
								<i class="fas fa-plus"></i>
							</span>

						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-data">
							<?php 
							if(!empty($LatestItems)){
							foreach ($LatestItems as $item) {
								echo "<li>" .  $item['Name'];
								echo "<a href='items.php?do=Edit&itemid=" . 
						 $item['itemID'] .  "' class='btn btn-success pull-right'> <i class=\"fas fa-edit\"></i> Edit</a>  " . 
					"<a href='items.php?do=Delete&itemid=" . $item['itemID'] . "' class='btn btn-danger confirm pull-right'> <i class=\"fas fa-trash-alt\"></i> Delete</a>"; 
					      if($item['Approve'] == 0){
									echo " <a href='items.php?do=Approve&itemid=" .
									 $item['itemID'] . " ' class='btn btn-info pull-right activate'>
									  <i class=\"fas fa-clipboard-check\"></i> Approve </a> 
									  <br>";

									} 
						echo "</li>";
						

							}
						} else{
							echo "There is no Item to show";
						}
							 ?> 
							</ul>
						</div>
					</div>	
				</div>
			</div>
	<!--Third Panel-->
					<div class="row">
					<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading text-capitalize">
							<i class="fas fa-comments"></i>
							 latest <?php echo $order; ?> comments 
							 <span class="pull-right toggle-show">
								<i class="fas fa-plus"></i>
							</span>

						</div>
						<div class="panel-body">
							<ul class="list-unstyled">
							<?php 
							$stmt = $connect->prepare("
						SELECT comments.*, items.Name AS item , 
						`shop-users`.username AS user
						FROM comments
						INNER JOIN items 
						   ON items.itemID = comments.itemID
						INNER JOIN `shop-users`
						   ON `shop-users`.UserID = comments.UserID
						   ORDER BY added_Date DESC
						");
					$stmt-> execute(); //Execute the Statement
					//Assign To a Variable
					$comments = $stmt-> FetchAll(); //get All comments
					    if(!empty($comments)){
							foreach ($comments as $comment) {
								echo "<li>";
								echo "<div class='comment-box'>";
									echo "<span class='comment-n'>
									<a href='members.php?do=Edit&userid=".
									$comment['UserID'] . "'>".$comment['user']
									 . "</a> </span>";
									 echo "<p class='comment-c'>";
									 
								echo  $comment['comment'];
								echo "<a href='comments.php?do=Delete&comid=" .
								 $comment['c_id'] . "' class='btn btn-danger confirm pull-right'> <i class=\"fas fa-trash-alt\"></i> Delete</a>"; 
					      if($comment['status'] == 0){
						  echo " <a href='comments.php?do=Approve&comid=" .
									 $comment['c_id'] . " ' class='btn btn-info pull-right activate'>
									  <i class=\"fas fa-clipboard-check\"></i> Approve </a> 
									  <br>";
									  echo "</p>";
									  echo "</div>";

									} 
						echo "</li>";
						

							}
						} else{
							echo "There is no comments to show";
						}
							 ?> 
							</ul>
						</div>
					</div>	
				</div>
			</div>
			</div>
		</div>
	</div>
	</section>
<?php
/*End Dashboard Page*/
include $templates . 'footer.php';
	
} else{
	header('location: index.php'); //if there's no Session return to the login Page
	exit();
}
ob_end_flush(); //Release the output
?>