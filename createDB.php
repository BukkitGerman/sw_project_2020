<?php
	$db = new SQLite3("data.db");



	$db->exec("CREATE TABLE IF NOT EXISTS users(
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		email VARCHAR(255) NOT NULL, 
		passwort VARCHAR(255) NOT NULL,
		vorname VARCHAR(255) NOT NULL DEFAULT '',
		nachname VARCHAR(255) NOT NULL DEFAULT '',
		berechtigung INTEGER NOT NULL DEFAULT 0,
		created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");

	$db->exec("CREATE TABLE IF NOT EXISTS posts(
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		author INTEGER NOT NULL,
		head varchar(255) NOT NULL,
		post text NOT NULL,
		created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");	

if(isset($_GET['testuser'])){
	if($_GET['testuser'] == true){
		$db->exec("INSERT INTO users (email, passwort, berechtigung) VALUES ('test@123.de', test, 2)");
	}
}
	
?>