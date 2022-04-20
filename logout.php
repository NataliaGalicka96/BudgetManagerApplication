<?php

session_start();

session_unset();

/*unset($_SESSION['loggedUser']);
unset($_SESSION['successfulRegistration']);
unset($_SESSION['bad_attempt']);
*/
header('Location: index.php');
