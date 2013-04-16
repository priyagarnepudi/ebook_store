<?php
	require 'session.php';
	require 'connect.php';

	if($_GET){

		$isbn = $_GET['isbn'];
		$result = mysqli_query($con, "SELECT title,ebook FROM book WHERE isbn = $isbn");

		while($row = mysqli_fetch_array($result))
		{
			header("Content-type: application/pdf");
  			header("Content-Disposition: attachment; filename=".$row['title']."");
  			header("Content-Description: PHP Generated Data");
  			echo $row['ebook'];
  			/*
  			header("Content-type: image/jpg");
  			header("Content-Disposition: attachment; filename=".$row['title']."");
  			header("Content-Description: PHP Generated Data");
  			echo $row['coverpage'];
  			*/
  		}
	}

?>