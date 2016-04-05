<?php
include_once("is_logged.php");
if(!isset($_REQUEST['roomid']))
	header("Location: rooms.php");
include_once("functions.php");
$room=roomDetails($_REQUEST['roomid']);
if($room==null)
	header("Location: rooms.php");
?>
<html>
	<head>
		<title><?php echo $room['name']; ?></title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
			include("navigation.php");
		?>
		<h1 class="heading" style="margin-left:490px;">Room Details</h1>
		<br/>
		<center><table class="h_table" id="room_details" border="1" cellpadding="10" cellspacing="0">
			<tr>
				<th>Name:</th>
				<td><?php echo $room['name']; ?></td>
			</tr>
			<tr>
				<th>Capacity:</th>
				<td><?php echo $room['capacity'] . " students"; ?></td>
			</tr>
			<tr>
				<th>Projector:</th>
				<td><?php echo $room['projector']==0?"No":"Yes"; ?></td>
			</tr>
		</table>
		<br/>
		<a href="book.php?roomid=<?php echo $room['id']; ?>" style="font-family:Arial">
			<strong>Book</strong>
		</a>
		<?php
		if($_SESSION['level']=="admin")
			{
		?>
		<br/>
		<a href="edit_room.php?roomid=<?php echo $room['id']; ?>" style="font-family:Arial">
			<strong>Edit</strong>
		</a>
		<?php
			}
		?>
		</center>
		</div>
	</body>
</html>