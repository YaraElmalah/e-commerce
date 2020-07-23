<?php 
ob_start();
$pageTitle = str_replace("-", " ", $_GET['name']);
include 'init.php'; 
 	//print_r(getCats());
	if(isset($_GET['name'])){ 
		$tag = $_GET['name'];
		?>
		<h1 class="text-center"><?php echo str_replace('-', ' ' , $_GET['name']); ?></h1>
		<section class="category">
		<div class="container">
			<div class="row">
				<?php 

				$taggedItems = getAllFrom('*' , 'items' , "WHERE Approve = 1 AND tags like '%$tag%'" , 'itemID');
				   if(! empty($taggedItems)){
					foreach ($taggedItems as $item) {
						echo "<div class='col-sm-6 col-md-3'>";
							echo "<div class='thumbnail item-box text-center'>";
							echo "<img src='item-avatar.png' alt=''>";
							echo "<div class='caption'>" . 
							"<h3><a href='items.php?itemid= " .
							 $item['itemID'] ."&pageName=". 
							 str_replace(" ", "-", $item['Name']) ."'>" .$item['Name'] . "</a></h3>"
							 . "<p>"	. $item['Description'] . "</p>" . 
							 "<span class='price-tag'>" . $item['Price'] 
							 . "</span>" . 
							 "<span class='date'>" .$item['Date'] . "</span>" 
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