<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
session_start();
$_SESSION['manufacturer'] = "ALL";
$_SESSION['search'] = NULL;
include 'config.php';
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products || Dummy Ecommerce Portal</title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />

<script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery.jcarousel.pack.js" type="text/javascript"></script>
<script src="js/custom.js" type="text/javascript"></script>

  </head>
  <body>

    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a href="index.php">Dummy Ecommerce Portal</a></h1>
        </li>
        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
      </ul>

      <section class="top-bar-section">
      <!-- Right Nav Section -->
        <ul class="right">
          <li><a href="about.php">About</a></li>
          <li class='active'><a href="products.php">Products</a></li>
          <li><a href="cart.php">View Cart</a></li>
          <li><a href="orders.php">My Orders</a></li>
          <li><a href="contact.php">Contact</a></li>
          <?php

          if(isset($_SESSION['username'])){
            echo '<li><a href="account.php">My Account</a></li>';
            echo '<li><a href="logout.php">Log Out</a></li>';
          }
          else{
            echo '<li><a href="login.php">Log In</a></li>';
            echo '<li><a href="register.php">Register</a></li>';
          }
          ?>
        </ul>
      </section>
    </nav>



    <div id ="chart_area" style=" background:grey; z-index:1000;position:fixed;top:150px;left:230px;display:none; width:500px; height:400px;">
      
      <div id ="chart_div" style="background:grey; width: 500px; height: 400px;float:left;"></div>
      <p id="close_graph"style="position:fixed;float:left;" >(&#x274C;)</p>
    </div>
      
    <!-- End Content -->
    <!-- Sidebar -->
    <div id="sidebar" style="position:fixed;">
    
      <!-- Categories -->

      <div class="box categories">
        <h2>Search <span></span></h2>
            <input type="text" class="field" id="product_search" />
        <h2>Categories <span></span></h2>
        <div class="box-content">
          <ul class = "manufacturer_list">
          <li class="last" id="manufacturer" style="color:#000">ALL</li>
          <?php
          $i=0;
          $product_id = array();
          $product_quantity = array();

          $result = $mysqli->query('SELECT DISTINCT manufacturer FROM camera_product');
          if($result === FALSE){
            die(mysql_error());
          }

          if($result){
            while($obj = $result->fetch_object()) {
              echo '<li class="last" id="manufacturer" style="color:#000">'.$obj->manufacturer.'</li>';
            }
          }
          ?>
          </ul>
        </div>
      </div>
      
      <!-- End Categories -->
    </div>
    <!-- End Sidebar -->

    <div class ="product_details">
    <div class="row" style="margin-top:10px; margin-left:300px;">
      <div class="small-12" style="margin-top:5px;">
        <?php
          $i=0;
          $product_id = array();
          $product_quantity = array();

          $result = $mysqli->query('SELECT * FROM camera_product');
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
          ?>
        </div>
        <div class="row" style="margin-top:10px;">
          <div class="small-12">




        <footer style="margin-top:10px;">
           <p style="text-align:center; font-size:0.8em;clear:both;">&copy; BOLT Sports Shop. All Rights Reserved.</p>
        </footer>

      </div>
    </div>





    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
