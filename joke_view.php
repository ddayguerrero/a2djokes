<?php
$allowEdit = false;
session_start();
if (isset($_SESSION['username']))
{
	$currentUser = $_SESSION['username'];

	if($currentUser == "admin")
	{
		require_once 'db_connection.php'; 
		$allowEdit = true;
	}
	else
	{
		require_once 'readonly_db_connection.php'; 
		$allowEdit = false;
	}
}
else
{
	header("Location: index.php");
	exit;
}

if(isset($_POST['logout']))
{
	$_SESSION = array();
	session_destroy(); 
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0);
	header("Location: index.php"); 
	exit();
}

$id = substr($_SERVER['QUERY_STRING'], 3);

//fetches joke data from db based on ID
//If ID is invalid redirects to joke list page
if(is_numeric($id))	
{
	$query = "SELECT joke_type, description, question, answer, monologue, url FROM jokes WHERE _id = $id";
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
	if($rows > 0)
		$info = mysql_fetch_row($result);
	else
	{
		header("Location: joke_list.php");
		exit;
	}	
	
}
else
{
	header('Location: joke_list.php');
	exit;	
}


if(isset($_POST['deleteJoke']))
{

	if($allowEdit)
	{
	$deleteQuery = "DELETE FROM jokes WHERE _id=$id";
	$deleteResult = mysql_query($deleteQuery);

	if($deleteResult == 1)
		$deleteMessage = "Joke succesfully deleted!";
	else
		$deleteMessage = "Failed to delete the joke!";
	}
	else
		$deleteMessage = "You are not allowed to delete jokes from the database!";

}


function displayJoke($info)
{
	if($info[0] == "0"){
		$jokeType = "Question & Answer";
		echo "<h2 class='centerText'>$jokeType</h2>";
		echo "<p class='jokeContent'><span class='boldText'>Question</span>$info[2]</p>";
		echo "<p class='jokeContent'><span class='boldText'>Answer</span>$info[3]</p>";
	}
	else if ($info[0] == "1"){
		$jokeType = "Monologue";
		$monologue = str_replace('|', ' ', $info[4]);
		echo "<h2 class='centerText'>$jokeType</h2>";
		echo "<p class='jokeContent'>$monologue</p>";
	} else{
		$jokeType = "Image";
		echo "<h2 class='centerText'>$jokeType</h2>";
		echo "<img class='images' alt='Could not display the image. Invalid URL.' src='$info[5]' />";
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Joke View</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/joke_view.js"></script>
</head>
<body>
	<div class="page-wrapper">
		<div id="header">
			<div class="headerWrapper">
				<div class="titlePanel"><h1 class="centerText">Jokes by A2D</h1></div>
				<div class="userPanel">
					<form action="" method="POST">
					<?php if(isset($currentUser)) echo "Hello, $currentUser!"; ?>
					<input type="submit" name="logout" class="menuButton smallButton" value="logout"></div>	
					</form>
				<div style="clear:both;"></div>
			</div>
			</div>

			<div id="content" class="mainContent">
				<?php displayJoke($info); ?>
				<div class="buttons">
					<form id="deleteForm" method="POST" action="">
						<a id="editJoke" class="menuButton smallButton" href='<?php echo "joke_form.php?id=$id"; ?>'>Edit</a>
						<input name="deleteJoke" type="submit" value="Delete" class="menuButton smallButton"></input>
					</form>
				</div>
				<?php 
				if(isset($deleteMessage))
				{
					echo "<p class='centerText'>$deleteMessage</p>";
					echo "<meta http-equiv='refresh' content='1'>";
				}
				?>
				<hr class="mainHR">
				<br>
				<div class='buttons'>
					<a class="menuButton bigButton" href="joke_list.php">Back to Joke List</a>
				</div>	
			</div>

		</div>

		<div class="footer centerText">
			Copyright 2013 | A2D Team | PHP Phase 1
		</div>

	</body>
	</html>
