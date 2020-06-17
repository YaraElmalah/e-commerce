<?php
ob_start();
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
			$link = 'Previous Page';
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
	$stmt2 = $connect->prepare("SELECT COUNT($items) FROM $table");
      $stmt2->execute();
 return $stmt2->fetchColumn();
}
//Function to check and count itemsV1.0
/*
Here We are tying to merge both functions (checkItem, countItems)
Parameters ==> 
$items ==> the select or items that you want to select or count
$table ==> You Want Select from 
$value ==> The Value You want search on (Default = "")
*/
function countAndSelect($items, $table, $value=""){
	global $connect;
	if($value === ""){
			$stmt2 = $connect->prepare("SELECT COUNT($items) FROM $table");
            $stmt2->execute();
            $colCount = $stmt2->fetchColumn();		
            return $colCount;
	} else{
		$query = $connect->prepare("SELECT $items FROM $table 
		                         WHERE $items = ?");
	    $query->execute(array($value));
	    $count = $query-> rowCount();
	    return $count;
	}
}
//getLatest records from DatabaseV1.0
/*
get the latest Items or user or .. etc from the Database
$select ==> the Column You to select
$table ==> The table You want to get from Data
$order ==> the column you want to order by 
$limit ==> number of records you want to show (Default is 5)
*/
function getLatest($select, $table, $order ,$limit = 5){
	global $connect;
	$getData = $connect->prepare("SELECT $select FROM $table 
		                          ORDER BY $order DESC 
		                          LIMIT $limit");
	$getData->execute();
	$rows = $getData->fetchAll(); //get the Latest data from Database As an Array
	return $rows;
}
ob_end_flush();
?>