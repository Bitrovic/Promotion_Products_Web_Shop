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
	?>
</div>

<?php
$porukaONeuspehu = "";
if(isset($_POST['register'])){
	if(!$_POST['ime'] || !$_POST['prezime'] || !$_POST['adresa'] || !$_POST['email'] || !$_POST['password']){
		echo "<script>alert('Morate uneti sve podatke da biste se registrovali!')</script>";
	}
	else{
		$mysqli = new mysqli("localhost", "root", "", "prodavnica");

		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$adresa = $_POST['adresa'];
		$email = $_POST['email'];
		$sifra = $_POST['password'];

		$upit = "select * from korisnik where Email = '$email'";
		$rez = $mysqli->query($upit);

		if(!$rez){
			print("Upit ne moze da se izvrsi!");
			die($mysqli->error);
		}

		$red = $rez->fetch_assoc();
		if($red){
			$porukaONeuspehu = "<p style='color:red;text-align:center;'>Email već postoji, pokušajte ponovo!</p>";
		}
		else{
			$upit1 = "insert into korisnik(Ime, Prezime, Adresa, Email, Password) values ('$ime', '$prezime', '$adresa', '$email', '$sifra')";

			$rez1 = $mysqli->query($upit1);
			if(!$rez){
				print("Upit ne moze da se izvrsi!");
			}
			else{
				$_SESSION['poruka'] = "<script>alert('Uspešno ste se registrovali!')</script>";
				header("Location: login.php");
			}
		}

	}
}
?>

<form class="logIn" action="register.php" method="post">
	<div class="container">
		<img src="Images/profil.png">
		<h1>Registruj se</h1>
		<div class="levo">
			<div class="form-group">
				<label for="ime">Ime</label>
				<input type="text" class="form-control" id="ime" placeholder="Unesite ime" name="ime">
			</div>
			<div class="form-group">
				<label for="prezime">Prezime</label>
				<input type="text" class="form-control" id="prezime" placeholder="Unesite prezime" name="prezime">
			</div>
			<div class="form-group">
				<label for="email">E-mail</label>
				<input type="email" class="form-control" id="email" placeholder="Unesite e-mail" name="email">
				<?php echo $porukaONeuspehu ?>
				<div id="poruka" style="text-align: center;"></div>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Šifra</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Unesite šifru" name="password">
			</div>
			<div class="form-group">
				<label for="adresa">Adresa stanovanja</label>
				<input type="text" class="form-control" id="adresa" placeholder="Unesite adresu stanovanja" name="adresa">
			</div>
		</div>
		
		<div class="form-group form-check">
			<label>Več ste naš član? <a href="login.php">Logujte se</a></label>
		</div>
		<button type="submit" name="register">Registrujte se</button>
	</div>
</form>

<?php
include "php/footer.php";
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>