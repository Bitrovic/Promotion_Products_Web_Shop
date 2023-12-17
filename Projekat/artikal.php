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
	<link rel="stylesheet" type="text/css" href="css/artikli.css">
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

		<?php
		$mysqli = new mysqli("localhost", "root", "", "prodavnica");
		$pripremaSifreArtikla = "";

		if($mysqli->error){
			die("Greska: " . $mysqli->error);
		}

		$sifraArtikla = "";
		$soljaMajica = "";
		$boja = "";
		$cena = "";
		$fajl = "";

		if(isset($_GET['artikalId'])){
			$sifraArtikla = $_GET['artikalId'];
			$pripremaSifreArtikla = "<input type='hidden' value='$sifraArtikla' name='artikalId'>";
		}

		if(isset($_POST['artikalId'])){
			$sifraArtikla = $_POST['artikalId'];
		}

		$upit = "select * from artikal where SifraArtikla = '$sifraArtikla'";
		$rez = $mysqli->query($upit);

		if(!$rez){
			print("Nema artikala trenutno na stanju!");
			die($mysqli->error);
		}

		$red = $rez->fetch_assoc();
		if(!$red){
			print("Trenutno nema artikla!");
		}
		else{
			$sifraArtikla = $red["SifraArtikla"];
			$soljaMajica = $red["SoljaMajica"];
			$boja = $red["Boja"];
			$cena = $red["Cena"];
			$fajl = $red["Fajl"];

			$prikazVelicine = "";

			if($soljaMajica == 0){
				$prikazVelicine .= "<label>Veličina</label></br>
				<select class=\"velicina\" name=\"velicina\">
				<option>S</option>
				<option>M</option>
				<option>L</option>
				<option>XL</option>
				<option>XLL</option>
				</select></br></br>";
			}
		}
		?>

		<div class="container">
			<?php 
			$sifraLogotipa = "";
			$nazivLogotipa = "";
			$fajlLogotipa = "";
			$cenaLogotipa = "";

			$upit1 = "select * from logotip";
			$rez1 = $mysqli->query($upit1);

			if(!$rez1){
				print("Nema logotipa!");
				die($mysqli->error);
			}

			$red1 = $rez1->fetch_assoc();
			if(!$red1){
				print("Trenutno nema logotipa!");
			}
			else{
				$message = "";

				$sifraLogotipa = $red1["SifraLogotipa"];
				$nazivLogotipa = $red1["Naziv"];
				$fajlLogotipa = $red1["FajlLogotipa"];
				$cenaLogotipa = $red1["Cena"];

				$message .= "
				<div class=\"bg-modal\">
				<div class=\"modal-content\">
				<div class=\"close\">+</div>
				<label>Logotipi</label></br>
				<select id=\"selectLogo\" name=\"selectLogo\" onchange=\"OnGradeChanged()\">
				<option value=\"0\">Izaberi...</option>
				<option value=\"" . $sifraLogotipa . "\">" . $nazivLogotipa . "&nbsp-&nbsp" . $cenaLogotipa . " din</option>";

				while($row1 = $rez1->fetch_assoc()){
					$sifraLogotipa = $row1["SifraLogotipa"];
					$nazivLogotipa = $row1["Naziv"];
					$fajlLogotipa = $row1["FajlLogotipa"];
					$cenaLogotipa = $row1["Cena"];

					if($sifraLogotipa != 6){
						$message .= "
						<option value=\"" . $sifraLogotipa . "\">" . $nazivLogotipa . "&nbsp-&nbsp" . $cenaLogotipa . " din</option>";
					}
				}

				$message .= "</select></br>
				<img id=\"slikaLogotipa\" class=\"slikaLogotipa\" src=\"Images/logotip/logotip1.png\" alt=\"logotip1\" style=\"visibility: hidden;\"></br>
				<button id=\"ok\" class=\"btn btn-primary\" type=\"button\" onclick=\"OnClickIzaberiLogo1()\">Izaberite logo</button>
				<button id=\"reset\" class=\"btn btn-primary\" type=\"button\" onclick=\"OnClickReset1()\">Resetujte</button>
				</div></div>";
			// echo $message;

				$porukaOIzabranomLogu = "";
				if(isset($_POST['dodajUKorpu'])){
					$sifraLogotipa = "";
					$logoPutanjaKorisnika = "";
					$cenaLogotipaRac = "";

					if(isset($_POST["selectLogo"]) && $_POST["selectLogo"] != 0){
						$sifraLogotipa = $_POST["selectLogo"];
						$logoPutanjaKorisnika = null;
					}
					else{
						$logoPutanjaKorisnika = "Images/korisnikLogotipi/" . $_FILES['fupload']['name'];
						$sifraLogotipa = 6;
					}

					$rola = $_SESSION['rola'];
					$velicina = $_POST['velicina'];
					$sifraKorisnika = $_SESSION["idKorisnika"];

					$upitCenaLogotipa = "select Cena from logotip where SifraLogotipa = '$sifraLogotipa'";
					$rezCenaLogotipa = $mysqli->query($upitCenaLogotipa);
					if(!$rezCenaLogotipa){
						print("Greška!");
						die($mysqli->error);
					}

					$redCenaLogotipa = $rezCenaLogotipa->fetch_assoc();
					if(!$redCenaLogotipa){
						print("Greška!");
					}
					else{
						$cenaLogotipaRac = $redCenaLogotipa["Cena"];
					}

					$ukupnaCena = $cena + $cenaLogotipaRac;

					$upisUKorpuUpit = "insert into korpa(SifraArtikla, SifraKorisnika, SifraLogotipa, LogoPutanjaKorisnika, Boja, Velicina, Rola, UkupnaCena) values ('$sifraArtikla', '$sifraKorisnika', '$sifraLogotipa', '$logoPutanjaKorisnika', '$boja', '$velicina', '$rola', '$ukupnaCena')";

					$rez = $mysqli->query($upisUKorpuUpit);

					if(!$rez){
						print("Artikal nije dodat u korpu!");
						die($mysqli->error);
					}
					else{
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
						$_SESSION['poruka'] = "<script>alert('Uspešno ubačen artikal u korpu!')</script>";
						header("Location: index.php");
					}
				}
			}
			?>

			<?php 
			if(isset($_FILES['fupload'])){
				$source = $_FILES['fupload']['tmp_name'];
				$target = "Images/korisnikLogotipi/" . $_FILES['fupload']['name'];
				move_uploaded_file($source, $target);
			}
			?>

			<form action="artikal.php" method="post" enctype="multipart/form-data">
				<?php echo $message;?>
				<div class="bg-modal1">
					<div class="modal-content1">
						<div class="close1">+</div>
						<label>Izaberite Vaš logotip</label></br>
						<input type="file" name="fupload" class="fupload" id="fupload" onchange="OnChangeInput()"></br>
						<p>U slučaju da birate logotip cena logotipa je 500 dinara!</p>
						<button type="button" id="ok1" class="btn btn-primary" name="ok1" onclick="OnClickIzaberiLogo2()">Izaberite logo</button></br>
						<button type="button" id="reset1" class="btn btn-primary" name="reset1" onclick="OnClickReset2()">Resetujte</button>

						<?php 
						echo $pripremaSifreArtikla;
						?>
					</div>
				</div>

				<div class="slika">
					<img src="<?php echo $fajl?>" alt="bela_majica">
				</div>

				<div class="ostalo">			
					<h1><?php echo $boja ?> majica</h1>
					<h2>Cena: <?php echo $cena?></h2></br>

					<?php echo $prikazVelicine?>

					<button type="button" class="btn btn-info" id="pokusaj" name="izaberiNas">Izaberite naš logo</button>
					<button type="button" class="btn btn-info" id="pokusaj1" name="izaberiVas">Izaberite Vaš logo</button></br>

					<button type="submit" name="dodajUKorpu" class="btn btn-danger" id="dodajUKorpu" disabled><img src="https://img.icons8.com/ios-glyphs/30/000000/buy--v1.png"/> Dodajte u korpu</button></br>
					<p id="obavezanLogo" style='color:red;'>Morate izabrati logotip, da biste mogli da ubacite artikal u korpu!</p>
				</div>
			</form>
		</div>
	</div>

	<script src="js/artikli.js"></script>

</div>
<?php
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