<?php require_once('db_connect.php');
include 'functions.php';

$message = array('<font color=black>Success!! Author added, activation mail will be sent instantly.</font>', 
	'Please fill in a name!', 
	'That name is already registered!',
	'Please fill in a e-mail address!', 
	'Mail address is invalid!', 
	'That e-mail address is already registered!',
	'Please fill in a biography!');
$errormsg = array();
if(count($_POST) > 0)
{
//Debugging
//echo $_POST['name'];
//echo "-<br/>";
//echo $_POST['mail'];
//echo "-<br/>";
//----------------


	$name = $_POST['name'];
	$mail = $_POST['mail'];
	$bio = $_POST['bio'];
	$ipaddress = $_SERVER["REMOTE_ADDR"];
	//error messages - unsure how to do this better or more effecient, $run could be better, unsure on triggering the right error message. (Maybe have big array of error message only get filled on error?)
	if ($name=='') { $errormsg[1]=true;}
	if ($mail=='') { $errormsg[3]=true;}
	if ($bio=='') { $errormsg[6]=true;}
	else {if (!filter_var( $mail, FILTER_VALIDATE_EMAIL)) { $errormsg[4]=true;}}
	

//This is easier to do with PDO - unsure how though. Will keep it like this, but very ineffecient!!
//Also, could most likely shorten this script by combining the two.


	if ($result = (mysqli_query($db, "SELECT * FROM day2_author WHERE name = '".$name."'"))) 
	{ 
		while($row = mysqli_fetch_array($result))
		{
			if(array_search($name, $row)) 
			{
				$errormsg[2]=true; 
			}
		}
	}
	else 
	{
		die(mysqli_error($db));	
	}	


	if ($result = (mysqli_query($db, "SELECT * FROM day2_author WHERE mail = '".$mail."'"))) 
	{ 
		while($row = mysqli_fetch_array($result))
		{
			if(array_search($name, $row)) 
			{
				$errormsg[5]=true; 
			}
		}
	}
	else 
	{
		die(mysqli_error($db));	
	}	

	
	if (array_search(true,$errormsg) == false) 
	{	
		//Register Author
		$sql = "INSERT INTO day2_author (name, mail, bio, ipaddress) VALUES ('$name', '$mail', '$bio', '$ipaddress')"; // Write the query to save an author to the database
		mysqli_query($db, $sql);
		

		///Placeholder - generate random key from regdate+mail as secure activationkey
//		$sql = "SELECT  FROM day2_author WHERE mail='$mail'"; 
//		echo'1<br/>';
//		
//
//		if ($result = mysqli_query($db, $sql))
//		{
//			echo'2<br/>';
//			if($row = mysqli_fetch_array($result))
//			{
//				
//
//				
//				$confirmkey=12345;
//				
//				
//			}
//		}
//		else
//		{
//			echo'3<br/>';
//			die(mysqli_error($db));
//		}

		$confirmkey=12345;	
		RegisterMail($name,$mail, $ipaddress, $confirmkey);
		$errormsg[0]=true;

		//clear previous results
		$name = NULL;
		$mail = NULL;
		$bio = NULL;
		$_POST = array();

	}
	else{}
}

?>

<!DOCTYPE>
<html>
	<head>
		<title>My first blog</title>
		<!--
		!!!
		<link rel="stylesheet" src="style.css" />
		!!! Don't forget to play around with css
		-->
	</head>
	<body>
		<div id="container">
			<?php require_once('blogheader.php') ?>
			<hr/>
			<section>
				<h1>Add an author</h1>
				<form action="addauthor.php" method="post">
					<label>Name</label><br/>
						<!-- Reinsert name and mail value after failed attempt to create author -->
					<input type="text" name="name" value="<?php  echo isset($name) ? $name : '' ?>" autofocus /><br/>
					<br/>
					<label>E-mail address</label><br/>
					<input type="text" name="mail" value="<?php  echo isset($mail) ? $mail : '' ?>" /><br/>
					<br/>
					<label>Biography</label><br/>
					<textarea name="bio" value="<?php  echo isset($bio) ? $bio : '' ?>"></textarea><br/> 
					<input type="submit" /><br/>
					
					<?php 
							for($i = 0; $i <= 7; $i++)
							{
								if ($errormsg[$i]==true)
								{
									echo "<li><font color=#B20000>$message[$i]</li></font>";
								}
							} 
					?>
				</form>
			</section>
		</div>
	</body>
</html>
<?php require_once('db_close.php') ?>