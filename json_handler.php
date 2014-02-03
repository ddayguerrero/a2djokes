<?php

header('Content-type: application/json');

require_once 'readonly_db_connection.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{

	if(isset($_POST['_id']))
		getJoke($_POST['_id']);
	else
		searchDB();
}

//This function searches the database using the fields provided
//Returns a JSON array of data containing a joke ID and description
function searchDB()
{

	$category = $_POST['category'];

	if($category == 'Geek' || $category == 'Holiday')
		$sub_category = $_POST['subcategory'];
	else
		$sub_category = "";

	$type = $_POST['type'];
	$description = $_POST['description'];

	if (!empty($description)) 
	{
		$description = "CONCAT('%','" . mysql_real_escape_string($description) . "','%')" ;
		$searchQuery = sprintf("SELECT _id, description FROM jokes WHERE category='%s' AND sub_category='%s' AND joke_type=%u AND description LIKE %s",
			$category, $sub_category, $type, $description);
	} else 
	{
		$searchQuery = sprintf("SELECT _id, description FROM jokes WHERE category='%s' AND sub_category='%s' AND joke_type=%u",
			$category, $sub_category, $type);
	}

	$result = mysql_query($searchQuery);
	$rows = mysql_num_rows($result);

	$arr = array();

	for ($i=0; $i < $rows; $i++) { 
		$row = mysql_fetch_row($result);
		array_push($arr, array('_id' => $row[0], 'description' => $row[1]));
	}

	$jsonArray = array('responseData' => $arr);
	print (json_encode($jsonArray));

}

//This function is called when user wants to downaload a joke from his Android device.
//It receives and ID and returns a JSON array with all information about the joke.
function getJoke($id)
{
	$jokeInfo = array();

	$getJokeQuery = sprintf("SELECT * FROM jokes WHERE _id=%u", $id);
	$getJokeResult = mysql_query($getJokeQuery);

	if(mysql_num_rows($getJokeResult) > 0)
	{
		$joke = mysql_fetch_row($getJokeResult);


		array_push($jokeInfo, array( "_id" => $joke[0], "category" => $joke[1], "sub_category" => $joke[2], 
			"joke_type" => $joke[3], "description" => $joke[4], "question" => $joke[5], "answer" => $joke[6], 
			"monologue" => $joke[7], "url" => $joke[8], "joke_source" => $joke[9], "comments" => $joke[10], "rating" => $joke[11],
			"release_status" => $joke[12], "create_date" => $joke[13], "modify_date" => $joke[14]));
	}	

	print json_encode(array('responseData' => $jokeInfo));
	
}

?>