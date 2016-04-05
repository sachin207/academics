<?php 
 
include 'config.php';
session_start();
$manufacturer = $_POST['manufacturer'];
$_SESSION['manufacturer'] = $manufacturer;




echo '<div class ="product_details">';
echo '<div class="row" style="margin-top:10px; margin-left:300px;">';
echo '<div class="small-12" style="margin-top:5px;">';
          $i=0;
          $product_id = array();
          $product_quantity = array();
          if(strlen($_SESSION['search'])==0){
            if($manufacturer == 'ALL')
            {
              $result = $mysqli->query('SELECT * FROM camera_product');
            }
            else{
              $result = $mysqli->query('SELECT * FROM camera_product WHERE manufacturer = "'.$manufacturer.'"');
            }
          }
          else{
            if(strlen($_SESSION['manufacturer'])==0 || $_SESSION['manufacturer'] == "ALL")
            {
              $query = 'SELECT * FROM camera_product WHERE product_name LIKE "%'.$_SESSION['search'].'%"';
              $result = $mysqli->query($query);
              
            }
            else{
              $query = 'SELECT * FROM camera_product WHERE manufacturer = "'.$_SESSION["manufacturer"].'" AND  product_name LIKE "%'.$_SESSION['search'].'%"';
              $result = $mysqli->query($query);
            
            }
          }
          if($result === FALSE){
            die(mysql_error());
          }

          if($result){

            while($obj = $result->fetch_object()) {

              
              echo '<div class="large-3 columns" style="height:350px;">';
              echo '<a href = "review.php?review_id='.$obj->prodId.'&rating=ALL"><p id = "product_name" style="color:#0078A0; font-size: 16px; text-overflow:ellipsis; word-wrap: normal; height: 50px;  overflow: hidden;" >'.$obj->product_name.'</p></a>';
              echo '<img src="images/cam.jpg" style="height:100px"/>';
              echo '<p style="color:#1f1f14;">Product Code: '.$obj->prodId.'</p>';
              echo '<p style="color:#1f1f14;">Units Available: '.$obj->qty.'</p>';
              echo '<p style="color:#1f1f14;">Price (Per Unit): '.$currency.$obj->price.'</p>';



              if($obj->qty > 0){
                echo '<p><a href="update-cart.php?action=add&id='.$obj->prodId.'"><input type="submit" value="Add To Cart" style=" clear:both; background: #0078A0; border: none; color: #fff; font-size: 1em; padding: 10px;" /></a></p>';
              }
              else {
                echo 'Out Of Stock!';
              }
              echo '</div>';

              $i++;
            }

          }

          $_SESSION['product_id'] = $product_id;


          echo '</div>';
          echo '</div>';
          echo '</div>';
          ?>