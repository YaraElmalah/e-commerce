<?php
//getTitle Page
function getTitle(){
	global $pageTitle;
	if(isset($pageTitle)){
	 echo $pageTitle;
	} else{ 
		echo 'BuyIt';
	}
}