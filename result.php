<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en-US">

<head>
	<!--Meta tag info-->
	<meta charset="UTF-8">
	<meta name="description" content="Reviewing estate listings">
	<meta name="keywords" content="4WW3">
	<meta name="author" content="Lin Rozenszajn">
	<!--To make the view fit to screen of the device-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Result Page</title>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<!--styling-->
	<link href="4WW3_project/assets/css/header_footer.css" rel="stylesheet" />
	<link href="4WW3_project/assets/css/result.css" rel="stylesheet" />
	<!-- javascript file -->
	<script type="text/javascript" src="4WW3_project/assets/js/result.js"></script> 
	<!--load icon library for search bar-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<!-- Animation resource -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<body>
	<!--include header-->
	<!--same comments on the indext/html-->
	<?php
        include "4WW3_project/assets/php/header.php";
    ?>

	<!--Dropdown buttons bar, each button is a search filter (to be added later with JavaScript-->>
	<div class="filter-bar"></div>
	<!--page containing the results of a search-->
	<!--contains a dynamic map showing location of each result, as well as a card displaying-->
	<!--the address, mls listing number and synopsis of each result, along with a button to access its individual result page-->
	<!-- animation is added using the css animate library -->
	<div class="content-container">
		<!--Dynamic map-->
		<div class="content-child animate__animated animate__zoomInLeft" id="map">
		</div>
		<!--Results display-->
		<div class="content-child animate__animated animate__zoomInRight" id="results">


		<?php
		echo '<input id="firstLat" type="hidden" value="' . $_SESSION['searchResults'][0]['dlat']. '"></input>';
		echo '<input id="firstLong" type="hidden" value="' . $_SESSION['searchResults'][0]['dlong']. '"></input>';
		
		$allRanks = array();
		foreach ($_SESSION['searchResults'] as $result) {
			$allRanks[$result['id']] = $result['rating'];
		}

		$rank_1 = false;
		$rank_2 = false;
		$rank_3 = false;
		$i = 1;
        foreach ($_SESSION['searchResults'] as $result) {
            echo '<div class="content-grandchild"> <div class="result-top-image-container"></div>';
			echo '<input class="lat" type="hidden" value="' . $result['dlat']. '"></input>';
			echo '<input class="long" type="hidden" value="' . $result['dlong']. '"></input>';
			$i =  $i + 1;
			$rank = 7654;
			$aveRating = (int) ($result['rating'] / 10 * 5);
			if ($aveRating > 3) {
				if (!$rank_1 && $result['count'] > 1){
					$rank = 1;
					$rank_1 = True;
				}
				else{
					$rank = 2;
					$rank_2 = True;
				}
			}
			else if ($aveRating > 2){
				if (!$rank_3){
					$rank = 3;
					$rank_3 = True;
				}
				else{
					$rank = 4;
				}
			}
			
            echo '<div class="result-ranking"> Ranked # '. $rank .' <span id="ranking-'. $i .'"></span> </div>';
            echo '<div class="result-stars">';
            for ($x = 0; $x < $aveRating ; $x++) {
                echo '<i class="fas fa-star"></i>';
            }
			echo '<span class="text"> (' . $result['count'];
			if ($result['count'] > 1){
				echo ' reviews)</span></div>';
			}
			else {
				echo ' review)</span></div>';
			}
			echo '<div class="bedsandbath"> <p class="beds-baths" style="margin:0;"><i class="fa fa-bed"></i> ';
            echo $result['bedroom'] . " Bed ";
            echo '<i class="fa fa-bath"></i> ' . $result['bathroom'] . ' Bath </p></div>';
            
			echo '<div class="result-description"><div class="address" id="' . $result['id'] . '">' . $result['address']. '</div>
				<div class="listing-desc">' . $result['description'] . '</div> </div>';
            echo '<div class="viewListing"><form class="submit" method="POST" action="4WW3_project/assets/php/checkResult.php">
				<input type="hidden" id="chosenID" name="chosenID" value="' . $result['id'] . '">';
            echo '<div class="check-button"><input type="submit" name="submitSearch" value="View listing" ></div></form> </div></div>';
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
