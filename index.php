<?php

	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);

	include 'classes/Answers.php';
	include 'classes/Question.php';
	include 'classes/Questionlist.php';
	include 'classes/User.php';

	session_start();
	unset($_SESSION['user']);			// Reset user
	unset($_SESSION['answers']);		// Reset answers
	unset($_SESSION['questionlist']);	// Reset questionlist

	// Default variables
	$error = "";
	$tempuser = new User();
	$language = "NL";

	$tempuseranswers = new Answers();
	$questionlist = new Questionlist();

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
	<div class="container-fluid">
			<div class="row vr">
				<div class="my-auto col-xl-9">	
				<div id="headleft">
				<img src="image/logo.png" alt="" class="img-fluid" onclick="location.href='start.php';">
				</div></div>

				<div class="my-auto col-4 col-xl-1" onclick="location.href='start.php';">
				<br>
				<div id="headcenter">
				<p><strong>Home</strong><br><img src="image/minibar.png" alt="" class="img-fluid"></p>
				</div></div>

				<div class="my-auto col-4 col-xl-1" onclick="location.href='contact.php';">
				<div id="headcenter">
				<p><strong>Contact</strong></p>
				</div></div>

				<div class="my-auto col-4 col-xl-1" onclick="location.href='over.php';">	
				<div id="headcenter">
				<p><strong>Over</strong></p>
				</div></div>

			</div></div><hr>


		<div class="container">
			<?php echo "<p class='red'>" . $error . "</p>"; ?>

			<form action="#" method="POST">
				<div class="form-row">
					<div class="form-group col-12 align-self-center">
						
						<p>Welkom bij MyPro, maak hier uw taalkeuze voor de vragenlijst, indien Nederlands, kies de Nederlandse optie.
						<br>
						</p>
						<p>					
						Welcome to MyPro, make your choice as to which language u would like to use, in case of English, choose the English option.</p>
					</div>
    				<div class="form-group col-md-6">
						<img src="image/dutch.png" alt="" class="img-fluid" type="submit" name="EngLogin" value="English" onclick="location.href='start.php';">
						</a>
					</div>
					<div class="form-group col-6">
						<img src="image/english.png" alt="" class="img-fluid" type="submit" name="EngLogin" value="English" onclick="location.href='start.php';">
						</a>
					</div>
					</div>					</div>
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