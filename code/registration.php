<?php 
	require 'connect.php';

	if($_POST){
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];


		$result = mysqli_query($con,"SELECT * FROM user WHERE email = '$email'");
		if($result->num_rows == 1){
			echo "You are already registered!";
		}
		else{
			 //create a prepared statement;
+  			$stmt = $con->prepare("insert into user(first_name,last_name, email, password) values (?,?,?,?)");
+    		//bind parameters for email and password;

		}else{

			$sql = "INSERT INTO user( first_name, last_name, email, password) VALUES ('$fname','$lname','$email','$password')";
			if( !mysqli_query($con, $sql) ){
				die( 'Error: '. mysqli_error() );
			}else{
				header('Location:index.php');
+    		$stmt->bind_param("ssss", $fname, $lname, $email, $password);
+    
+    		//execute the query;
+     		$stmt->execute(); 
+       	header('Location:home.php');
 			$stmt->close();
			}
		}

	}
?>
<html>
<head>
	<title>Registration</title>
	<script type="text/javascript" src="livevalidation_standalone.compressed.js"></script>
</head>
<body>
		<div align="center">	
			
			<a href="index.php">Login</a>
			<form action="registration.php" method="POST">
				<table>
					<tr>
						<td>&nbsp;</td>
						<td>Registration Details</td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><input type="text" name="fname" id="f1">
							<script type="text/javascript">
		         			var f1 = new LiveValidation('f1');
		           			f1.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" name="lname" id="f2">
							<script type="text/javascript">
		         			var f2 = new LiveValidation('f2');
		           			f2.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" name="email" id="f3">
							<script type="text/javascript">
		         			var f3 = new LiveValidation('f3');
		           			f3.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" name="password" id="f4">
							<script type="text/javascript">
		         			var f4 = new LiveValidation('f4');
		           			f4.add(Validate.Presence);
		     				</script>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="Register" value="Register"></td>
					</tr>
				</table>
			</form>
		</div>	
</body>
</html>
