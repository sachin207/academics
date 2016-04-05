<?php
include_once("is_logged.php");
include_once("connect_database.php");
include_once("functions.php");

if(!isset($_REQUEST['bookingid']))
	{
	echo "Please select a booking first<br/>";
	include("my_bookings.php");
	exit();
	}
$booking=bookingDetails($_REQUEST['bookingid']);
if($booking==null)
	{
	echo "Booking not found.<br/>";
	include("my_bookings.php");
	exit();
	}
?>
<html>
	<head>
		<title>Booking id: <?php echo $booking['bookingid']; ?> </title>
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
			<?php
			if($booking['userid']==$_SESSION['id'])
				{
				if($booking['starttime']>time())
					{
			?>
					<tr>
						<td colspan="2" align="center">
							<a href="edit_booking.php?bookingid=<?php echo $booking['bookingid']; ?>">Edit</a>
						</td>
					</tr>
					<?php
					}
					?>
				<tr>
					<td colspan="2" align="center">
						<a href="delete_booking.php?bookingid=<?php echo $booking['bookingid']; ?>">Delete</a>
					</td>
				</tr>
				<?php
				}
				?>
		</table>
		</center>
	</div>
	</body>
</html>