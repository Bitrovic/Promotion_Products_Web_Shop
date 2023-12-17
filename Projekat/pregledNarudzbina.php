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
	<link rel="stylesheet" type="text/css" href="css/pregledNarudzbina.css">
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

		<h1>Sve narudžbine</h1>

		<form action="pregledNarudzbina.php" method="post">
			<table class="tabelaZaPretragu">
				<tr>
					<td><label for="pretragaPoKorisniku">Pretraga narudžbina po korisniku</label></td>
					<td><input type="text" name="pretragaPoKorisniku" class="pretragaPoKorisniku" id="pretragaPoKorisniku"></td>
					<td><input type="submit" name="dugmeZaPretraguPoKorisnicima" class="btn btn-secondary" value="Pretraži po korisniku"></td>
				</tr>

				<tr>
					<td><label for="pretragaPoDatumu" class="labelDatum">Pretraga narudžbina po datumu</label></td>
					<td><input type="date" name="pretragaPoDatumu" class="pretragaPoDatumu" id="pretragaPoDatumu"></td>
					<td><input type="submit" name="dugmeZaPretraguPoDatumu" class="btn btn-secondary" value="Pretraži po datumu"></td>
				</tr>
			</table>		
		</form>

		<?php

		$mysqli = new mysqli("localhost", "root", "", "prodavnica");

		if($mysqli->error){
			die("Greska: " . $mysqli->error);
		}

		$sifraNarudzbine = "";
		$sifraArtikla = "";
		$sifraKorisnika = "";
		$sifraLogotipa = "";
		$logoPutanjaKorisnika = "";
		$boja = "";
		$velicina = "";
		$rola = "";
		$cena = "";
		$datum = "";

		$upit = "select * from narudzbina";
		$rez = $mysqli->query($upit);

		if(!$rez){
			print("Trenutno nema narudžbina!");
			die($mysqli->error);
		}

		$red = $rez->fetch_assoc();
		if(!$red){
			print("Trenutno nema narudžbina!");
		}
		else{
			$message = "";

			$sifraNarudzbine = $red["SifraNarudzbine"];
			$sifraArtikla = $red["SifraArtikla"];
			$sifraKorisnika = $red["SifraKorisnika"];
			$sifraLogotipa = $red["SifraLogotipa"];
			$logoPutanjaKorisnika = $red["LogoPutanjaKorisnika"];
			$boja = $red["Boja"];
			$velicina = $red["Velicina"];
			$rola = $red["Rola"];
			$cena = $red["Cena"];
			$datum = $red["Datum"];

			$joinUpit = "select n.SifraNarudzbine, a.SifraArtikla, a.Fajl, l.SifraLogotipa, l.FajlLogotipa, n.Velicina, n.Cena, n.LogoPutanjaKorisnika, n.Boja, n.Datum, ks.SifraKorisnika, ks.Ime, ks.Prezime, ks.Adresa from narudzbina n join artikal a on n.SifraArtikla = a.SifraArtikla JOIN logotip l on n.SifraLogotipa = l.SifraLogotipa JOIN korisnik ks on n.SifraKorisnika = ks.SifraKorisnika order by ks.SifraKorisnika asc;";


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
				$joinSifraLogotipa = "";
				$sifraNarudzbine = $joinRed['SifraNarudzbine'];
				$sifraArtikla = $joinRed['SifraArtikla'];
				$slikaArtikla = $joinRed['Fajl'];
				$sifraKorisnika = $joinRed["SifraKorisnika"];
				$sifraLogotipa = $joinRed["SifraLogotipa"];

				if($sifraLogotipa == 6){
					$joinSlikaLogotipa = $joinRed['LogoPutanjaKorisnika'];
				}
				else{
					$joinSlikaLogotipa = $joinRed['FajlLogotipa'];
				}

				$boja = $joinRed["Boja"];
				$velicina = $joinRed["Velicina"];
				$ukupnaCena = $joinRed["Cena"];
				$datum = $joinRed["Datum"];
				$joinImePrezimeKorisnika = $joinRed['Ime'] . " " . $joinRed['Prezime'];
				$adresa = $joinRed["Adresa"];

				$message .= "
				<table>
				<th class='table-dark'>Šifra narudžbine</th>
				<th class='table-dark'>Šifra artikla</th>
				<th class='table-dark'>Slika artikla</th>
				<th class='table-dark'>Šifra logotipa</th>
				<th class='table-dark'>Slika logotipa</th>
				<th class='table-dark'>Veličina</th>
				<th class='table-dark'>Ukupna cena</th>
				<th class='table-dark'>Šifra korisnika</th>
				<th class='table-dark'>Ime i prezime</th>
				<th class='table-dark'>Adresa</th>
				<th class='table-dark'>Datum</th>
				<th class='table-dark'>Operacije</th>
				";

				$message .= "
				<tr>
				<td class='table-primary'>" . $sifraNarudzbine . "</td>
				<td class='table-primary'>" . $sifraArtikla . "</td>
				<td class='table-primary'><img src=\"" . $slikaArtikla . "\" alt='slika" . $sifraArtikla ."'></td>
				<td class='table-primary'>" . $sifraLogotipa . "</td>
				<td class='table-primary'><img src=\"" . $joinSlikaLogotipa . "\" alt='slika" . $sifraLogotipa ."'></td>
				<td class='table-primary'>" . $velicina . "</td>
				<td class='table-primary'>" . $ukupnaCena . " din</td>
				<td class='table-primary'>" . $sifraKorisnika . "</td>
				<td class='table-primary'>" . $joinImePrezimeKorisnika . "</td>
				<td class='table-primary'>" . $adresa . "</td>
				<td class='table-primary'>" . $datum . "</td>
				<td class='table-primary'> 
				<a class=\"btn btn-danger\" name=\"brisi\" href=\"brisiNarudzbinu.php?deleteId=" . $sifraNarudzbine . "\" role=\"button\">Obrišite</a>
				<a class=\"btn btn-success\" name=\"izmeni\" href=\"izmeniNarudzbinu.php?izmeniId=" . $sifraNarudzbine . "\" role=\"button\">Izmenite</a>
				</div>
				</tr>
				";

				while($joinRow = $joinRez->fetch_assoc()){
					$sifraNarudzbine = $joinRow['SifraNarudzbine'];
					$sifraArtikla = $joinRow['SifraArtikla'];
					$slikaArtikla = $joinRow['Fajl'];
					$sifraKorisnika = $joinRow["SifraKorisnika"];
					$sifraLogotipa = $joinRow["SifraLogotipa"];

					if($sifraLogotipa == 6){
						$joinSlikaLogotipa = $joinRow['LogoPutanjaKorisnika'];
					}
					else{
						$joinSlikaLogotipa = $joinRow['FajlLogotipa'];
					}

					$boja = $joinRow["Boja"];
					$velicina = $joinRow["Velicina"];
					$ukupnaCena = $joinRow["Cena"];
					$datum = $joinRow["Datum"];
					$joinImePrezimeKorisnika = $joinRow['Ime'] . " " . $joinRow['Prezime'];
					$adresa = $joinRow["Adresa"];

					$message .= "
					<tr>
					<td class='table-primary'>" . $sifraNarudzbine . "</td>
					<td class='table-primary'>" . $sifraArtikla . "</td>
					<td class='table-primary'><img src=\"" . $slikaArtikla . "\" alt='slika" . $sifraArtikla ."'></td>
					<td class='table-primary'>" . $sifraLogotipa . "</td>
					<td class='table-primary'><img src=\"" . $joinSlikaLogotipa . "\" alt='slika" . $sifraLogotipa ."'></td>
					<td class='table-primary'>" . $velicina . "</td>
					<td class='table-primary'>" . $ukupnaCena . " din</td>
					<td class='table-primary'>" . $sifraKorisnika . "</td>
					<td class='table-primary'>" . $joinImePrezimeKorisnika . "</td>
					<td class='table-primary'>" . $adresa . "</td>
					<td class='table-primary'>" . $datum . "</td>
					<td class='table-primary'> 
					<a class=\"btn btn-danger\" name=\"brisi\" href=\"brisiNarudzbinu.php?deleteId=" . $sifraNarudzbine . "\" role=\"button\">Obrišite</a>
					<a class=\"btn btn-success\" name=\"izmeni\" href=\"izmeniNarudzbinu.php?izmeniId=" . $sifraNarudzbine . "\" role=\"button\">Izmenite</a>
					</td>
					
					</tr>
					";
				}
				$message .= "</table>";
			}
		}

		// <input type="text" name="pretragaPoKorisniku" class="pretragaPoKorisniku">
		// <input type="submit" name="dugmeZaPretraguPoKorisnicima" class="dugmeZaPretraguPoKorisnicima" value="Pretraži po korisniku">

		if(isset($_POST["dugmeZaPretraguPoKorisnicima"])){
			if($_POST["pretragaPoKorisniku"] == 0 || !$_POST["pretragaPoKorisniku"]){
				echo "<script>alert(\"Morate uneti korisnika sa validnom šifrom!\")</script>";
			}
			else{
				$upit = "select * from narudzbina";
				$rez = $mysqli->query($upit);

				if(!$rez){
					print("Trenutno nema narudžbina!");
					die($mysqli->error);
				}

				$red = $rez->fetch_assoc();
				if(!$red){
					print("Trenutno nema narudžbina!");
				}
				else{
					$message = "";

					$sifraNarudzbine = $red["SifraNarudzbine"];
					$sifraArtikla = $red["SifraArtikla"];
					$sifraKorisnika = $_POST["pretragaPoKorisniku"];
					$sifraLogotipa = $red["SifraLogotipa"];
					$logoPutanjaKorisnika = $red["LogoPutanjaKorisnika"];
					$boja = $red["Boja"];
					$velicina = $red["Velicina"];
					$rola = $red["Rola"];
					$cena = $red["Cena"];
					$datum = $red["Datum"];

					$joinUpit = "select n.SifraNarudzbine, a.SifraArtikla, a.Fajl, l.SifraLogotipa, l.FajlLogotipa, n.Velicina, n.Cena, n.LogoPutanjaKorisnika, n.Boja, n.Datum, ks.SifraKorisnika, ks.Ime, ks.Prezime, ks.Adresa from narudzbina n join artikal a on n.SifraArtikla = a.SifraArtikla JOIN logotip l on n.SifraLogotipa = l.SifraLogotipa JOIN korisnik ks on n.SifraKorisnika = ks.SifraKorisnika where ks.SifraKorisnika = '$sifraKorisnika';";


					$joinRez = $mysqli->query($joinUpit);

					if(!$joinRez){
						print("Greška!");
						die($mysqli->error);
					}

					$joinRed = $joinRez->fetch_assoc();
					if(!$joinRed){
						echo "<script>alert('Morate uneti korisnika sa validnom šifrom!');</script>";

						//Napraviti novi upit za selekciju svih narudzbina
						$joinUpit = "select n.SifraNarudzbine, a.SifraArtikla, a.Fajl, l.SifraLogotipa, l.FajlLogotipa, n.Velicina, n.Cena, n.LogoPutanjaKorisnika, n.Boja, n.Datum, ks.SifraKorisnika, ks.Ime, ks.Prezime, ks.Adresa from narudzbina n join artikal a on n.SifraArtikla = a.SifraArtikla JOIN logotip l on n.SifraLogotipa = l.SifraLogotipa JOIN korisnik ks on n.SifraKorisnika = ks.SifraKorisnika order by ks.SifraKorisnika asc;";

						$joinRez = $mysqli->query($joinUpit);
						$joinRed = $joinRez->fetch_assoc();

					}

					$joinSifraLogotipa = "";
					$sifraNarudzbine = $joinRed['SifraNarudzbine'];
					$sifraArtikla = $joinRed['SifraArtikla'];
					$slikaArtikla = $joinRed['Fajl'];
					$sifraKorisnika = $joinRed["SifraKorisnika"];
					$sifraLogotipa = $joinRed["SifraLogotipa"];

					if($sifraLogotipa == 6){
						$joinSlikaLogotipa = $joinRed['LogoPutanjaKorisnika'];
					}
					else{
						$joinSlikaLogotipa = $joinRed['FajlLogotipa'];
					}

					$boja = $joinRed["Boja"];
					$velicina = $joinRed["Velicina"];
					$ukupnaCena = $joinRed["Cena"];
					$datum = $joinRed["Datum"];
					$joinImePrezimeKorisnika = $joinRed['Ime'] . " " . $joinRed['Prezime'];
					$adresa = $joinRed["Adresa"];

					$message .= "
					<table>
					<th class='table-dark'>Šifra narudžbine</th>
					<th class='table-dark'>Šifra artikla</th>
					<th class='table-dark'>Slika artikla</th>
					<th class='table-dark'>Šifra logotipa</th>
					<th class='table-dark'>Slika logotipa</th>
					<th class='table-dark'>Veličina</th>
					<th class='table-dark'>Ukupna cena</th>
					<th class='table-dark'>Šifra korisnika</th>
					<th class='table-dark'>Ime i prezime</th>
					<th class='table-dark'>Adresa</th>
					<th class='table-dark'>Datum</th>
					<th class='table-dark'>Operacije</th>
					";

					$message .= "
					<tr>
					<td class='table-primary'>" . $sifraNarudzbine . "</td>
					<td class='table-primary'>" . $sifraArtikla . "</td>
					<td class='table-primary'><img src=\"" . $slikaArtikla . "\" alt='slika" . $sifraArtikla ."'></td>
					<td class='table-primary'>" . $sifraLogotipa . "</td>
					<td class='table-primary'><img src=\"" . $joinSlikaLogotipa . "\" alt='slika" . $sifraLogotipa ."'></td>
					<td class='table-primary'>" . $velicina . "</td>
					<td class='table-primary'>" . $ukupnaCena . " din</td>
					<td class='table-primary'>" . $sifraKorisnika . "</td>
					<td class='table-primary'>" . $joinImePrezimeKorisnika . "</td>
					<td class='table-primary'>" . $adresa . "</td>
					<td class='table-primary'>" . $datum . "</td>
					<td class='table-primary'> 
					<a class=\"btn btn-danger\" name=\"brisi\" href=\"brisiNarudzbinu.php?deleteId=" . $sifraNarudzbine . "\" role=\"button\">Obrišite</a>
					<a class=\"btn btn-success\" name=\"izmeni\" href=\"izmeniNarudzbinu.php?izmeniId=" . $sifraNarudzbine . "\" role=\"button\">Izmenite</a>
					</div>
					</tr>
					";

					while($joinRow = $joinRez->fetch_assoc()){
						$sifraNarudzbine = $joinRow['SifraNarudzbine'];
						$sifraArtikla = $joinRow['SifraArtikla'];
						$slikaArtikla = $joinRow['Fajl'];
						$sifraKorisnika = $joinRow["SifraKorisnika"];
						$sifraLogotipa = $joinRow["SifraLogotipa"];

						if($sifraLogotipa == 6){
							$joinSlikaLogotipa = $joinRow['LogoPutanjaKorisnika'];
						}
						else{
							$joinSlikaLogotipa = $joinRow['FajlLogotipa'];
						}

						$boja = $joinRow["Boja"];
						$velicina = $joinRow["Velicina"];
						$ukupnaCena = $joinRow["Cena"];
						$datum = $joinRow["Datum"];
						$joinImePrezimeKorisnika = $joinRow['Ime'] . " " . $joinRow['Prezime'];
						$adresa = $joinRow["Adresa"];

						$message .= "
						<tr>
						<td class='table-primary'>" . $sifraNarudzbine . "</td>
						<td class='table-primary'>" . $sifraArtikla . "</td>
						<td class='table-primary'><img src=\"" . $slikaArtikla . "\" alt='slika" . $sifraArtikla ."'></td>
						<td class='table-primary'>" . $sifraLogotipa . "</td>
						<td class='table-primary'><img src=\"" . $joinSlikaLogotipa . "\" alt='slika" . $sifraLogotipa ."'></td>
						<td class='table-primary'>" . $velicina . "</td>
						<td class='table-primary'>" . $ukupnaCena . " din</td>
						<td class='table-primary'>" . $sifraKorisnika . "</td>
						<td class='table-primary'>" . $joinImePrezimeKorisnika . "</td>
						<td class='table-primary'>" . $adresa . "</td>
						<td class='table-primary'>" . $datum . "</td>
						<td class='table-primary'> 
						<a class=\"btn btn-danger\" name=\"brisi\" href=\"brisiNarudzbinu.php?deleteId=" . $sifraNarudzbine . "\" role=\"button\">Obrišite</a>
						<a class=\"btn btn-success\" name=\"izmeni\" href=\"izmeniNarudzbinu.php?izmeniId=" . $sifraNarudzbine . "\" role=\"button\">Izmenite</a>
						</td>

						</tr>
						";
					}
					$message .= "</table>";

				}
			}
		}

		if(isset($_POST["dugmeZaPretraguPoDatumu"])){
			if($_POST["pretragaPoDatumu"] == 0 || !$_POST["pretragaPoDatumu"]){
				echo "<script>alert(\"Morate uneti datum u validnom formatu!\")</script>";
			}
			else{
				$upit = "select * from narudzbina";
				$rez = $mysqli->query($upit);

				if(!$rez){
					print("Trenutno nema narudžbina!");
					die($mysqli->error);
				}

				$red = $rez->fetch_assoc();
				if(!$red){
					print("Trenutno nema narudžbina!");
				}
				else{
					$message = "";

					$sifraNarudzbine = $red["SifraNarudzbine"];
					$sifraArtikla = $red["SifraArtikla"];
					$sifraKorisnika = $red["SifraKorisnika"];
					$sifraLogotipa = $red["SifraLogotipa"];
					$logoPutanjaKorisnika = $red["LogoPutanjaKorisnika"];
					$boja = $red["Boja"];
					$velicina = $red["Velicina"];
					$rola = $red["Rola"];
					$cena = $red["Cena"];
					$datum = $_POST["pretragaPoDatumu"];

					$joinUpit = "select n.SifraNarudzbine, a.SifraArtikla, a.Fajl, l.SifraLogotipa, l.FajlLogotipa, n.Velicina, n.Cena, n.LogoPutanjaKorisnika, n.Boja, n.Datum, ks.SifraKorisnika, ks.Ime, ks.Prezime, ks.Adresa from narudzbina n join artikal a on n.SifraArtikla = a.SifraArtikla JOIN logotip l on n.SifraLogotipa = l.SifraLogotipa JOIN korisnik ks on n.SifraKorisnika = ks.SifraKorisnika where cast(n.Datum as date) = '$datum';";


					$joinRez = $mysqli->query($joinUpit);

					if(!$joinRez){
						print("Greška!");
						die($mysqli->error);
					}

					$joinRed = $joinRez->fetch_assoc();
					if(!$joinRed){
						echo "<script>alert('Morate uneti validni datum!');</script>";

						//Napraviti novi upit za selekciju svih narudzbina
						$joinUpit = "select n.SifraNarudzbine, a.SifraArtikla, a.Fajl, l.SifraLogotipa, l.FajlLogotipa, n.Velicina, n.Cena, n.LogoPutanjaKorisnika, n.Boja, n.Datum, ks.SifraKorisnika, ks.Ime, ks.Prezime, ks.Adresa from narudzbina n join artikal a on n.SifraArtikla = a.SifraArtikla JOIN logotip l on n.SifraLogotipa = l.SifraLogotipa JOIN korisnik ks on n.SifraKorisnika = ks.SifraKorisnika order by ks.SifraKorisnika asc;";

						$joinRez = $mysqli->query($joinUpit);
						$joinRed = $joinRez->fetch_assoc();

					}
					
					$joinSifraLogotipa = "";
					$sifraNarudzbine = $joinRed['SifraNarudzbine'];
					$sifraArtikla = $joinRed['SifraArtikla'];
					$slikaArtikla = $joinRed['Fajl'];
					$sifraKorisnika = $joinRed["SifraKorisnika"];
					$sifraLogotipa = $joinRed["SifraLogotipa"];

					if($sifraLogotipa == 6){
						$joinSlikaLogotipa = $joinRed['LogoPutanjaKorisnika'];
					}
					else{
						$joinSlikaLogotipa = $joinRed['FajlLogotipa'];
					}

					$boja = $joinRed["Boja"];
					$velicina = $joinRed["Velicina"];
					$ukupnaCena = $joinRed["Cena"];
					$datum = $joinRed["Datum"];
					$joinImePrezimeKorisnika = $joinRed['Ime'] . " " . $joinRed['Prezime'];
					$adresa = $joinRed["Adresa"];

					$message .= "
					<table>
					<th class='table-dark'>Šifra narudžbine</th>
					<th class='table-dark'>Šifra artikla</th>
					<th class='table-dark'>Slika artikla</th>
					<th class='table-dark'>Šifra logotipa</th>
					<th class='table-dark'>Slika logotipa</th>
					<th class='table-dark'>Veličina</th>
					<th class='table-dark'>Ukupna cena</th>
					<th class='table-dark'>Šifra korisnika</th>
					<th class='table-dark'>Ime i prezime</th>
					<th class='table-dark'>Adresa</th>
					<th class='table-dark'>Datum</th>
					<th class='table-dark'>Operacije</th>
					";

					$message .= "
					<tr>
					<td class='table-primary'>" . $sifraNarudzbine . "</td>
					<td class='table-primary'>" . $sifraArtikla . "</td>
					<td class='table-primary'><img src=\"" . $slikaArtikla . "\" alt='slika" . $sifraArtikla ."'></td>
					<td class='table-primary'>" . $sifraLogotipa . "</td>
					<td class='table-primary'><img src=\"" . $joinSlikaLogotipa . "\" alt='slika" . $sifraLogotipa ."'></td>
					<td class='table-primary'>" . $velicina . "</td>
					<td class='table-primary'>" . $ukupnaCena . " din</td>
					<td class='table-primary'>" . $sifraKorisnika . "</td>
					<td class='table-primary'>" . $joinImePrezimeKorisnika . "</td>
					<td class='table-primary'>" . $adresa . "</td>
					<td class='table-primary'>" . $datum . "</td>
					<td class='table-primary'>
					<a class=\"btn btn-danger\" name=\"brisi\" href=\"brisiNarudzbinu.php?deleteId=" . $sifraNarudzbine . "\" role=\"button\">Obrišite</a>
					<a class=\"btn btn-success\" name=\"izmeni\" href=\"izmeniNarudzbinu.php?izmeniId=" . $sifraNarudzbine . "\" role=\"button\">Izmenite</a>
					</td>
					</div> 
					</tr>
					";

					// <button type=\"submit\" name=\"brisi\" class=\"brisi\"><a href=\"brisiNarudzbinu.php?deleteId=" . $sifraNarudzbine . "\">Obriši</a></button>
					// 	<button type=\"submit\" name=\"izmeni\" class=\"izmeni\"><a href=\"izmeniNarudzbinu.php?izmeniId=" . $sifraNarudzbine . "\">Izmeni</a></button>

					while($joinRow = $joinRez->fetch_assoc()){
						$sifraNarudzbine = $joinRow['SifraNarudzbine'];
						$sifraArtikla = $joinRow['SifraArtikla'];
						$slikaArtikla = $joinRow['Fajl'];
						$sifraKorisnika = $joinRow["SifraKorisnika"];
						$sifraLogotipa = $joinRow["SifraLogotipa"];

						if($sifraLogotipa == 6){
							$joinSlikaLogotipa = $joinRow['LogoPutanjaKorisnika'];
						}
						else{
							$joinSlikaLogotipa = $joinRow['FajlLogotipa'];
						}

						$boja = $joinRow["Boja"];
						$velicina = $joinRow["Velicina"];
						$ukupnaCena = $joinRow["Cena"];
						$datum = $joinRow["Datum"];
						$joinImePrezimeKorisnika = $joinRow['Ime'] . " " . $joinRow['Prezime'];
						$adresa = $joinRow["Adresa"];

						$message .= "
						<tr>
						<td class='table-primary'>" . $sifraNarudzbine . "</td>
						<td class='table-primary'>" . $sifraArtikla . "</td>
						<td class='table-primary'><img src=\"" . $slikaArtikla . "\" alt='slika" . $sifraArtikla ."'></td>
						<td class='table-primary'>" . $sifraLogotipa . "</td>
						<td class='table-primary'><img src=\"" . $joinSlikaLogotipa . "\" alt='slika" . $sifraLogotipa ."'></td>
						<td class='table-primary'>" . $velicina . "</td>
						<td class='table-primary'>" . $ukupnaCena . " din</td>
						<td class='table-primary'>" . $sifraKorisnika . "</td>
						<td class='table-primary'>" . $joinImePrezimeKorisnika . "</td>
						<td class='table-primary'>" . $adresa . "</td>
						<td class='table-primary'>" . $datum . "</td>
						<td class='table-primary'> 
						<a class=\"btn btn-danger\" name=\"brisi\" href=\"brisiNarudzbinu.php?deleteId=" . $sifraNarudzbine . "\" role=\"button\">Obrišite</a>
						<a class=\"btn btn-success\" name=\"izmeni\" href=\"izmeniNarudzbinu.php?izmeniId=" . $sifraNarudzbine . "\" role=\"button\">Izmenite</a>
						</td>

						</tr>
						";
					}
					$message .= "</table>";

				}
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
	?>

	<?php include "php/footer.php";	

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