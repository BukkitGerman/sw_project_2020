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
  <title>Login</title>    
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
 <h1>Login</h1><br>
<form action="?login=1" method="post">
E-Mail:
<input type="email" size="40" maxlength="250" name="email"><br><br>
 
Dein Passwort:
<input type="password" size="40"  maxlength="250" name="passwort"><br>
 
<input type="submit" value="Login">
</form> 
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
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