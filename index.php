<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog - Home</title>
</head>
<nav class="menu">
	<h1>Blog</h1>
	<ol>
        <li class="crumb active"><a href="/">Home</a></li>
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
<div>
	<div class="post">
		<h1>Neuster Blog Post</h1>
		<!-- 
		Newest Blog Post
		Neusten Post aus Datenbank auslesen und Anzeigen.
		-->
	</div>
</div>
</body>
<footer>
	Author: Justin Preuß<br>
	Copyright © 2020 Justin Preuß<br>
	<a href="impressum.php">Impressum</a>
</footer>
</html>
