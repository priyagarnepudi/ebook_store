<?php
	session_start();
	if(isset($_SESSION['user'])){
  		unset($_SESSION['user']);
  		header('Location:admin.php');
	}
	
	if(isset($_SESSION['cuser'])){
		unset($_SESSION['cuser']);
		unset($_SESSION['cuserid']);
  		header('Location:index.php');

	}
?>