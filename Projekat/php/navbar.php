<?php
$pregledArtikala = "";
$pregledNarudzbina = "";
$pregledKupaca = "";
$link = "login.php";
$isLogged = '<li><a href="login.php">Ulogujte se</a></li>';

if(isset($_SESSION['rola']) && $_SESSION['rola'] == 0){
	$pregledArtikala = '<li><a href="pregledSvihArtikala.php">Pregled svih artikala</a></li>';
	$pregledNarudzbina = '<li><a href="pregledNarudzbina.php">Pregled narudžbina</a></li>';
	$pregledKupaca = '<li><a href="pregledSvihKupaca.php">Pregled svih kupaca</a></li>';
	$link = "korpa.php";
	$isLogged = '<li><a href="login.php">Izlogujte se</a></li>';
}

if(isset($_SESSION['rola']) && $_SESSION['rola'] == 1){
	$link = "korpa.php";
	$isLogged = '<li><a href="login.php">Izlogujte se</a></li>';
}
?>

<nav class="hederMeni">
	<ul class="meni">
		<p><img src="Images/logo2.png" alt="logo">Štampanje</p>
		<li><a href="index.php">Početna strana</a></li>
		<li>
			<a class="dropArtikal" href="index.php#usluge">Artikli <img src="https://img.icons8.com/ios-filled/50/000000/sort-down.png"/></a>
			<ul>
				<li><a href="majice.php">Majice</a></li>
				<li><a href="solje.php">Šolje</a></li>
				<?php echo $pregledArtikala?>
				<?php echo $pregledNarudzbina ?>
				<?php echo $pregledKupaca ?>
			</ul>
		</li>
		<li><a href="contact.php">Kontakt</a></li>
		<li><a href="about.php">O projektu</a></li>
		
	</ul>

	<ul class="logovanje">
		<?php echo $isLogged ?>
		<li><a href="<?php echo $link?>"><img class="korpa_slika" src="https://img.icons8.com/ios-glyphs/50/000000/shopping-cart--v1.png"/><span class="badge badge-info">
			<?php 
			if(isset($_SESSION['brojArtikalaUKorpi'])){
				echo $_SESSION['brojArtikalaUKorpi'];
			}
			else{
				echo 0;
			}
			?>
		</span></a></li>
	</ul>
</nav>