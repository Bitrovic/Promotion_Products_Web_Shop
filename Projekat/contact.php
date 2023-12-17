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
	<link rel="stylesheet" type="text/css" href="css/contact.css">
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

	 <div class="row"> <!-- podela prikaza -->
      <div class="col-md-6">
        <h2 class="page-header-kontakt">
          Kontakt
        </h2>
        <form> <!-- pocetak forme -->
          <div class="form-group">
            <label for="inputName">Vaše ime i prezime</label>
            <input type="text" class="form-control" id="inputName" placeholder="Unesite Vaše ime i prezime">
          </div>
          <div class="form-group">
            <label for="inputEmail">Vaš email</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Ovde unesite Vaš email">
          </div>
          <div class="form-group">
            <label for="inputTel">Telefonski broj</label>
            <input type="tel" class="form-control" id="inputTel" placeholder="Ovde unesite Vaš telefonski broj">
          </div>
          <div class="form-group">
            <label for="inputSubject">Naslov Vaše poruke</label>
            <input type="text" class="form-control" id="inputSubject" placeholder="Ovde unesite naslov Vaše poruke">
          </div>
          <div class="form-group">
            <label for="inputText">Vaša Poruka</label>
            <textarea class="form-control" rows="5" id="inputText"></textarea>
          </div>
          <button type="submit" class="btn btn-lg btn-block">Pošaljite <img src="https://img.icons8.com/ios-filled/50/ffffff/paper-plane.png"/></button>
        </form> <!-- kraj forme -->
      </div> 
      <div class="col-md-6">
        <h2 class="page-header">
          Gde se nalazimo
        </h2>
        <p><img src="https://img.icons8.com/ios-filled/50/000000/worldwide-location--v1.png"/> Savski nasip 7, Beograd 11000 </p>
        <p><img src="https://img.icons8.com/ios-filled/50/000000/ringing-phone.png"/> +381 11 2096777</p>
        <p><img src="https://img.icons8.com/ios-filled/50/000000/email-open.png"/> office@its.edu.rs</p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2830.975802243903!2d20.417924615801656!3d44.80168177909869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a6fed108da8a7%3A0x9c662a8e931516fb!2sITS+-+Information+Technology+School!5e0!3m2!1sen!2srs!4v1549693251601" allowfullscreen></iframe>
      </div>
    </div> <!-- kraj podele prikaza -->

	<?php
		include "php/footer.php";
	?>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>