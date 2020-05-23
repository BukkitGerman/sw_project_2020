<?php
session_start();

$db = new SQLite3("data.db");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog - Registrierung</title>
</head>
<nav class="menu">
	<h1>Blog</h1>
	<ol>
		<li class="crumb"><a href="/">Home</a></li>
		<li class="crumb"><a href="posts.php">Posts</a></li>
		<?php 
        	if(isset($_SESSION['userid'])){
        		echo '<li class="crumb active"><a href="profile.php?user='.$_SESSION["userid"].'">Profile</a></li>';
        	}
        ?>
		<?php
        if(!isset($_SESSION['userid'])){
        echo '<li class="crumb" id="login"><a href="login.php">Login</a></li>';
    	}else{
    	echo '<li class="crumb" id="logout"><a href="logout.php">Logout</a></li>';
    	}
        ?>
	</ol>
</nav>
<body>
<?php

$Showform = true;

if(isset($_GET['register'])){
	if(isset($_POST["email"]) && isset($_POST["passwort"]) && isset($_POST["passwort2"])){
		$e = false;
		$email = $_POST['email'];
		$passwort = $_POST['passwort'];
		$passwort2 = $_POST['passwort2'];
	
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			echo "E-Mail nicht gültig, bitte geben sie eine G&uuml;ltige E-Mail ein!<br>";
			$e = true;
		}
		if(strlen($passwort) == 0){
			echo "Bitte geben sie ein Passwort ein!";
			$e = true;
		}
		if($passwort != $passwort2){
			echo "Passw&ouml;rter stimmen nicht überein!";
			$e = true;
		}


		if(!$e){
			$result = $db->query("SELECT * FROM users WHERE email = '$email'");
			$user = $result->fetchArray();

			if($user != false){
				echo "E-Mail Adresse ist vergeben!";
				$e = true;
			}
		}

		if(!$e){
			$pw_hash = password_hash($passwort, PASSWORD_DEFAULT);

			$smt = $db->prepare("INSERT INTO users (email, passwort) VALUES (:email, :passwort)");
			$smt->bindValue(':email', $email, SQLITE3_TEXT);
			$smt->bindValue('passwort', $pw_hash);
			$smt->execute();

			if($result){
				echo "Registrierung erfolgreich! <a href='login.php'>Zum Login</a>";
				$Showform = false;
			} else {
				echo "Es ist ein Fehler aufgetreten!";
			}
		}

	}
}



if($Showform){
?>
<h1>Registrierung</h1><br>
<form action="?register=1" method="post">
E-Mail:
<input type="email" size=40 maxlength="250" name="email"><br>

Passwort:
<input type="password" size="40" maxlength="250"name="passwort"><br>

Passwort widerholen:
<input type="password" size="40" maxlength="250"name="passwort2"><br>

<input type="submit" name="Registrieren">
	
</form>
<?php
}
?>
</body>
<footer>
	Author: Justin Preuß
	Copyright © 2020 Justin Preuß
	<a href="impressum.php">Impressum</a>
</footer>
</html>