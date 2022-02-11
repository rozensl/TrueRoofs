<?php
	session_start();
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strtolower($data);
        return $data;
      }

	// connection
	include 'pdoConnect.php';
	
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submitSearch']) && $_POST['submitSearch'] == "1") {
            $latitude = $_POST['lat'];
            $longitude = $_POST['long'];
            if (!empty($_POST['search'])) {
                $pattern = '~\b(drop|table|insert|values|select)\b~i';
                $enteredSearch = test_input($_POST['search']);
                if (!preg_match($pattern, $enteredSearch)) {
                    $latitude = $_POST['lat'];
                    $longitude = $_POST['long'];
                } else {
                    $url = "http://3.130.249.183//index.php";
                    header('location: ' . $url);
                }
            }
            // Query database for listings within certain radius of search bar input
            $query = "SELECT id, name, description, address, dlat, dlong, price, bedroom, bathroom, source,
            (  3959 * acos( cos( radians($latitude) ) * cos( radians(`dlat`) ) * 
            cos ( radians(`dlong`) - radians($longitude) ) + sin( radians($latitude) )* 
            sin( radians(`dlat`) ) )  ) AS distance FROM `listing` ORDER BY distance";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            // Retrieve all listing ID's that are in the same city
            if ($stmt->rowCount() != 0) {
                $_SESSION['resultsFound'] = 1;
                $_SESSION['searchResults'] = array();
                $locationIDs = array();
                $i = 0;
                while ($i < 4 && $result =  $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $_SESSION['searchResults'][] = $result;
                    $locationIDs[] = $result['id'];
                    $i += 1;
                }

                $list = implode(',', $locationIDs);
                $query = "SELECT locationID, rating, review_amount FROM (SELECT ROUND(AVG(rating), 0) AS rating, count(rating) as review_amount, locationID 
                FROM `review` GROUP BY locationID) bob where bob.locationID IN ($list)";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                $j = 0;
                while ($j < 4 && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    print_r($row);
                    echo "***********";
                    $i = 0;
                    while ($i < 4) {
                        if ($_SESSION['searchResults'][$i]['id'] == $row['locationID']){
                            echo "HIT!!!!!!!!!!!!!!!!!!!111!";
                            echo " ROW values are " . $row['rating'] . " and " . $row['review_amount'];
                            $_SESSION['searchResults'][$i]['rating'] = $row['rating'];
                            $_SESSION['searchResults'][$i]['count'] = $row['review_amount'];
                            echo "  SESSION rating value is " . $_SESSION['searchResults'][$i]['rating'];
                        }
                        $i = $i + 1;
                        echo "-------------------------------";
                    }
                    $j = $j + 1;
                }

                echo "-------------------------------";
                //print_r($_SESSION['searchResults'][0]);
                // close the connection
                $pdo = null;
                // Redirect to Result page
                $url = "http://3.130.249.183//result.php";
                header('location: ' . $url);
            } else {
                // close the connection
                $_SESSION['resultsFound'] = 0;
                $pdo = null;
                // Redirect to Result page
                //$url = "http://3.130.249.183//result.php";
                //header('location: ' . $url);
                echo "\n no results";
            }
        } else {
            echo "\n Nothing entered in search bar";
            //$url = "http://3.130.249.183//index.php";
            //header('location: ' . $url);
        }
    } else{
        //$url = "http://3.130.249.183//index.php";
        //header('location: ' . $url);
        echo "\n Search button not pressed";
    }
?>