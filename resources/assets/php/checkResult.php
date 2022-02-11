<?php
    session_start();

    // Open connection
    include 'pdoConnect.php';

    $query = "SELECT name, reviewerName, created, rating, content FROM `review` WHERE review.locationID = " . $_POST['chosenID'];
    $stmt = $pdo->prepare($query);
    //$stmt-> bindParam($_SESSION['chosenID']);
    $stmt->execute();

    $_SESSION['chosenListing'] = array();
    $_SESSION['reviews'] = array();

    foreach ($_SESSION['searchResults'] as $result) {
        if ($result['id'] == $_POST['chosenID']) {
            $_SESSION['chosenListing'] = $result;
        }
    }

    print_r($_SESSION['chosenListing']);
    //echo  "----------------------------------------------";
    while ($result =  $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($result);
        $reviewData = array($result['reviewerName'],  $result['name'], $result['created'], $result['rating'], $result['content']);
        $_SESSION['reviews'][] = $reviewData;
    }
    
    //echo "******************************";
    print_r($_SESSION['reviews']);
    $pdo = null; // Close connection
    
    //print($_SESSION["reviewRating_"]);
    $url = $url = "http://3.130.249.183//individualResult.php";
    header('location: ' . $url);
