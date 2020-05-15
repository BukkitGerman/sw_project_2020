<!DOCTYPE html>
<html>
<head>
	<title>Blog - Login</title>
</head>
<nav class="menu">
	<ol>
        <li class="crumb"><a href="/">Home</a></li>
        <li class="crumb"><a href="">Posts</a></li>
        <li class="crumb"><a href="">Profile</a></li>
        <li class="crumb active" id="login"><a href="login.php">Login</a></li>
    </ol>
</nav>
<body>
<div>
	<form method="POST">
		<h3>Login</h3>
		<label>Username: <input type="text" name="username"></label><br>
		<label>Password: <input type="password" name="password"></label><br>
		<input type="submit" name="Submit" value="Submit">
	</form>
</div>
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
</body>
</html> 