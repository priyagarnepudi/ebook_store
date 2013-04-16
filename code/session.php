<?php session_start(); 

	if(!isset($_SESSION['cuser']) and !isset($_SESSION['cuserid'])){
    	$_SESSION['resultString']='You are not authorized for this page!';
		header('Location:index.php');
	}
?>