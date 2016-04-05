<?php
include_once("is_logged.php");
include_once("connect_database.php");
include_once("functions.php");
//Building search query
$sql="SELECT b.id as bookingid, r.id as roomid, r.name, b.starttime, b.endtime, b.purpose, b.repetition FROM bookings b, rooms r WHERE b.roomid=r.id && b.userid={$_SESSION['id']} && starttime<=CURRENT_TIMESTAMP ORDER BY b.starttime;";
$result=mysql_query($sql);
$number;
if(!$result)
	die("Data can't be retrieved from database:" . mysql_error());
else
	$number=mysql_num_rows($result);

if(isset($_REQUEST['confirm']))
	{
	if($_REQUEST['confirm']==0)
		header("Location: my_past_bookings.php");
	if($_REQUEST['confirm']==1)
		{
		$sql="DELETE FROM bookings WHERE userid={$_SESSION['id']} && endtime<=CURRENT_TIMESTAMP;";
		$delete=mysql_query($sql);
		if($delete)
			header("Location: my_past_bookings.php");
		}
	}
?>
<html>
	<head>
		<title>My Bookings</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
			include("navigation.php");
		?>
		<h1 class="heading" style="margin-left:300px;">You have <?php echo $number==0?"no":"the following"; ?> past bookings.</h1>
		<?php
			if($number==0)
				goto skip_table;
			echo "<center>
					<p style=\"font-size:23px;color:#00266D;\"><strong><u>My past bookings</u></strong></p>
					<table id=\"bookings\" border=\"1\" cellpadding=\"10\" cellspacing=\"0\">
					<thead>
						<tr class=\"t_heading\">
							<th>Booking ID</th>
							<th>Room Name/Number</th>
							<th>Date</th>
							<th>From</th>
							<th>To</th>
							<th>Purpose</th>
							<th>Repetition</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>";
			while($row=mysql_fetch_array($result))
				{
				echo "<tr>";
				echo "<td><a href=\"booking.php?bookingid={$row['bookingid']}\" target=\"_blank\"	>{$row['bookingid']}</a></td>";
				echo "<td><a href=\"room.php?roomid={$row['roomid']}\" target=\"_blank\" >{$row['name']}</a></td>";
				echo "<td>" . dateFrom($row['starttime']) . "</td>";
				echo "<td>" . timeFrom($row['starttime']) . "</td>";
				echo "<td>" . timeFrom($row['endtime']) . "</td>";
				echo "<td>{$row['purpose']}</td>";
				echo "<td>{$row['repetition']}</td>";
				echo "<td><a href=\"delete_booking.php?bookingid={$row['bookingid']}\" target=\"_blank\" >Delete</a></td>";
				echo "</tr>";
				}				
			echo "	</tbody>
				</table></center>";
			?>
				<br/>
				<center>
						<strong>Are you sure you want to delete all your past bookings?</strong><br/>
						<a href="delete_past_bookings.php?confirm=1">Yes</a>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
						<a href="delete_past_bookings.php?confirm=0">No</a>
				</center>
				
				<?php
			
			skip_table:
		?>
	</div>
	</body>
</html>