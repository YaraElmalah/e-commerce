<?php include 'init.php'; ?>
	
	<section class="category">
		<div class="container">
			<h1 class="text-center"><?php echo str_replace('-', ' ' , $_GET['pagename']); ?></h1>
			<div class="row">
				
				<?php 
				$CatItems = getItems($_GET['pageid']);
				   if(! empty($CatItems)){
					foreach ($CatItems as $item) {
						echo "<div class='col-sm-6 col-md-3'>";
							echo "<div class='thumbnail item-box text-center'>";
							echo "<img src='item-avatar.png' alt=''>";
							echo "<div class='caption'>" . 
							"<h3>" .$item['Name'] . "</h3>"
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

<?php include $templates . 'footer.php'; ?>