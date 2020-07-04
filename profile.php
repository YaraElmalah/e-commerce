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
					<?php
					$stmt = $connect->prepare("SELECT * FROM `shop-users` 
						WHERE username = ?");
					$stmt->execute(array($sessionUser));
					$info = $stmt->fetch();
					?>
					<span class="text-capitalize"> name: <span>
						<?php echo "<span>"  . $info['username'] . "</span> <br>" ?>
				    <span class="text-capitalize"> contact email: <span>
						<?php echo "<span>"  . $info['Email'] . "</span> <br>" ?>
				    <span class="text-capitalize"> full name: <span>
						<?php echo "<span>"  . $info['Full-Name'] . "</span> <br>" ?>
				    <span class="text-capitalize"> registered date: <span>
						<?php echo "<span>"  . $info['date'] . "</span> <br>" ?>
					<span class="text-capitalize"> rank: <span>
						<?php echo "<span>";
						if($info['groupID'] == 1){
							echo 'Admin';
						} else{
							echo 'User';
						}
						echo  "</span> <br>" ?>
						
				    
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
					<?php
					$userAds = getItems($info['UserID'] , 'MemberID');
					if(!empty($userAds)){
						foreach ($userAds as $ad) {
							echo "<div class='col-sm-6 col-md-3'>";
							echo "<div class='thumbnail item-box text-center'>";
							echo "<img src='item-avatar.png' alt=''>";
							echo "<div class='caption'>" . 
							"<h3>" .$ad['Name'] . "</h3>"
							 . "<p>"	. $ad['Description'] . "</p>" . 
							 "<span class='price-tag'>" . $ad['Price'] 
							 . "</span>"
							.  "</div>";
							echo "</div>";
						echo  "</div>";
						}
					} else{
						echo "<div class='empty-message'>There is no ads to show</div>";
					}
				 
					?>
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
					<div class="row">
					<?php
					$stmt = $connect->prepare("
						SELECT comment, added_Date FROM comments
						WHERE UserID = ? 
						ORDER BY added_Date DESC");
					$stmt->execute(array($info['UserID']));
					$comments = $stmt->FetchAll();
					if(!empty($comments)){
					foreach ($comments as $comment ) {
					echo "<div class='col-sm-3'>";
					echo "<p class='profile-c'>" . $comment['comment'];
					echo "<span>" . $comment['added_Date'] .
					 "</span>
					 </p>";
					echo "</div>";
					
					}
				} else{
					echo "<div class='empty-message'>There is no comments to show</div>";
				}

					?>
				</div>
				</div>
			</div>
		</div>
		<!--End Latest Comments-->
		
	</div>
</section>
<?php } else{
	header('location:login.php');
	exit();
}
?>
<?php include $templates . 'footer.php'; ?>