<?php
	include_once("is_logged.php");
	if(!isset($_GET['search']) || $_GET['q']=="Search a booking...")
		header("Location: home.php");
	include_once("functions.php");
	$result=searchBooking($_GET['q']);
	$number=mysql_num_rows($result);
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
		<h1 class="heading" style="margin-left:300px;"><?php echo $number==0?"No results for \"{$_GET['q']}\"":("Search for \"{$_GET['q']}\" gave the following {$number} result" . ($number==1?".":"s.")); ?></h1>
		<?php if($number==0) goto skip_table; ?>
			<center><table id="search_results" border="1" cellpadding="10" cellspacing="0">
				<tr class="t_heading">
					<th>Booking id</th>
					<th>Room Booked</th>
					<th>Booked by</th>
					<th>Purpose</th>
					<th>Date</th>
					<th>From</th>
					<th>To</th>
				</tr>
				<?php
					while($row=mysql_fetch_array($result))
						echo "<tr>
								<td><a href=\"booking.php?bookingid={$row['bookingid']}\" target=\"_blank\">{$row['bookingid']}</a></td>
								<td><a href=\"room.php?roomid={$row['roomid']}\">{$row['roomname']}</a></td>
								<td><a href=\"profile.php?userid={$row['userid']}\">{$row['username']}</a></td>
								<td>{$row['purpose']}</td>
								<td>" . dateFrom($row['starttime']) . "</td>
								<td>" . timeFrom($row['starttime']) . "</td>
								<td>" . timeFrom($row['endtime']) . "</td>
							</tr>";
				?>
			</table>
			</center>
		<?php skip_table: ?>
		</div>
	</body>
</html>