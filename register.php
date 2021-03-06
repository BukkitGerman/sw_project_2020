<?php
session_start();

$db = new SQLite3("data.db");

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css">
	<title>Blog - Registrierung</title>
</head>
<nav class="menu">
	<ul>
        <li><a href="/">Home</a></li>
        <li><a href="posts.php">Posts</a></li>
        <?php 
        	if(isset($_SESSION['userid'])){
        		echo '<li><a href="profile.php?user='.$_SESSION["userid"].'">Profile</a></li>';
        	}
        ?>
        <?php
        if(!isset($_SESSION['userid'])){
        echo '<li style="float:right" class="active" id="login"><a href="login.php">Login</a></li>';
    	}else{
    	echo '<li style="float:right" class="active" id="logout"><a href="logout.php">Logout</a></li>';
    	}
        ?>
        <li><a href="impressum.php">Impressum</a></li>
    </ul>
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
			$result = $db->prepare("SELECT * FROM users WHERE email = :email");
			$result->bindValue(":email", $email);
			$result = $result->execute();
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
<div class="con">
 <div class="item" id="login">
<h1>Registrierung</h1><br>
<form action="?register=1" method="post">
E-Mail:<br>
<input type="email" size=40 maxlength="250" name="email" required placeholder="example@example.de"><br>

Passwort:<br>
<input type="password" size="40" maxlength="250"name="passwort" required><br>

Passwort widerholen:<br>
<input type="password" size="40" maxlength="250"name="passwort2" required><br>
<br>
<input type="submit" name="Registrieren" value="Registrieren">
	
</form>
<?php
}
?>
</div>
</div>
</body>
<footer>
	Author: Justin Preuß
	Copyright © 2020 Justin Preuß
</footer>
</html>