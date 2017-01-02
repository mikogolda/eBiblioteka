<?php

	session_start();
	
	if (!($_SESSION['czyadmin']==1))
	{
		header('Location: index.php');
		exit();
	}
        
        
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Obsługa wypożyczeń</title>
        
        <link rel = "stylesheet" href = "styl.css" type = "text/css" >
	<link href = "https://fonts.googleapis.com/css?family=Lato" rel = "stylesheet" >
	<link href = "https://fonts.googleapis.com/css?family=Exo:900" rel = "stylesheet">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" 
	integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
</head>


<body>
    <div class="container">
        <div class="row">
                
                <div class="col-sm-11">
                <div class="table-responsive">
                    <table id="wypozyczenia" class="table table-bordered table-hover">
                            <tr><th>Imię czytelnika</th><th>Nazwisko czytelnika</th><th>Tytuł książki</th><th>Status</th></tr>
                            <?php
                            require_once "connect.php";

                            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                            $polaczenie->set_charset("utf8");

                            if ($polaczenie->connect_errno!=0)
                            {
                                    echo "Error: ".$polaczenie->connect_errno;
                            }
                            else
                            {
                                            if ($rezultat = @$polaczenie->query(
                                            "SELECT * FROM wypozyczenia WHERE NOT(czy_obsluzono=2)"))
                                            {
                                                $ile = $rezultat->num_rows;
                                                $i = 1;
                                                while($ile >= $i){
                                                    $wiersz = $rezultat->fetch_assoc();
                                                    $id_Czytelnika = $wiersz['id_czytelnika'];
                                                    $id_ksiazki = $wiersz['id_ksiazki'];
                                                    $id_wypozyczenia=$wiersz['id_wypozyczenia'];
                                                    
                                                    if($rezultat3 = @$polaczenie->query(
                                                    "SELECT * FROM czytelnik WHERE id_czytelnika=$id_Czytelnika")){
                                                        $wiersz3 = $rezultat3->fetch_assoc();
                                                        $imie = $wiersz3['imie'];
                                                        $nazwisko = $wiersz3['nazwisko']; 
                                                    }
                                                    
                                                    if($rezultat2 = @$polaczenie->query(
                                                    "SELECT * FROM ksiazka WHERE id_ksiazki=$id_ksiazki")){
                                                        $wiersz2 = $rezultat2->fetch_assoc();
                                                        $tytul = $wiersz2['tytul'];   
                                                    }
                                                       
                                                    $status = $wiersz['czy_obsluzono'];
                                                    $i++;
                                                    echo '<tr>';
                                                    echo '<td>' . $imie . '</td>';
                                                    echo '<td>' . $nazwisko . '</td>';
                                                    echo '<td>' . $tytul . '</td>';
                                                    
                                                    if($status==0){
                                                    echo '<td><a href="pozycz.php?id='.$id_wypozyczenia.'">Wypożycz</a></td>';
                                                    }
                                                    
                                                    if($status==1){
                                                    echo '<td><a href="oddana.php?id='.$id_wypozyczenia.'">oddana</a></td>';
                                                    }
                                                    

                                                    echo '</tr>';
                                                }
                                            }
                                $polaczenie->close();
                            }
                        
                    ?>
                    </table>
                    </div>
                </div>
                <div class="col-sm-1">
                        <div class = "przyciski2" > 
                                <a href="biblioteka.php">Powrót</a>
                        </div>       
                </div>
        </div>
    </div>
    <?php
        if(isset($_SESSION['pozyczono'])){ 
            echo $_SESSION['pozyczono'];
            unset($_SESSION['pozyczono']);
        }
    ?>
    
    
	

</body>
</html>

