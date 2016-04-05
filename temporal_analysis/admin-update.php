<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if(session_id() == '' || !isset($_SESSION)){session_start();}

if($_SESSION["type"]!="admin") {
  header("location:index.php");
}

include 'config.php';

$_SESSION["products_id"] = array();
$_SESSION["products_id"] = $_REQUEST['quantity'];


$result = $mysqli->query("SELECT * FROM camera_product ORDER BY prodId asc");
$i=0;
$x=1;

if($result) {
  while($obj = $result->fetch_object()) {
    if(empty($_SESSION["products_id"][$i])) {
      $i++;
      $x++;
    }
    else {
      $newqty = $obj->qty + $_SESSION["products_id"][$i];
      $update = $mysqli->query("UPDATE camera_products SET qty =".$newqty." WHERE prodId ='".$x."'  ");
      if($update)
        echo 'Data Updated';

      $i++;
      $x++;
    }
  }
}



header ("location:success.php");



?>
