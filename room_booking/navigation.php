<div class="navigation">
<br>
<ul class="navigation_list">
<li><a href="home.php" class="nav">Home</a></li><br/>
<li><a href="profile.php" class="nav">My Profile</a></li><br/>
<li><a href="rooms.php" class="nav">Search for a Room</a></li><br/>
<?php 
	if(isset($_SESSION['level']) && $_SESSION['level']=="admin")
		echo "<li><a href=\"add_room.php\" class=\"nav\">Add a room</a></li><br/>";
?>
<li><a href="my_bookings.php" class="nav">My Bookings</a></li><br/>
<li><a href="sign_out.php" class="nav">Sign out</a></li>
</ul>
</dl>
</div>
<div class="main_box">