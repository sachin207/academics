<?php
	include_once("is_logged.php");
?>
<html>
	<head>
		<title>
			<?php
			echo $_SESSION['name'];
			?>
		</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php
		include("header.php");
		include("navigation.php");
		?>
		<div class="welcome">
			<center>
				<h1 style="float:right;margin-right:40px;font-size:18px;font-family:'Arial';">
					<?php echo "<a href=\"profile.php?userid={$_SESSION['id']}\" target=\"_blank\" >{$_SESSION['name']}</a>"; ?>
				</h1>
				<br/><br/>
				<h2>
					Welcome to IIT Hyderabad Room Booking Portal.
				</h2>
				<img src="LH1.jpg" width="75%" height="55%"/>
			</center>
				
		</div>
		</div>
	</body>
</html>