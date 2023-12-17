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
	<link rel="stylesheet" type="text/css" href="css/pregledSvihKupaca.css">
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
	if((isset($_SESSION['rola']) && $_SESSION['rola'] == 0) || (isset($_SESSION['rola']) && $_SESSION['rola'] == 1)){
		?>

		<h1>Pregled svih kupaca</h1>

		<?php
		$mysqli = new mysqli("localhost", "root", "", "prodavnica");

		if($mysqli->error){
			die("Greška: " . $mysqli->error);
		}

		$sifraKorisnika = "";
		$imeKorisnika = "";
		$prezimeKorisnika = "";
		$adresaKorisnika = "";

		$upit = "select * from korisnik where Rola = 1;";
		$rez = $mysqli->query($upit);

		if(!$rez){
			print("Greška!");
			die($mysqli->error);
		}

		$red = $rez->fetch_assoc();
		if(!$red){
			print("Još nema kupaca!");
		}
		else{
			$message = "";

			$sifraKorisnika = $red["SifraKorisnika"];
			$imeKorisnika = $red["Ime"];
			$prezimeKorisnika = $red["Prezime"];
			$adresaKorisnika = $red["Adresa"];

			$message .= "
			<table>
			<th class='table-dark'>Šifra kupca</th>
			<th class='table-dark'>Ime kupca</th>
			<th class='table-dark'>Prezime kupca</th>
			<th class='table-dark'>Adresa kupca</th>
			<th class='table-dark'>Operacije</th>
			";

			$message .= "
			<tr>
			<td class='table-primary'>" . $sifraKorisnika . "</td>
			<td class='table-primary'>" . $imeKorisnika . "</td>
			<td class='table-primary'>" . $prezimeKorisnika . "</td>
			<td class='table-primary'>" . $adresaKorisnika . "</td>
			<td class='table-primary'><a class=\"btn btn-secondary\" href=\"pregledKorpe.php?kupacId=" . $sifraKorisnika . "\" role=\"button\">Pogledajte korpu</a></td>
			</tr>
			";

			// <button type=\"submit\" name=\"zaviri\" class=\"zaviri\"><a href=\"pregledKorpe.php?kupacId=" . $sifraKorisnika . "\">Pogledajte korpu</a></button>

			while($row = $rez->fetch_assoc()){
				$sifraKorisnika = $row["SifraKorisnika"];
				$imeKorisnika = $row["Ime"];
				$prezimeKorisnika = $row["Prezime"];
				$adresaKorisnika = $row["Adresa"];

				$message .= "
				<tr>
				<td class='table-primary'>" . $sifraKorisnika . "</td>
				<td class='table-primary'>" . $imeKorisnika . "</td>
				<td class='table-primary'>" . $prezimeKorisnika . "</td>
				<td class='table-primary'>" . $adresaKorisnika . "</td>
				<td class='table-primary'><a class=\"btn btn-secondary\" href=\"pregledKorpe.php?kupacId=" . $sifraKorisnika . "\" role=\"button\">Pogledajte korpu</a></td>
				</tr>	
				";
			}
			$message .= "</table>";
		}
		?>

		<?php 

		if(isset($message)){
			echo $message;
		}
	}
	else{
		echo "<h1 class='porukaOPristupu'>Stranica je samo za administratore i kupce!</h1>";
	}
	include "php/footer.php";
	?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>