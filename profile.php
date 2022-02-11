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
		<meta name="description" content="Profile">
		<meta name="keywords" content="4WW3">
		<meta name="author" content="Abeer A-Y and Lin Rozenszajn">
		<!--To make the view fit to screen of the device-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Profile</title>
		<!--styling to the main page-->
		<link href="resources/assets/css/header_footer.css" rel="stylesheet"/>
		<link href="resources/assets/css/profile.css" rel="stylesheet"/>
		<!--load icon library for search bar-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
		<!-- Animation resource -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
	</head>
	<body>
		<!--include header-->
		<!--same comments on the indext/html for nav bar-->
		<?php
			include "resources/assets/php/header.php";
			
			// check if the person is logged in to display the page
			if (isset($_SESSION['validlogin']) && ($_SESSION['validlogin'] == true)) {
				// start displaying the page for the logged user
				$loggeduser = $_SESSION['userfullname'];
				$loggedemail = $_SESSION['useremail'];
				$loggedReason = $_SESSION['userinterest'];
				$loggedID = $_SESSION['userid'];
		?>	
		<!--title section on the webpage-->
		<div class="title">
			<h2><u>Profile</u></h2>
		</div> 
		<!--presenting the info of the logged in user, this is an example-->
		<!-- animation is added using the css animate library -->
		<div class="profile animate__animated animate__bounceIn">
			<img src="resources/assets/images/avatar.png" alt="Avatar profile icon">
			<h3><?php echo 'Welcome back, ' . $loggeduser . '!'; ?> </h3>
			<h3><?php echo "Looking for <i>".$loggedReason."</i>!"; ?></h3>
			<button><a href="resources/assets/php/logout.php">Log out</button>
		</div>
		
	<!--include the footer of the webpage-->
	<?php
			} else {
				echo "<div class='profile'>
						<img src=\"4WW3_project/assets/images/avatar-1x.png\" alt=\"profile-avatar\">
						<h3>Please log in or sign in to see profile.</h3>
					</div>";
			}
		include "4WW3_project/assets/php/footer.php";
	?>
	</body>
</html>
