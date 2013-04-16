<?php 
	session_start(); 
	require 'connect.php';

	if($_SESSION['user'] != 'admin'){
    	$_SESSION['resultString']='You are not authorized for this page!';
		header('Location:admin.php');
	}

	if(!$_GET){
		echo "Invalid Request";
		header('Location:admin.php');

    }else{
    	?>
		<html>
		<head></head>
		<body>
		
		<a href="admin_home.php">Home</a>
			<div align="center">	
				<?php
				if($_GET['param'] == 'author'){
			
					$result = mysqli_query($con,"SELECT * FROM author");
				?>
					<p><b>List of Authors</b></p>
				    <table border="1">
				    
				    	<tr>
				    		<td>First Name</td>
				    		<td>Last Name</td>
				    	</tr>
				    	
				    
					    <?php while($row = mysqli_fetch_array($result)){ 
						?>
							  <tr>
							  	<td><?php echo $row['first_name']; ?></td>
							  	<td><?php echo $row['last_name']; ?></td>
							  </tr>
						<?php }?>
    			
					</table>
				<?php }  

	
				else if($_GET['param'] == 'publisher'){
			
					$result1 = mysqli_query($con,"SELECT * FROM publisher");
					?>
				    <table border="1">
				    	<tr>
				    		<td>Publisher Name</td>
				    	</tr>
				    
					    <?php while($row = mysqli_fetch_array($result1)){ 
						?>
							  <tr>
							  	<td><?php echo $row['name']; ?></td>
							  </tr>
							<?php }?>

					</table>
				<?php }  


				else if($_GET['param'] == 'book'){
					
					$result = mysqli_query($con,"SELECT isbn,title,edition,publisher_id,price,coverpage FROM book");			
					?>
				<p><b>Ebooks List</b></p>
				    <table border="1">
				    
				    	<tr>
				    		<td><b>ISBN</b></td>
				    		<td><b>Title</b></td>
				    		<td><b>Edition</b></td>
				    		<td><b>Author</b></td>
				    		<td><b>Publisher</b></td>
				    		<td><b>Price</b></td>
				    		<td><b>CoverPage</b></td>
				    	</tr>
				    	
				    
					   <?php while($row = mysqli_fetch_array($result)){ 
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
							  					echo $author['first_name'] ." ".$author['last_name']."<br/>";
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
							  </tr>
						<?php }?>
    			
					</table>

				<?php }  
	    		
			    else{

			    	echo "Invalid Request";
			    	header('Location:admin.php');
			    }
			?>
		</div>
    </body>
    <html>

    	<?php
    
	require 'close.php';
	}
?>


