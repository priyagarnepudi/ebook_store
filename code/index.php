<?php
session_start();
require 'connect.php';

if ($_POST)
{

	$email = $_POST['email'];
	$pass = $_POST['password'];
	
	
	$result = mysqli_query($con,"SELECT * FROM user WHERE email='" .$email."' and password='" .$pass. "'");
	if($result){
		$row = mysqli_fetch_array($result);
		if($row){
			$_SESSION['cuser'] = $email;
			$_SESSION['cuserid'] = $row['id'];
			header('Location:home.php');

		}else{
			echo "Incorrect email/password";
		}
	}else{
		echo "Incorrect email/password";
	}
	

}
?>

<html>
<head>
	<title> Ebook Store</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
</head>
<body>
	<div align="center">	
	<p>Welcome to Online Ebook Store</p>
	<a href="registration.php">Sign Up!</a>
	<form action="index.php" method="POST">
		<table>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" id="f1">
					<script type="text/javascript">
		         	var f1 = new LiveValidation('f1');
		           	f1.add(Validate.Presence);
		     		</script>							
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password" id="f2" >
					<script type="text/javascript">
		         	var f2 = new LiveValidation('f2');
		           	f2.add(Validate.Presence);
		     		</script>							
				</td>
			</tr>
			<tr><td>&nbsp;</td>
				<td><input type="submit" name="Login" value="Login"></td>
			</tr>
		</table>
	</form>
	</div>
</body>
</html>


