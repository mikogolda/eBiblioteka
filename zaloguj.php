<?php

	session_start();
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}
	
	
	

	require_once "connect.php";

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
		sprintf("SELECT * FROM czytelnik WHERE login='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				
				if (password_verify($haslo, $wiersz['haslo']))
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['id_czytelnika'] = $wiersz['id_czytelnika'];
					$_SESSION['login'] = $wiersz['login'];
					$_SESSION['imie'] = $wiersz['imie'];
					$_SESSION['nazwisko'] = $wiersz['nazwisko'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['czyadmin'] = $wiersz['czyadmin'];
					
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: biblioteka.php');
				}
				else 
				{
					$_SESSION['blad'] = '<span style="color:#8B0000">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
				
			} else {
				
				$_SESSION['blad'] = '<span style="color:#8B0000">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
				
			}
		}
		
	
		
		$polaczenie->close();
	}
	
?>