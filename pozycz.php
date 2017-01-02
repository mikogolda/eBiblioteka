<?php

	session_start();
	if (!($_SESSION['czyadmin']==1 && isset($_GET['id'])))
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
                        "UPDATE wypozyczenia SET dataOdbioru=now(),dataZwrotu=now() + INTERVAL 30 DAY,czy_obsluzono=1 WHERE id_wypozyczenia=$id"))
                        {
                            $_SESSION['pozyczono'] = '<span style="color:#8B0000">Pożyczono książke!</span>';
                            header('Location: obsluga.php');
                        }
                    
                
		
	
		
		$polaczenie->close();
	}
	
?>

