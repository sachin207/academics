<?php
	include("is_logged.php");
	include("functions.php");
	if(!isset($_REQUEST['bookingid']))
		{
		header("Location: my_bookings.php");
		exit();
		}
	$booking=bookingDetails($_REQUEST['bookingid']);
	if($booking==null || $booking['userid']!=$_SESSION['id'])
		{
		header("Location: my_bookings.php");
		exit();
		}
	if(isset($_REQUEST['confirm']))
		{
		if($_REQUEST['confirm']==0)
			header("Location: booking.php?bookingid={$_REQUEST['bookingid']}");
		if($_REQUEST['confirm']==1)
			{
			$sql="DELETE FROM bookings WHERE id={$_REQUEST['bookingid']};";
			$delete=mysql_query($sql);
			if($delete)
				header("Location: my_bookings.php");
			}
		}
?>
<html>
	<head>
		<title>Delete booking id: <?php echo $booking['bookingid']; ?> </title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
			include("navigation.php");
		?>
		<h1 class="heading">Booking Details</h1>
		<center><table id="form_table" border="0" cellpadding="3">
			<tr>
				<th>ID:</th> 
				<td><?php echo $booking['bookingid']; ?></td>
			</tr>
				<th>Room Booked:</th>
				<td><?php echo "<a href=\"room.php?roomid={$booking['roomid']}\" target=\"_blank\">{$booking['roomname']}</a>"; ?></td>
			</tr>
			<tr>
				<th>Booked By:</th>
				<td><?php echo "<a href=\"profile.php?userid={$booking['userid']}\" target=\"_blank\">{$booking['username']}</a>"; ?></td>
			</tr>
			<tr>
				<th>Date:</th>
				<td><?php echo dateFrom($booking['starttime']); ?></td>
			</tr>
			<tr>
				<th>From:</th>
				<td><?php echo timeFrom($booking['starttime']); ?></td>
			</tr>
			<tr>
				<th>To:</th>
				<td><?php echo timeFrom($booking['endtime']); ?></td>
			</tr>
			<tr>
				<th>Duration:</th>
				<td><?php echo DATE("H \h\o\u\\r\s i \m\i\\n\u\\t\\e\s", STRTOTIME($booking['duration'])); ?></td>
			</tr>
			<tr>
				<th>Purpose:</th>
				<td><?php echo $booking['purpose']; ?></td>
			</tr>
			<tr>
				<th>Repetition:</th>
				<td><?php echo $booking['repetition']; ?></td>
			</tr>
			<tr>
				<th>Booking Time:</th>
				<td><?php echo DATE("jS F, Y h:i A", STRTOTIME($booking['bookingtime'])); ?></td>
			</tr>
			<tr>
				<th>Last Update Time:</th>
				<td><?php echo DATE("jS F, Y h:i A", STRTOTIME($booking['lastupdate'])); ?></td>
			</tr>

			<tr></tr><tr></tr><tr></tr>

			<tr>
				<td colspan="2" align="center">
					Are you sure you want to delete this booking?
				</td>
			</tr>
			
			<tr>
				<td align="center">
					<a href="delete_booking.php?bookingid=<?php echo $booking['bookingid']; ?>&confirm=1">Yes</a>
				</td>
				<td align="center">
					<a href="delete_booking.php?bookingid=<?php echo $booking['bookingid']; ?>&confirm=0">No</a>
				</td>
			</tr>
		</table>
		</center>
	</div>
	</body>
</html>