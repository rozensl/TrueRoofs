<?php
	session_start(); 
	// echo "<pre>";
	// print_r($_SESSION);
	// exit();
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<!--Meta tag info-->
		<meta charset="UTF-8">
		<meta name="description" content="User Registeration">
		<meta name="keywords" content="4WW3">
		<meta name="author" content="Abeer Al Yasiri">
		<!--To make the view fit to screen of the device-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>User Registeration</title>
		<!--styling to the main page-->
		<!-- <link href="4WW3_project/assets/css/header_footer.css" rel="stylesheet"/> -->
		<!-- <link href="4WW3_project/assets/css/userRegisteration.css" rel="stylesheet"/> -->
		<link href="4WW3_project/assets/css/header_footer.css" rel="stylesheet"/>
		<link href="4WW3_project/assets/css/userRegisteration.css" rel="stylesheet"/>
		<!--load icon library for search bar-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
		<!-- js script for registration -->
		<script type="text/javascript" src="4WW3_project/assets/js/registration.js"></script>
	</head>
	<body>
		<!-- include header -->
		<!--same comments on the indext/html for nav bar-->
		<?php
			include "4WW3_project/assets/php/header.php";
			
			// check if the person is logged in
			if (!isset($_SESSION['validlogin']) && !($_SESSION['validlogin'] == true)) {
		?>
		<!--title section on the webpage with background-image-->
		<div class="title" style="background-image: linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),url('assets/images/buildings.png'); background-position: bottom;">
			<h2><u>User Registration</u></h2>
		</div> 
		<!--4 different HTML form elements text box, checkbox/radio item, email, search, date, password-->
		<!--beginning of the registration login part similar to the registration.html but the difference is the here we are signing in and have more input fields-->
		<!--comments here are the same as registration.html section of registration-->
		<div class="registration">
			<form class="reg-form" id="reg-signin" onsubmit="return validateSignIn(this)" action="4WW3_project/assets/php/signinAdd.php" method="POST">
				<div class="reg-type">
					<p>Sign In</p>
				</div>
				<div class="message">
					<p>Create New Account!</p>
					<?php
					if(isset($_SESSION['status_message'])){
						if(!empty($_SESSION['status_message'])){
							$msg = '';
							if($_SESSION['status_message'] == 'invalid'){
								$msg = "Invalid credentials.";
								$_SESSION['status_message'] = '';
							}
							if($_SESSION['status_message'] == 'empty'){
								$msg = "fill the fields";
								$_SESSION['status_message'] = '';
							}
							if($_SESSION['status_message'] == 'wrong'){
								$msg = "Failed submisssion please try again.";
								$_SESSION['status_message'] = '';
							}
							if($_SESSION['status_message'] == 'exist'){
								$msg = "Username already exists, please try another username.";
								$_SESSION['status_message'] = '';
							}
							echo '<p style="background-color: Tomato;">'.$msg.'</p>';
						}
					}
				?>
				</div>
				<div class="title-label">
					<label for="username">Username</label>
				</div>
				<div class="field-input">
					<input type="text" id="username" name="username" placeholder="username" required>
				</div>
				<div class="title-label">
					<label for="email">Email</label>
				</div>
				<div class="field-input">
					<input type="text" id="email" name="email" placeholder="email" required>
				</div>
				<div class="title-label">
					<label for="password">Password</label>
				</div>
				<div class="field-input">
					<input type="password" id="password" name="password" placeholder="password" required>
				</div>
				<div class="title-label">
					<label>Looking to</label>
				</div>
				<div class="field-input">
					<input type="radio" id="buying" name="reason" value="buy">
					<label for="buying">buy</label>
					<input type="radio" id="renting" name="reason" value="rent">
					<label for="renting">rent</label>
					<input type="radio" id="browsing" name="reason" value="browse">
					<label for="browsing">browse</label>
				</div>
				
				
				<div class="submit-button">
					<input type="submit" name="signinClick" value="Sign In"> <!-- onclick="location.href = 'profile.html';"> -->
				</div>
				<div class="switch-type">
					<a href="userRegistration.php">Already have an account? Log in!</a>
				</div>
			</form>
		</div>
		
		<!--include the footer of the webpage-->
		<?php
			} else {
				echo "
				<div class='registration'>
					<h3 class='reg-form'>You are already logged in as ". $_SESSION['userfullname'] . ". Navigate to <a href='profile.php'>Profile</a> to logout.</h3>
				</div>";
			}
			include "4WW3_project/assets/php/footer.php";
		?>
		
		<!-- animation for the title of the page - lettering of the title in a loop -->
		<script type="text/javascript">
			// Wrap every letter in a span to make it easier to animate each letter alone
			var textWrapper = document.querySelector('.logo');
			textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

			anime.timeline({loop: true})
			  .add({
				targets: '.logo .letter',
				opacity: [0,1],
				easing: "easeInOutQuad",
				duration: 2250,
				delay: (el, i) => 150 * (i+1)
			  }).add({
				targets: '.logo',
				opacity: 0,
				duration: 1000,
				easing: "easeOutExpo",
				delay: 2000
			  });
		</script>
	</body>
</html>
