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
	<link rel="stylesheet" type="text/css" href="css/pregledKorpe.css">
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
	if((isset($_SESSION['rola']) && $_SESSION['rola'] == 0)){
		?>

		<?php
		$mysqli = new mysqli("localhost", "root", "", "prodavnica");

		if($mysqli->error){
			die("Greška: " . $mysqli->error);
		}

		$sifraKorpe = "";
		$sifraArtikla = "";

		if(isset($_GET['kupacId'])){
			$sifraKorisnika =  $_GET['kupacId'];
		}
		
		$rola = $_SESSION['rola'];
		$sifraLogotipa = "";
		$logoPutanjaKorisnila = "";
		$boja = "";
		$cena = "";
		$velicina = "";

		$upit = "select * from korpa where SifraKorisnika = '$sifraKorisnika'";
		$rez = $mysqli->query($upit);

		if(!$rez){
			print("Nema artikala trenutno u korpi!");
			die($mysqli->error);
		}


		$red = $rez->fetch_assoc();
		if(!$red){
			echo "<h1 class='praznaKorpa'>Kupac trenutno nema artikala u korpi!</h1>";
		}
		else{
			echo "<h1>Pregled korpe</h1>";

			$message = "";

			$sifraArtikla = $red["SifraArtikla"];
			$sifraLogotipa = $red["SifraLogotipa"];
			$boja = $red["Boja"];
			$cena = $red["UkupnaCena"];
			$velicina = $red["Velicina"];
			$logoPutanjaKorisnika = $red["LogoPutanjaKorisnika"];

			$joinUpit = "select a.SifraArtikla, a.Fajl, l.SifraLogotipa, l.FajlLogotipa, ko.SifraKorpe, ko.Velicina, ko.UkupnaCena, ko.LogoPutanjaKorisnika, ks.SifraKorisnika, ks.Ime, ks.Prezime from korpa ko join artikal a on ko.SifraArtikla = a.SifraArtikla JOIN logotip l on ko.SifraLogotipa = l.SifraLogotipa JOIN korisnik ks on ko.SifraKorisnika = ks.SifraKorisnika where ko.SifraKorisnika = '$sifraKorisnika'";


			$joinRez = $mysqli->query($joinUpit);

			if(!$joinRez){
				print("Greška!");
				die($mysqli->error);
			}

			$joinRed = $joinRez->fetch_assoc();
			if(!$joinRed){
				print("Greška!");
			}
			else{
				$ukupnaCenaSvihArtikala = 0;

				$joinSifraKorpe = $joinRed['SifraKorpe'];
				$joinSifraArtikla = $joinRed['SifraArtikla'];
				$joinSlikaArtikla = $joinRed['Fajl'];
				$joinSifraLogotipa = $joinRed['SifraLogotipa'];

				if($joinSifraLogotipa == 6){
					$joinSlikaLogotipa = $joinRed['LogoPutanjaKorisnika'];
				}
				else{
					$joinSlikaLogotipa = $joinRed['FajlLogotipa'];
				}

				$joinVelicina = $joinRed['Velicina'];
				$joinUkupnaCena = $joinRed['UkupnaCena'];

				$ukupnaCenaSvihArtikala += $joinUkupnaCena; 

				$joinSifraKorisnika = $joinRed['SifraKorisnika'];
				$joinImePrezimeKorisnika = $joinRed['Ime'] . " " . $joinRed['Prezime'];

				$message .= "
				<table>
				<th class='table-dark'>Šifra artikla</th>
				<th class='table-dark'>Slika artikla</th>
				<th class='table-dark'>Šifra logotipa</th>
				<th class='table-dark'>Slika logotipa</th>
				<th class='table-dark'>Veličina</th>
				<th class='table-dark'>Ukupna cena</th>
				";

				$message .= "
				<tr>
				<td class='table-primary'>" . $joinSifraArtikla . "</td>
				<td class='table-primary'><img src=\"" . $joinSlikaArtikla . "\" alt='slika" . $joinSifraArtikla ."'></td>
				<td class='table-primary'>" . $joinSifraLogotipa . "</td>
				<td class='table-primary'><img src=\"" . $joinSlikaLogotipa . "\" alt='slika" . $joinSifraLogotipa ."'></td>
				<td class='table-primary'>" . $joinVelicina . "</td>
				<td class='table-primary'>" . $joinUkupnaCena . " din</td>
				</tr>
				";

				while($joinRow = $joinRez->fetch_assoc()){
					$joinSifraKorpe = $joinRow['SifraKorpe'];
					$joinSifraArtikla = $joinRow['SifraArtikla'];
					$joinSlikaArtikla = $joinRow['Fajl'];
					$joinSifraLogotipa = $joinRow['SifraLogotipa'];

					if($joinSifraLogotipa == 6){
						$joinSlikaLogotipa = $joinRow['LogoPutanjaKorisnika'];
					}
					else{
						$joinSlikaLogotipa = $joinRow['FajlLogotipa'];
					}

					$joinVelicina = $joinRow['Velicina'];

					$joinUkupnaCena = $joinRow['UkupnaCena'];
					$ukupnaCenaSvihArtikala += $joinUkupnaCena; 

					$joinSifraKorisnika = $joinRow['SifraKorisnika'];
					$joinImePrezimeKorisnika = $joinRow['Ime'] . " " . $joinRow['Prezime'];

					$message .= "
					<tr>
					<td class='table-primary'>" . $joinSifraArtikla . "</td>
					<td class='table-primary'><img src=\"" . $joinSlikaArtikla . "\" alt='slika" . $joinSifraArtikla ."'></td>
					<td class='table-primary'>" . $joinSifraLogotipa . "</td>
					<td class='table-primary'><img src=\"" . $joinSlikaLogotipa . "\" alt='slika" . $joinSifraLogotipa ."'></td>
					<td class='table-primary'>" . $joinVelicina . "</td>
					<td class='table-primary'>" . $joinUkupnaCena . " din</td>
					</td>
					</tr>
					";
				}
				$message .="<tr>
				<td class='table-active'>Ukupna cena svih artikala:</td>
				<td class='table-active'> </td>
				<td class='table-active'> </td>
				<td class='table-active'> </td>
				<td class='table-active'> </td>
				<td class='table-active'>" . $ukupnaCenaSvihArtikala .  " din</td>
				</tr></table>";
			}
		}
		?>

		<?php 

		if(isset($message)){
			echo $message;
		}
	}
	else{
		echo "<h1 class='porukaOPristupu'>Stranica je samo za administratore!</h1>";
	}
	include "php/footer.php";
	?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>