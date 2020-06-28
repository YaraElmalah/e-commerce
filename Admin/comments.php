<?php
ob_start();
$pageTitle = "Comments";
/*=====
	Manage Comments Page 
	As You Can Edit / Delete / Approve Comments from Here
====*/
session_start(); //Should be in All the Pages
if(isset($_SESSION['username'])){ 
   //If there is a session Continue
	include 'init.php';
		//Page Content
	//Write The Short if Condition
$do = isset($_GET['do'])? $_GET['do']: $do = 'Manage'; 
//Assign do;
//Create Our Page Depends on the $_GET
if($do == 'Manage'){ //Manage Page
	if(isset($_GET['page'])){
		$query = "WHERE status = 0";
	} else{
		$query = "";
	}
	?>
	<div class="container">
		<h1 class="text-center">Manage Comments</h1>
	<div class="table-responsive">
		<table class="table table-bordered text-center main-table">
			<tr>
				<th class="text-uppercase">#id</th>
				<th class="text-capitalize">comment</th>
				<th class="text-capitalize">added date</th>
				<th class="text-capitalize">item</th>
				<th class="text-capitalize">user</th>
				<th class="text-capitalize">control</th>
			</tr>
				<?php 
					$stmt = $connect->prepare("
						SELECT comments.*, items.Name AS item , 
						`shop-users`.username AS user
						FROM comments
						INNER JOIN items 
						   ON items.itemID = comments.itemID
						INNER JOIN `shop-users`
						   ON `shop-users`.UserID = comments.UserID
						   ORDER BY c_id DESC
						");
					$stmt-> execute(); //Execute the Statement
					//Assign To a Variable
					$comments = $stmt-> FetchAll(); //get All comments
					foreach ($comments as $comment) {
						 echo "<tr>";
						 echo "<td>" . $comment['c_id'] . "</td>";
						 echo "<td>" . $comment['comment'] . "</td>";
						 echo "<td>" . $comment['added_Date'] . "</td>";
						 echo "<td>" . $comment['item'] . "</td>";
						 echo "<td>" . $comment['user'] . "</td>";
						 echo "<td>" . "<a href='comments.php?do=Edit&comid=" . 
						 $comment['c_id'] .  "' class='btn btn-success'> <i class=\"fas fa-pencil-alt\"></i> Edit</a> " . 
					"<a href='comments.php?do=Delete&comid=" . $comment['c_id'] . "' class='btn btn-danger confirm'> <i class=\"fas fa-ban\"></i> Delete</a>"; 
						if($comment['status'] == 0){

						echo " <a href='comments.php?do=Approve&comid=" . $comment['c_id'] . " ' class='btn btn-info activate'><i class=\"fa fa-check\"></i> Approve </a>";

						}

						 echo "</tr>";
					}
			?>
			
		</table>
	</div>
     </div>
<?php } elseif ($do == "Edit") { //Edit Page
	//Edit from the id with short if condition
	$comid = isset($_GET['comid']) 
		&& is_numeric($_GET['comid'])? 
		intval($_GET['comid']): 0; 
		$stmt = $connect->prepare("SELECT * from comments
			WHERE c_id = ? 
			LIMIT 1"); //get this comment
		$stmt->execute(array($comid));
		$comments = $stmt->fetch();
		$count = $stmt-> rowCount();
		//if We have a record then it must be > 0
		if($count > 0 ){ ?>
			<h1 class="text-center">Edit Comment</h1>
	<div class="container">
		<form class="form-horizontal form-lg" action="?do=Update" method="POST">
			<div class="form-group">
				<input type="hidden" name="id" value="<?php echo $comid; ?>">
				<!--Start Comment-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Comment
				</label>
					<div class="col-sm-10 col-md-6">
						<textarea class='form-control' name='comment' required="required"><?php echo $comments['comment'] ?></textarea>
					</div>
				</div>
				<!--End Comment-->
				
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Save" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End Submit-->
				
			</div>
		</form>
	</div> <?php
		} else{
			$errorMsg =  "<div class='container'> 
			                   <div class='alert alert-danger'> 
			                   There is no such Comment
			                        </div>";
			redirectHome($errorMsg, 'back');
		}
	
        } 
elseif ($do == "Update") {
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Update Comment</h1>"; 
		//Get Variables From the Form
		$id = $_POST['id'];
		$comment = $_POST['comment'];
		
		 	
			//Database Query
			//Check if There is no errors 
			if(!empty($comment)){
			    //Update Database with this info
			     $stmt = $connect->prepare("UPDATE comments 
				SET comment = ? where c_id = ?");
		     	$stmt->execute(array($comment, $id));
		     	//Echo Success Message
		     	$success =  " <div class='container'>
		     	              <div class='alert alert-success'>" .  $stmt->rowCount() . " Record Updated </div>";
		     	redirectHome($success, 'back');
		    
			} else{
				//Get The Errors
	         $error = "<div class='container'>
                           <div class='alert alert-danger'>
                           		The Comment Can't be empty.
                           </div>";
                redirectHome($error, 'back');
			}
			
		
	}else{
		header('location: comments.php');
	}
} 
elseif ($do == "Delete") { //Delete Page ?>

			   <div class="container">
				<h1 class="text-center">Delete Comment</h1>
			
 <?php
		$comid = isset($_GET['comid']) 
		&& is_numeric($_GET['comid'])? 
		intval($_GET['comid']): 0; //That is our user that we would deal with
		//Now We get the Record from database
		$check = checkItem( 'c_id' , 'comments', $comid);
		//if We have a record then it must be > 0
		if($check > 0){ // User Existed
			//Delete Query
				$stmt = $connect->prepare("DELETE FROM comments WHERE
					                       c_id = :com");
				$stmt->bindParam(":com" , $comid);
				$stmt->execute();
				//Echo Success Message
			 $success =  "<div class='container'>
			                <div class='alert alert-success'>" .  $stmt->rowCount() . " Record Deleted </div> </div>";
			 redirectHome($success, 'back');
		} else{
			$error = " <div class='container'>
			               <div class='alert alert-danger'>There is No Such Comment</div> 
			            ";
			redirectHome($error, 'back');
		}
} 
elseif ($do == "Approve") { //Activate Page ?>
	          <div class="container">
				<h1 class="text-center">Approve Comment</h1>
			
 <?php
		$comid = isset($_GET['comid']) 
		&& is_numeric($_GET['comid'])? 
		intval($_GET['comid']): 0;
		$check = checkItem( 'c_id' , 'comments', $comid);
		//if We have a record then it must be > 0
		if($check > 0){ 
			//Delete Query
				$stmt = $connect->prepare("	UPDATE comments SET status = 1 WHERE  c_id = :com");
				$stmt->bindParam(":com" , $comid);
				$stmt->execute();
				//Echo Success Message
			 $success =  "<div class='container'>
			                <div class='alert alert-success'>" .  $stmt->rowCount() . " Comment Approved </div> </div>";
			 redirectHome($success, 'back');
		} else{
			$error = " <div class='container'>
			               <div class='alert alert-danger'>There is No Such Comment</div> 
			            ";
			redirectHome($error, 'back');
		}
	
} else{
	$error = " 
	            <div class='container'>
	            <h1 class='text-center'>Error 404</h1>
	            <div class='alert alert-danger'>There's no Page With this Name</div>
	            ";
			redirectHome($error);
}
	include $templates . 'footer.php';
} else{
	header('location:index.php');
	exit(); //Stop the Script
	 //Redirect To the Login Page if there is no  Session
}
ob_end_flush();
?>