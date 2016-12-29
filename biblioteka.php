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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" 
	integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
</head>


<body>
	
        
		<div class="form-group" style="text-align: center;">
                    <form  method="post" style="color:white">
			<input type="text" name="szukaj" /> 
			<input type="submit" value="Szukaj" /><br />	
                    </form>
		</div>
    
    <div class="table-responsive">
        <table id="ksiazki" class="table table-bordered table-hover">
            
                <?php

                    if (isset($_POST['szukaj']))
                    {
                        
                ?>
                        <tr><th>Tytuł</th><th>Autor</th><th>Wydawnictwo</th><th>Rok wydania</th><th>Czy dostępna</th>
                        <?php
                        if (isset($_SESSION['czyadmin']) && $_SESSION['czyadmin']==1) {
                        ?>
                            <th>Usuń</th>
                        <?php
                        }
                        ?>
                        </tr>
                        <?php
                        require_once "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

                        if ($polaczenie->connect_errno!=0)
                        {
                                echo "Error: ".$polaczenie->connect_errno;
                        }
                        else
                        {
                            $szukaj = $_POST['szukaj'];
                            $szukaj = htmlentities($szukaj, ENT_QUOTES, "UTF-8");


                                        if ($rezultat = @$polaczenie->query(
                                        sprintf("SELECT * FROM ksiazka WHERE ( (tytul LIKE '%%%1\$s%%') OR (autor LIKE '%%%1\$s%%') )",
                                        mysqli_real_escape_string($polaczenie,$szukaj))))
                                        {
                                            $ile = $rezultat->num_rows;
                                            $i = 1;
                                            while($ile >= $i){
                                                $wiersz = $rezultat->fetch_assoc();
                                                $id_ksiazki = $wiersz['id_ksiazki'];
                                                $isbn = $wiersz['isbn'];
                                                $tytul = $wiersz['tytul'];
                                                $autor = $wiersz['autor'];
                                                $wydawnictwo = $wiersz['wydawnictwo'];
                                                $rok_wydania = $wiersz['rok_wydania'];
                                                $czy_dostepna = $wiersz['czy_dostepna'];
                                                $i++;
                                                echo '<tr>';
                                                echo '<td>' . $tytul . '</td>';
                                                echo '<td>' . $autor . '</td>';
                                                echo '<td>' . $wydawnictwo . '</td>';
                                                echo '<td>' . $rok_wydania . '</td>';
                                                
                                                if($czy_dostepna==1)
                                                    echo '<td><a href="wypozycz.php?id='.$id_ksiazki.'">Wypożycz</a></td>';
                                                else echo '<td>niedostępna</td>';
                                                
                                                
                                                if (isset($_SESSION['czyadmin']) && $_SESSION['czyadmin']==1) {
                                                    echo '<td><a href="usun.php?id='.$id_ksiazki.'">Usuń</a></td>';
                                                }
                                                echo '</tr>';
                                            }
                                        }
                            $polaczenie->close();
                        }
                    }
                ?>
        </table>
    
    </div>
    
    <?php
	if(isset($_SESSION['usunieto'])){ 
            echo $_SESSION['usunieto'];
            unset($_SESSION['usunieto']);
        }
        if(isset($_SESSION['dodano'])){ 
            echo $_SESSION['dodano'];
            unset($_SESSION['dodano']);
        
        }
    ?>
	

</body>
</html>