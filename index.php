<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: biblioteka.php');
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

<body background="obrazek.jpg">
			<div class="container">
				<div class="logo">
					<h1>System obsługi biblioteki</h1>
				</div>
				
				<div class="row">
				
					<div class="col-sm-12">
						<div class="form-group" style="text-align: center;" style="margin: 0 auto">
							<form action="zaloguj.php" method="post" style="color:white">
				
								Login: <br /> <input type="text" name="login" /> <br />
								Hasło: <br /> <input type="password" name="haslo" /> <br /><br />
								<input type="submit" value="Zaloguj się" /><br />
								<?php
									if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
								?>
				
							</form>
						</div>
					</div>
				</div>
				
				<div class="row">	
					<div class="col-sm-12">
						<div class = "przyciski" > 
							<a href="rejestracja.php">Rejestracja - załóż darmowe konto!</a>
						</div>
					</div>
				</div>
			</div>
			

			


		

</body>
</html>