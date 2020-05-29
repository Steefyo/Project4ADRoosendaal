<?php
// Include config file
include "db/config.php";
session_start();
 
// Define variables and initialize with empty values
$error = "";
$username = $password = $confirm_password = $email = $userage = $name = $profession = $gender = $language = "";
$username_err = $password_err = $confirm_password_err = $email_err = $userage_err = $name_err = $profession_err = $gender_err = $language_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT userid FROM user WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
    	$email_err = "Please enter an email.";
    } else {
    	$email = trim($_POST["email"]);
    }

    // Validate name
    if(empty(trim($_POST["name"]))){
    	$name_err = "Please enter a name.";
    } else {
    	$name = trim($_POST["name"]);

    // Validate profession
    if(empty(trim($_POST["profession"]))){
    	$profession_err = "Please enter a profession.";
    } else {
    	$profession = trim($_POST["profession"]);
    }

        // Validate gender
    if(empty(trim($_POST["gender"]))){
    	$gender_err = "Please enter an gender.";
    } else {
    	$gender = trim($_POST["gender"]);
    }

    }
    //Validate age
    if(empty(trim($_POST["userage"]))){
    	$userage_err = "Please enter your age.";
    }else{
    	$userage = trim($_POST["userage"]);
    }
    
    //Validate language
    $language =$_POST ['languagechoice'];
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($userage_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (Email, Age, Username, Name, Profession, Gender, Language, Password) VALUES (:email, :userage, :username, :name, :profession, :gender, :language, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":profession", $param_profession, PDO::PARAM_STR);
            $stmt->bindParam(":gender", $param_gender, PDO::PARAM_STR);
            $stmt->bindParam(":language", $param_language, PDO::PARAM_STR);                        
            $stmt->bindParam(":userage", $param_userage, PDO::PARAM_STR);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = $email;
            $param_name = $name;
            $param_profession = $profession;
            $param_gender = $gender;
            $param_language = $language;
            $param_userage = $userage;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo "Account has been created";
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    
    // Close connection
    unset($pdo);
}
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
			<h1>Welcome</h1>
		</div>

		<div class="container">
			<?php echo "<p class='red'>" . $error . "</p>"; ?>

		<!-- <form action="Accountcreation.php" style="border:1px solid #ccc"> -->
 	<div class="container">
   		<h1>Sign Up</h1>
    	<p>Please fill in this form to create an account.</p>
    	<hr>

    		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>                
            <div class="form-group <?php echo (!empty($profession_err)) ? 'has-error' : ''; ?>">
                <label>Profession</label>
                <input type="text" name="profession" class="form-control" value="<?php echo $profession; ?>">
                <span class="help-block"><?php echo $profession_err; ?></span>
            </div>              
            <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                <label>Gender</label>
                <input type="text" name="gender" class="form-control" value="<?php echo $gender; ?>">
                <span class="help-block"><?php echo $gender_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($userage_err)) ? 'has-error' : ''; ?>">
                <label>Age</label>
                <input type="text" name="userage" class="form-control" value="<?php echo $userage; ?>">
                <span class="help-block"><?php echo $userage_err; ?></span>
            </div>    
            <p>
				Language
					<select name="languagechoice">
 						<option value="">Select...</option>
  						<option  value="EN">English</option>
  						<option  value="NL">Dutch</option>
					</select>
			</p>	               
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>

    		<label>
      		<input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    		</label>

    			<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="logintemp.php">Login here</a>.</p>
        </form>
		</div>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	  </body>
</html>

