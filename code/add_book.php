<?php 
	session_start(); 
	require 'connect.php';

	if($_SESSION['user'] != 'admin'){
    	$_SESSION['resultString']='You are not authorized for this page!';
		header('Location:admin.php');
	}

	if($_POST  && $_FILES['coverpage']['size'] > 0 && $_FILES['ebook']['size'] > 0){

		$isbn = $_POST['isbn'];
		$title = $_POST['title'];
		$edition = $_POST['edition'];
		$publisher_id = $_POST['publisher'];
		$price = $_POST['price'];
		
		$result = mysqli_query($con,"SELECT isbn FROM book WHERE isbn = '$isbn'");
		
		if($result->num_rows == 1){
			echo "Book having same ISBN already exists in database!";

		}else{

			$fileName = $_FILES['coverpage']['name'];
			$tmpName  = $_FILES['coverpage']['tmp_name'];
			//$fileSize = $_FILES['userfile']['size'];
			//$fileType = $_FILES['userfile']['type'];

			$fp      = fopen($tmpName, 'r');
			$coverpage = fread($fp, filesize($tmpName));
	 		$coverpage = addslashes($coverpage);
	 		fclose($fp);

	 		$fileName1 = $_FILES['ebook']['name'];
			$tmpName1  = $_FILES['ebook']['tmp_name'];

	 		$fp1      = fopen($tmpName1, 'r');
			$ebook = fread($fp1, filesize($tmpName1));
	 		$ebook = addslashes($ebook);
	 		fclose($fp1);
			

	 		mysqli_autocommit($con, FALSE);

			$sql = "INSERT INTO ebook_store.book ( isbn, title, edition, publisher_id, price, coverpage, ebook) 
			VALUES ('$isbn', '$title', '$edition', '$publisher_id', '$price', '$coverpage', '$ebook')";
		
			if( !mysqli_query($con,$sql) ){
				die( 'Error: '. mysqli_error($con) );
			}else{
				foreach($_POST['authors'] as $id){
					$sql1 = "INSERT INTO book_author (book_isbn, author_id) VALUES ($isbn, $id)";
					if( !mysqli_query($con,$sql1) ){
						die( 'Error: '. mysqli_error($con) );
						mysqli_rollback($con);
					}
				}
				mysqli_commit($con);
				header('Location:list.php?param=book');
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
			<p>Add EBook</p>

			<form action="add_book.php" method="POST" ENCTYPE="multipart/form-data">
				<table>
					<th>
						<td>EBook Details</td>
					</th>
					<tr>
						<td>ISBN</td>
						<td><input type="text" id="f1" name="isbn">
							<script type="text/javascript">
		            		var f1 = new LiveValidation('f1');
		            		f1.add(Validate.Numericality, { onlyInteger: true } );
		          			</script>
						</td>
					</tr>
					<tr>
						<td>Title</td>
						<td><input type="text" id="f2" name="title">
							<script type="text/javascript">
		            		var f2 = new LiveValidation('f2');
		            		f2.add( Validate.Presence );
		          			</script>
						</td>
					</tr>
					<tr>
						<td>Edition</td>
						<td><input type="text" id="f3" name="edition">
							<script type="text/javascript">
		            		var f3 = new LiveValidation('f3');
		            		f3.add( Validate.Presence );
		          			</script>
						</td>
					</tr>
					<tr>
						<td>Author</td>
						<td>
							<select multiple name="authors[]">
								<?php 
									$result = mysqli_query($con,"SELECT * FROM author");

									while($row = mysqli_fetch_array($result)){ 

										echo "<option value='". $row['id'] ."'>".$row['first_name']. " ". $row['last_name'] ."</option>";
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Publisher</td>
						<td>
							<select name="publisher">
								<?php 
									$result = mysqli_query($con,"SELECT * FROM publisher");

									while($row = mysqli_fetch_array($result)){ 

										echo "<option value='". $row['id'] ."'>". $row['name'] ."</option>";
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Price</td>
						<td>
							<input type="text" id="f4" name="price">
							<script type="text/javascript">
		            		var f4 = new LiveValidation('f4');
		            		f4.add( Validate.Numericality );
		          			</script>							

						</td>
					</tr>
					<tr>
						<td>Coverpage</td>
						<td><input type="file" name="coverpage"></td>
					</tr>					
					<tr>
						<td>Ebook</td>
						<td><input type="file" name="ebook"></td>
					</tr>							
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" value="Add"></td>
					</tr>
				</table>
			</form>
	</div>			
</body>
</html>
