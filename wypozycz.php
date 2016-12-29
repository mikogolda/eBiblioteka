<?php

	session_start();
	if (!(isset($_SESSION['czyadmin'])))
	{
		header('Location: biblioteka.php');
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
		$id = $_GET['id'];
		$id = htmlentities($id, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		"INSERT INTO wypozyczenia VALUES(NULL,$id_czytelnika,$id,now(),now() + INTERVAL 30 DAY,0)"))
		{
                    $_SESSION['dodano'] = '<span style="color:#8B0000">Zamówienie w trakcie realizacji!</span>';
                    header('Location: biblioteka.php');
		}
		
	
		
		$polaczenie->close();
	}
	
?>

