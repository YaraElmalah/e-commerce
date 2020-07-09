<?php 
$pageTitle = 'Add New Ad';
include 'init.php';
if(isset($_SESSION['user'])){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$formErrors = [];
		$itemName   = filter_var($_POST['name'] , FILTER_SANITIZE_STRING);
		$desc       = filter_var($_POST['desc'] , FILTER_SANITIZE_STRING);
		$price      = filter_var($_POST['price'] ,  
			                         FILTER_SANITIZE_NUMBER_INT);
		$country    = filter_var($_POST['country'],
		                         FILTER_SANITIZE_STRING);
		$status     = filter_var($_POST['status'] , 
			                     FILTER_SANITIZE_NUMBER_INT);
		$category   = filter_var($_POST['category'],
		                         FILTER_SANITIZE_NUMBER_INT);

		if(empty($itemName)){
			$formErrors[] = "Name can't be <strong>empty</strong>";
		} 
		if (empty($desc)) {
			$formErrors[] = "Description can't be <strong>empty</strong>";
		}
		if (empty($price)) {
			$formErrors[] = "Price can't be <strong>empty</strong>";
		} 	
		if (empty($country)) {
			$formErrors[] = "Country Filed can't be <strong>empty</strong>";
		} 
		if ($status == 0) {
			$formErrors[] = "You Should chose the status of The Item";
		}
		if ($category == 0) {
			$formErrors[] = "You Should chose the Category of The Item";
		}
		//Database Query
			//Check if There is no errors 
			if(empty($formErrors)){
	           
	             //Insert this info into Database 
				   	$stmt =  $connect->prepare("INSERT INTO items 
				   		(Name , Description, Price, Origin, Status , MemberID, CatID , `Date`) 
				   		VALUES 
				   		(:item, :des , :price, :country, :status, :members, :cats , now())");
				   	$stmt->execute(array(
				   		':item'    => $itemName,
				   		':des'     => $desc,
				   		':price'   => '$' . $price,
				   		':country' => $country,
				   		':status'  => $status,
				   		':members' => $useridSession ,
				   		':cats'    => $category

				   	));
			     	//Echo Success Message
			     	if($stmt){
			     		echo "<div class='alert alert-success text-center'>The Item is added Successfully &#128079; &#x1F44F;</div>";
			     		$itemName = NULL;
			     		$desc     = NULL;
			     		$price    = NULL;
			     		$country  = NULL;
			     		$status   = NULL;
			     		$category = NULL;
			     	}

				} else{
				//Get The Errors
				echo "<div class='container'>";
	          foreach ($formErrors as $error) {
				echo "<div class='alert alert-danger'>"  . 
				$error . "</div>";
			 }

			}
			
	}

?>
<section class="profile">
	<div class="container">
		<h1 class="text-center text-capitalize"><?php echo $pageTitle ?></h1>
		<!--Start Adding New Ad-->
		<div class="information">
			<div class="panel panel-info">
				<div class="panel-heading">
				<i class="fas fa-location-arrow"></i>
					<?php echo  $pageTitle ?>
				</div>
				<div class="panel-body"> 
					<div class="row">
						<div class="col-md-8">
					<form class="form-horizontal form-lg live-preview" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
			<div class="form-group">
				<!--Start item name-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Item Name
				</label>
					<div class="col-sm-10 col-md-8">
						<input type="text" name="name" class="form-control"      
						 placeholder="The Name of this Item"
						 data-class='.live-title'
						 value = "<?php if(isset($itemName)): echo 
						 $itemName; endif; ?>">
					</div>
				</div>
				<!--End Item Name-->
				<!--Start Description-->
				<div class="form-group">
					<label class="col-sm-2 control-label">
					Description
				</label>
				<div class="col-sm-10 col-md-8">
				<input type="text" name="desc" class="form-control" placeholder="Describe This Item"     
				data-class='.live-desc'
				 value = "<?php if(isset($desc)): echo 
						 $desc; endif; ?>">
				</div>
				</div>
				<!--End Description-->
				<!--Start Price Field-->
					<div class="form-group">
						<label class="col-sm-2 control-label"> Price
				   </label>
					<div class="col-sm-10 col-md-8">
						<input type="text" name="price" class="form-control" placeholder="The Price of the Item" value = "<?php if(isset($price)): echo 
						 $price; endif; ?>"
						data-class='.live-price'>
					</div>
					</div>
				<!--End Price Field-->
				<!--Start Country Made Field-->
					<div class="form-group">
						<label class="col-sm-2 control-label"> Made In
				   </label>
					<div class="col-sm-10 col-md-8">
						<input type="text" name="country" class="form-control" placeholder="The Country that the Item Made in"   
						value = "<?php if(isset($country)): echo 
						 $country; endif; ?>"  >
					</div>
					</div>
				<!--End Country Made Field-->
				<!--Start Status Field-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> Status
			   </label>
				<div class="col-sm-10 col-md-8">
					<select name="status">
						<option value="0"></option>
						<option value="1"
						 <?php 
						if(isset($status) && $status == 1): echo 'Selected';  
						endif;?>>New</option>
						<option value="2" <?php 
						if(isset($status) && $status == 2): echo 'Selected';  
						endif;?>>Like New</option>
						<option value="3" <?php 
						if(isset($status) && $status == 3): echo 'Selected';  
						endif;?>>Used</option>
						<option value="4" <?php 
						if(isset($status) && $status == 4): echo 'Selected';  
						endif;?>>Old</option>

					</select>
				</div>
				</div>
			<!--End Status Field-->
			 <!--Start Category Field-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> Category
			   </label>
				<div class="col-sm-10 col-md-8">
					<select name="category">
						<option value="0"></option>
						<?php 
							$stmt2 = $connect->prepare("SELECT 
								* FROM categories");
							$stmt2->execute(); 
							$cats = $stmt2->fetchAll();
						foreach ($cats as $cat) {
							echo "<option value='". $cat['ID'] . "'"; 
							if(isset($category) && $category == $cat['ID']){
								echo 'selected';
							}
						   echo ">" .
							 $cat['Name'] . "</option>";
						}
				?>
					</select>
				</div>
				</div>
			   <!--End Category Field-->
			   
				<!--Start Submit-->
				<div class="form-group">
					<label class="col-sm-2 control-label"> 
				</label>
					<div class="col-sm-10 col-md-8">
						<input type="submit" value="Add Item" class="btn btn-primary btn-lg">
					</div>
				</div>
				<!--End Submit-->
				
					</div>
				</form>
					<!--Start Errors-->
					<div class="items-errors text-center">
				
				<?php
					if(!empty($formErrors)){
						echo "<div class='alert alert-danger'>";
						foreach ($formErrors as $error) {
							echo "<p>" .  $error . "</p>";
						}
						echo "</div>";
					}
				    if(isset($success)){
				    	echo $success;
				    }
				?>
			
			</div>
					<!--End Errors-->
						</div>
						<!--Start Live Preview-->
						<div class="col-md-3">
							<div class='thumbnail item-box text-center'>
							<img src='item-avatar.png' alt=''>
							<div class='caption'>
							<h3 class="live-title"><?php if(isset($itemName)){
								echo $itemName;
							}else{
								echo "Title";
							}?>
							</h3>
							<p class="live-desc"><?php if(isset($desc)){
								echo $desc;
							}else{
								echo "Description";
							}?></p>
							 <span class='price-tag'>$ <span class="live-price"><?php if(isset($price)){
								echo $price;
							}else{
								echo " ";
							}?></span> 
							 </span>
							</div>
							
						</div>
						</div>
						<!--End Live Preview-->
						
					</div>
				</div>
			
		<!--End Adding New Ad-->
	</div>
</section>
<?php } else{
	header('location:login.php');
	exit();
}
?>
<?php include $templates . 'footer.php'; ?>