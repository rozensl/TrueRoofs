<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en-US">

<head>
	<!--Meta tag info-->
	<meta charset="UTF-8">
	<meta name="description" content="Search results">
	<meta name="keywords" content="4WW3">
	<meta name="author" content="Lin Rozenszajn">
	<!--To make the view fit to screen of the device-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Individual Object</title>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<!--styling to the main page-->
	<link href="4WW3_project/assets/css/header_footer.css" rel="stylesheet" />
	<link href="4WW3_project/assets/css/individualResult.css" rel="stylesheet" />
	<!--load icon library for search bar-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<!-- javascript file -->
	<script type="text/javascript" src="4WW3_project/assets/js/individualResult.js"></script> 
</head>

<body>
	<!--include header-->
	<!--same comments on the index.php-->
	<?php
        include "4WW3_project/assets/php/header.php";
    ?>
	<!--dropdown buttons bar, each button is a search filter-to be added later with Javascript-->>
	<div class="filter-bar"></div>
	<?php
        // Transfer SESSION data into hidden fields, used to pass SESSION data to Javascript file
        echo '<input type="hidden" id="lat" value="' . $_SESSION['chosenListing']['dlat'] . '"></input>';
        echo '<input type="hidden" id="long" value="' . $_SESSION['chosenListing']['dlong'] . '"></input>';
    ?>
	<!--page displaying information about an individual result-->
	<!--includes two photos, an interactive map, a video, text description, link to original mls listing, and reviews-->
	<div class="container">
		<div class="slideshow-and-map-container">
			<!--Slideshow container-->
			<div class="slideshow-container">
				<div class="prev-next-buttons">
					<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
					<a class="next" onclick="plusSlides(1)">&#10095;</a>
				</div>
				<div class="mySlides fade" id="main">
					<!--Task 2 in Add On 2: use <picture> and <source> tags to add customizable images-->
					<picture>
						<img src="4WW3_project/assets/images/placeholder_1.png" alt="main listing photo">
					</picture>
				</div>
				<div class="mySlides">
					<img src="4WW3_project/assets/images/placeholder_2.png">
				</div>
				<div class="mySlides fade" id="top-photo">
					<img src="4WW3_project/assets/images/placeholder_2.png">
				</div>
				<!--Addon 1 Task 3-->
				<!-- Next and previous buttons -->
			</div>
			<!--Map-->
			<div id="map">
			</div>
		</div>
		<div class="object">
			<!--Task 1 in Add On 2: add a video-->
			<div class="object-video"><video controls>
					<source src="4WW3_project/assets/images/apartment-tour.mp4" type="video/mp4">
					Your browser does not support the video tag.
				</video></div>
			<div class="object-content">
				<!--Addon 1 Task 3-->
				<div class="locationOnMap" itemscope itemtype="https://schema.org/Place">
					<h2 class="address"> <?php echo $_SESSION['chosenListing']['address']; ?></h2>

					<div class="geographicCoordinate" itemscope itemtype="https://schema.org/GeoCoordinates">
						<h2 class="coordinates" style="display:none; visibility:hidden"> 44.5W 70N</h2>
						<meta itemprop="latitude" content="44.5W" />
						<meta itemprop="longtitude" content="70N" />
					</div>
				</div>
				<p class="listing-link"><a href=<?php echo $_SESSION['chosenListing']['source'];?>> Link to original listing </a></p>
				<?php echo $_SESSION['chosenListing']['description'];?>
			</div>
		</div>
		<div class="object-reviews">
		<?php
            //Dynamically generate page content
            for ($i = 0; $i < count($_SESSION['reviews']); $i++) {
				echo "hi";
                $result = $_SESSION['reviews'][$i];
                echo '<div class="reviewGroup" itemscope itemtype="https://schema.org/Review">
						<div itemprop="author" itemscope itemtype="https://schema.org/Person">
							<meta itemprop="name" content="Nikki Smith">
						</div>
						<div class="review">
							<div class="reviewer-info">
								<div class="avatar-image">
									<picture>
										<source media="(min-width: 1920px)" srcset="avatar-2x.png, avatar-2x.png 2x">
										<img src="4WW3_project/assets/images/avatar-1x.png" alt="profile-avatar">
									</picture>
								</div>
								<div class="reviewer-name" style="font-weight: bolder;">' . $result[0] .
								'</div>
								<div class="reviewer-date">(' . $result[2] .')
								</div>
							</div>
							<div class="reviewer-rating">';
                	for ($j = 0; $j < $result[3]; $j++) {
                    	echo '<i class="fa fa-star" aria-hidden="true"></i>';
                	}
                	echo '</div><meta itemprop="reviewRating" content="4">
					<div class="review-content">' . $result[4] . '</div>
				</div></div>'; 
			}
        ?>
		</div>
	</div>
	<!--include the footer of the webpage-->
	<?php
        include "4WW3_project/assets/php/footer.php";
    ?>
</body>
</html>
