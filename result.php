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

	function calculatePercent($category, $answers, $questionlist) {
		$countFysiek = $questionlist->getCountEachCategory("Fysiek");
		$countEmotioneel = $questionlist->getCountEachCategory("Emotioneel");
		$countMentaal = $questionlist->getCountEachCategory("Mentaal");
		$countSpiritueel = $questionlist->getCountEachCategory("Spiritueel");
		if ($category == "Fysiek") {
			$baseValue = 0;
			$tillValue = $countFysiek;
		} elseif ($category == "Emotioneel") {
			$baseValue = $countFysiek;
			$tillValue = $countEmotioneel;
		} elseif ($category == "Mentaal") {
			$baseValue = $countFysiek + $countEmotioneel;
			$tillValue = $countMentaal;
		} elseif ($category == "Spiritueel") {
			$baseValue = $countFysiek + $countEmotioneel + $countMentaal;
			$tillValue = $countSpiritueel;
		}

		$givenAnswers = array_slice($answers->getAnswers(), $baseValue, $tillValue);
		$givenAnswerTotal = 0;
		foreach ($givenAnswers as $givenAnswer) {
			$givenAnswerTotal += $givenAnswer;
		}

		$percent = ($givenAnswerTotal / (count($givenAnswers) * 5)) * 100;

		return $percent;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Result</title>
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
		  <h1>Resultaten</h1>
		</div>

		<div class="jumbotron text-center">
		  <h1>
		  	<?php
		  		echo "Fysiek " . calculatePercent("Fysiek", $answers, $questionlist) . "%";
		  		echo "<br>";

		  		echo "Emotioneel " . calculatePercent("Emotioneel", $answers, $questionlist). "%";
		  		echo "<br>";

		  		echo "Mentaal " . calculatePercent("Mentaal", $answers, $questionlist). "%";
		  		echo "<br>";

		  		echo "Spiritueel " . calculatePercent("Spiritueel", $answers, $questionlist). "%";
		  	?>
		  </h1>
		</div>

		<div class="container">
	        <div class="card-body">
	            <canvas id="chLine"></canvas>
	        </div>
		</div>

		<div class="jumbotron text-center">
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

	    <script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>

	    <script type="text/javascript">
	 		var color = '#204D73';
			var chLine = document.getElementById("chLine");
			var chartData = {
				labels: ["Fysiek", "Emotioneel", "Mentaal", "Spiritueel"],
				datasets: [{
					data: [
						<?php echo calculatePercent("Fysiek", $answers, $questionlist); ?>, 
						<?php echo calculatePercent("Emotioneel", $answers, $questionlist); ?>, 
						<?php echo calculatePercent("Mentaal", $answers, $questionlist); ?>, 
						<?php echo calculatePercent("Spiritueel", $answers, $questionlist); ?>
					],
					borderColor: color,
					borderWidth: 0,
					pointBackgroundColor: color
				}]
			};

			if (chLine) {
				new Chart(chLine, {
					type: 'radar',
					data: chartData,
					options: {
						legend: {
  							display: false
						},
						scale: {
					        angleLines: {
					            display: false
					        },
					        ticks: {
					            suggestedMin: 0,
					            suggestedMax: 100
					        }
					    }
					}
				});
			}
	    </script>
	  </body>
</html>