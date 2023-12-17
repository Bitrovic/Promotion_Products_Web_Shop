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
	<link rel="stylesheet" type="text/css" href="css/majice.css">
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

	$mysqli = new mysqli("localhost", "root", "", "prodavnica");


	if($mysqli->error){
		die("Greska: " . $mysqli->error);
	}

	$sifraArtikla = "";
	$boja = "";
	$cena = "";
	$soljaMajica = "";
	$fajl = "";

	$upit = "select * from artikal where SoljaMajica = 0";
	$rez = $mysqli->query($upit);

	if(!$rez){
		print("Trenutno nema majici!");
		die($mysqli->error);
	}

	$red = $rez->fetch_assoc();
	if(!$red){
		print("Trenutno nema majici!");
	}
	else{
		$message = "";

		$sifraArtikla = $red["SifraArtikla"];
		$boja = $red["Boja"];
		$cena = $red["Cena"];
		$fajl = $red["Fajl"];
		$soljaMajica = $red["SoljaMajica"];

		if((isset($_SESSION['rola']) && $_SESSION['rola'] == 0) || (isset($_SESSION['rola']) && $_SESSION['rola'] == 1)){
			$message .= "
			<div class='majice'>
			<a href='artikal.php?artikalId=" . $sifraArtikla . "'><img src=\"" . $fajl . "\" alt='majica" . $sifraArtikla . "'></a>
			<h1>" . $boja . " majica</h1>
			<p>Cena " . $cena . "</p>
			</div>
			";
		}
		else{
			$message .= "
			<div class='majice'>
			<a href='login.php'><img src=\"" . $fajl . "\" alt='majica" . $sifraArtikla . "'></a>
			<h1>" . $boja . " majica</h1>
			<p>Cena " . $cena . "</p>
			</div>
			";
		}

		while($row = $rez->fetch_assoc()){
			$sifraArtikla = $row["SifraArtikla"];
			$boja = $row["Boja"];
			$cena = $row["Cena"];
			$fajl = $row["Fajl"];
			$soljaMajica = $row["SoljaMajica"];

			
			if((isset($_SESSION['rola']) && $_SESSION['rola'] == 0) || (isset($_SESSION['rola']) && $_SESSION['rola'] == 1)){
				$message .= "
				<div class='majice'>
				<a href='artikal.php?artikalId=" . $sifraArtikla . "'><img src=\"" . $fajl . "\" alt='majica" . $sifraArtikla . "'></a>
				<h1>" . $boja . " majica</h1>
				<p>Cena " . $cena . "</p>
				</div>
				";
			}
			else{
				$message .= "
				<div class='majice'>
				<a href='login.php'><img src=\"" . $fajl . "\" alt='majica" . $sifraArtikla . "'></a>
				<h1>" . $boja . " majica</h1>
				<p>Cena " . $cena . "</p>
				</div>
				";
			}
		}
	}

	?>
</div>

<h1>Majica</h1></br>

<?php 
if(isset($message)){
	echo $message;
}
include "php/footer.php"; 
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>