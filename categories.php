<?php 
ob_start();
$pageTitle = str_replace("-", " ", $_GET['pagename']);
include 'init.php'; 
$flag = false;
foreach (getCats() as $cat => $catvalue) {
	if(in_array(str_replace('-', ' ' , $_GET['pagename']), $catvalue)){
		$flag = true; //To make sure that you enter the correct page without error pages displayed
	}
}

 	//print_r(getCats());
	if(isset($_GET['pagename']) && $flag == true){ 

		?>
	<section class="category">
		<div class="container">
			<h1 class="text-center"><?php echo str_replace('-', ' ' , $_GET['pagename']); ?></h1>
			<div class="row">
				
				<?php 
				$CatItems = getItems($_GET['pageid'] , 'CatID' , 'Approved');
				   if(! empty($CatItems)){
					foreach ($CatItems as $item) {
						echo "<div class='col-sm-6 col-md-3'>";
							echo "<div class='thumbnail item-box text-center'>";
							echo "<img src='item-avatar.png' alt=''>";
							echo "<div class='caption'>" . 
							"<h3><a href='items.php?itemid= " .
							 $item['itemID'] ."&pageName=". 
							 str_replace(" ", "-", $item['Name']) ."'>" .$item['Name'] . "</a></h3>"
							 . "<p>"	. $item['Description'] . "</p>" . 
							 "<span class='price-tag'>" . $item['Price'] 
							 . "</span>"
							.  "</div>";
							echo "</div>";
						echo  "</div>";
					}
				} else{

				echo 	"<div class='empty-message'>" . "There is no Items to show" . "</div>";
				}
				?>
			</div>
		</div>
	</section>

<?php   } else{
	header('location: index.php');
	exit();
}
include $templates . 'footer.php';
ob_end_flush();
?>