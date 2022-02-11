<?php
	// begin the session to access the variables 
    include 'assets/php/pdoConnect.php';

    $query = "SELECT address from listing";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $listings;
?>