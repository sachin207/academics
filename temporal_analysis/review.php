<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
session_start();
include 'config.php';
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reviews || Dummy Ecommerce Portal</title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!--[if lte IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
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
    <div class="row" style="margin-top:30px;">
      <div class="small-12">
        <p><?php echo '<h3>Product ID : ' .$_GET['review_id'] .'</h3>'; ?></p>

        

        <p>Below are the reviews for the product</p>
      </div>
      <?php
      echo '<div style="float:right">';
      echo '<p class="button[secondary success alert]" style="padding:5px;">Rating :<a href = "review.php?review_id='.$_GET["review_id"].'&rating=1">1</a>&nbsp;&nbsp;';
      echo '<a href = "review.php?review_id='.$_GET["review_id"].'&rating=2">2</a>&nbsp;&nbsp;';
      echo '<a href = "review.php?review_id='.$_GET["review_id"].'&rating=3">3</a>&nbsp;&nbsp;';
      echo '<a href = "review.php?review_id='.$_GET["review_id"].'&rating=4">4</a>&nbsp;&nbsp;';
      echo '<a href = "review.php?review_id='.$_GET["review_id"].'&rating=5">5</a>&nbsp;&nbsp;';
      echo '<a href = "review.php?review_id='.$_GET["review_id"].'&rating=ALL">ALL</p>&nbsp;&nbsp;';
    echo'</div>';
    ?>

    <?php
    echo '<div class="row" style="margin-top:10px;">';
    echo  '<div class="large-12">';
        

          
            echo '<table>';
            echo '<tr>';
            echo '<th>Review</th>';
            echo '</tr>';
            if($_GET['rating']!="ALL")
            $result = $mysqli->query('SELECT * FROM camera_review WHERE prodId = "'.$_GET['review_id'].'" AND rating = '.$_GET['rating']);
            else
            $result = $mysqli->query('SELECT * FROM camera_review WHERE prodId = "'.$_GET['review_id'].'"');

          if($result === FALSE){
            die(mysql_error());
          }

          if($result){

            while($obj = $result->fetch_object()) {

                echo '<tr>'; echo '<td style="border-style:
                solid;">'.$obj->reviewText.'</br></br></br><p class="button
                [secondary success alert]" style="padding:5px;"> Rating : '.$obj->rating.'</p></td>';
                
                echo '</tr>';
                
              }
          } 
          echo '</table>';





          echo '</div>';
          echo '</div>';
          ?>

      
        <div class="row" style="margin-top:10px;">
          <div class="small-12">




        <footer style="margin-top:10px;">
           <p style="text-align:center; font-size:0.8em;clear:both;">&copy; Dummny Ecommerce Portal. All Rights Reserved.</p>
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

