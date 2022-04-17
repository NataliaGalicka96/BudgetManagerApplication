<?php

session_start();

unset($_SESSION['loggedUser']);
unset($_SESSION['successfulRegistration']);
unset($_SESSION['bad_attempt']);

header('Location: index.php');
