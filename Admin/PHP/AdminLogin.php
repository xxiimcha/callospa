<?php include('AdminServer.php') ?>
<!DOCTYPE html>
<html>

<head>
	<title>Admin Login</title>
	<link rel="stylesheet" type="text/css" href="../CSS/AdminStyle.css">
</head>

<body>
	<div class="header">
		<h2>Login</h2>
	</div>

	<form method="post" action="AdminLogin.php">
		<?php include('AdminErrors.php'); ?>
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_user">Login</button>
		</div>
	</form>
</body>

</html>