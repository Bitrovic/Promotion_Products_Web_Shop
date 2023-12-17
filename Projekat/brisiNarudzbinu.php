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

		$sifraArtikla = "";
		$sifraNarudzbine = "";
		$sifraKorisnika = "";
		$sifraLogotipa = "";
		$logoPutanjaKorisnika = "";
		$boja = "";
		$velicina = "";
		$cena = "";
		$rola = "";
		$datum = "";
		$sifra = 0;

		if(isset($_GET['deleteId'])){
			$sifra = $_GET['deleteId'];
		}

		$upit = "select * from narudzbina where SifraNarudzbine = '$sifra'";
		$rez = $mysqli->query($upit);
		if(!$rez){
			print("Nema narudžbine sa tom šifrom!");
			die($mysqli->error);
		}

		$red = $rez->fetch_assoc();
		if(!$red){
			print("Nema trazene narudžbine po šifri!");
		}
		else{
			$sifraArtikla = $red["SifraArtikla"];
			$sifraNarudzbine =  $red["SifraNarudzbine"];
			$sifraKorisnika =  $red["SifraKorisnika"];
			$sifraLogotipa =  $red["SifraLogotipa"];
			$logoPutanjaKorisnika = $red["LogoPutanjaKorisnika"];
			$boja =  $red["Boja"];
			$velicina =  $red["Velicina"];
			$cena =  $red["Cena"];
			$rola =  $red["Rola"];
			$datum =  $red["Datum"];
		}

		if(isset($_POST['potvrda'])){
			$upit1 = "delete from narudzbina where SifraNarudzbine = '$sifra'";
			$rez1 = $mysqli->query($upit1);

			if(!$rez1){
				print("Nema narudžbine sa tom šifrom!");
				die($mysqli->error);
			}
			else{
				$_SESSION['poruka'] = "<script>alert('Uspešno brisanje narudžbine!')</script>";
				header("Location: pregledNarudzbina.php");
			}
		}
		?>
	</div>
	<form class="logIn" method="post">
		<div class="container">
			<h1>Obrišite narudžbinu</h1>
			<div class="levo">

				<div class="form-group">
					<label for="sifraNar">Šifra narudžbine</label>
					<input type="text" class="form-control" id="sifraNar" readonly="true" value="<?php echo $sifraNarudzbine ?>">
				</div>
				<div class="form-group">
					<label for="sifraArt">Šifra artikla</label>
					<input type="text" class="form-control" id="sifraArt" readonly="true" value="<?php echo $sifraArtikla ?>">
				</div>
				<div class="form-group">
					<label for="sifraLog">Šifra logotipa</label>
					<input type="text" class="form-control" id="sifraLog" readonly="true" value="<?php echo $sifraLogotipa ?>">
				</div>
				<div class="form-group">
					<label for="boja">Boja</label>
					<input type="text" class="form-control" id="boja" readonly="true" value="<?php echo $boja ?>">
				</div>
				<div class="form-group">
					<label for="velicina">Veličina</label>
					<input type="text" class="form-control" id="velicina" readonly="true" value="<?php echo $velicina ?>">
				</div>
				<div class="form-group">
					<label for="cena">Cena</label>
					<input type="text" class="form-control" id="cena" readonly="true" value="<?php echo $cena ?>">
				</div>
				<div class="form-group">
					<label for="datum">Datum</label>
					<input type="text" class="form-control" id="datum" readonly="true" value="<?php echo $datum ?>">
				</div>
			</div>

			<button type="submit" name="potvrda" onclick="Potvrda()">Obrišite</button>
		</div>
	</form>

	<script type="text/javascript">
		function Potvrda(){
			return confirm('Da li ste sigurni da želite da obrišete artikal?');
		}
	</script>
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