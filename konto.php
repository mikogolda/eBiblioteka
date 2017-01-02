<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
        
        
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Biblioteka</title>
        
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
                    <table id="mojewypozyczenia" class="table table-bordered table-hover">
                            <tr><th>Tytuł</th><th>Autor</th><th>Data wypożyczenia</th><th>Data oddania</th><th>Status</th></tr>
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
                                            $id_czytelnika=$_SESSION['id_czytelnika'];
                                            if ($rezultat = @$polaczenie->query(
                                            "SELECT * FROM wypozyczenia WHERE id_czytelnika=$id_czytelnika"))
                                            {
                                                $ile = $rezultat->num_rows;
                                                $i = 1;
                                                while($ile >= $i){
                                                    $wiersz = $rezultat->fetch_assoc();
                                                    $id_ksiazki = $wiersz['id_ksiazki'];
                                                    
                                                    if($rezultat2 = @$polaczenie->query(
                                                    "SELECT * FROM ksiazka WHERE id_ksiazki=$id_ksiazki")){
                                                        $wiersz2 = $rezultat2->fetch_assoc();
                                                        $autor = $wiersz2['autor'];
                                                        $tytul = $wiersz2['tytul'];   
                                                    }
                                                    
                                                    $datapozyczenia = $wiersz['dataOdbioru'];
                                                    $datazwrotu = $wiersz['dataZwrotu'];
                                                    $status = $wiersz['czy_obsluzono'];
                                                    $i++;
                                                    echo '<tr>';
                                                    echo '<td>' . $tytul . '</td>';
                                                    echo '<td>' . $autor . '</td>';
                                                    
                                                    if($status==0){
                                                    echo '<td></td>';
                                                    echo '<td></td>';
                                                    echo '<td>oczekuje na realizacje</td>';
                                                    }
                                                    
                                                    if($status==1){
                                                    echo '<td>'.$datapozyczenia.'</td>';
                                                    echo '<td>'.$datazwrotu.'</td>';
                                                    echo '<td>czytasz</td>';
                                                    }
                                                    
                                                    if($status==2){
                                                    echo '<td>'.$datapozyczenia.'</td>';
                                                    echo '<td>'.$datazwrotu.'</td>';
                                                    echo '<td>oddana</td>';
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
    
    
	

</body>
</html>

