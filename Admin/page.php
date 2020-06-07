<?php
/*
gategories => [ Manage | Edit | Update | Add | Insert | Delete | Stats]
*/
//Write The Short if Condition
$do = isset($_GET['do'])? $_GET['do']: $do = 'Manage'; 
//Assign do;
//Create Our Page Depends on the $_GET
if($do == 'Manage'){
	echo "Welcome To Manage Page";
} elseif($do == 'Add'){
	echo "Welcome to the Add Page";
} elseif ($do == "Edit") {
	echo "Edit";
} 
elseif ($do == "Update") {
	echo "Update";
} 
elseif ($do == "Edit") {
	echo "Edit";
} 
elseif ($do == "Add") {
	echo "Add";
} 
elseif ($do == "Insert") {
	echo "Insert";
} 
elseif ($do == "Delete") {
	echo "Delete";
} 
elseif ($do == "Stats") {
	echo "Stats";
} 
else{
	echo "Error There's no Page With this Name";
}