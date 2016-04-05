<?php 
 
include 'config.php';
session_start();
$manufacturer = $_POST['manufacturer'];

$query = 'SELECT  rating, count(*) as count FROM camera_review WHERE manufacturer = "'.$manufacturer.'" GROUP BY rating';
$query1 = 'SELECT rating , unixReviewTime FROM camera_review WHERE manufacturer = "'.$manufacturer.'"';
$result = $mysqli->query($query1);
$rating = array();
$rating_count = array();
		if($result === FALSE){
            die(mysql_error());
         }

        if($result){

           $rows = array();
			while($r = mysqli_fetch_assoc($result)) {
    			$time = substr($r["unixReviewTime"], 0,6 );
    			if (!array_key_exists($time, $rating)&&!array_key_exists($time, $rating_count)){

    				$rating[$time]= 0;
    				$rating_count[$time]=0;
    			}
    			else{
    				$rating[$time] = $rating[$time]+$r["rating"];
    				$rating_count[$time] = $rating_count[$time]+1;
    			}
 			}
 			
 			foreach ($rating as $key => $value) {
 				if($rating[$key]>0 && $rating_count[$key]>0){
			 		$rating[$key] = $value/$rating_count[$key];
			 		$year = substr($key,0,4);
					$month = substr($key,4,6);
					$data[] = array('time_period' => $year."-".$month, 'rating' => $rating[$key],'count' => $rating_count[$key]);
 				}
			 	
			}
			
        }
       print json_encode($data);

    ?>