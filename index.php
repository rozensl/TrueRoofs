<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<!-- Meta tag information on the page -->
	<meta charset="UTF-8">
	<meta name="description" content="Reviewing estate listings">
	<meta name="keywords" content="4WW3">
	<meta name="author" content="Lin Rozenszajn and Abeer A-Y">
	<!--To make the view fit to screen of the device-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Main Page</title>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<!-- javascript file -->
	<script type="text/javascript" src="4WW3_project/assets/js/main.js" async></script> 
	<!--styling to the main page-->
	<link href="resources/assets/css/mainStyle.css" rel="stylesheet" />
	<!--load icon library for search bar-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<!-- Animation resource -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
</head>

<body>
	<!--include header-->
	<?php
		include "resources/assets/php/header.php";
	?>

	<!--Search bar of the estates-->
	<div class="main-container">
		<!--background image of the div-->
		<img src="4WW3_project/assets/images/house.jpg" alt="top view of estates"
			style="width:100%; filter: blur(5px); padding-top: 80px;">
		<!--div section that have the search bar as a form-->
		<div class="search">
			<!--title-->
			<p class="search-title" id="search-title"><u>Search Reviews</u></p>
			<!--form to pass the info use the get method because we want to allow bookmarks and ideal for search boxes-->
			<form class="search-bar" id="search-bar" method="POST" action="4WW3_project/assets/php/retrieveResults.php">
				<!--bar of the search-->
				<input id="searchBar_input" type="text" placeholder="Enter a city name" name="search">
				<input id="searchBar_lat" type="hidden" name="lat"></input>
				<input id="searchBar_long" type="hidden" name="long"></input>
				<!--clickable button to send the input-->
				<button type="submit" id="submit_btn" name="submitSearch" value="0" aria-label="submit address search"><i class="fa fa-search"></i></button>
			</form>
		</div>
	</div>
	<!--dynamic map section-->
	<div class="map">
		<!--map filters that filter the listings available on the map as icons-->
		<div class="map-checks">
			<div id="Filters">
				<h3>Filters</h3>
			</div>
			<div id="Filter-boxes">
				<form class="map-filter">
					<input type="checkbox" id="checkbox1">
					<label for="checkbox1">House</label>
					<input type="checkbox" id="checkbox2">
					<label for="checkbox2">Apartment</label>
					<input type="checkbox" id="checkbox3">
					<label for="checkbox3">4+ BR</label>
					<input type="checkbox" id="checkbox4">
					<label for="checkbox4">Sale</label>
					<input type="checkbox" id="checkbox5">
					<label for="checkbox5">Lease</label>
					<button aria-label="submit filter" type="submit"><i class="fa fa-sync-alt"></i></button>
				</form>
			</div>
			<div id="map_button">
				<a id="getLocation">Search by location</a>
			</div>
		</div>
		<!--placeholder for the comming soon dynamic mapping that positions map on user location and display clickable icons of the listings-->
			<div id="mapholder">
		</div>
	</div>

	<!--include the footer of the webpage-->
	<?php
		include "4WW3_project/assets/php/footer.php";
	?>

</body>

</html>
