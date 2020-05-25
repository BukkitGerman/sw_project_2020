<?php
	session_start();
	$db = new SQLite3("data.db");

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css">
	<title>Blog - Home</title>
</head>
<nav class="menu">
	<ul>
        <li class="active"><a href="/">Home</a></li>
        <li><a href="posts.php">Posts</a></li>
        <?php 
        	if(isset($_SESSION['userid'])){
        		echo '<li><a href="profile.php?user='.$_SESSION["userid"].'">Profile</a></li>';
        	}
        ?>
        <?php
        if(!isset($_SESSION['userid'])){
        echo '<li id="login"><a href="login.php">Login</a></li>';
    	}else{
    	echo '<li id="logout"><a href="logout.php">Logout</a></li>';
    	}
        ?>
        <li><a href="impressum.php">Impressum</a></li>
    </ul>
</nav>
<body>
<div>
	<div class="post">
		<h1>Neuster Blog Post</h1>
		<?php
			$rs = $db->query("SELECT * FROM posts ORDER BY id DESC");
				$dbsatz = $rs->fetchArray();
				$head = $dbsatz['head'];
				$po = $dbsatz['post'];
				$rs_author = $db->query("SELECT vorname, nachname FROM users WHERE id = ".$dbsatz['author']);
				$rs_author_data = $rs_author->fetchArray();
				$author = $rs_author_data['vorname'] . " " . $rs_author_data['nachname'];
				$date = $dbsatz['created_at'];
				echo "<div class='post' id='id_".$dbsatz['id']."'>
					  	<h1>".$head."</h1>
					  	<p>".$po."</p><br>
					  	<p>Author: ".$author.", ".$date."</p>
					  </div><br>";
			
		?>
	</div>
</div>
</body>
<footer>
	Author: Justin Preuß<br>
	Copyright © 2020 Justin Preuß<br>
</footer>
</html>
