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
                        "UPDATE wypozyczenia SET dataZwrotu=now(),czy_obsluzono=2 WHERE id_wypozyczenia=$id"))
                        {
                            if ($rezultat = @$polaczenie->query(
                            "SELECT * FROM wypozyczenia WHERE id_wypozyczenia=$id")){
                                $wiersz = $rezultat->fetch_assoc();
                                $idksiazki = $wiersz['id_ksiazki'];
                                @$polaczenie->query("UPDATE  ksiazka SET czy_dostepna=1 WHERE id_ksiazki=$idksiazki");
                                $_SESSION['pozyczono'] = '<span style="color:#8B0000">Książka oddana!</span>';
                                header('Location: obsluga.php');
                            }
                        }
                    
                
		
	
		
		$polaczenie->close();
	}
	
?>

