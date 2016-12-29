<?php

	session_start();
	if (!(isset($_SESSION['czyadmin']) && $_SESSION['czyadmin']==1 && isset($_GET['id'])))
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
		sprintf("DELETE  FROM ksiazka WHERE id_ksiazki='%s'",
		mysqli_real_escape_string($polaczenie,$id))))
		{
                    $_SESSION['usunieto'] = '<span style="color:#8B0000">Książka usunięta ze zbioru!</span>';
                    header('Location: biblioteka.php');
		}
		
	
		
		$polaczenie->close();
	}
	
?>

