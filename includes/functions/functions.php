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
function getItems($value , $where){
	global $connect;
	$stmt = $connect->prepare("SELECT * FROM items WHERE $where = ?
		                          ORDER BY Date DESC
		                           ");
	$stmt->execute(array($value));
	$items = $stmt->fetchAll();
	return $items;
}
//checkUserStatusV1.0
/*
Check if the user is activated 
$username = the username of the user
return 0 if it's not activated
return 1 if it's activated
*/
function checkUserStatus($username){
	global $connect;
	$stmt = $connect->prepare("SELECT username, RegStatus FROM 
		                       `shop-users` WHERE
		                       username =? 
		                       AND
		                        RegStatus = 1");
	$stmt->execute(array($username));
	$status = $stmt->rowCount();
	return $status;
}


?>