<?php

	session_start();
        
        if (!($_SESSION['czyadmin']==1))
	{
		header('Location: index.php');
		exit();
	}
	
	if (isset($_POST['isbn']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		$isbn = $_POST['isbn'];
		
		//Sprawdzenie długości isbn
		if ((strlen($isbn)<14) || (strlen($isbn)>25))
		{
			$wszystko_OK=false;
			$_SESSION['e_isbn']="ISBN musi posiadać od 15 do 25 znaków!";
		}
		
		
		$tytul = $_POST['tytul'];
		if (strlen($tytul)<3)
		{
			$wszystko_OK=false;
			$_SESSION['e_tytul']="Tytuł musi posiadać conajmniej 3 znaki!";
		}
		
		$autor = $_POST['autor'];
		if (strlen($autor)<3)
		{
			$wszystko_OK=false;
			$_SESSION['e_autor']="Autor musi posiadać conajmniej 3 znaki!";
		}
                
                $wydawnictwo = $_POST['wydawnictwo'];
		if (strlen($wydawnictwo)<3)
		{
			$wszystko_OK=false;
			$_SESSION['e_wydawnictwo']="Wydawnictwo musi posiadać conajmniej 3 znaki!";
		}
                
                $rokwydania = $_POST['rokwydania'];
                if ($rokwydania<1900 || $rokwydania>2017)
		{
			$wszystko_OK=false;
			$_SESSION['e_rokwydania']="Zły rok wydania!";
		}
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_isbn'] = $isbn;
		$_SESSION['fr_tytul'] = $tytul;
		$_SESSION['fr_autor'] = $autor;
		$_SESSION['fr_wydawnictwo'] = $wydawnictwo;
		$_SESSION['fr_rokwydania'] =$rokwydania;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                        $polaczenie->set_charset("utf8");
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				if ($wszystko_OK==true)
				{
				
					
					if ($polaczenie->query("INSERT INTO ksiazka VALUES (NULL, '$isbn', '$tytul','$autor','$wydawnictwo',$rokwydania,1)"))
					{
                                            $_SESSION['dodanoksiazke']="Dodano książke!";
                                            header('Location: biblioteka.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o dodanie książki w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel = "stylesheet" href = "styl.css" type = "text/css" >
	<link href = "https://fonts.googleapis.com/css?family=Lato" rel = "stylesheet" >
	<link href = "https://fonts.googleapis.com/css?family=Exo:900" rel = "stylesheet">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" 
	integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
	<title>Biblioteka - dodaj książke!</title>
	
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	<div class="form-group" style="text-align: center;" style="margin: 0 auto">
            <form method="post">

                    isbn: <br /> <input type="text" value="<?php
                            if (isset($_SESSION['fr_isbn']))
                            {
                                    echo $_SESSION['fr_isbn'];
                                    unset($_SESSION['fr_isbn']);
                            }
                    ?>" name="isbn" /><br />

                    <?php
                            if (isset($_SESSION['e_isbn']))
                            {
                                    echo '<div class="error">'.$_SESSION['e_isbn'].'</div>';
                                    unset($_SESSION['e_isbn']);
                            }
                    ?>

                    Tytuł: <br /> <input type="text" value="<?php
                            if (isset($_SESSION['fr_tytul']))
                            {
                                    echo $_SESSION['fr_tytul'];
                                    unset($_SESSION['fr_tytul']);
                            }
                    ?>" name="tytul" /><br />

                    <?php
                            if (isset($_SESSION['e_tytul']))
                            {
                                    echo '<div class="error">'.$_SESSION['e_tytul'].'</div>';
                                    unset($_SESSION['e_tytul']);
                            }
                    ?>

                    Autor: <br /> <input type="text" value="<?php
                            if (isset($_SESSION['fr_autor']))
                            {
                                    echo $_SESSION['fr_autor'];
                                    unset($_SESSION['fr_autor']);
                            }
                    ?>" name="autor" /><br />

                    <?php
                            if (isset($_SESSION['e_autor']))
                            {
                                    echo '<div class="error">'.$_SESSION['e_autor'].'</div>';
                                    unset($_SESSION['e_autor']);
                            }
                    ?>

                    Wydawnictwo: <br /> <input type="text" value="<?php
                            if (isset($_SESSION['fr_wydawnictwo']))
                            {
                                    echo $_SESSION['fr_wydawnictwo'];
                                    unset($_SESSION['fr_wydawnictwo']);
                            }
                    ?>" name="wydawnictwo" /><br />

                    <?php
                            if (isset($_SESSION['e_wydawnictwo']))
                            {
                                    echo '<div class="error">'.$_SESSION['e_wydawnictwo'].'</div>';
                                    unset($_SESSION['e_wydawnictwo']);
                            }
                    ?>

                    Rok wydania: <br /> <input type="number"  min="1900" max="2017" value="<?php
                            if (isset($_SESSION['fr_rokwydania']))
                            {
                                    echo $_SESSION['fr_rokwydania'];
                                    unset($_SESSION['fr_rokwydania']);
                            }
                    ?>" name="rokwydania" /><br />

                    <?php
                            if (isset($_SESSION['e_rokwydania']))
                            {
                                    echo '<div class="error">'.$_SESSION['e_rokwydania'].'</div>';
                                    unset($_SESSION['e_rokwydania']);
                            }
                    ?>		

                    <br />

                    <input type="submit" value="Dodaj książke" />

            </form>
        </div>

</body>
</html>