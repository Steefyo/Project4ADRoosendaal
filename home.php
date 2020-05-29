<?php
	// Import the nessasary files
	include 'db/config.php';
	include 'classes/Answers.php';
	include 'classes/Question.php';
	include 'classes/Questionlist.php';
	include 'classes/User.php';

	// Start the session logic
	session_start();

	// Check if instances exist
	if (isset($_SESSION['user']) && isset($_SESSION['answers']) && isset($_SESSION['questionlist'])) {
		// Set some default values with the session data
		$user = $_SESSION['user'];
		$answers = $_SESSION['answers'];
		$questionlist = $_SESSION['questionlist'];
	} else {
		// Back to the login page
		header("Location:logintemp.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Data</title>
		<!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	    <link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>
		<hr>
		<img class="img-responsive" src="image/logo.png" alt="Logo"><br>
		<a href="logintemp.php">Logout</a>
		<hr>

		<div class="jumbotron text-center">
		  <h1><?php echo $user->getName(); ?></h1>
		</div>

		<div class="container">
			<table class="table table-striped">
				<tr>
					<th>Email</th>
					<td><?php echo $user->getEmail(); ?></td>
				</tr>
				<tr>
					<th>Beroep</th>
					<td><?php echo $user->getProfession(); ?></td>
				</tr>
				<tr>
					<th>Geslacht</th>
					<td><?php echo $user->getGender(); ?></td>
				</tr>
				<tr>
					<th>Leeftijd</th>
					<td><?php echo $user->getAge(); ?></td>
				</tr>
			</table>
		</div>

		<div class="jumbotron text-center">
			<h1>
				<?php 
					echo ($user->getLanguage() == "NL" ? "Vragen + Antwoorden" : "Questions + Answers");
				?>
			</h1>
			<?php
				// Calculate a test progres value. 
				// Example ( completed / total amount )
				$countFilledInAnswers = count(array_filter($answers->getAnswers()));
				$progress = "";			
				if ($countFilledInAnswers == count($questionlist->getQuestionlist())) {
					if ($user->getLanguage() == "NL") {
						$progress = "De lijst is volledig ingevuld.";
					} else {
						$progress = "List has been completed.";
					}
				} else if ($countFilledInAnswers < count($questionlist->getQuestionlist())) {
					if ($user->getLanguage() == "NL") {
						$progress = "Er zijn nog vragen onbeantwoordt. Er zijn er (" . $countFilledInAnswers . " / " . count($questionlist->getQuestionlist()) . ") ingevuld.";
					} else {
						$progress = "Some questions are unanswered. You've completed (" . $countFilledInAnswers . " / " . count($questionlist->getQuestionlist()) . ").";
					}
				} else {
					if ($user->getLanguage() == "NL") {
						$progress = "De lijst is kapot.";
					} else {
						$progress = "You've broke it.";
					}
				}

				echo "<p>" . $progress . "</p>";

				// Calculate the next question.
				// Search in the array for the first result which is empty.
				// Display this question.
				if ($countFilledInAnswers < count($questionlist->getQuestionlist())) {
					$nextQuestion = "";
					$getNext = array_search(0, $answers->getAnswers());
					$nextQuestion = $questionlist->getQuestion($getNext);

					$text = "";
					if ($user->getLanguage() == "NL") {
						$text = $nextQuestion->getTextNL();
					} elseif ($user->getLanguage() == "EN") {
						$text = $nextQuestion->getTextEN();
					} else {
						$text = "Error";
					}

					echo "<p>De volgende vraag die beantwoord moet worden is: " . $text . " | " . $nextQuestion->getCategory() . "</p>";
				}
			?>
		</div>		

		<div class="container">
			<?php 
				if ($countFilledInAnswers < count($questionlist->getQuestionlist())) {	
					echo "<a href='questionnaire.php' class='btn btn-primary btn-lg btn-block' role='button'>" . ($user->getLanguage() == "NL" ? "Ga verder met de vragenlijst." : "Continue with the questionnaire.") . "</a>";
				} else {
					echo "<a href='result.php' class='btn btn-primary btn-lg btn-block' role='button'>" . ($user->getLanguage() == "NL" ? "Bekijk mijn resultaat." : "View my result.") . "</a>";
				}
			 ?>
		</div>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	  </body>
</html>