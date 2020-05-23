<!DOCTYPE html>
<html>
<head>
	<title>Blog - Impressum</title>
</head>
<nav class="menu">
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
	<div class="middle box">
		<p>Justin Preuß<br>
		Beispiel Adresse 32<br>
		Tel. 3820137529</p>
	</div>
</body>
</html>