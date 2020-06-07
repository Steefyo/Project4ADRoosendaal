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

		// Calculate the current fase
		$currentCategoryID = getCurrentFase($questionlist, $answers);
	} else {
		// Back to the login page
		header("Location:logintemp.php");
	}

	// Set answers from database
	$answersForm = $answers->getAnswers();

	// Check form submit
	if(isset($_POST['submitForm'])){
		$answersForm = saveAnswers($questionlist,$user, $answers);
		exit(header("Location:result.php"));
	}
	if(isset($_POST['nextCategory'])){
		$answersForm = saveAnswers($questionlist,$user, $answers);
		exit(header("Location:questionnaire.php"));
	}

	// Check inserted data
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function saveAnswers($questionlist, $user, $answers) {
		// Override the new answers onto the old answers.
		$answersForm = $answers->getAnswers();
		$countFysiek = $questionlist->getCountEachCategory("Fysiek");
		$countEmotioneel = $questionlist->getCountEachCategory("Emotioneel");
		$countMentaal = $questionlist->getCountEachCategory("Mentaal");

		// Calculate the current fase for saving the correct values
		if (getCurrentFase($questionlist, $answers) == "Fysiek") {
			$answerFilledCount = 0;
		} elseif (getCurrentFase($questionlist, $answers) == "Emotioneel") {
			$answerFilledCount = $countFysiek;
		} elseif (getCurrentFase($questionlist, $answers) == "Mentaal") {
			$answerFilledCount = $countFysiek + $countEmotioneel;
		} elseif (getCurrentFase($questionlist, $answers) == "Spiritueel") {
			$answerFilledCount = $countFysiek + $countEmotioneel + $countMentaal;
		}

		// Insert new answers in the array
		for ($i=$answerFilledCount; $i < count($questionlist->getQuestionlist()); $i++) { 
			$question = $questionlist->getQuestionlist()[$i];
			$id = $question->getID();
			if (empty($_POST["question_" . $id])) {
				$answersForm[$i] = 0;
			} else {
			    $answersForm[$i] = (int)test_input($_POST["question_" . $id]);
			}
		}

		// TODO: Need a form completion check

		saveAnswersDB(json_encode($answersForm), $user->getEmail());
		$answers->setAnswers($answersForm);
		return $answers;
	}

	function saveAnswersDB($answers, $email) {
		include 'db/config.php';
		$stmt = $pdo->prepare("UPDATE `tempuser` SET `AnswerJSON`= :answers WHERE `Email` = :email");
		$stmt->bindParam(':answers', $answers);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
	}

	function getCurrentFase($questionlist, $answers) {
		$countFysiek = $questionlist->getCountEachCategory("Fysiek");
		$countEmotioneel = $questionlist->getCountEachCategory("Emotioneel");
		$countMentaal = $questionlist->getCountEachCategory("Mentaal");
		$countSpiritueel = $questionlist->getCountEachCategory("Spiritueel");
		$countFilledInAnswers = count(array_filter($answers->getAnswers()));

		if ($countFilledInAnswers < $countFysiek) {
			return "Fysiek";
		} elseif ($countFilledInAnswers < ($countFysiek + $countEmotioneel)) {
			return "Emotioneel";
		} elseif ($countFilledInAnswers < ($countFysiek + $countEmotioneel + $countMentaal)) {
			return "Mentaal";
		} elseif ($countFilledInAnswers <= ($countFysiek + $countEmotioneel + $countMentaal + $countSpiritueel)) {
			return "Spiritueel";
		}
	}

	function getCurrentFaseDiv($questionlist, $answers) {
		$currentFase = getCurrentFase($questionlist, $answers);
		if ($currentFase == "Fysiek") {
			return "<div class='jumbotron text-center category-purple-bg'><h1>". $currentFase . "</h1></div>";
		} elseif ($currentFase == "Emotioneel") {
			return "<div class='jumbotron text-center category-red-bg'><h1>". $currentFase . "</h1></div>";
		} elseif ($currentFase == "Mentaal") {
			return "<div class='jumbotron text-center category-blue-bg'><h1>". $currentFase . "</h1></div>";
		} elseif ($currentFase == "Spiritueel") {
			return "<div class='jumbotron text-center category-yellow-bg' style='color:#204D73;'><h1>". $currentFase . "</h1></div>";
		}
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
	<div class="container-fluid">
			<div class="row vr">
				<div class="my-auto col-xl-9">	
				<div id="headleft">
				<img src="image/logo.png" alt="" class="img-fluid" onclick="location.href='index.php';">
				</div></div>

				<div class="my-auto col-4 col-xl-1" onclick="location.href='index.php';">
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



		<?php 
			//echo getCurrentFaseDiv($questionlist, $answers);
		?>

		<div class="container">
			<form action="#" method="POST">
				<?php
					// Automaticly fill in the existing values from last time.
					foreach ($questionlist->getQuestionCategory($currentCategoryID) as $question) {

						$questionId = $question->getID();
						$questionAnswer = $answersForm[$question->getID()-1];

						echo "<div class='form-row'>";
							echo "<div class='col-12'>";
								echo "<label>" . $questionId . " " . ($user->getLanguage() == "NL" ? $question->getTextNL() : $question->getTextEN()) . "</label>";
							echo "</div>";
						echo "</div>";

						echo "<div class='form-row'>";

							echo "<div class='col-lg-auto col-md-12 col-sm-12'>";
								if ((isset($questionAnswer)) && ($questionAnswer == 1)){
									echo "<input type='radio' name='question_" . $questionId . "' value='1' checked onchange='Change(this);'>";
								} else {
									echo "<input type='radio' name='question_" . $questionId . "' value='1' onchange='Change(this);'>";
								}
								echo "Helemaal niet mee eens";
							echo "</div>";

							echo "<div class='col-lg-auto col-md-12 col-sm-12'>";
								if ((isset($questionAnswer)) && ($questionAnswer == 2)){
									echo "<input type='radio' name='question_" . $questionId . "' value='2' checked onchange='Change(this);'>";
								} else {
									echo "<input type='radio' name='question_" . $questionId . "' value='2' onchange='Change(this);'>";
								}
								echo "Enigszins niet mee eens";
							echo "</div>";

							echo "<div class='col-lg-auto col-md-12 col-sm-12'>";
								if ((isset($questionAnswer)) && ($questionAnswer == 3)){
									echo "<input type='radio' name='question_" . $questionId . "' value='3' checked onchange='Change(this);'>";
								} else {
									echo "<input type='radio' name='question_" . $questionId . "' value='3' onchange='Change(this);'>";
								}
								echo "Neutraal";
							echo "</div>";

							echo "<div class='col-lg-auto col-md-12 col-sm-12'>";
								if ((isset($questionAnswer)) && ($questionAnswer == 4)){
									echo "<input type='radio' name='question_" . $questionId . "' value='4' checked onchange='Change(this);'>";
								} else {
									echo "<input type='radio' name='question_" . $questionId . "' value='4' onchange='Change(this);'>";
								}
								echo "Enigszins mee eens";
							echo "</div>";

							echo "<div class='col-lg-auto col-md-12 col-sm-12'>";
								if ((isset($questionAnswer)) && ($questionAnswer == 5)){
									echo "<input type='radio' name='question_" . $questionId . "' value='5' checked onchange='Change(this);'>";
								} else {
									echo "<input type='radio' name='question_" . $questionId . "' value='5' onchange='Change(this);'>";
								}
								echo "Helemaal mee eens";
							echo "</div>";

						echo "</div>";

						echo "<hr>";
					}

					// Calculate the button the user needs to see
					echo "<div class='form-group col-md-12'>";
						if (getCurrentFase($questionlist, $answers) == "Spiritueel") {
							echo "<input class='form-control btn btn-primary mb-2' type='submit' name='submitForm' value='Vragenlijst afronden.'>";
						} else {
							echo "<input class='form-control btn btn-primary mb-2' type='submit' name='nextCategory' value='Volgende category.'>";
						}
					echo "</div>";
				?>
			</form>
		</div>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	    <script type="text/javascript">

	    	var answerArray = <?php echo json_encode($answers->getAnswers()); ?>;

	        function Change(radio) {   
	            if(radio.value) {
	                radiovalue = radio.value;
	                questionNameInArray = radio.name.replace('question_', '') - 1;

	                answerArray[questionNameInArray] = radiovalue;
	                sessionStorage["answersTemp"] = answerArray;

	                <?php
	                	//$answers->setAnswers($_SESSION['answersTemp']);
	                	//saveAnswers($questionlist, $user, $answers);
	                ?>
	            }
	        }
	    </script>
	  </body>
</html>