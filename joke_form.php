<?php
$allowEdit = false;

session_start();
if (isset($_SESSION['username']))
{
	$currentUser = $_SESSION['username'];

	if($currentUser == "admin")
	{
		require_once 'db_connection.php'; 
		require_once 'joke_utilities.php';
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

$categories = array("Geek", "Holiday", "Kids", "Animals", "Sports");
$types = array("Question & Answer", "Monologue", "Image");

$id = substr($_SERVER['QUERY_STRING'], 3);

if(is_numeric($id))	
	$action = "edit";
else
	$action = null;

if($action == "edit")
{
	$formAction = "Edit Joke";

	$query = "SELECT category, sub_category, joke_type, description, url, question, answer, monologue, comments, joke_source FROM jokes WHERE _id = $id";

	$result = mysql_query($query);
	if (!$result) 
		die ("Joke does not exists: " . mysql_error());

	$row = mysql_fetch_assoc($result);

	$category = $row['category'];
	$subcategory = $row['sub_category'];

	if ($row['joke_type'] == 0) {
		$type = "Question & Answer";
	} else if ($row['joke_type'] == 1) {
		$type = "Monologue";
	} else {
		$type = "Image";
	}

	$description = $row['description'];
	$question = $row['question'];
	$answer = $row['answer'];
	$monologue = $row['monologue'];
	$url = $row['url'];
	$comments = $row['comments'];
	$jokesource = $row['joke_source'];
}
else
{
	$formAction = "New Joke";
	$category = null;
	$subcategory = null;
	$type = null;
	$description = null;
	$url = null;
	$question = null;
	$answer = null;
	$monologue = null;
	$comments = null;
	$jokesource = null;
}


if($_SERVER['REQUEST_METHOD']=='POST')
{
	if($allowEdit)
	{
		$isValid = true;

		if(isset($_POST['subcategory']))
			$subcategory = $_POST['subcategory'];
		else
			$subcategory = null;

		if ($action == "edit") {
			editJoke($isValid, $subcategory, $id);
		} else {
			newJoke($isValid, $subcategory, $id);
		}
	}
	else
		$message = "You are not allowed to add or modify jokes in database!";
}



function setSubcategory()
{
	if($category == "Geek")
	{
		$geekSubCat = array("Computer Science", "Science");
		foreach ($geekSubCat as $data => $displayData) 
		{
			$str = ucfirst($displayData);
			echo "<option value=\"$str\"";

			if ($displayData == $subcategory)
				echo " selected";

			echo ">$displayData</option>";

		}
	}else if($category == "Holiday")
	{
		$holidaySubCat = array("Halloween", "Thanksgiving");
		foreach ($holidaySubCat as $data => $displayData) 
		{
			$str = ucfirst($displayData);
			echo "<option value=\"$str\"";

			if ($displayData == $subcategory) 
				echo " selected";

			echo ">$displayData</option>";
		}
	}
}

?>	
<!DOCTYPE HTML>
<html>
<head>
	<title>Joke Form</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/joke_form.js"></script>
</head>
<body>
	<div class="page-wrapper">
		<div id="header">
			<div class="headerWrapper">
				<div class="titlePanel"><h1 class="centerText">Jokes by A2D</h1></div>
				<div class="userPanel">
					<form id="logout" action="" method="POST">
						<?php if(isset($currentUser)) echo "Hello, $currentUser!"; ?>
						<input type="submit" name="logout" class="menuButton smallButton" value="logout"></div>	
					</form>
					<div style="clear:both;"></div>
				</div>
			</div>

			<div class="mainContent">
				<h2 class="centerText"><?php echo "$formAction"; ?></h2>
				<form id="jokeForm" action="" method="POST">
					<p class="formLabels">Category:</p>
					<select class="inputStyles" id="category" name="category">
						<?php
						foreach ($categories as $data => $displayData) 
						{
							$str = ucfirst($displayData);
							echo "<option value=\"$str\"";

							if ($displayData == $category)
								echo " selected";


							echo ">$displayData</option>";
						}
						?>
					</select><br>

					<div id="subCatPanel">
						<p class="formLabels">Subcategory:</p>
						<select class="inputStyles" id="subcategory" name="subcategory">
							<?php setSubcategory(); ?>			
						</select>
					</div>

					<p class="formLabels">Type:</p>
					<select class="inputStyles" id="type" name="type">
						<?php
						foreach ($types as $data => $displayData) 
						{
							$str = ucfirst($displayData);
							echo "<option value=\"$str\"";

							if ($displayData == $type)
								echo " selected";

							echo ">$displayData</option>";
						}

						?>
					</select><br>

					<p class="formLabels">Description:</p>
					<input class="inputStyles" name="description" type="text" value="<?php if(isset($description)) echo $description; ?>"><br>


					<div id="qandaPanel">
						<p class="formLabels">Question:</p>
						<input class="inputStyles" name="question" type="text" value="<?php if(isset($question)) echo $question; ?>"><br>
						<p class="formLabels">Answer:</p>
						<input class="inputStyles" name="answer" type="text" value="<?php if(isset($answer)) echo $answer; ?>">
					</div>

					<div id="monologuePanel">
						<p class="formLabels">Monologue:</p>
						<input class="inputStyles" name="monologue" type="text" value="<?php if(isset($monologue)) echo $monologue; ?>">
					</div>	

					<div id="urlPanel">
						<p class="formLabels">Image URL:</p>
						<input class="inputStyles" name="url" type="text" value="<?php if(isset($url)) echo $url; ?>">
					</div>

					<p class="formLabels">Comments:</p>
					<input class="inputStyles" name="comments" type="text" value="<?php if(isset($comments)) echo $comments; ?>"><br>
					<p class="formLabels">Joke Source:</p>
					<input class="inputStyles" name="source" type="text" value="<?php if(isset($jokesource)) echo $jokesource; ?>"><br>

					<div class="buttons">
						<input type="reset" class="menuButton smallButton" value="Reset" />
						<input type="submit" class="menuButton smallButton" value="<?php if(isset($formAction)) echo $formAction; ?>"/>
					</div>
					<?php 
					if(isset($message))
						echo "<p class='centerText'>$message</p>";
					?>
					<hr class="mainHR">
					<br>
					<div class='buttons'>
						<a class="menuButton bigButton" href="joke_list.php">Back to Joke List</a>
					</div>	
				</form>

			</div>
		</div>
		<div class="footer centerText">
			Copyright 2013 | A22D Team | PHP Phase 1
		</div>
	</body>
	</html>