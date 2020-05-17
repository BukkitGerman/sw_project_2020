<!DOCTYPE html>
<html>
<?php 
$db = new SQLite3("data.db");

if( isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password2"])){

	$usr = $_POST["username"];
	$pwd = $_POST["password"];

	$db-> exec("CREATE TABLE IF NOT EXISTS login(
		id INTEGER PRIMARY KEY AUTOINCREMENT, 
		db_username TEXT NOT NULL DEFAULT '0',
		db_password TEXT NOT NULL DEFAULT '0',
		db_permission INTEGER NOT NULL DEFAULT '0')");

	$result = $db->query("SELECT * FROM login WHERE db_username = '$usr'");

	$result_usr = $result->fetchArray();

	if($usr != $result_usr['db_username']){

		if($_POST['password'] === $_POST['password2']){
			$db->exec("INSERT INTO login (
				db_username, 
				db_password,
				db_permission) VALUES (
				'$usr',
				'$pwd',
				0)");
			$info = "Registration Successful!";
			$form = "";
		}else{
			$info = "Passwords are not equal!";
			$form = '<form method="POST">
			<h3>Register</h3>
			<label>Username: <input type="text" name="username"></label><br>
			<!--<label>E-Mail: <input type="email" name="email"></label><br>-->
			<label>Password: <input type="password" name="password"></label><br>
			<label>Password: <input type="password" name="password2"></label><br>
			<input type="submit" name="Submit" value="Submit">
			</form>';
		}

	} else {
		$info = "Username already exist!";
		$form = '<form method="POST">
			<h3>Register</h3>
			<label>Username: <input type="text" name="username"></label><br>
			<!--<label>E-Mail: <input type="email" name="email"></label><br>-->
			<label>Password: <input type="password" name="password"></label><br>
			<label>Password: <input type="password" name="password2"></label><br>
			<input type="submit" name="Submit" value="Submit">
			</form>';
	}		
}else{
	$form = '<form method="POST">
			<h3>Register</h3>
			<label>Username: <input type="text" name="username"></label><br>
			<!--<label>E-Mail: <input type="email" name="email"></label><br>-->
			<label>Password: <input type="password" name="password"></label><br>
			<label>Password: <input type="password" name="password2"></label><br>
			<input type="submit" name="Submit" value="Submit">
			</form>';
}
?>
<head>
	<title>Blog - Register</title>
</head>
<nav class="menu">
	<ol>
		<li class="crumb"><a href="/">Home</a></li>
		<li class="crumb"><a href="posts.php">Posts</a></li>
		<li class="crumb"><a href="profile.php">Profile</a></li>
		<li class="crumb active" id="login"><a href="login.php">Login</a></li>
	</ol>
</nav>
<body>
	<div>
		<?php 
		echo $form;
		echo $info; 
		?>
	</div>
</body>
<footer>
	Author: Justin Preuß
	Copyright © 2020 Justin Preuß
	<a href="impressum.php">Impressum</a>
</footer>
</html>