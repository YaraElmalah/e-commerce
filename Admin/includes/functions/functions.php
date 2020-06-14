<?php
//getTitle Page V1.0
/*
Get Title of the page
*/
function getTitle(){
	global $pageTitle;
	if(isset($pageTitle)){
	 echo $pageTitle;
	} else{ 
		echo 'BuyIt';
	}
}
//Redirect Function V2.0
/*
Parameters of the Function
$errorMsg ==> Echo The Error Msg
$seconds  ==> Num of Seconds before redirecting (Default is 3)
$url      ==> link that you want to redirect into
if You didn't pass a parameter in the function then it will redirect into index.php else would redirect to back
*/
function redirectHome($errorMsg, $url = null, $seconds = 3){
	if($url === null){
		$url = 'index.php';
		$link = 'homepage';
	} else{
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'Previous Page';
		} else{
			$url = 'index.php';
		}
	}
 echo $errorMsg;
 echo '<div class=\'alert alert-info\'>You will be redirected to the ' .  $link  . 
 ' after ' .  $seconds .' seconds ...</div> </div>';
 header("refresh: $seconds;url=$url"); //redirect to index.php
 exit();
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
//Function countItemsV1.0
/*
Function to Count number of items rows
$items = The Items to Count
$table = the table to chose from 
*/
function countItems($items, $table){
	global $connect;
	$stmt2 = $connect->prepare("SELECT COUNT('UserID') FROM `shop-users`");
      $stmt2->execute();
 return $stmt2->fetchColumn();
}