<?php 
//getCats V1.0
/*
get Categories from the Database
*/
function getCats(){
	global $connect;
	$stmt = $connect->prepare("SELECT * FROM categories 
		                          ORDER BY Ordering ASC");
	$stmt->execute();
	$cats = $stmt->fetchAll();
	return $cats;
}
//getItems V1.0
/*
get Items from the Database
*/
function getItems($item){
	global $connect;
	$stmt = $connect->prepare("SELECT * FROM items WHERE CatID = ?
		                          ORDER BY Date DESC
		                           ");
	$stmt->execute(array($item));
	$items = $stmt->fetchAll();
	return $items;
}


?>