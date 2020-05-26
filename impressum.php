<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css">
	<title>Blog - Impressum</title>
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
        echo '<li style="float:right" id="login"><a href="login.php">Login</a></li>';
    	}else{
    	echo '<li style="float:right" id="logout"><a href="logout.php">Logout</a></li>';
    	}
        ?>
        <li class="active"><a href="impressum.php">Impressum</a></li>
    </ul>
</nav>
<body>
	<div class="middle box">
		<p>Justin Preuß<br>
		Beispiel Adresse 32<br>
		Tel. 3820137529</p>
	</div>
</body>
<footer>
	Author: Justin Preuß<br>
	Copyright © 2020 Justin Preuß<br>
</footer>
</html>