<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/loader.css">
</head>
<body>
	<div class="loader_bg">
		<div class="loader"></div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        setTimeout(function(){
            $('.loader_bg').fadeToggle();
        }, 1500);
</body>
</html>