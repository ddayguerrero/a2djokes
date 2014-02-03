<?php 
//fetch username from the session
session_start();
if (isset($_SESSION['username']))
{
	$currentUser = $_SESSION['username'];
	if($currentUser == "admin")
		require_once 'db_connection.php'; 
	else
		require_once 'readonly_db_connection.php'; 
}
else
{
	header("Location: index.php");
	exit;
}

//if logout was pressed, deletes the session and redirects
if(isset($_POST['logout']))
{
	$_SESSION = array();
	session_destroy(); 
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0);
	header("Location: index.php"); 
}

//Creates a select list of categories and updates it depending on list displayed
function setCategories()
{
	$categories = array("All", "Geek", "Holiday", "Kids", "Animals", "Sports");

	if(!isset($_POST['category']))
		$category = "All";
	else
		$category = $_POST['category'];

	foreach ($categories as $data => $displayData) 
	{
		echo "<option value=\"$displayData\"";
		if ($displayData == $category) 
			echo " selected";
		echo ">$displayData</option>";
	}

	return $category;

}

// Fetches a list of jokes depending on the category
function fetchCategories($category = "All")
{
	if(isset($_POST['category']))
		$category = $_POST['category'];

	if($category != "All")				
		$whereClause = "WHERE category = '$category'";
	else
		$whereClause = "";

	$query = "SELECT _id, description FROM jokes " . $whereClause;
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);

	for ($i = 0; $i < $rows; ++$i)
	{
		$info = mysql_fetch_row($result);
		echo "<tr><td>$info[0]</td><td>";
		echo "<a href='joke_view.php?id=$info[0]'>";
		echo $info[1];
		echo '</a></td>';
		echo "</tr>"; 
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>All Jokes</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
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
			<div class="mainContent">
				<h1 class="centerText ">Jokes List</h1>
				<form id="" action="" method="POST"> 
					<div id="searchByCategory">
						<p class="formLabels">Select a category: </p>
						<select class='inputStyles' id='category' name='category' onchange='this.form.submit()'>
							<?php $category = setCategories(); ?>
						</select>			
					</div>
				</form>
				<hr class="mainHR">
				<table class="tableStyle">
					<tbody>
						<tr><td class="centerText tableTitle"><b>ID</b></td><td class="centerText"><b>Jokes</b></td></tr>
						<?php fetchCategories($category); ?>
					</tbody>
				</table>
				<div class="buttons">
					<a id="addJoke" class="menuButton bigButton" href='<?php echo "joke_form.php" ?>'>Add Joke</a>
				</div>
			</div> 
		</div>
		<div class="footer centerText">
			Copyright 2013 | A2D Team | PHP Phase 1
		</div>
	</body>
	</html>