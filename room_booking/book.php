<?php
include_once("is_logged.php");
include_once("functions.php");
include_once("connect_database.php");
$error;
$success;
if(!isset($_REQUEST['roomid']))
	{
	$error="Please select a room first.";
	include("rooms.php");
	exit();
	}
$roomid=$_REQUEST['roomid'];
$roomdetails=roomDetails($roomid);
if($roomdetails==null)
	{
	$error="Room not found. Please select a valid room.";
	include("rooms.php");
	exit();
	}
$date;
$start;
$end;
$purpose;
$repetition;
if(isset($_POST['book']))
	{
	if(!isset($_POST['date']))
		{
		$error="Please enter a date.<br/>";
		}
	else
		{
		if(!isset($_POST['start']))
			{
			$error="Please enter starting time.<br/>";
			}
		else
			{
			if(!isset($_POST['end']))
				{
				$error="Please enter ending time.<br/>";
				}
			else	//if everything is given as input
				{
				$date=$_POST['date'];
				$start=DATE("Y-m-d H:i", STRTOTIME($date . $_POST['start'] . " " . $_POST['startampm']));
				$end=DATE("Y-m-d H:i", STRTOTIME($date . $_POST['end'] . " " . $_POST['endampm']));
				$dayofweek=DATE("w", STRTOTIME($date . $_POST['start'] . " " . $_POST['startampm']));
				if($_POST['repetition']=="Weekdays" && ($dayofweek==0 || $dayofweek==6))
					{
					$error= dateFrom($date . $_POST['start'] . " " . $_POST['startampm']) . " is a " . DATE("l", STRTOTIME($date . $_POST['start'] . " " . $_POST['startampm'])) . ", not a weekday.";
					}
				else
					{
					if($start>=$end)
						{
						$error="Starting time can't be more than ending time<br/>";
						}
					else
						{
						$purpose=$_POST['purpose'];
						$repetition=$_POST['repetition'];
						$isfree=isFree($roomid, $start, $end);
						if($isfree!=0)
							{
							$error="Clashes with booking id: <a href=\"booking.php?bookingid={$isfree}\">" . $isfree . "</a>";
							}
						else
							{
							$sql="INSERT INTO bookings (userid, roomid, lastupdate, starttime, endtime, purpose, repetition) VALUES (";
							$sql .= "\"{$_SESSION['id']}\"";
							$sql .= ", \"{$roomid}\"";
							$sql .= ", CURRENT_TIMESTAMP";
							$sql .= ", \"{$start}\"";
							$sql .= ", \"{$end}\"";
							$sql .= ", \"{$purpose}\"";
							$sql .= ", \"{$repetition}\"";
							$sql .= ");";
							$book=mysql_query($sql);
							if($book)
								{
								$success=$roomdetails['name'] . " successfully booked for " . DATE("jS F, Y", STRTOTIME($start)) . " from " . DATE("h:i A", STRTOTIME($start)) . " to " . DATE("h:i A", STRTOTIME($end));
								$success .= "<br/><a href=\"book.php?roomid={$roomdetails['id']}\" >Click here to book {$roomdetails['name']} again.</a><br/>";
								$success .= "<br/><a href=\"rooms.php\" >Click here to select another room for booking.</a><br/>";
								}
							else
								{
								$error="Booking failed. Please try again";
								}
							
							}
						}
					}
				}
			}
		}
	}

?>
<html>
	<head>
		<title> Book <?php echo $roomdetails['name']; ?> </title>
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
				<td><?php echo $roomdetails['name']; ?></td>
			</tr>
			<tr>
				<th>Capacity:</th>
				<td><?php echo $roomdetails['capacity'] . " students"; ?></td>
			</tr>
			<tr>
				<th>Projector:</th>
				<td><?php echo $roomdetails['projector']==0?"No":"Yes"; ?></td>
			</tr>
		</table>
		<?php if(isset($success)) 
				{
				echo "<p style=\"color:#000000\";>{$success}</p>";
				exit();
				}
		?>
		<h1>Fill in the following details</h1>
		<form id="booking_details" action="book.php" method="post" >
			<table class="booking_form">
			
			<input type="hidden" name="roomid" value="<?php echo $roomid ?>" />
			<tr>
			<th>Date:</th>
			<td><input type="date" name="date" value="<?php echo isset($_POST['date'])?$_POST['date']:date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>"/></td>
			</tr>
			
			<tr>
			<th>Starting time(hh:mm):</th>
			<td><input type="text" name="start"  value="<?php echo isset($_POST['start'])?$_POST['start']:'08:30'; ?>"/>
			<input type="radio" name="startampm" value="am" <?php if(!isset($_POST['startampm']) || $_POST['startampm']=='am') echo 'checked=\"checked\"'; ?> >A.M.
			<input type="radio" name="startampm" value="pm" <?php if(isset($_POST['startampm']) && $_POST['startampm']=='pm') echo 'checked=\"checked\"'; ?> >P.M.
			</td>
			</tr>
			
			<tr>
			<th>Ending time(hh:mm)</th>
			<td>
			<input type="text" name="end" value="<?php echo isset($_POST['end'])?$_POST['end']:'10:00'; ?>"/>
			<input type="radio" name="endampm" value="am" <?php if(!isset($_POST['endampm']) || $_POST['endampm']=='am') echo 'checked=\"checked\"'; ?> >A.M.
			<input type="radio" name="endampm" value="pm" <?php if(isset($_POST['endampm']) && $_POST['endampm']=='pm') echo 'checked=\"checked\"'; ?> >P.M.
			</td>
			</tr>
			
			<tr>
			<th>Purpose:</th>
			<td>
			<textarea name="purpose" rows="4" cols="50" ><?php if(isset($_POST['purpose'])) echo $_POST['purpose']; ?></textarea></td>
			</tr>
			
			<tr>
			<th>Repetition:</th>
			<td>
			<select name="repetition">
				<option value="None" <?php /*default selected is None*/ if(!isset($_POST['repetition']) || $_POST['repetition']=='None') echo 'selected'; ?> >None</option>
				<option value="Daily" <?php if(isset($_POST['repetition']) && $_POST['repetition']=='Daily') echo 'selected'; ?> >Daily</option>
				<option value="Weekdays" <?php if(isset($_POST['repetition']) && $_POST['repetition']=='Weekdays') echo 'selected'; ?> >Weekdays</option>
				<option value="Weekly" <?php if(isset($_POST['repetition']) && $_POST['repetition']=='Weekly') echo 'selected'; ?> >Weekly</option>
			</select>
			</td>
			</tr>
			
			<tr>
			<td colspan="2" align="center"><input type="submit" name="book" value="Book"  style="font-size:15px;"/></td>
			</tr>
			</table>
		</form>
		<?php if(isset($error)) echo "<p style=\"color:#000000;font-size:16px\";>{$error}</p>"; ?>
		</center>
	</body>
</html>