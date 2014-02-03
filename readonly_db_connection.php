<?php

// Establish connection with remote database.
$db_hostname = 'waldo2.dawsoncollege.qc.ca:3306';
$db_username = 'readonly';
$db_password = '';
$db_database = 'a2d';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server)
	die("Could not establish a connection with MySql: " . mysql_error());

$database = mysql_select_db($db_database);
if (!$database)
	die("Unable to select database: " . mysql_error());

?>