<?php
function editJoke($isValid, $subcategory, $id)
{
	if($_POST['type'] == "Question & Answer")
	{
		if (empty($_POST['description']) || empty($_POST['question']) || empty($_POST['answer']) || empty($_POST['comments']) || empty($_POST['source']))
			$isValid = false;
		else
			$updateQuery = sprintf("UPDATE jokes SET category='%s', sub_category='%s', joke_type=0, description='%s', question='%s', answer='%s', comments='%s', joke_source='%s', modify_date='" . date("Y-m-d H:i:s") . "', monologue=null, url=null  WHERE _id= '%s'", $_POST['category'], $subcategory, mysql_real_escape_string($_POST['description']), mysql_real_escape_string($_POST['question']), mysql_real_escape_string($_POST['answer']), mysql_real_escape_string($_POST['comments']), mysql_real_escape_string($_POST['source']), $id);

	}else if ($_POST['type'] == "Monologue")
	{
		if (empty($_POST['description']) || empty($_POST['monologue']) || empty($_POST['comments']) || empty($_POST['source']))
			$isValid = false;
		else
			$updateQuery = sprintf("UPDATE jokes SET category = '%s' , sub_category = '%s', joke_type = 1, description = '%s', monologue = '%s', comments = '%s', joke_source = '%s', modify_date='" . date("Y-m-d H:i:s") ."', url=null, question=null, answer=null WHERE _id= '%s' ; " , $_POST['category'], $subcategory, mysql_real_escape_string($_POST['description']), mysql_real_escape_string($_POST['monologue']), mysql_real_escape_string($_POST['comments']), mysql_real_escape_string($_POST['source']), $id);
	
	}else{
		
		if (empty($_POST['description']) || empty($_POST['url']) || empty($_POST['comments']) || empty($_POST['source']))
			$isValid = false;
		else
			$updateQuery = sprintf("UPDATE jokes SET category='%s', sub_category='%s', joke_type=2, description='%s', url='%s', comments='%s', joke_source='%s', modify_date='" . date("Y-m-d H:i:s") ."', monologue=null,question=null, answer=null WHERE _id='%s'" , $_POST['category'], $subcategory, mysql_real_escape_string($_POST['description']), mysql_real_escape_string($_POST['url']), mysql_real_escape_string($_POST['comments']), mysql_real_escape_string($_POST['source']), $id);
	}

	if ($isValid)
	{
		$result = mysql_query($updateQuery);
		if($result)
		{
			$message = "Joke successfully updated!";
			echo "<meta http-equiv='refresh' content='1'>";
		}
		else
			die ("Failed to edit joke1: " . mysql_error());		
	}
	else
		$message = "Please fill in all the fields!";
}

function newJoke($isValid, $subcategory, $id)
{
	if($_POST['category'] == "Geek" || $_POST['category'] == "Holiday")
		$subcategory = $_POST['subcategory'];
	else 
		$subcategory = "";

	if (empty($_POST['description']) || empty($_POST['comments']) || empty($_POST['source'])) 
		$isValid = false;
	else
	{
		if($_POST['type'] == "Question & Answer" ) 
		{
			if (empty($_POST['question']) || empty($_POST['answer']) )
				$isValid = false;
			else
				$type = 0;

		}
		else if($_POST['type'] == "Monologue")
		{
			if(empty($_POST['monologue']))
				$isValid = false;
			else
				$type = 1;
		}
		else if($_POST['type'] == "Image")
		{
			if(empty($_POST['url']))
				$isValid = false;
			else	
				$type = 2;	
		}
	}
	
	if ($isValid) {
		$insertQuery = "INSERT INTO jokes (_id, category, sub_category, joke_type, description, question, answer, monologue, url, joke_source, comments, rating, release_status, create_date, modify_date) VALUES (null, '" . $_POST['category'] . "', '$subcategory', '$type', '" . $_POST['description'] . "', '" . $_POST['question'] . "', '" . $_POST['answer'] . "', '" . $_POST['monologue'] . "', '" . $_POST['url'] . "', '" . $_POST['source'] . "', '" . $_POST['comments'] . "', 0, 0, '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d H:i:s") .  "');";			
		$result = mysql_query($insertQuery);
		if ($result) {
			$message = "Joke successfully inserted!";
			echo "<meta http-equiv='refresh' content='1'>";
		} else {
			die("Could not insert joke to database" . mysql_error());
		}
	}
	else
		$message = "Please fill in all the fields!";
}

?>