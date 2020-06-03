<?php
session_start();
$db = new SQLite3("data.db");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css">
	<title>Blog - Posts</title>
</head>
<nav class="menu">
	<ul>
        <li><a href="/">Home</a></li>
        <li class="active"><a href="posts.php">Posts</a></li>
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
        <li><a href="impressum.php">Impressum</a></li>
    </ul>
</nav>
<body>
<div>
	<div class="Posts">
		<?php
		if(!isset($_GET['post'])){
			$rs = $db->query("SELECT * FROM posts ORDER BY id DESC");
			while($dbsatz = $rs->fetchArray()){
				$head = $dbsatz['head'];
				$po = $dbsatz['post'];

				$rs_author = $db->prepare("SELECT vorname, nachname FROM users WHERE id = :author");
				$rs_author->bindValue(":author", $dbsatz['author']);
				$rs_author = $rs_author->execute();
				$rs_author_data = $rs_author->fetchArray();
				$author = $rs_author_data['vorname'] . " " . $rs_author_data['nachname'];
				$date = $dbsatz['created_at'];
				if(strlen($po) > 1500){
					$ending = "...";
				}else{
					$ending = "";
				}
				echo "
				<div class='con-box'>
					<div class='item-box'>
					<div class='post' id='id_".$dbsatz['id']."'>
					  	<h1><a href='posts.php?post=".$dbsatz['id']."'>".filter_var($head, FILTER_SANITIZE_SPECIAL_CHARS)."</a></h1>
					  	<p>".substr(filter_var($po, FILTER_SANITIZE_SPECIAL_CHARS), 0, 1500)."".$ending."</p><br>
					  	<p>Author: <a href='profile.php?user=".$dbsatz['author']."'>".filter_var($author, FILTER_SANITIZE_SPECIAL_CHARS)."</a>, ".$date."</p>
					</div><br>
					</div>
				</div>";
			}
			}else if(isset($_GET['post'])){
				$rs = $db->prepare("SELECT * FROM posts WHERE id = :id");
				$rs->bindValue(":id", $_GET['post']);
				$db_result = $rs->execute();
				$db_result = $db_result->fetchArray();


				$head = $db_result['head'];
				$po = $db_result['post'];
				$rs_author = $db->query("SELECT vorname, nachname FROM users WHERE id = ".$db_result['author']);
				$rs_author_data = $rs_author->fetchArray();
				$author = $rs_author_data['vorname'] . " " . $rs_author_data['nachname'];
				$date = $db_result['created_at'];

				echo "
				<div class='con-box'>
					<div class='item-box'>
						<h1>".filter_var($head, FILTER_SANITIZE_SPECIAL_CHARS)."</h1>
					  	<p>".filter_var($po, FILTER_SANITIZE_SPECIAL_CHARS)."</p><br>
					  	<p>Author: <a href='profile.php?user=".$db_result['author']."'>".filter_var($author, FILTER_SANITIZE_SPECIAL_CHARS)."</a>, ".$date."</p>
					</div>
				</div>

					";


			}			
		?>
	</div>
</div>
</body>
<footer>
	Author: Justin Preuß<br>
	Copyright © 2020 Justin Preuß<br>
</footer>
</html>