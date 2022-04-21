<?php

	session_start();

	if (!isset($_SESSION['successfulRegistration']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['successfulRegistration']);
	}

	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['fr_username'])) unset($_SESSION['fr_username']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_pass1'])) unset($_SESSION['fr_pass1']);
	if (isset($_SESSION['fr_pass2'])) unset($_SESSION['fr_pass2']);

	
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['error_username'])) unset($_SESSION['error_username']);
	if (isset($_SESSION['error_email'])) unset($_SESSION['error_email']);
	if (isset($_SESSION['error_password'])) unset($_SESSION['error_password']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Personal Budget</title>
	<link rel="stylesheet" href="welcome.css">
</head>
<body >
<div class="main"  style="padding-top: 50px;">
	<div class="row" style=" width: 75%; margin-right:auto; margin-left:auto;">
			<div style="padding-top: 10px; padding-bottom: 10px; text-align:center;">
				Thank you for your registration! You can log in to your account!<br /><br />
				<a href="index.php" >Log in to your account!</a>
			</div>
	</div>	
</div>
</body>
</html>