<?php
/*
In the logout Page we should destroy the Session and Cookies if it exists
View https://www.php.net/session_destroy 
*/
//Start The Session
session_start();
session_unset(); //Unset The Data
session_destroy(); //Destroy the Data
header('location: index.php'); //Direct to the login Page
exit(); //Exit the script 