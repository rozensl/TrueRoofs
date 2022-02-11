<?php
	
	// function to be used later
	$_SESSION['listSelected'] = false;
	
	function listingSelected($selectedID) {
		// we want to be able to prepopulate the fields 
		// connection
		include 'assets/php/pdoConnect.php';
		$queryG = "SELECT * FROM listing WHERE ID = :id";
		$stmt2 = $pdo->prepare($queryG);
		$stmt2-> bindParam(':id', $selectedID);
		$stmt2->execute();
		$record = $stmt2->fetch(PDO::FETCH_ASSOC);
		$_SESSION['selectedLat'] = $record['dlat'];
		$_SESSION['selectedLong'] = $record['dlong'];
		$_SESSION['selectedAdd'] = $record['address'];
		$_SESSION['listSelected'] = true;
		
		//pdo = null; // close the connection
	}
	
	if ($_POST['dropdownValue']) {
		// call the function
		listingSelected($_POST['dropdownValue']);}
?>