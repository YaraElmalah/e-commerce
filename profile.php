<?php 
$pageTitle = 'My profile';
include 'init.php';
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
					<ul class="list-unstyled">
					<li class="text-capitalize">
					<i class="fas fa-user fa-fw"></i>
					 <span class="title">username</span>:
						<?php echo "<span>"  . $info['username'] . "</span>"  ?>
					</li>
				    <li class="text-capitalize"> 
				    	<i class="fas fa-envelope fa-fw"></i>
				    	<span class="title">contact email
				    </span>:
						<?php echo "<span>"  . $info['Email'] . "</span>" ?>
					</li>
				    <li class="text-capitalize">
				    <i class="fas fa-id-card fa-fw"></i>
				     <span class="title">full name</span>:
						<?php if(!empty($info['Full-Name'])){
						 echo "<span>"  . $info['Full-Name'] . "</span>"; 
						} else{
							echo "<span>"  . " --- " . "</span>";
						}
						?>
					</li>
				    <li class="text-capitalize">
				    	<i class="fas fa-calendar-day fa-fw"></i>
				    	<span class="title" >registered date</span>:<?php echo "<span>"  . $info['date'] . "</span>" ?>
				    </li>
					<li class="text-capitalize">
						<i class="fas fa-hat-cowboy-side fa-fw"></i>
						<span class="title">rank</span>:
						<?php echo "<span>";
						if($info['groupID'] == 1){
							echo 'Admin';
						}elseif ($info['RegStatus'] == 0) {
							echo 'Waiting for Activation';
						} else{
							echo 'User';
						}
						echo  "</span>" ?>
					</li>						
				   </ul> 
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
							"<h3><a href='items.php?itemid= " .
							 $ad['itemID'] ."&pageName=". 
							 str_replace(" ", "-", $ad['Name']) ."'>" .$ad['Name'] . "</a></h3>"
							 . "<p>"	. $ad['Description'] . "</p>" . 
							 "<span class='price-tag'>" . $ad['Price'] 
							 . "</span>" . 
							 "<span class='date'>" . $ad['Date'] .
							  "</span>";
							  if($ad['Approve'] == 0){
							  	echo "<span class='approve-pending'>" . "Waiting for Approve" . "</span>";
							  }
							echo   "</div>";
							echo "</div>";
						echo  "</div>";
						}
					} else{
						echo "<div class='empty-message'>There is no ads to show</div>";
						echo "<a href='additem.php' class=\"btn btn-info\">
		            <i class=\"fas fa-folder-plus\"></i> New Ad</a>";
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
					
					<?php
					$stmt = $connect->prepare("
						SELECT comment, added_Date FROM comments
						WHERE UserID = ? 
						ORDER BY added_Date DESC");
					$stmt->execute(array($info['UserID']));
					$comments = $stmt->FetchAll();
					if(!empty($comments)){
					echo "<div class=\"row\">";
					foreach ($comments as $comment ) {
					echo "<div class='col-sm-3'>";
					echo "<p class='profile-c'>" . $comment['comment'];
					echo "<span>" . $comment['added_Date'] .
					 "</span>
					 </p>";
					echo "</div>";
					
					}
					echo "</div>";
				} else{
					echo "<div class='empty-message'>There is no comments to show</div>";
				}

					?>
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