<?php session_start(); 

	if($_SESSION['user'] != 'admin'){
    	$_SESSION['resultString']='You are not authorized for this page!';
		header('Location:admin.php');
	}
?>
<html>
<head>
	<title>Admin Home!</title>
</head>
<body>
<div>
			<p>Welcome <?php echo $_SESSION['user']; ?></p>
			<div float="right"><a href="logout.php">Logout</a></div>
</div>
<div align="center">			
			
			<br/>
			<table width="400px">
				<tr>
					<td width="33%"><a href="add_author.php">Add Author</a></td>
					<td width="33%"><a href="add_publisher.php">Add Publisher</a></td>
					<td width="33%"><a href="add_book.php">Add Book</a></td>
				</tr>
				<tr>
					<td><a href="list.php?param=author">List Authors</a></td>
					<td><a href="list.php?param=publisher">List Publishers</a></td>
					<td><a href="list.php?param=book">List Books</a></td>
				</tr>
			</table>
			
</div>			
		
</body>
</html>
