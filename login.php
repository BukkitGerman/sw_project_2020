<?php
session_start();
$db = new SQLite3("data.db");

if(isset($_GET['login'])){
	$email = $_POST['email'];
	$passwort = $_POST['passwort'];


	$stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
	$stmt->bindValue(':email', $email);
	$stmt = $stmt->execute();
	$user = $stmt->fetchArray();
	$userpw = $user["passwort"];


	if ($user !== false){
		if(password_verify($passwort, $userpw)){
			$_SESSION['userid'] = $user['id'];

			die('Login erfolgreich. Weiter zu <a href="profile.php?user='.$_SESSION["userid"].'">deinem Profil!</a>');

	    } else {
	        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
	    }
	}
}

?>


<!DOCTYPE html> 
<html> 
<head>
  <link rel="stylesheet" href="css/style.css">
  <title>Login</title>    
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
    	echo '<li style="float:right" id="logout"><a href="logout.php">Logout</a></li>';
    	}
        ?>
        <li><a href="impressum.php">Impressum</a></li>
    </ul>
</nav>
<body>
<div class="con">
 <div class="item" id="login">
 <h1>Login</h1><br>
<form action="?login=1" method="post">
E-Mail:<br>
<input class="login" type="email" size="40" maxlength="250" name="email" required><br><br>
 
Dein Passwort:<br>
<input class="login" type="password" size="40"  maxlength="250" name="passwort" required><br>
 <br>
<input class="login" type="submit" value="Login">
</form> 
<hr/>
<div>
<p>Wenn du noch kein Account hast dann kannst du dich <a href="register.php">Hier Registrieren.</a></p>
<br>
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
</div></div>
</div>
</body>
<footer>
	Author: Justin Preuß<br>
	Copyright © 2020 Justin Preuß<br>
</footer>
</html>