<?php
	session_start(); 
	
	// connection
	include 'pdoConnect.php';
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['logInClick'])) {
			if (isset($_POST['username']) && isset($_POST['password'])) {
				if (!empty($_POST['username']) && !empty($_POST['password'])) {
					$enteredUsername = $_POST['username'];
					$enteredPassword = $_POST['password'];
					
					// get user info
					$query = "SELECT * FROM user WHERE userName = :username AND password = :pass";
					$stmt = $pdo->prepare($query);
					$stmt-> bindParam(':username', $enteredUsername);
					$stmt-> bindParam(':pass', $enteredPassword);
					$stmt->execute();
					
					if ($stmt->rowCount() != 0) {
						$record = $stmt->fetch(PDO::FETCH_ASSOC);
						$_SESSION['userfullname'] = $enteredUsername;
						$_SESSION['userid'] = $record['userID'];
						$_SESSION['useremail'] = $record['email'];
						$_SESSION['userinterest'] = $record['interest'];
						$_SESSION['validlogin'] = true;
						
						$pdo = null; // close the connection
						
						// check rememberme and set cookies
						$lblrememberme = '0';
						if (isset($_POST['rem'])){
							if (!empty($_POST['rem'])){
								setcookie('rememberme', '1', time() + (86400 * 30), "/"); // 86400 = 1 day
								setcookie('uname', $_POST['username'], time() + (86400 * 30), "/");
							} else {
								setcookie('rememberme', null, -1, '/');
								setcookie('uname', null, -1, '/');
							}
						} else {
							setcookie('rememberme', null, -1, '/');
							setcookie('uname', null, -1, '/');
						}
						
						//once we are logged in display the profile
						$url = "http://3.130.249.183/profile.php";
						header('location: ' . $url);
					} else { // error messages 
						$_SESSION['status_message'] = 'invalid';
						$url = "http://3.130.249.183/userRegistration.php";
						header('location: ' . $url);
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