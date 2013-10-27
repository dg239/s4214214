<?php require_once('db_connect.php');
/*******************************************************************
** line 18 Show author
** line 41 Show list of posts
*******************************************************************/
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
				<?php // Get the author

				//Get the author id from the URL by using $_GET, and save as variable

				$sql = "SELECT * FROM day2_author WHERE id = '".$_GET['id']."'"; //Query to get author with that id from database
				if($result = mysqli_query($db, $sql))
				{
					if($row = mysqli_fetch_array($result))
					{
						$name 	= $row['name'];
						$bio 	= $row['bio'];

						echo "<h1>$name</h1>";
						echo "<p>$bio</p>";
					}
				}
				else // If something went wrong
				{
					die(mysqli_error($db));	
				}
				?>
			</section>
			<hr/>
			<section>
				<h1>Posts</h1>
				<ul>
					<?php // Get posts from database and print in list

					//Get the author id from the URL by using $_GET, and save as variable

					$sql = "SELECT * FROM day2_post WHERE author=".$_GET['id'].""; // Query to get all posts from author with that id
					if($result = mysqli_query($db, $sql)) // If everything goes ok
					{
						// We loop over every post and print this as a list item
						while($row = mysqli_fetch_array($result))
						{
							$id 	= $row['id'];
							$title 	= $row['title'];
							
							echo "<li>";					
							
								//open anchor tag (link) <a href="post.php?id=...">
								echo "<a href='post.php?id=$id'>";
								
									//echo post title
									echo "<span>$title</span>";
								
								//close anchor tag
								echo '</a>';
							
							echo "</li>";	
						}
					}
					else // If something went wrong
					{
						die(mysqli_error($db));	
					}
					?>
				</ul>			
			</section>
			<hr/>
			<section>
				<h1>Comments</h1>
				<ul>
					<?php 

					$sql = "SELECT * FROM day2_comment WHERE author=".$_GET['id']."";
					if($result = mysqli_query($db, $sql)) 
					{
						while($row = mysqli_fetch_array($result))
						{
							$postid 		= $row['postid'];
							$comment 	= $row['comment'];
							$commentid 	= $row['id'];
							echo "<li><a href='post.php?id=$postid&highlight=$commentid'> <span>";
							if (strlen($comment) >=14)
							{
								 echo(substr("$comment", 0, 13) . "... </span></a></li>");
							}
							else
							{
								echo $comment;
							}
						}
					}
					else 
					{
						die(mysqli_error($db));	
					}
					?>
				</ul>			
			</section>
		</div>
		
	</body>
</html>
<?php require_once('db_close.php') ?>