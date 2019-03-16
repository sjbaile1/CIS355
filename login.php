<?php
session_start();
require "database.php";

if (!empty($_POST)){
    // Get the username and password from the post.
    $username = $_POST['username'];
    $password = $_POST['password'];
	$passwordhash = MD5($password);
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // See if this username / password combination exists in the database.
    $sql = "SELECT * FROM customers WHERE email=? AND password_hash =? LIMIT 1";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($username, $passwordhash));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    // If we got data back, the username / password combination was correct.
    if ($data) {
        $_SESSION["username"] = $username;
        // Go to the customer page.
        header("Location: customer.php");
    } else // Otherwise, try to log in again.
        header("Location: login.php?errorMessage=Invalid Username or Password!");
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset='UTF-8'>
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
	</head>

<body>
    <div class="container">
		<div class="span10 offset1">

			<div class="row">
				<h3>Login</h3>
			</div>

			<form class="form-horizontal" action="login.php" method="post">
								  
				<div class="control-group">
					<label class="control-label">Username (Email)</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="me@email.com" required> 
					</div>	
				</div> 
				
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password" placeholder="not your SVSU password, please" required> 
					</div>	
				</div> 

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
					&nbsp; &nbsp;
					<a class="btn btn-primary" href="createNewPerson.php">Join</a>
				</div>
				
				<div>
					<br><span style='color: red;' class='help-inline'>&nbsp;&nbsp;</span><br>				</div>
				

			</form>


		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
  
</html>