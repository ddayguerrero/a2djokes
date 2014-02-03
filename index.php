<?php
require_once 'readonly_db_connection.php';


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
// Look up username and password in USERS table
$query = sprintf("SELECT _id, username FROM users WHERE username= '%s' AND password= '%s';",
	mysql_real_escape_string(trim($_POST['username'])),
	mysql_real_escape_string(crypt(trim($_POST['password']), ($_POST['username']))));
	
	$result = mysql_query($query);
	$rows = mysql_num_rows($result);
	
	if ($rows == 1) {
		session_start();
		$info = mysql_fetch_row($result);

		$_SESSION['userID'] = $info[0]; 
		$_SESSION['username'] = $info[1];
		header("Location: joke_list.php");
		exit();
	} 
	else
	{
		header('HTTP/1.0 401 Unauthorized');
		$message = "Invalid username or password!";
	}
}else
{
	session_start();
	if (isset($_SESSION['username']))
		header("Location: joke_list.php");
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Jokes by A2D - Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body id="login">
	<div id="login_info">
		<div>
			<h1>Login to Jokes App</h1>
			<form method="POST" action="index.php">
				<h3>Username:</h3><input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>">
				<h3>Password:</h3><input type="password" name="password">
				<input type="submit" class="btnSubmit" value="Login" />
				<p><?php if(isset($message)) echo $message; ?></p>
			</form>
		</div>
	</div>
</body>
</html>