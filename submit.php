<?php
	// begin the session to access the variables 
	session_start(); 
	// echo "<pre>";
	// print_r($_SESSION);
	// exit();
	// connection
	include '4WW3_project/assets/php/pdoConnect.php';
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<!--Meta tag info-->
		<meta charset="UTF-8">
		<meta name="description" content="Submit Review">
		<meta name="keywords" content="4WW3">
		<meta name="author" content="Abeer A-Y and Lin Rozenszajn">
		<!--To make the view fit to screen of the device-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Submit Page</title>
		<!--styling to the main page-->
		<!-- <link href="assets/css/header_footer.css" rel="stylesheet"/> -->
		<!-- <link type="text/css" href="assets/css/submit.css" rel="stylesheet"/> -->
		<link href="4WW3_project/assets/css/header_footer.css" rel="stylesheet"/>
		<link type="text/css" href="4WW3_project/assets/css/submit.css" rel="stylesheet"/>
		<!--load icon library for search bar-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
		<!-- js script for geolocation and submit -->
		<script type="text/javascript" src="4WW3_project/assets/js/submit.js"></script>
		<!-- Animation resource -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<script>
			//when the listing is selected update the other fields 
			function selectedList() {
				// variables to be updated
				var longitude = document.getElementById("locationlo");
				var latitude = document.getElementById("locationl");
				var address = document.getElementById("address");
				var locID = document.getElementById("locationID");
				
				// what did we select
				var selected = document.getElementById("list");
				var selectedValues = selected.value;
				
				const updates = selectedValues.split(';');
				
				// make the filling
				longitude.value = updates[2];
				latitude.value = updates[1];
				address.value = updates[3];
				locID.value = updates[0];
				
				//alert(locID.value);
				//return false;
			}
		</script>
	</head>
	<body>
		<!-- beginning to see if logged in -->
		<?php
			// header
			include "4WW3_project/assets/php/header.php";
			
			// check if the person is logged in to display the submission page
			if (isset($_SESSION['validlogin']) && ($_SESSION['validlogin'] == true)) {
				// start displaying the page
				if (isset($_SESSION['submissionStatus'])) {
					echo "HERE";
					if ($_SESSION['submissionStatus'] == "true") {
						$_SESSION['submissionStatus'] = "";
						echo '<script>alert("New review was submitted successfully!")</script>';
					}
					elseif ($_SESSION['submissionStatus'] == "picture") {
						$_SESSION['submissionStatus'] = "";
						echo '<script>alert("Picture upload fail. Please try again by uploading an image file and renaming the file.")</script>';
					}
					elseif ($_SESSION['submissionStatus'] == "exist") {
						$_SESSION['submissionStatus'] = "";
						echo '<script>alert("Review is not for an existing listing. Please check your coordinates or select a listing from the dropdown.")</script>';
					}
					elseif ($_SESSION['submissionStatus'] == "empty") {
						$_SESSION['submissionStatus'] = "";
						echo '<script>alert("Please fill in all the fields to submit a new review.")</script>';
					}
					elseif ($_SESSION['submissionStatus'] == "submit") {
						$_SESSION['submissionStatus'] = "";
						echo '<script>alert("Something wrong with the submit button, try again.")</script>';
					}
					elseif ($_SESSION['submissionStatus'] == "form") {
						$_SESSION['submissionStatus'] = "";
						echo '<script>alert("Something wrong with form submission, try again.")</script>';
					}
					elseif ($_SESSION['submissionStatus'] == "false") {
						$_SESSION['submissionStatus'] = "";
						echo '<script>alert("New review fail to submit.")</script>';
					}
				}
		?>
				<!--page title-->
				<div class="title">
					<h2><u>Submit Review</u></h2>
				</div> 
				
				<!--submission form for new object review with name, description, location as latitude longtitude coordinates, and upload-->
				<!--this submission form is for a review-->
				<!-- animation is added using the css animate library -->
				<div class="submission-container">
					<form class="submission-form" method="post" action="uploadReview.php" onsubmit="return validateSubmission(this)" enctype="multipart/form-data">
						<!--each line form div form will represent a row in the form-->
						<div class="line-form animate__animated animate__fadeInDown">
							<!--what we need to enter-->
							<div class="title-line-form">
								<label for="rname">Review Name</label>
							</div>
							<!--text box to enter the info-->
							<div class="field-line-form">
								<input type="text" id="rname" name="reviewname" placeholder="review title.." required>
							</div>
						</div>
						<!-- Add button for Geolocation API autofill coordinates -->
						<div class="line-form animate__animated animate__fadeInDown animate__delay-1s">
							<div class="title-line-form">
								<label>Use Current Location</label>
							</div>
							<div class="field-line-form">
								<p style="padding-left: 10px;" id="useLocation"><a class="useLocationBtn" onclick="getLocation()"><i class="fas fa-street-view">&nbsp My Location</i></a></p>
							</div>
						</div>
						<div class="line-form animate__animated animate__fadeInDown animate__delay-1s">
							<div class="title-line-form">
								<label for="list">Listing to review</label>
							</div>
							<div class="field-line-form">
								<select id="list" name="list" onchange="selectedList();">
									<!--<option value='' disabled selected></option>-->
									<?php
									// get the name of the listings available
									$query = "SELECT * FROM listing WHERE 1=1";
									$stmt = $pdo->prepare($query);
									$stmt->execute();
									$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
									foreach ($records as $record) {
										echo '<option value="'.$record['id'].';'.$record['dlat'].';'.$record['dlong'].
										';'.$record['address'].'">'.$record['name'].'</option>';
									}
									$pdo = null; // close the connection
									?>
								</select>
							</div>
						</div>
						<div type="hidden" class="line-form">
							<div type="hidden" class="title-line-form">
								<label type="hidden" for="locationID"></label>
							</div>
							<div type="hidden" class="field-line-form">
								<input type="hidden" id="locationID" name="locationID">
							</div>
						</div>
						<div class="line-form animate__animated animate__fadeInDown animate__delay-2s">
							<div class="title-line-form">
								<label for="locationl">Location Latitude</label>
							</div>
							<div class="field-line-form">
								<input type="text" id="locationl" name="latitude" placeholder="float to 4 decimals.." required>
							</div>
						</div>
						<div class="line-form animate__animated animate__fadeInDown animate__delay-2s">
							<div class="title-line-form">
								<label for="locationlo">Location Longtitde</label>
							</div>
							<div class="field-line-form">
								<input type="text" id="locationlo" name="longitude" placeholder="float to 4 decimals.." required>
							</div>
						</div>
						<div class="line-form animate__animated animate__fadeInDown animate__delay-2s">
							<div class="title-line-form">
								<label for="address">Address</label>
							</div>
							<div class="field-line-form">
								<input type="text" id="address" name="address" placeholder="listing addrees (if known)">
							</div>
						</div>
						<div class="line-form animate__animated animate__fadeInDown animate__delay-3s">
							<div class="title-line-form">
								<label for="rate" title="will be a dynamic rating in part 2">Rating Score</label>
							</div>
							<div class="field-line-form">
								<select id="rate" name="rate">
									<option value="1">1 star</option>
									<option value="2">2 star</option>
									<option value="3">3 star</option>
									<option value="4">4 star</option>
									<option value="5">5 star</option>
								</select>
							</div>
						</div>
						<div class="line-form animate__animated animate__fadeInDown animate__delay-3s">
							<div class="title-line-form">
								<label for="description">Description</label>
							</div>
							<div class="field-line-form">
								<!--use textarea instead of input becuase we want a larger box-->
								<textarea id="description" name="description" placeholder="what do you think??" style="height:5em" required></textarea>
							</div>
						</div>
						<div class="line-form animate__animated animate__fadeInDown animate__delay-4s">
							<div class="title-line-form">
								<label for="picture">Upload Image</label>
							</div>
							<div class="field-line-form">
								<input type="file" id="picture" name="picture" accept="image/*" required>
							</div>
						</div>
						<!-- Task 1 in Add On 2: upload a video this is not updated with part 3 as it is not mentioned in the specifications of the posted document -->
						<div class="line-form animate__animated animate__fadeInDown animate__delay-4s">
							<div class="title-line-form">
								<label for="video">Upload video (!P3)</label>
							</div>
							<div class="field-line-form">
								<input type="file" id="video" name="video" accept="video/*">
							</div>
						</div>
						<br>
						<!--submit button-->
						<div class="line-form animate__animated animate__fadeInDown animate__delay-5s">
							<input type="submit" name="submit" value="Submit">
						</div>
					</form>
				</div>
		<?php
				// end of displaying the page
			} else { // DISPLAY A MESSAGE TO TELL THE USER WHY THEY CAN'T USE THE PAGE 
				echo "<div class='title'>
						<h2><u>Submit Review</u></h2>
					</div>";
				echo "<div class='submission-container'>
						<h3>YOU MUST BE LOGGED IN TO MAKE A SUBMISSION. PLEASE USE THE <a href='userRegistration.php'>LOGIN PAGE</a>! </h3>
					</div>";
			}
		?>
		
		<!--include the footer of the webpage-->
		<?php
			include "4WW3_project/assets/php/footer.php";
		?>
	</body>
</html>
