<?php
require_once('connexion.php');
$connexion = new Connexion('localhost', 'root', '', 'connexion');

// Check if form is submitted for login or registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    // Login
    if (isset($_POST["connexion"])) {
        $email = $_POST["logemail"];
        $password = $_POST["logpass"];
        $connexion->login($email, $password);
    }

    // Registration
    if (isset($_POST["inscription"])) {
        $name = $_POST["logname"];
        $email = $_POST["logemail"];
        $password = $_POST["logpass"];
        $connexion->register($name, $email, $password);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>login</title>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
	<link rel="stylesheet" href="indexstyle.css">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="connexionstylee.css">
</head>

<body>

	<div class="section">
		<canvas id="canvas"></canvas>

		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Connexion </span><span>Inscrit-toi</span></h6>
						<input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
						<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Connexion</h4>
											<form action="" method="post">
												<div class="form-group">
													<input type="email" name="logemail" class="form-style"
														placeholder="Email" id="logemail" autocomplete="off">
													<i class="input-icon uil uil-at"></i>
													<input type="password" name="logpass" class="form-style"
														placeholder="Mot de passe" id="logpass" autocomplete="off"
														minlength="4">
													<i class="input-icon uil uil-lock-alt cadenaconnexion"></i>
												</div>
												<div class="form-group">
													<button type="submit" name="connexion"
														class="btn mt-4">Connexion</button>
												</div>
											</form>
											<p class="mb-0 mt-4 text-center">Vous n'avez pas encore de compte ? <a
													href="#" class="text-danger" id="log-reg-btn">Inscrivez-vous</a></p>
										</div>
									</div>
								</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Inscription</h4>
											<form action="" method="post">
												<div class="form-group">
													<input type="text" name="logname" class="form-style"
														placeholder="Nom d'utilisateur" id="logname" autocomplete="off"
														minlength="4">
													<i class="input-icon uil uil-user"></i>
												</div>
												<div class="form-group">
													<input type="email" name="logemail" class="form-style"
														placeholder="Email" id="logemail2" autocomplete="off">
													<i class="input-icon uil uil-at"></i>
												</div>
												<div class="form-group">
													<input type="password" name="logpass" class="form-style"
														placeholder="Mot de passe" id="logpass2"
														autocomplete="new-password" minlength="4">
													<i class="input-icon uil uil-lock-alt"></i>
												</div>
												<div class="form-group">
													<button type="submit" name="inscription"
														class="btn mt-4">Inscription</button>
												</div>
											</form>
											<p class="mb-0 mt-4 text-center">Vous avez déjà un compte ? <a href="#"
													class="text-danger" id="reg-log-btn">Connectez-vous</a></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js'></script>
	<script src="paillettesouris.js"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/three.js/101/three.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.7.5/dat.gui.min.js'></script>
	<script type="module" src="paillettesouris.js"></script>

</body>

</html>