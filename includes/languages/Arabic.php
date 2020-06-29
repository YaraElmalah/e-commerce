<?php
  /*
We make an Associative Array For The languages (We can use also define)
  */
function lang($phrase){
 static  $arabic = array(
  "Welcome" => "مرحبا",
  "Admin"   => "مشرف"
  );
  return $arabic[$phrase];
}
/*
This is Function Called (translate Function) ==> We Will use it in the future
we used static here to refere to not everytime call it as the array would contains alot of words
*/
