<?php 
//getTitle Page V1.0
/*
Get Title of the page
*/
function getTitle(){
	global $pageTitle;
	if(isset($pageTitle)){
	 echo $pageTitle . " - " . 'BuyIt';
	} else{ 
		echo 'BuyIt';
	}
}
//Check Item FunctionV1.0
/*
Function to check item if it exists in Database
[Function accepts Parameters] ==> 
$select -> the item to Select [example: user, item, category]
$from   -> the table to Select from [example: users, items, categories]
$value  -> the value of Select[example: Yara, Laptop, Electronics]
Note: We make any Variable defined outside the function global to can access it
if You Want to check from an specific column write $select = $value
*/
function checkItem($select, $from, $value){
	global $connect; 
	$query = $connect->prepare("SELECT $select FROM $from 
		                         WHERE $select = ?");
	$query->execute(array($value));
	$count = $query-> rowCount();
	return $count;
}
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