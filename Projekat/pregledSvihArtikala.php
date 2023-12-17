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
	<link rel="stylesheet" type="text/css" href="css/pregledSvihArtikala.css">
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
		?>

		<h1>Svi artikli</h1>

		<div class="mestoZaDugme">
			<a class="btn btn-primary btn-lg btn-block" href="kreirajArtikal.php" role="button" name="kreiraj">Dodajte novi artikal</a>
			<!-- <a href="kreirajArtikal.php"><button type="submit" name="kreiraj" class="kreiraj">Kreirajte artikal</button></a> -->
		</div>
		
		<?php

		$mysqli = new mysqli("localhost", "root", "", "prodavnica");

		if($mysqli->error){
			die("Greska: " . $mysqli->error);
		}

		$sifraArtikla = "";
		$soljaMajica = "";
		$boja = "";
		$cena = "";
		$fajl = "";

		$upit = "select * from artikal";
		$rez = $mysqli->query($upit);

		if(!$rez){
			print("Nema artikala trenutno na stanju!");
			die($mysqli->error);
		}

		$red = $rez->fetch_assoc();
		if(!$red){
			print("Trenutno nema artikala!");
		}
		else{
			$message = "";

			$sifraArtikla = $red["SifraArtikla"];
			$soljaMajica = $red["SoljaMajica"];
			$boja = $red["Boja"];
			$cena = $red["Cena"];
			$fajl = $red["Fajl"];

			$artikal = "majica";
			if($soljaMajica){
				$artikal = "šolja";
			}


			$message .= "
			<div class=\"artikal\">
			<img src=\"" . $fajl . "\"></br>
			<h2>" . $boja . " " . $artikal . "</h2></br>
			<p>Sifra artikla: " . $sifraArtikla . "</p></br>
			<p>Cena: " . $cena . "</p>
			<a class=\"btn btn-danger\" name='brisi' role=\"button\" href=\"brisiArtikal.php?deleteId=" . $sifraArtikla . "\">Obrišite</a>
			<a class=\"btn btn-success\" name='izmeni' role=\"button\" href=\"izmeniArtikal.php?izmeniId=" . $sifraArtikla . "\">Izmenite</a>
			</div>
			";

			// <button type=\"submit\" name=\"brisi\" class=\"brisi\"><a href=\"brisiArtikal.php?deleteId=" . $sifraArtikla . "\">Obriši</a></button>
			// <button type=\"submit\" name=\"izmeni\" class=\"izmeni\"><a href=\"izmeniArtikal.php?izmeniId=" . $sifraArtikla . "\">Izmeni</a></button>

			while($row = $rez->fetch_assoc()){
				$sifraArtikla = $row["SifraArtikla"];
				$soljaMajica = $row["SoljaMajica"];
				$boja = $row["Boja"];
				$cena = $row["Cena"];
				$fajl = $row["Fajl"];

				$artikal = "majica";
				if($soljaMajica){
					$artikal = "šolja";
				}

				$message .= "
				<div class=\"artikal\">
				<img src=\"" . $fajl . "\"></br>
				<h2>" . $boja . " " . $artikal . "</h2></br>
				<p>Sifra artikla: " . $sifraArtikla . "</p></br>
				<p>Cena: " . $cena . "</p>
				<a class=\"btn btn-danger\" name='brisi' role=\"button\" href=\"brisiArtikal.php?deleteId=" . $sifraArtikla . "\">Obrišite</a>
				<a class=\"btn btn-success\" name='izmeni' role=\"button\" href=\"izmeniArtikal.php?izmeniId=" . $sifraArtikla . "\">Izmenite</a>
				</div>
				";
			}
		}
		?>
	</div>
	<?php 
	if(isset($message)){
		echo("<br><br>$message");
	}
}
else{
	echo "<h1 class='porukaOPristupu'>Stranica je samo za administratore!</h1>";
}
include "php/footer.php";
if(isset($_SESSION['poruka']) && $_SESSION['poruka'] != ""){
	echo $_SESSION['poruka'];
	$_SESSION['poruka'] = "";
}
?> 
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>