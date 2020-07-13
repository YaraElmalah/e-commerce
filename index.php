<?php 
ob_start();
include 'init.php'; 
$pageTitle = 'Home Page';
?> 
<div class="container">
<?php 
$AllItems  = getAllFrom('*' , 'items' , 'WHERE Approve = 1' , 'itemID');
               foreach ($AllItems as $item) {
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
?>
</div>

  
<?php include $templates . 'footer.php';
ob_end_flush();
?>
