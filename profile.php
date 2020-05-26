<?php
	session_start();
	$db = new SQLite3("data.db");

	function alert($msg) {
    	echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	if(isset($_SESSION['userid']) && isset($_GET['user'])){
		if($_SESSION['userid'] == $_GET['user']){
			$showdata = true;
			$rs = $db->query("SELECT berechtigung FROM users WHERE id = '".$_SESSION['userid']."'");
			$rsFetch = $rs->fetchArray();
			$permission = $rsFetch["berechtigung"];
		}else{
			$showdata = false;
		}
	}else{
		die('Bitte zuerst <a href="login.php">einloggen</a>');
	}

	if(isset($_POST['set']) && isset($_POST['name']) && isset($_POST['nachname'])){
		$smt = $db->prepare("UPDATE users SET vorname = :name, nachname = :nachname WHERE id = ".$_SESSION['userid']);
		$smt->bindValue(':name', $_POST['name']);
		$smt->bindValue(':nachname', $_POST['nachname']);
		$smt->execute();
	}

	if(isset($_POST['text']) && $permission >=1){
		$smt = $db->prepare("INSERT INTO posts (author, head, post) VALUES (:author, :head, :post)");
		$smt->bindValue(':author', $_SESSION['userid']);
		$smt->bindValue(':head', $_POST['head']);
		$smt->bindValue(':post', $_POST['text']);
		$smt->execute();

		alert("Beitrag Erfolgreich erstellt!");
	}

	if(isset($_POST['usid']) && $permission >=2){
		$smt = $db->prepare("UPDATE users SET berechtigung = :berechtigung WHERE id = ".$_POST['usid']);
		$smt->bindValue(':berechtigung', $_POST['level']);
		$smt->execute();
	}


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css">
	<title>Blog - Profile</title>
</head>
<nav class="menu">
	<ul>
        <li><a href="/">Home</a></li>
        <li><a href="posts.php">Posts</a></li>
        <?php 
        	if(isset($_SESSION['userid'])){
        		echo '<li class="active"><a href="profile.php?user='.$_SESSION["userid"].'">Profile</a></li>';
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
	<div class="con">
	<?php
	if($showdata == true){
		$stmt = $db->query("SELECT * FROM users WHERE id = '".$_SESSION['userid']."'");
		$user = $stmt->fetchArray();
		$name = $user["vorname"];
		$nachname = $user["nachname"];
		echo '<div class="item"><h2>Profil Informationen</h3>';
		echo '<p>UserID: '.$_SESSION["userid"].'</p>';
		echo 'Anzahl der beiträge: '. beitrags_anzahl($db)."<br>";
		echo '<br><h2>Persönliche Informationen</h2>';
		echo "<form method='POST'>
				<label>Vorname: <input type='text' name='name' value='".$name."'></label><br>
				<label>Nachname: <input type='text' name='nachname' value='".$nachname."'></label><br>
				<input type='hidden' name='set' value='set'>
				<input type='submit' name='aendern' value='&Auml;ndern'>
			  </form><br></div>";
		if($permission >= 1){
			echo "<div class='item'><h2>Beitrag erstellen</h2>
				  <form method='POST'>
					<div>  
      					<label>Überschrift: <input type='text' id='head' name='head' required></label><br>
					    <label>Beitrag: <textarea id='text' name='text' cols='35' rows='4' required></textarea></label><br>	
					    <input type='submit' value='Erstellen'/>
					</div> 
				  </form></div>";
		}
		if($permission >=2){
			$rs = $db->query("SELECT id, vorname, nachname, berechtigung FROM users");
			echo "<div class='item'><h2>Nutzer Verwaltung</h2>
				  <form method='POST'>
					<div>  
      					<label for='text'>Nutzer Berechtigungs Level Setzen</label><br>
      					<label>Nutzer: 
      									<select name='usid'>
      										";
      										while($dbsatz = $rs->fetchArray()){
      											echo "<option value='".$dbsatz['id']."'>".$dbsatz['id'].", ".$dbsatz['vorname']." ".$dbsatz['nachname']." lv.".$dbsatz['berechtigung']."</option>";
      										}
      										echo "
      									</select>
      					</label><br>
      					<label>Neues Level: <input type='number' name='level' min='0' max='2' required></label><br>	
					    <input type='submit' value='&Auml;ndern'/>
					</div> 
				  </form></div>";
		}

	}else{
		
		$rs = $db->prepare("SELECT vorname, nachname FROM users WHERE id = :id");
		$rs->bindValue(":id", $_GET['user']);
		$db_result = $rs->execute();
		$db_result = $db_result->fetchArray();

		

		
		echo "<h2>".$db_result['vorname']." ".$db_result['nachname']."</h2><br>
			  <p>Der Nutzer hat ". beitrags_anzahl($db) ." erstellt.";

		

		}


		function beitrags_anzahl($db){
			$smt = $db->prepare("SELECT * FROM posts WHERE author = :id");
			$smt->bindValue(":id", $_GET['user']);
			$db_rs = $smt->execute();
			$db_anzahl = 0;
			while($durchlauf = $db_rs->fetchArray()){
				$db_anzahl++;
			}
			if($db_anzahl == 1 && $db_anzahl > 0){
				$db_anzahl = $db_anzahl . " Beitrag";
			}else if($db_anzahl > 1){
				$db_anzahl = $db_anzahl . " Beitr&auml;ge";
			}else{
				$db_anzahl = "keine";
			}
			return $db_anzahl;
		}
	?>
</div>
</body>
<footer>
	Author: Justin Preuß<br>
	Copyright © 2020 Justin Preuß<br>
</footer>
</html>

