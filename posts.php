<?php
session_start();
$db = new SQLite3("data.db");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog - Posts</title>
</head>
<nav class="menu">
	<h1>Blog</h1>
	<ol>
        <li class="crumb"><a href="/">Home</a></li>
        <li class="crumb active"><a href="posts.php">Posts</a></li>
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
	<div class="Posts">
		<?php
			$rs = $db->query("SELECT * FROM posts");
			while($dbsatz = $rs->fetchArray()){
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
			}			
		?>
	</div>
</div>
</body>
<footer>
	Author: Justin Preuß<br>
	Copyright © 2020 Justin Preuß<br>
	<a href="impressum.php">Impressum</a>
</footer>
</html>