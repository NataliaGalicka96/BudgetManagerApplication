<?php

	session_start();
	require_once 'database.php';

	
	//jeśli nie jesteśmy zalogowani
	if(!isset($_SESSION['logged_id'])){

		if(isset($_POST['username'])){
			//odczytujemy hasło
			$username = filter_input(INPUT_POST, 'username');
			$password = filter_input(INPUT_POST, 'password');

			//Połączenie z bazą danych

			$userQuery = $db->prepare('SELECT id, password FROM users WHERE username=:username');
			$userQuery->bindValue(':username',$username, PDO::PARAM_STR);
			$userQuery->execute();

			//My będziemy musieli obsłużyć wyjątek jak zapytanie nie zwróci nam rekordu
			//jeśli login nie istnieje

			//zliczanie zwróconych rekordów

			//echo $userQuery->rowCount();

			$user = $userQuery->fetch();

			//sprawdzam czy wyjmiemy dane z bazy danych

        //echo $user['id']." ".$user['password'];

        //warunek jeśli udało się potwierdzić tożsamość
        //jeżeli user!= false
        //jeśli login istnieje i dla tego rekordu hasło zgadza się z tym hasłem w bazie danych
			if ($user && password_verify($password, $user['password'])) {
            //zapamietanie zalogowanego admina
			$_SESSION['logged_id'] = $user['id'];
			$_SESSION['username'] = $user['username'];
			unset($_SESSION['bad_attempt']);
			header('Location: menu.php');

        	}else{
            //nie udana próba

			$_SESSION['bad_attempt'] = true;
			header('Location: index.php');
			exit();
        	}

		}else{
			//Nie podano loginu, przekierowanie na stronę logowania index.php
			header('Location: index.php');
			exit();
		}


	}


/*
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				
				if (password_verify($haslo, $wiersz['pass']))
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['user'];
					$_SESSION['drewno'] = $wiersz['drewno'];
					$_SESSION['kamien'] = $wiersz['kamien'];
					$_SESSION['zboze'] = $wiersz['zboze'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['dnipremium'] = $wiersz['dnipremium'];
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: gra.php');
				}
				else 
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
				
			} else {
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
*/	
?>