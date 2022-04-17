<?php

	session_start();
	require_once 'database.php';

	
	//jeśli nie jesteśmy zalogowani
	if(isset($_SESSION['loggedUser'])==false){

		if(isset($_POST['username'])){
			//odczytujemy hasło
			$username = filter_input(INPUT_POST, 'username');
			$password = filter_input(INPUT_POST, 'password');

			//Połączenie z bazą danych

			$sql = "SELECT id, username, password FROM users WHERE username=:username";

			$userQuery = $db->prepare($sql);
			$userQuery->bindValue(':username',$username, PDO::PARAM_STR);
			$userQuery->execute();

			//My będziemy musieli obsłużyć wyjątek jak zapytanie nie zwróci nam rekordu
			//jeśli login nie istnieje

			//zliczanie zwróconych rekordów

			//echo $userQuery->rowCount();

			$user = $userQuery->fetch();
			//sprawdzam czy wyjmiemy dane z bazy danych

     		//echo $user['id']." ".;

			//warunek jeśli udało się potwierdzić tożsamość
       		//jeżeli user!= false
        	//jeśli login istnieje i dla tego rekordu hasło zgadza się z tym hasłem w bazie danych
		
			if ($user && ($user['password']==$password) /*password_verify($password, $user['password']*/){
				//zapamietanie zalogowanego admina
				$_SESSION['loggedUser']=true;

				$_SESSION['logged_id'] = $user['id'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['password'] = $user['password'];

				unset($_SESSION['bad_attempt']);
				header('Location: menu.php');

			}else{
				//nie udana próba

				$_SESSION['bad_attempt'] = '<span style="color:red">The username or password you have entered is incorrect!</span>';
				header('Location: index.php');
				//exit();
        	}

		}
		else{
			//Nie podano loginu, przekierowanie na stronę logowania index.php
			$_SESSION['bad_attempt'] = '<span style="color:red">Username is not entered!</span>';
			header('Location: index.php');
			//exit();
		}
	}
		
?>