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

	// On form submit
	if(isset($_POST['submitLogin'])){
		// Get fields
		$email = $_POST['email'];
		$password = $_POST['password'];

		// If validate function returns an error.
		if (validate($email, $password) != 0) {
			$error = "The fields weren't correctly filled in.";
		} else {
			// Request from db
			if (checkDB($email, $password) == 1) {
				// Insert into the user model.
				$tempuser = fetchUserDB($email, $password, $language);
				$tempuseranswers = fetchUserAnswersDB($email, $password);
				$questionlist = fetchQuestionlistDB($tempuser->getQuestionListID());

				// Set session
				$_SESSION['user'] = $tempuser;
				$_SESSION['answers'] = $tempuseranswers;
				$_SESSION['questionlist'] = $questionlist;

				// Navigate to next page
				exit(header("Location:home.php"));
			} else {
				$error = "User credentials are Incorrect.";
			}
		}
	}   

	// Check if the data which is inserted is incorrect.
	// Incorrect email. The email which is inserted isn't formatted properly.
	// No input in the password field.
	// Return if an error has been detected.
	function validate($email, $password) {
		$errorDetection = 0;

	 	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	 		$errorDetection++;
		}
		if (empty($password)) {
			$errorDetection++;
		}

		return $errorDetection; 
	} 

	// Check if a result exist.
	// Return the amount of found results (1 of 0)
	function checkDB($email, $password) {
		include 'db/config.php';

		$query = "SELECT * FROM `tempuser` WHERE `Email` = '{$email}' AND `Password` = '{$password}'";
		if ($result = mysqli_query($mysqli, $query)) {
		    $rowcount = mysqli_num_rows($result);
		}

		return $rowcount;
	}

	// Get all the data from the requested user.
	// Put the data in a model
	function fetchUserDB($email, $password, $language) {
		include 'db/config.php';

		$tempuser = new User();

		$query = "SELECT * FROM `tempuser` WHERE `Email` = '{$email}' AND `Password` = '{$password}'";
		if ($result = mysqli_query($mysqli, $query)) {
		    while ($row = mysqli_fetch_assoc($result)) {
		        $tempuser->setName($row["Name"]);
		        $tempuser->setEmail($row["Email"]);
				$tempuser->setProfession($row["Profession"]);
				$tempuser->setGender($row["Gender"]);
				$tempuser->setQuestionListID($row["QLID"]);
				$tempuser->setAge($row["Age"]);
				$tempuser->setPassword($row["Password"]);
				$tempuser->setLanguage($language);
		    }
		}

		return $tempuser;
	}

	// Get all the data from the requested user.
	// Put the data in a model
	function fetchUserAnswersDB($email, $password) {
		include 'db/config.php';

		$tempuseranswers = new Answers();

		$query = "SELECT * FROM `tempuser` WHERE `Email` = '{$email}' AND `Password` = '{$password}'";
		if ($result = mysqli_query($mysqli, $query)) {
		    while ($row = mysqli_fetch_assoc($result)) {
		    	$tempuseranswers->setQuestionListID($row["QLID"]);
				$tempuseranswers->setAnswers($row["AnswerJSON"]);
		    }
		}

		return $tempuseranswers;
	}

	// Get all the data from the requested user.
	// Put the data in a model
	function fetchQuestionlistDB($questionListID) {
		include 'db/config.php';

		$questionlist = new Questionlist();

		$query = "SELECT * FROM question q LEFT JOIN category c ON c.CATID = q.CATID WHERE q.QLID = '{$questionListID}'";

		$list = array();
		if ($result = mysqli_query($mysqli, $query)) {
			
		    while ($row = mysqli_fetch_assoc($result)) {
		    	$question = new Question();
		    	$question->setTextNL($row["QTNL"]);
		    	$question->setTextEN($row["QTEN"]);
		    	$question->setCategory($row["Name"]);
		    	array_push($list, $question);
		    }
		}

		$questionlist->setQuestionlist($list);

		return $questionlist;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
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
		<hr>

		<div class="jumbotron text-center">
			<h1>Login</h1>
		</div>

		<div class="container">
			<?php echo "<p class='red'>" . $error . "</p>"; ?>

			<form action="#" method="POST">
				<div class="form-row">
    				<div class="form-group col-md-12">
    					<label for="inputEmail">Email</label>
						<input class="form-control" type="text" id="inputEmail" name="email" placeholder="test@mail.com" value="test@test.nl" required>
					</div>
					<div class="form-group col-md-12">
    					<label for="inputPassword">Password</label>
						<input class="form-control" type="password" id="inputPassword" name="password" placeholder="*******" value="dsagf43qvdchg4" required>
					</div>
					<div class="form-group col-md-12">
						<input class="form-control btn btn-primary mb-2" type="submit" name="submitLogin" value="Login">
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