<?php

if(isset($_POST['remove'])){
	echo $_POST['countries'];
	$fn = "../src/blocked_country.txt";
	$str=file_get_contents("../src/blocked_country.txt");

	if (empty($str)){
	    die('Failed to fetch data');
	}else{
		$oldMessage = $_POST['countries'];
	    //$oldMessage = "PH - Philippines";
	    $deletedFormat = "";
	    $str = str_replace($oldMessage, $deletedFormat,$str);
	    $a = file_put_contents('../src/blocked_country.txt',$str);
	    header("Location: ../config.php");
	}
}


elseif(isset($_POST['add'])){
	$country = $_POST['countries'];
	//file_put_contents('../src/blocked_country.txt',"\n", FILE_APPEND);
	file_put_contents('../src/blocked_country.txt',$country, FILE_APPEND);
	header("Location: ../config.php");

}


?>