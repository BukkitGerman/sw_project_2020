<!DOCTYPE html>
<html>
<head>
	<title>Blog - Register</title>
</head>
<nav class="menu">
	<ol>
        <li class="crumb"><a href="/">Home</a></li>
        <li class="crumb"><a href="posts.php">Posts</a></li>
        <li class="crumb"><a href="profile.php">Profile</a></li>
        <li class="crumb active" id="login"><a href="login.php">Login</a></li>
    </ol>
</nav>
<body>
<div>
	<form method="POST">
		<h3>Register</h3>
		<label>Username: <input type="text" name="username"></label><br>
		<label>E-Mail: <input type="email" name="email"></label><br>
		<label>Password: <input type="password" name="password"></label><br>
		<label>Password: <input type="password" name="password2"></label><br>
		<input type="submit" name="Submit" value="Submit">
	</form>
</div>
</body>
<footer>
	Author: Justin Preuß
	Copyright © 2020 Justin Preuß
	<a href="impressum.php">Impressum</a>
</footer>
</html>