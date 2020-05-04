<?php
	include 'db/config.php';
	include 'classes/Answers.php';
	include 'classes/Question.php';
	include 'classes/Questionlist.php';
	include 'classes/User.php';

	session_start();
	if (isset($_SESSION['user']) && isset($_SESSION['answers']) && isset($_SESSION['questionlist'])) {
		$user = $_SESSION['user'];
		$answers = $_SESSION['answers'];
		$questionlist = $_SESSION['questionlist'];
	} else {
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
		<a href="logintemp.php">Go to login temp</a>
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
			<h1>Vragen + Antwoorden</h1>
			<?php
				$progress = "";
				if (count($answers->getAnswers()) == count($questionlist->getQuestionlist())) {
					$progress = "List has been completed.";
				} else if (count($answers->getAnswers()) < count($questionlist->getQuestionlist())) {
					$progress = "Er zijn nog vragen onbeantwoordt. Er zijn er (" . count($answers->getAnswers()) . " / " . count($questionlist->getQuestionlist()) . ") ingevuld.";
				} else {
					$progress = "You've broke it.";
				}
			?>
			<p><?php echo $progress; ?></p>

			<?php
				$nextQuestion = "";
				$getNext = count($answers->getAnswers());
				$nextQuestion = $questionlist->getQuestion($getNext);

				$text = "";
				if ($user->getLanguage() == "NL") {
					$text = $nextQuestion->getTextNL();
				} elseif ($user->getLanguage() == "EN") {
					$text = $nextQuestion->getTextEN();
				} else {
					$text = "Error";
				}
			?>			
			<p><?php echo "De volgende vraag die beantwoord moet worden is: " . $text . " | " . $nextQuestion->getCategory(); ?></p>
		</div>

		<div class="container">
			<table class="table table-striped">
				<?php
					for ($i=0; $i < count($questionlist->getQuestionlist()); $i++) {
						echo "<tr>";
							echo "<th>" . ($i + 1) . " " . ($user->getLanguage() == "NL" ? $questionlist->getQuestion($i)->getTextNL() : $questionlist->getQuestion($i)->getTextEN()) . "</th>";
							
							if ($questionlist->getQuestion($i)->getCategory() == "Fysiek") {
								echo "<th class='category-purple'>" . $questionlist->getQuestion($i)->getCategory() . "</th>";
							} elseif ($questionlist->getQuestion($i)->getCategory() == "Emotioneel") {
								echo "<th class='category-red'>" . $questionlist->getQuestion($i)->getCategory() . "</th>";
							}  elseif ($questionlist->getQuestion($i)->getCategory() == "Mentaal") {
								echo "<th class='category-blue'>" . $questionlist->getQuestion($i)->getCategory() . "</th>";
							}  elseif ($questionlist->getQuestion($i)->getCategory() == "Spiritueel") {
								echo "<th class='category-yellow'>" . $questionlist->getQuestion($i)->getCategory() . "</th>";
							} else {
								echo "<th>" . $questionlist->getQuestion($i)->getCategory() . "</th>";
							}

							echo "<td>" . ($answers->getAnswer($i) == 0 ? "" : $answers->getAnswerToText($i)) . "</td>";
						echo "</tr>";
					}
				?>
			</table>
		</div>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	  </body>
</html>