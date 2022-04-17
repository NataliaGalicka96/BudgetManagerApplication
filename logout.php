<?php

session_start();
unset($_SESSION['loggedUser']);
unset($_SESSION['successfulRegistration']);

header('Location: index.php');
