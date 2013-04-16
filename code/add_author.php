<?php 
	session_start(); 
	require 'connect.php';

	if($_SESSION['user'] != 'admin'){
    	$_SESSION['resultString']='You are not authorized for this page!';
		header('Location:admin.php');
	}

	if($_POST){
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		
		$result = mysqli_query($con,"SELECT * FROM author WHERE first_name = '$fname' and last_name = '$lname'");
		if($result->num_rows == 1){
			echo "Author already added to database!";

		}else{
			$sql = "INSERT INTO author( first_name, last_name) VALUES ('$fname','$lname')";
			if( !mysqli_query($con,$sql) ){
				echo " ". mysqli_error();
				die( 'Error: '. mysqli_error() );

			}else{
				header('Location:list.php?param=author');
			}
		}
	}
?>
<html>
<head>
	<title>Admin Home!</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
</head>
<body>
		<a href="admin_home.php">Home</a>
		<div align="center">	
			<p>Add Author</p>

			<form action="add_author.php" method="POST">
				<table>
					<tr>
						<td></td>
						<td>Details</td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><input type="text" id="f1" name="fname">
							<script type="text/javascript">
		            		var f1 = new LiveValidation('f1');
		            		f1.add(Validate.Presence);
		          			</script>
						</td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" id="f2" name="lname">
							<script type="text/javascript">
		            		var f2 = new LiveValidation('f2');
		            		f2.add(Validate.Presence);
		          			</script>							

						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="Add"></td>
					</tr>
				</table>
			</form>
		</div>	
</body>
</html>
