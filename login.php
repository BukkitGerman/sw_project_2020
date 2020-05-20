<?php
session_start();
$db = new SQLite3("data.db");

if(isset($_GET['login'])){
	$email = $_POST['email'];
	$passwort = $_POST['passwort'];

	$stmt = $db->query("SELECT * FROM users WHERE email = '$email'");
	$user = $stmt->fetchArray();
	$userpw = $user["passwort"];


	if ($user !== false){
		if(password_verify($passwort, $userpw)){
			$_SESSION['userid'] = $user['id'];

			die('Login erfolgreich. Weiter zu <a href="profile.php">deinem Profil!</a>');

	    } else {
	        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
	    }
	}
}

?>


<!DOCTYPE html> 
<html> 
<head>
  <title>Login</title>    
</head> 
<nav class="menu">
	<ol>
        <li class="crumb"><a href="/">Home</a></li>
        <li class="crumb"><a href="posts.php">Posts</a></li>
        <li class="crumb"><a href="profile.php">Profile</a></li>
        <li class=crumb active' id='login'><a href='login.php'>Login</a></li>
    </ol>
</nav>
<body>
 
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
 

 <h1>Login</h1><br>
<form action="?login=1" method="post">
E-Mail:
<input type="email" size="40" maxlength="250" name="email"><br><br>
 
Dein Passwort:
<input type="password" size="40"  maxlength="250" name="passwort"><br>
 
<input type="submit" value="Login">
</form> 
</body>
<footer>
	<div>
		Author: Justin Preuß
		Copyright © 2020 Justin Preuß
		<a href="impressum.php">Impressum</a>

	</div>
	<div>
		<a href="register.php">Register</a>
	</div>
</footer>
</html>