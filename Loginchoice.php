<?php

session_start();


	// Default variables
	$error = "";



?>

<!DOCTYPE html>
<html>
	<head>
		<title>Welkom</title>
		<!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	    <link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>
		<hr>
		<img class="img-responsive" src="image/logo.png" alt="Logo">
		<br>
		<hr>

		<div class="jumbotron text-center">
			<h1>Welkom</h1>
		</div>

		<div class="container">
			<?php echo "<p class='red'>" . $error . "</p>"; ?>

			<form action="#" method="POST">
				<div class="form-row">
					<div class="form-group col-12 align-self-center">
						
						<p>Bent u een terugkerende gebruiker, klik hier. / If you are a returning user, click here.</p>
					</div>
    				<div class="form-group col-12">
    					<label for="ReturningUser">Returning User</label>
						<a class="form-control btn btn-primary mb-2" type="submit" name="submitLogin" value="ReturningUser">
						</a>
					</div>
					<div class="form-group col-12 align-self-center">
						<p>Bent u een nieuwe gebruiker, klik hier. / If you are a new user, click here.</p>
					</div>
					<div class="form-group col-12">
    					<label for="NewUser">New User</label>
						<a href="Premiumchoice.php" class="form-control btn btn-primary mb-2" type="submit" name="submitLogin" value="NewUser">
						</a>
					</div>
						
					</div>
				</div>
			</form>
		</div>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	  </body>
</html>