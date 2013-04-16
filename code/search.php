<?php
	require 'session.php';
	require 'connect.php';

	if($_POST){

		$search_str = $_POST['search_text'];		
	
		if($_POST['option'] == 'isbn'){
	
			$result = mysqli_query($con,"SELECT isbn,title,edition,publisher_id,price,coverpage FROM book WHERE isbn = '$search_str'");
	
		}else if($_POST['option'] == 'title'){
	
			$result = mysqli_query($con,"SELECT isbn,title,edition,publisher_id,price,coverpage FROM book WHERE title LIKE '%$search_str%'");
	
		}else if($_POST['option'] == 'author'){

			$search_arr = explode(" ",$search_str);
			if(count($search_arr) == 1){ 
				$search_arr[1] = '';
			}
			
			$author_ids = mysqli_query($con,"SELECT id FROM author WHERE first_name LIKE '%$search_arr[0]%' or last_name LIKE '%$search_arr[0]%' or last_name LIKE '$search_arr[1]'");
			$book_isbn_arr = array();

			while($row = mysqli_fetch_array($author_ids)){
				$author_id = $row['id'];
				$book_isbn = mysqli_query($con,"SELECT book_isbn FROM book_author WHERE author_id = '$author_id'");
				while($row1 = mysqli_fetch_array($book_isbn)){
					array_push($book_isbn_arr,$row1['book_isbn']);
				}
			}
			$ids = join(',',$book_isbn_arr);
			$result = mysqli_query($con,"SELECT isbn,title,edition,publisher_id,price,coverpage FROM book WHERE isbn IN ($ids)");

		}else if($_POST['option'] == 'publisher'){

			$pub_ids = mysqli_query($con,"SELECT id FROM publisher WHERE name LIKE '%$search_str%'");
			$pub_id_arr = array();

			while($row = mysqli_fetch_array($pub_ids)){
				array_push($pub_id_arr,$row['id']);
			}
			$ids = join(',',$pub_id_arr);
			$result = mysqli_query($con,"SELECT isbn,title,edition,publisher_id,price,coverpage FROM book WHERE publisher_id IN ($ids)");
		}
?>

<?php	}
?>


<html>
<head>
	<title>Search for Ebooks!</title>

</head>
<body>
		<div align="center">
			<a href="home.php">Ebooks List</a>
			<a href="logout.php">Logout</a>
			<p>Search for Ebooks</p>
			<form action="search.php" method="post">
				<input type="text" name="search_text">
				<select name="option">
					<option value="isbn">ISBN</option>
					<option value="title">Title</option>
					<option value="author">Author</option>
					<option value="publisher">Publisher</option>
				</select>
				<input type="submit" value="Search">
			</form>

	<?php if($_POST) { ?>


		    <table border="1">
				    
				    	<tr>
				    		<td><b>ISBN</b></td>
				    		<td><b>Title</b></td>
				    		<td><b>Edition</b></td>
				    		<td><b>Author</b></td>
				    		<td><b>Publisher</b></td>
				    		<td><b>Price</b></td>
				    		<td><b>CoverPage</b></td>
				    		<td>&nbsp;</td>
				    		<td>&nbsp;</td>
				    	</tr>
				    	
				    
					    <?php if($result){
					    		while($row = mysqli_fetch_array($result)){ 
						?>
								  <tr>
								  	<td><?php echo $row['isbn']; ?></td>
								  	<td><?php echo $row['title']; ?></td>
								  	<td><?php echo $row['edition']; ?></td>
								  	<td>
								  		<?php 
								  				$author_id_res = mysqli_query($con,"SELECT author_id FROM book_author WHERE book_isbn = " .$row['isbn']. "");
								  				$author_id_arr = array();
								  				while($author_row = mysqli_fetch_array($author_id_res)){
							  						array_push($author_id_arr,$author_row['author_id']);

								  				}
								  				
								  				$ids = join(',',$author_id_arr);  	
								  				$authors = mysqli_query($con,"SELECT first_name,last_name FROM author WHERE id IN ($ids)");
								  				while($author = mysqli_fetch_array($authors)){
								  					echo $author['first_name'] ." ".$author['last_name']."<br/> ";
								  				}

								  		?>
								  	</td>
								  	<td>
								  		<?php 
								  				$pub_res = mysqli_query($con,"SELECT name FROM publisher WHERE id = " .$row['publisher_id']. "");
								  				$pub_row = mysqli_fetch_array($pub_res);
								  				echo $pub_row['name']; 
								  		?>
								  	</td>
								  	<td>$<?php echo $row['price']; ?></td>
								  	<td>
								  		<?php echo '<img src="data:image/jpeg;base64,' . base64_encode( $row['coverpage'] ) . '" heigh="92" width="42"/>'; ?>
								  	</td>
								  	<td><a href="review.php?isbn=<?php echo $row['isbn']?>">Review</a></td>
								  	<td><a href="buy.php?isbn=<?php echo $row['isbn']?>">Buy</a></td>
								  </tr>
								<?php }
							}
							?>
    			
					</table>
	<?php } ?>
		</div>



</body>
</html>

