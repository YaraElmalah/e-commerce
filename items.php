<?php 
$pageTitle = str_replace("-", " ", $_GET['pageName']);
include 'init.php';
$flag = false;
foreach (getItems($pageTitle, 'Name') as $item => $itemSelf) {
	if(in_array($pageTitle, $itemSelf)){
		$flag = true; //To make sure that you enter the correct page without error pages displayed
	}
}

 	//print_r(getCats());
	if(isset($_GET['pageName']) && $flag == true &&  isset($_GET['itemid']) &&  is_numeric($_GET['itemid'])){
		//Our Database Query
		$stmt = $connect->prepare("SELECT items.*,
		 categories.Name AS catName,
		 `shop-users`.username AS member
		    FROM items 
		    inner join categories   ON 
				  categories.ID = CatID
			inner join `shop-users` ON 
	       `shop-users`.UserID = MemberID
		    WHERE itemID = ?
		            LIMIT 1
		                  ");
	    $stmt->execute(array($_GET['itemid']));
	    $myItem = $stmt->fetch();
?>
<section class="item-info">
	<div class="container">
		<h1 class="text-center text-capitalize"><?php echo $pageTitle ?></h1>
		<div class="row">
			<div class="col-sm-3">
				<img src="item-avatar.png" alt="item" class="img-thumbnail center-block">
			</div>
			<div class="col-sm-9">
				<div class="panel panel-default">
					<div class="panel-heading text-capitalize">item info</div>
					<div class="panel-body">
						<ul class="list-unstyled">
						<li><span><i class="fas fa-cash-register"></i> Item Name:  </span><?php echo
						 $myItem['Name'];?></li>
						<li><span><i class="far fa-clone"></i> Description:  </span><?php echo
						 $myItem['Description'];?></li>
						 <li><span><i class="fas fa-dollar-sign"></i> Price:  </span><?php echo
						 $myItem['Price'];?></li>
						 <li><span><i class="fas fa-globe-europe"></i> Made on:  </span><?php echo
						 $myItem['Origin'];?></li>
						  <li><span><i class="far fa-calendar-check"></i> Added On:  </span><?php echo
						 $myItem['Date'];?></li>
						  <li><span><i class="fas fa-id-card-alt"></i> Seller:  </span><a href="#"><?php echo
						 $myItem['member'];?></a></li>
						  <li><span><i class="fas fa-mask"></i> Category:  </span><a href="categories.php?pageid=<?php echo $myItem['CatID'] . "&pagename=" . str_replace(' ', '-', $myItem['catName']) ?>"><?php echo
						 $myItem['catName'];?></a></li>
					</ul>
					</div>
				</div>
			</div>
		</div>
		<hr class="custom">
		<?php 
			//Add Comment 
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$comment = filter_var($_POST['comment'],
			 FILTER_SANITIZE_STRING);
			echo $comment;
		}
		?>
		<div class="add-comment">
		<div class="row">
			<div class="col-sm-offset-3">
				<?php 
					if(isset($_SESSION['user'])){
				?>
				<h3 class="text-capitalize text-center">share with us your experience <i class="fas fa-flask"></i></h3>
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?itemid=". $myItem['itemID'] . "&pageName=" . str_replace(' ', '-', $myItem['Name']); ?>">
					<textarea class="form-control" name="comment"></textarea>
					<input type="submit" value="Add Comment" class="btn btn-success btn-lg btn-block">
				</form>
				<?php 
					}else{
					echo "<h3 class=\"text-center text-capitalize\"><a href='login.php'>Login or signup</a> to comment <i class=\"fas fa-sign-in-alt\"></i></h3>";
					}
				?>
			</div>
		</div>
	</div>
		<hr class="custom">
		<div class="row">
			<div class="col-sm-3">User Image</div>
			<div class="col-sm-9">User Comment</div>
		</div>
	</div>
</section>
<?php } else{
	echo "There is no such item";
}?> 
<?php include $templates . 'footer.php'; ?>