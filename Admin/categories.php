<?php
/*=======
======= Page Name: Template =======
=======*/
ob_start(); //Output Buffering Start
session_start();
$pageTitle = 'Categories';
$orderBy = 'Ordering';
$sort = 'ASC';
$sort_array = array('ACS', 'DESC'); //We will depend on it in get request
if(isset($_SESSION['username'])){  
	include 'init.php';
	$cats = getAllFrom('*', 'categories', 'WHERE Parent = 0' , $orderBy ,
                  'ASC');
	$subcats = getAllFrom('*', 'categories', 'WHERE Parent != 0' , $orderBy ,'ASC');
		//Page Content
	//Write The Short if Condition
$do = isset($_GET['do'])? $_GET['do']: $do = 'Manage'; 
//Assign do;
//Create Our Page Depends on the $_GET
	if($do == 'Manage'){ //Manage Page 

		if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
			$sort = $_GET['sort'];
		}	

		?>
	
<div class="categories">
	<div class="container">
			<h1 class="text-center">Manage Categories</h1>
		    <a href='categories.php?do=Add' class="btn btn-primary">
		    <i class="fas fa-cart-plus fa-lg"></i> New Category</a>
		    	<?php 
		    		if(!empty($cats)){
		    	?>
		    <div class="panel panel-default">
		    	<div class="panel-heading">
		    	<i class="fas fa-tasks"></i> Manage BuyIT Sections
		    	<div class="manage-order pull-right">
		    		[
		    		<a href="?sort=ASC" class="<?php
		    		 if($_GET['sort'] == 'ASC'): echo 'active'; endif;?>"><i class="fas fa-sort-numeric-down"></i> </a> |
		    		<a href="?sort=DESC" class="<?php
		    		 if($_GET['sort'] == 'DESC'): echo 'active'; endif;?>"><i class="fas fa-sort-numeric-up"></i>
		    		</a>
		    	     ] - [
		    		<span data-view="classic"><i class="fas fa-bars"></i></span> |
		    		<span data-view="full" class="active"><i class="far fa-newspaper"></i></span>
		    		]
		        </div>
		        
		    </div>
		    	<div class="panel-body">
		    		<?php 
		    			foreach ($cats as $cat) {
		    			echo "<div class='cat'>";
		    				echo "<h3> " .  $cat['Name'] . "</h3>";
		    				echo "<div class='full-view'>";
		    				echo  "<p>";
		    				 if(empty($cat['DesBox'])){
		    				 	echo "This Category has no Description.";
		    				 } else{
		    				 	echo $cat['DesBox'];
		    				 }
		    				 echo "</p>";
		    				 //Will Change it
		    				 if($cat['Visible'] == 0){
		    				 	echo "<span class='cat-hidden' title='Invisible'>" . "<i class=\"far fa-eye-slash\"></i>" . 
		    				 	"</span>";
		    				 }
		    				 if($cat['Allow_Comment'] == 0){
		    				 	echo "<span class='cat-comments' title='Comments Off'>" . "<i class=\"fas fa-comment-slash\"></i>" . 
		    				 	"</span>"; 
		    				 } 
		    				 if($cat['Allow_Ads'] == 0){
		    				 	echo "<span class='cat-ads' title='Ads Off'>" . "
		    				 	<span class=\"fa-stack fa-1x\">
                            <i class=\"fab fa-cloudversify fa-stack-1x\"></i>
                   <i class=\"fas fa-ban fa-stack-2x\" style=\"color:Tomato\"></i>
</span>" . 
		    				 	"</span>"; 
		    				 }
		    				 echo "<div class='hidden-buttons'>";
		    				 echo "<a href='?do=Edit&catid= ". $cat['ID']  . 
		    				 "' class='btn  btn-success'><i class=\"fas fa-pen-nib\"></i> Edit</a> ";
		    				 echo " <a href='?do=Delete&catid=". $cat['ID'] . " ' class='btn  btn-danger confirm'><i class=\"fas fa-trash\"></i> Delete</a>";
		    				 echo "</div>"; 
		    			     echo "</div>";

		    			     echo "</div>";
		    			     foreach ($subcats as $c ) {
		    			        if($cat['ID'] == $c['Parent']){
		    			     	echo "<a class='sub-cat' href='?do=Edit&catid= ". $c['ID']  . "'>" . $c['Name'] . "</a>";
		    			     }
		    			     }
		    			      echo "<hr>";
		    			
		    				
		    			}
		    		?>
		    	</div>
		    </div>
		<?php } else{
			echo "<div class='empty-message'> There is no Categories </div>";
		}?>
		</div>
	</div>
	<?php
	} elseif($do == 'Add'){ //Add New Category Page?>

	<h1 class="text-center">Add New Category</h1>
	<div class="container">
		<form class="form-horizontal form-lg" action="?do=Insert" method="POST">
			<div class="form-group">

				<!--Start Category name-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Category Name
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control"  required="required"
						 placeholder="The Name of this Gategory">
					</div>
				</div>
				<!--End Category Name-->
				<!--Start Description-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Description
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="text" name="desc" class="form-control" placeholder="Describe This Gategory">
				</div>
				</div>
				<!--End Description-->
				<!--Start Ordering-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Order
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="number" name="order" class="form-control"  
						 placeholder="Enter the Order You Want to show this Category off">
					</div>
				</div>
				<!--End Ordering-->
				<!--Start Category Type-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Category Type
				    </label>
					<div class="col-sm-10 col-md-6">
					<select name='cat-type' required>
							<option value="0">Main</option>
							<?php 
							foreach ($cats as $cat) {
							echo "<option value='". $cat['ID'] . "'>" .
							 $cat['Name'] . "</option>";
							}
							?>
						</option>
					</select>
					</div>
				</div>
				<!--End Category Type-->
				<!--Start Visibility-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Visibility
				</label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="vis-yes" name="visibility" value="1" checked>
						<label for="vis-yes">Yes</label>
					</div>
					<div>
						<input type="radio"  id="vis-no" name="visibility" value="0">
						<label for="vis-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Visibility-->
				<!--Start Allow Comments-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Allow Comments
				 </label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="com-yes" name="comment" value="1" checked>
						<label for="com-yes">Yes</label>
					</div>
					<div>
						<input type="radio"  id="com-no" name="comment" value="0">
						<label for="com-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Allow Comments-->
				<!--Start Allow Ads-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Allow Ads
				</label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="ads-yes" name="ads" value="1" checked>
						<label for="ads-yes">Yes</label>
					</div>
					<div >
						<input type="radio"  id="ads-no" name="ads" value="0">
						<label for="ads-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Allow Ads-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Add Gategory" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End Submit-->
				
			</div>
		</form>
	</div>

<?php
	} elseif ($do == 'Insert'){ 
	//Insert Page
       if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Insert New Category</h1>"; 
		//Get Variables From the Form
		$name         = $_POST['name'];
		$desc         = $_POST['desc'];
		$order        = $_POST['order'];
		$catType      = $_POST['cat-type'];
		$visibility   = $_POST['visibility'];
		$allowComment = $_POST['comment'];
		$allowAds     = $_POST['ads'];
		//Check if Category Exists
		if(!empty($name)){
		$check = countAndSelect('name', 'Categories' , $name);
		
		//Database Query
			//Check if There is no errors 
	            if($check == 1){
		             $error =  "<div class='container'>
		                        <div class='alert alert-danger'>The Category is already existed</div>";
		             redirectHome($error, 'back');
	            } else{
	             	//Insert this info into Database 
				   	$stmt =  $connect->prepare("INSERT INTO `categories`(Name, DesBox, Ordering, Parent, Visible, Allow_Comment, Allow_Ads) 
				   		VALUES (:name, :des, :order,:parent, :vis, :comm , :ads)");
				   	$stmt->execute(array(
				   		':name'  => $name,
				   		':des'   => $desc,
				   		':order' => $order,
				   		':parent'=> $catType,
				   		':vis'   => $visibility,
				   		':comm'  => $allowComment,
				   		':ads'   => $allowAds
				   	));
			     	//Echo Success Message
			     	$success = "<div class='container'>
			     	            <div class='alert alert-success'>" .  $stmt->rowCount() . " Category Added</div>";
			     	redirectHome($success, 'back');
				}
			} else{
				$error = "<div class='container'>
				<div class='alert alert-danger'>The name Can't be Empty !</div>";
				redirectHome($error, 5);
			}
			

      } else{
      	$error = " <div class='container'>
      	            <div class='alert alert-danger'>You are not Allowed to browse this Page</div>
      	            ";
		redirectHome($error, 3);
		
	}
	} elseif ($do == 'Edit'){ //Edit Page
	//Edit from the id with short if condition
	$catid = isset($_GET['catid']) 
		&& is_numeric($_GET['catid'])? 
		intval($_GET['catid']): 0; //That is our user that we would deal with
		//Now We get the Record from database
		$stmt = $connect->prepare("SELECT * from categories
			WHERE ID = ? 
			LIMIT 1"); //get this user
		$stmt->execute(array($catid));
		$row = $stmt->fetch();
		$count = $stmt-> rowCount();
		//if We have a record then it must be > 0
		if($count > 0 ){ ?>
			<h1 class="text-center">Edit Category</h1>
	<div class="container">
		<form class="form-horizontal form-lg" action="?do=Update" method="POST">
			<div class="form-group">
				<input type="hidden" name="id" value="<?php echo $catid; ?>">
				<div class="form-group">

				<!--Start Category name-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Category Name
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control"  required="required"
						 placeholder="The Name of this Gategory"
						 value="<?php echo $row['Name']; ?>">
					</div>
				</div>
				<!--End Category Name-->
				<!--Start Description-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Description
				</label>
				<div class="col-sm-10 col-md-6">
				<input type="text" name="desc" class="form-control" placeholder="Describe This Gategory"
				value="<?php echo $row['DesBox']; ?>">
				</div>
				</div>
				<!--End Description-->
				<!--Start Ordering-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Order
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="number" name="order" class="form-control"  
						 placeholder="Enter the Order You Want to show this Category off"
						 value="<?php echo $row['Ordering']; ?>">
					</div>
				</div>
				<!--End Ordering-->
				<!--Start Category Type-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Category Type
				    </label>
					<div class="col-sm-10 col-md-6">
					<select name='cat-type' required>
							<option value="0" <?php if($row['Parent'] == 0): echo 'selected'; endif;?>>Main</option>
							<?php 
						//$row here referes to the opened page category
							foreach ($cats as $cat) {
							echo "<option value='". $cat['ID'] . "'";
								if($row['Parent'] == $cat['ID']){
								 echo 'selected'; 
								
							}
							
							echo ">" .
							 $cat['Name'] . "</option>";
							}
							?>
						</option>
					</select>
					</div>
				</div>
				<!--End Category Type-->
				<!--Start Visibility-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Visibility
				</label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="vis-yes" name="visibility" value="1" <?php if($row['Visible'] == 1): echo 'checked'; endif;?>>
						<label for="vis-yes">Yes</label>
					</div>
					<div>
						<input type="radio"  id="vis-no" name="visibility" value="0" <?php if($row['Visible'] == 0): echo 'checked'; endif;?>>
						<label for="vis-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Visibility-->
				<!--Start Allow Comments-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Allow Comments
				 </label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="com-yes" name="comment" value="1" <?php if($row['Allow_Comment'] == 1): echo 'checked'; endif;?>>
						<label for="com-yes">Yes</label>
					</div>
					<div>
						<input type="radio"  id="com-no" name="comment" value="0" <?php if($row['Allow_Comment'] == 0): echo 'checked'; endif;?>>
						<label for="com-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Allow Comments-->
				<!--Start Allow Ads-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Allow Ads
				</label>
					<div class="col-sm-10 col-md-6">
					<div>
						<input type="radio" id="ads-yes" name="ads" value="1" <?php if($row['Allow_Ads'] == 1): echo 'checked'; endif;?>>
						<label for="ads-yes">Yes</label>
					</div>
					<div>
						<input type="radio"  id="ads-no" name="ads" value="0" <?php if($row['Allow_Ads'] == 0): echo 'checked'; endif;?>>
						<label for="ads-no">No</label>
					</div>
					
				</div>
			</div>
				<!--End Allow Ads-->
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-6">
						<input type="submit" value="Save Gategory" class="btn btn-primary btn-lg">
						<a href='?do=Delete&catid=<?php echo $catid ?>' class='btn  btn-danger confirm btn-lg'><i class="fas fa-trash"></i> Delete Category</a>
					</div>
				</div>
				<!--End Submit-->
				
			</div>
		</form>
	</div> <?php
		} else{
			$errorMsg =  "Wrong There is no such user";
			redirectHome($errorMsg);
		}
	
       
	} elseif ($do == 'Update'){
		if($_SERVER['REQUEST_METHOD'] === "POST"){
		echo "<h1 class='text-center'>Update Category</h1>"; 
		//Get Variables From the Form
		$catid    = $_POST['id'];
		$name     = $_POST['name'];
		$desc     = $_POST['desc'];
		$order    = $_POST['order'];
		$catType  = $_POST['cat-type'];
		$visible  = $_POST['visibility'];
		$Comments = $_POST['comment'];
		$ads      = $_POST['ads'];
			//Database Query

			//Check if There is no errors 
			if(!empty($name)){
			 $myCheck = $connect->prepare("SELECT * FROM categories
               	WHERE ID != ? ");
               $myCheck->execute(array($catid));
               $check = $myCheck->fetch();
	            if($check == 1){
		             $error =  "<div class='container'>
		                        <div class='alert alert-danger'>This Name already existed</div>";
		             redirectHome($error, 'back');
		         } else{
		         	//Update Database with this info
			     $stmt = $connect->prepare("UPDATE categories 
				SET Name = ? , DesBox = ? ,  Ordering = ?, Parent = ? , Visible = ? , Allow_Comment = ? , Allow_Ads = ?  where ID = ?");
		     	$stmt->execute(array($name, $desc, $order, $catType, $visible , $Comments , $ads, $catid));
		     	//Echo Success Message
		     	$success =  " <div class='container'>
		     	              <div class='alert alert-success'>" .  $stmt->rowCount() . " Record Updated </div>";
		     	redirectHome($success, 'back');
		         }
		    
			} else{
			   $error = " <div class='container'>
			   				<div class='alert alert-danger'>
			         The Name of The Category Can't be Empty
			         </div>";
			   redirectHome($error, 'back');
			}
			
		
	
	} else{
		header('location: categories.php?sort=ASC');
	}
	} elseif($do == 'Delete'){ //Delete Page ?>

			   <div class="container">
				<h1 class="text-center">Delete Category</h1>
			
 <?php
		$catid = isset($_GET['catid']) 
		&& is_numeric($_GET['catid'])? 
		intval($_GET['catid']): 0; //That is our Category that we would deal with
		//Now We get the Record from database
		$check = checkItem( 'ID' , 'categories', $catid);
		//if We have a record then it must be > 0
		if($check > 0){ // User Existed
			//Delete Query
				$stmt = $connect->prepare("DELETE FROM categories WHERE
					                       ID = :catid");
				$stmt->bindParam(":catid" , $catid);
				$stmt->execute();
				//Echo Success Message
			 $success =  "<div class='container'>
			                <div class='alert alert-success'>" .  $stmt->rowCount() . " Record Deleted </div> </div>";
			 redirectHome($success, 'back');
		} else{
			$error = " <div class='container'>
			               <div class='alert alert-danger'>There is No Such Category</div> 
			            ";
			redirectHome($error, 'back');
		}

	}
	else{
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
	exit(); 
}
ob_end_flush(); //Release The Output
?>