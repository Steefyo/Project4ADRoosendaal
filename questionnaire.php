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

	// Set answers from database
	$answersForm = $answers->getAnswers();


	$error = "";
	if(isset($_POST['submitForm'])){

		// Override the new answers onto the old answers.
		for ($i=0; $i < count($questionlist->getQuestionlist()); $i++) { 
			$question = $questionlist->getQuestionlist()[$i];
			$id = $question->getID();
			if (empty($_POST["question_" . $id])) {
			    $error = $error . "Question $id is required.<br>";
			    $answersForm[$i] = 0;
			} else {
			    $answersForm[$i] = (int)test_input($_POST["question_" . $id]);
			}
		}

		// No Errors
		//if ($error == "") {
			saveAnswers(json_encode($answersForm), $user->getEmail());
			$answers->setAnswers($answersForm);
			exit(header("Location:result.php"));
		//}

	}

	// Check inserted data
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function saveAnswers($answers, $email) {
		include 'db/config.php';

		$stmt = $pdo->prepare("UPDATE `tempuser` SET `AnswerJSON`= :answers WHERE `Email` = :email");

		$stmt->bindParam(':answers', $answers);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Questionnaire</title>
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
		  <h1><?php echo ($user->getLanguage() == "NL" ? "Vragenlijst" : "Questionnaire"); ?></h1>
		</div>

		<?php 
			if ($error) {
				echo "<div class='jumbotron text-center'>";
					echo "<p>" . $error . "</p>";
				echo "</div>";
			}
		?>

		<div class="container">

			<form action="#" method="POST">
				<?php
					foreach ($questionlist->getQuestionlist() as $question) {

						echo "<div class='form-row'>";
							echo "<div class='col-12'>";
								echo "<label>" . ($user->getLanguage() == "NL" ? $question->getTextNL() : $question->getTextEN()) . "</label>";
							echo "</div>";
						echo "</div>";

						echo "<div class='form-row'>";

							echo "<div class='col-1'>";
								if ((isset($answersForm[$question->getID()-1])) && ($answersForm[$question->getID()-1] == 1)){
									echo "<input type='radio' name='question_" . $question->getID() . "' value='1' checked>";
								} else {
									echo "<input type='radio' name='question_" . $question->getID() . "' value='1'>";
								}
							echo "</div>";

							echo "<div class='col-1'>";
								if ((isset($answersForm[$question->getID()-1])) && ($answersForm[$question->getID()-1] == 2)){
									echo "<input type='radio' name='question_" . $question->getID() . "' value='2' checked>";
								} else {
									echo "<input type='radio' name='question_" . $question->getID() . "' value='2'>";
								}
							echo "</div>";

							echo "<div class='col-1'>";
								if ((isset($answersForm[$question->getID()-1])) && ($answersForm[$question->getID()-1] == 3)){
									echo "<input type='radio' name='question_" . $question->getID() . "' value='3' checked>";
								} else {
									echo "<input type='radio' name='question_" . $question->getID() . "' value='3'>";
								}
							echo "</div>";

							echo "<div class='col-1'>";
								if ((isset($answersForm[$question->getID()-1])) && ($answersForm[$question->getID()-1] == 4)){
									echo "<input type='radio' name='question_" . $question->getID() . "' value='4' checked>";
								} else {
									echo "<input type='radio' name='question_" . $question->getID() . "' value='4'>";
								}
							echo "</div>";

							echo "<div class='col-1'>";
								if ((isset($answersForm[$question->getID()-1])) && ($answersForm[$question->getID()-1] == 5)){
									echo "<input type='radio' name='question_" . $question->getID() . "' value='5' checked>";
								} else {
									echo "<input type='radio' name='question_" . $question->getID() . "' value='5'>";
								}
							echo "</div>";

						echo "</div>";

						echo "<hr>";
					}
				?>

				<div class="form-group col-md-12">
					<input class="form-control btn btn-primary mb-2" type="submit" name="submitForm" value="Vragenlijst afronden.">
				</div>
			</form>
		</div>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	  </body>
</html>