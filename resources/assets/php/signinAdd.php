<?php 
	session_start(); 
	
	// connection
	include 'pdoConnect.php';
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['signinClick'])) {
			if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
				if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) {
					$enteredUsername = $_POST['username'];
					$enteredPassword = $_POST['password'];
					$enteredEmail = $_POST['email'];
					
					if (isset($_POST['reason'])) {
						$enteredInterest = $_POST['reason'];
					} else { $enteredInterest = NULL; }
					
					// get users of same username
					$query = "SELECT * FROM user WHERE userName = :username";
					$stmt = $pdo->prepare($query);
					$stmt-> bindParam(':username', $enteredUsername);
					$stmt->execute();
					
					// check if user exits
					if ($stmt->rowCount() != 0) {
						$_SESSION['status_message'] = 'exist';
						$url = "http://3.130.249.183/signin.php";
						header('location: ' . $url);
					} else { //if user does not exit then insert into database
						$queryi = "INSERT INTO user (userName, password, email, interest) 
							VALUES (:username, :pass, :email, :interest)"; 
						$add = $pdo->prepare($queryi);
						$add->bindParam(':username', $enteredUsername);
						$add->bindParam(':pass', $enteredPassword);
						$add->bindParam(':email', $enteredEmail);
						$add->bindParam(':interest', $enteredInterest);
						
						// user is added 
						if ($add->execute() === TRUE) {
							// set the session parameters 
							$querys = "SELECT * FROM user WHERE userName = :username";
							$stmt2 = $pdo->prepare($querys);
							$stmt2-> bindParam(':username', $enteredUsername);
							$stmt2->execute();
							if ($stmt2->rowCount() != 0) {
								$record = $stmt2->fetch(PDO::FETCH_ASSOC);
								$_SESSION['userfullname'] = $enteredUsername;
								$_SESSION['userid'] = $record['userID'];
								$_SESSION['useremail'] = $record['email'];
								$_SESSION['userinterest'] = $record['interest'];
								$_SESSION['validlogin'] = true;
								
								//once we are logged in display the profile
								$url = "http://3.130.249.183/profile.php";
								header('location: ' . $url);
							} else {
								echo "session can't be set";
							}
							$pdo = null; // close the connection
						} else {
							echo "ERROR WITH adding user". $queryi . "<br/>" . $pdo->error;
							$pdo = null; // close the connection
						}
					}
					
				} else {
					//echo 'invalid_request please fill the fields';
					$_SESSION['status_message'] = 'empty';
					$url = "http://3.130.249.183/userRegistration.php";
					header('Location: ' . $url);
				}
			} else {
				//echo 'invalid_request please fill the fields';
				$_SESSION['status_message'] = 'empty';
				$url = "http://3.130.249.183/userRegistration.php";
				header('Location: ' . $url);
			}
		} else {
			//echo 'invalid_request';
			$_SESSION['status_message'] = 'wrong';
			$url = "http://3.130.249.183/userRegistration.php";
			header('Location: ' . $url);
		}
	} else {
		//echo 'invalid_request';
		$_SESSION['status_message'] = 'wrong';
		$url = "http://3.130.249.183/userRegistration.php";
		header('Location: ' . $url);
	}
?>