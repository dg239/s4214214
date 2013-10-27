<?php require_once('db_connect.php');
/*******************************************************************
** Check if a post has been done
** If so, insert the post data in the database
** line 44 get all authors
*******************************************************************/

if(count($_POST))
{
	// Define the variables that need to be saved (title, text, author) and store $_POST values in there

	$sql = "INSERT INTO day2_post (title, text, author, ipaddress) VALUES ('".$_POST['title']."', '".$_POST['text']."', '".$_POST['author']."', '".$_SERVER["REMOTE_ADDR"]."')"; // Write the query to save a post to the database
	if($result = mysqli_query($db, $sql))
	{
		$_POST = array();
	}
	else
	{
		die(mysqli_error($db));	
	}
}

?>
<!DOCTYPE>
<html>
	<head>
		<title>My first blog</title>
		<link rel="stylesheet" src="style.css" />
	</head>
	<body>
		<div id="container">
			<?php require_once('blogheader.php') ?>
			<hr/>
			<section>
				<h1>Add post</h1>
				<form action="addpost.php" method="post">
					<label>Title</label><br/>
					<input type="text" name="title" autofocus /><br/>
					<br/>
					<label>Text</label><br/>
					<textarea name="text"></textarea><br/>
					<br/>
					<select name="author">
						<?php // Get authors and print as options for the dropdown 

						$sql = "SELECT * FROM day2_author WHERE mailconfirmed=1 "; // Query to get authors from database
						if($result = mysqli_query($db, $sql)) // If everything goes ok
						{
							// We loop over the every author so we can provide this author as an option
							while($row = mysqli_fetch_array($result))
							{
								$id 	= $row['id'];
								$name 	= $row['name'];

								//open option tag <option value="..."> (This value is what is send when the form is submitted! So not per se the visible value)
								echo "<option value='$id'>$name</option>";
							}
						}
						else // If something went wrong
						{
							die(mysqli_error($db));	
						}
						?>
					</select><br/>
					<br/>
					<input type="submit" />
				</form>
			</section>
		</div>
	</body>
</html>
<?php require_once('db_close.php') ?>