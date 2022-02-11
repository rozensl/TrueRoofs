<?php
	session_start(); 
	// Used a youtube tutorial to set up the S3
	// This file demonstrates file upload to an S3 bucket. This is for using file upload via a
	// file compared to just having the link. If you are doing it via link, refer to this:
	// https://gist.github.com/keithweaver/08c1ab13b0cc47d0b8528f4bc318b49a
	//
	// You must setup your bucket to have the proper permissions. To learn how to do this
	// refer to:
	// https://github.com/keithweaver/python-aws-s3
	// https://www.youtube.com/watch?v=v33Kl-Kx30o
	
	// I will be using composer to install the needed AWS packages.
	// The PHP SDK:
	// https://github.com/aws/aws-sdk-php
	// https://packagist.org/packages/aws/aws-sdk-php 
	//
	// Run:$ composer require aws/aws-sdk-php
	require 'vendor/autoload.php';
	
	// to use s3 client
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	// AWS Info for S3 set up
	$bucketName = 'true-images';
	$IAM_KEY = '?';
	$IAM_SECRET = '?';

	// Connect to AWS
	try {
		// create the s3 client 
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'us-east-2'
			)
		);
		echo 'Done1';
	} catch (Exception $e) {
		// We use a die, so if this fails. It stops here. Typically this is a REST call so this would
		// return a json object.
		die("Error: " . $e->getMessage());
	}

	// bucket info to save the file upload
	// create a folder in the bucket test_example and use the image name of the selected file
	$keyName = 'test_example/' . basename($_FILES["picture"]['name']);
	$pathInS3 = 'https://s3.us-east-2.amazonaws.com/' . $bucketName . '/' . $keyName;
	
	// variables to track
	$uploadOK = 0; 
	$_SESSION['submmissionStatus'] = "false";
	
	// variables to be inserted 
	$listName = "";       // name
	$address = "";        // address
	$description = "";    // description
	$listLat = "";        // dlat
	$listLong = "";       // dlong
	$imagePath = $keyName;      // imagePath
	$imageURL = $pathInS3;       // imageURL
	$listPrice = "";      // price
	$sourceURL = "";      // source
	$listBD = "";         // bedroom
	$listBR = "";         // bathroom
	
	// when form is submitted , includes server side validation
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		echo 'Done';
		if (isset($_POST['submit'])) {
			echo 'Done';
			if (isset($_POST['reviewname']) && isset($_POST['description']) && isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['price']) && isset($_POST['link']) && isset($_POST['bathrooms']) && isset($_POST['bedrooms']) ) {
				echo 'Doneisset';
				if (!empty($_POST['reviewname']) && !empty($_POST['description']) && !empty($_POST['latitude']) && !empty($_POST['longitude']) && !empty($_POST['price']) && !empty($_POST['link']) && !empty($_POST['bathrooms']) && !empty($_POST['bedrooms']) ) {
					echo 'Done2';
					$listName = $_POST['reviewname'];
					$address = $_POST['address'];
					$description = $_POST['description'];
					$listLat = $_POST['latitude'];
					$listLong = $_POST['longitude'];
					$listPrice = $_POST['price'];
					$sourceURL = $_POST['link'];
					$listBD = $_POST['bedrooms'];;         // bedroom
					$listBR = $_POST['bathrooms'];;         // bathroom
					
					// start querying
					include 'assets/php/pdoConnect.php';
					
					// check if the entered pic has same name as another
/* 					$checkQuery = "SELECT * FROM listing WHERE imagePath = :path";
					$check = $pdo->prepare($checkQuery);
					$check->bindParam(':path', $imagePath);
					$check->execute(); */
					
					
/* 					if (isset($_FILES["picture"]) && $check->rowCount() == 0) {
						// Add it to S3 once the form is submitted
						echo $_FILES["picture"];
						echo "<br>/<br>";
						echo 'Done3';
						try {
							echo 'Done4';
							// Uploaded:
							$file = $_FILES["picture"]['tmp_name'];

							$s3->putObject(
								array(
									'Bucket'=>$bucketName,
									'Key' =>  $keyName,
									'SourceFile' => $file,
									'StorageClass' => 'REDUCED_REDUNDANCY'
								)
							);
							$uploadOK = 1;
							echo 'Done5';

						} catch (S3Exception $e) {
							die('Error:' . $e->getMessage());
						} catch (Exception $e) {
							die('Error:' . $e->getMessage());
						}
					} else {
						$_SESSION['submmissionStatus'] = "picture";
						$url = "http://3.130.249.183//submitListing.php";
						header('location: ' . $url);
					} */
					
					
					echo 'Done6';
					// check if the entered listing is already in database
					$checkQuery = "SELECT * FROM listing WHERE dlat = :elat AND dlong = :elong";
					$check = $pdo->prepare($checkQuery);
					$check->bindParam(':elat', $listLat);
					$check->bindParam(':elong', $listLong);
					$check->execute();
					echo 'Done7';
					if ($check->rowCount() != 0) {
						echo 'Done8';
						// close connection
						$pdo = null;
						$_SESSION['submmissionStatus'] = "exist";
						$url = "http://3.130.249.183//submitListing.php";
						header('location: ' . $url);
					}
					
					// insert record when pic uploaded
					if ($uploadOK == 1) {
						echo 'Done9';
						$insert = "INSERT INTO listing (name, address, description, dlat, dlong, imagePath, imageURL, price, source, bathroom, bedroom)
						VALUES (:name, :address, :description, :dlat, :dlong, :imagePath, :imageURL, :price, :source, :bathroom, :bedroom)";
						$newList = $pdo->prepare($insert);
						$newList->bindParam(':name', $listName);
						$newList->bindParam(':address', $address);
						$newList->bindParam(':description', $description);
						$newList->bindParam(':dlat', $listLat);
						$newList->bindParam(':dlong', $listLong);
						$newList->bindParam(':imagePath', $imagePath);
						$newList->bindParam(':imageURL', $imageURL);
						$newList->bindParam(':price', $listPrice);
						$newList->bindParam(':source', $sourceURL);
						$newList->bindParam(':bathroom', $listBR);
						$newList->bindParam(':bedroom', $listBD);
						if ($newList->execute() === true) { // if inserted
							echo 'Done10';
							// close connection
							$pdo = null;
							$_SESSION['submmissionStatus'] = "true";
							$url = "http://3.130.249.183//submitListing.php";
							header('location: ' . $url);
						} else {
							// close connection
							$pdo = null;
							$_SESSION['submmissionStatus'] = "false";
							$url = "http://3.130.249.183//submitListing.php";
							header('location: ' . $url);
						}
					} else {
						$pdo = null;
						$_SESSION['submmissionStatus'] = "picture";
						$url = "http://3.130.249.183//submitListing.php";
						header('location: ' . $url);
					}
				} else {
					$_SESSION['submmissionStatus'] = "empty";
					$url = "http://3.130.249.183//submitListing.php";
					header('location: ' . $url);
				}
			} else {
				$_SESSION['submmissionStatus'] = "empty";
				$url = "http://3.130.249.183//submitListing.php";
				header('location: ' . $url);
			}
		} else {
			$_SESSION['submmissionStatus'] = "submit";
			$url = "http://3.130.249.183//submitListing.php";
			header('location: ' . $url);
		}
	} else {
		$_SESSION['submmissionStatus'] = "form";
		$url = "http://3.130.249.183//submitListing.php";
		header('location: ' . $url);
	}
		

	echo 'Done';
?>