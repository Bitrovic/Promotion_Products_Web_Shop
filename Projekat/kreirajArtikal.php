<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&family=Roboto:ital,wght@1,500&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Open+Sans:ital,wght@1,500&family=Roboto+Slab:wght@700&family=Roboto:ital,wght@1,500&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Open+Sans:ital,wght@1,500&family=Roboto+Slab:wght@700&family=Roboto:ital,wght@1,500&display=swap" rel="stylesheet">
	<title>Štampanje</title>
</head>
<body>
	<?php 
	include "php/navbar.php";
	echo ('<div class="sadrzaj">');

if(isset($_SESSION['rola']) && $_SESSION['rola'] == 0){
	$mysqli = new mysqli("localhost", "root", "", "prodavnica");

	if($mysqli->error){
		die("Greska: " . $mysqli->error);
	}

	$soljaMajica = "";
	$boja = "";
	$cena = "";
	$fajl = "";

	if(isset($_POST["kreiraj"])){
		if(($_POST["bool"] != 0 && $_POST["bool"] != 1) || !$_POST["boja"] || !$_POST["cena"] || !$_POST["fajl"]){
			print("Nisu uneta sva polja!");
		}
		else{
			if($_POST['bool'] == 0){
				$soljaMajica = false;
			}
			else{
				$soljaMajica = true;
			}
			
			$boja = $_POST['boja'];
			$cena = $_POST['cena'];
			$fajl = $_POST['fajl'];

			$upit = "insert into artikal(SoljaMajica, Boja, Cena, Fajl) values ('$soljaMajica', '$boja', '$cena', '$fajl');";

			$rez = $mysqli->query($upit);

			if(!$rez){
				print("Artikal nije dodat u bazu!");
				die($mysqli->error);
			}
			else{
				$_SESSION['poruka'] = "<script>alert('Uspešno kreiran artikla!')</script>";
				header("Location: index.php");
			}
		}
	}

	?>
</div>
<form class="logIn" method="post" action="kreirajArtikal.php">
	<div class="container">
		<h1>Dodajte artikal</h1>
		<div class="levo">
			<div class="form-group">
				<label for="bool">Šolja ili majica?</label>
				<input type="text" class="form-control" id="bool" name="bool">
			</div>
			<div class="form-group">
				<label for="boja">Boja</label>
				<input type="text" class="form-control" id="boja" name="boja">
			</div>
			<div class="form-group">
				<label for="cena">Cena</label>
				<input type="text" class="form-control" id="cena" name="cena">
			</div>
			<div class="form-group">
				<label for="fajl">Fajl</label>
				<input type="text" class="form-control" id="fajl" name="fajl">
			</div>
		</div>

		<button type="submit" name="kreiraj">Dodajte</button>
	</div>
</form>

<?php
}
else{
	echo "<h1 class='porukaOPristupu'>Stranica je samo za administratore!</h1>";
}
include "php/footer.php";
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>