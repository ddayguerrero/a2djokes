<?php

// Establish connection with remote database.
$db_hostname = 'waldo2.dawsoncollege.qc.ca:3306';
$db_username = 'a2d';
$db_password = 'flower6gourd';
$db_database = 'a2d';

//local DB
// $db_hostname = 'localhost';
// $db_username = 'root';
// $db_password = 'root';
// $db_database = 'a2d';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server)
	die("Could not establish a connection with MySql: " . mysql_error());

$database = mysql_select_db($db_database);
if (!$database)
	die("Unable to select database: " . mysql_error());


// Add user to DB
// $username = 'a2d';
// $password = 'a2d';
// $token = crypt($password, $username);
// echo $token;

?>