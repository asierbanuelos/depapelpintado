<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>GESTIÓN EKAM</title>
		<meta name="description" content="">
		<meta name="author" content="Enrique Uriarte">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<link href="<?php echo $includes_dir ?>css/kol.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic,900,900italic,300italic,300,100italic,100' rel='stylesheet' type='text/css'>
	</head>

	<body>
		<div>
			<header>
				<h1>Zona de gestión</h1>
			</header>
		

			<div class="cajalogin">

				<form method="post">
					<div class="user"><input name="user" placeholder="Usuario"/></div>
					<div class="pass"><input type="password" name="pass" placeholder="Password"/></div>
					<div class="boton"><button type="submit" name=log>Entrar</button> </div>
				</form>

			</div>

			<footer>
				<p>
					&copy; Copyright  by  Ekam
				</p>
			</footer>
		</div>
	</body>
</html>
