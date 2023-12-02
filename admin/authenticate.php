<?php
session_start();
include 'functions.php';
$pdo = pdo_connect_mysql();

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['email'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    exit('Please fill both the email and password fields!');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $pdo->prepare('SELECT id, name, email, password FROM users WHERE email = ? AND status = 1');
$stmt->execute([$_POST['email']]);
$destination = $stmt->fetch(PDO::FETCH_ASSOC);

//$stmt->debugDumpParams(), $destination, $stmt->errorInfo()[2]
// var_dump($destination);

if(!empty($destination)) {
    // Account exists, now we verify the password.
	// Note: remember to use password_hash() in your registration file to store the hashed passwords.
	if (password_verify($_POST['password'], $destination['password'])) {
		// Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $destination['name'];
		$_SESSION['email'] = $destination['email'];
		$_SESSION['id'] = $destination['id'];

        header('Location: index.php');

	}else {
		// Incorrect password
		exit('Incorrect username and/or password!');
	}

}else {
    // Incorrect password
    exit('User does not exist');
}

?>