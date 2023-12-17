<?php 
session_start();

if (isset($_SESSION["korisnik"]) && $_SESSION["korisnik"] != "") {
	session_unset();
	session_destroy();
	$_SESSION['rola'] = 2;
}
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
	?>
</div>

<?php
$porukaONeuspehu = "";
if(isset($_POST['logovanje'])){
	$email = $_POST['email'];
	$password = $_POST['password'];

	$mysqli = new mysqli("localhost", "root", "", "prodavnica");

	$upit = "select * from korisnik where Email = '$email' and Password = '$password'";
	$rez = $mysqli->query($upit);		

	$red = $rez->fetch_assoc();
	if($red){
		$_SESSION["korisnik"] = $email;
		$_SESSION["idKorisnika"] = $red["SifraKorisnika"];
		$sifraKorisnika = $_SESSION["idKorisnika"];

		if($red['Rola'] == 0){
			$_SESSION['rola'] = 0;
		}
		else{
			$_SESSION['rola'] = 1;
		}
		$_SESSION['poruka'] = "<script>alert('Logovanje uspešno')</script>";
		header("Location: index.php");

		if($_SESSION['rola'] < 2){
			$artikliUKorpi = "select count(*) as Broj from korpa where SifraKorisnika = '$sifraKorisnika'";
			$countRez = $mysqli->query($artikliUKorpi);
			if(!$countRez){
				print("Greška!");
				die($mysqli->error);
			}

			$countRed = $countRez->fetch_assoc();
			if(!$countRed){
				print("Greška!");
			}
			else{
				$_SESSION['brojArtikalaUKorpi'] = $countRed["Broj"];
			}
		}
	}
	else{
		$_SESSION['rola'] = 2;
		//echo "<script>alert(\"Korisnički nalog sa unetim e-mailom i passwordom ne postoji! Pokušajte ponovo!\")</script>";
		$porukaONeuspehu = "<p style='color:red;text-align:center;'>Nalog sa unetim podacim ne postoji. Pokušajte ponovo!</p>";
	}
}	

?>
<form class="logIn" action="login.php" method="post">
	<div class="container">
		<img src="Images/profil.png">
		<h1>Uloguj se</h1>
		<div class="levo">
			<div class="form-group">
				<label for="email">E-mail</label>
				<input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Unesite e-mail" name="email">
				<small id="emailHelp" class="form-text text-muted">Nikad nećemo podeliti Vaš e-mail sa ostalima!</small>
			</div>
			<div class="form-group">
				<label for="password">Šifra</label>
				<input type="password" class="form-control" id="password" placeholder="Unesite šifru" name="password">
			</div>
		</div>
		<?php echo $porukaONeuspehu ?>
		
		<div class="form-group form-check">
			<label>Nisi član? <a href="register.php">Registrujte se</a></label>
		</div>
		<button type="submit" name="logovanje">Ulogujte se</button>
	</div>
</form>

<?php
include "php/footer.php";
if(isset($_SESSION['poruka']) && $_SESSION['poruka'] != ""){
	echo $_SESSION['poruka'];
	$_SESSION['poruka'] = "";
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>