<?php 
	session_start();
	
	session_unset();
	
	session_destroy();
	
	$url = "http://3.130.249.183/index.php";
	
	header('Location: ' . $url);
?>