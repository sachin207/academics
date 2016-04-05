<?php
	include_once("is_logged.php");
	if(!isset($_REQUEST['bookingid']))
		header("Location: my_bookings.php");
	include_once("functions.php");
	$booking=bookingDetails($_REQUEST['bookingid']);
	if($booking==NULL || $booking['userid']!=$_SESSION['id'] || $booking['starttime']<DATE("Y-m-d h:i:s", time()))
		header("Location: my_bookings.php");
	if(isset($_POST['update']))
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
						$isfree=isFree($booking['roomid'], $start, $end, $booking['bookingid']);
						if($isfree!=0)
							{
							$error="Clashes with booking id: <a href=\"booking.php?bookingid={$isfree}\">" . $isfree . "</a>";
							}
						else
							{
							$sql="UPDATE bookings SET ";
							$sql .= "roomid=\"{$booking['roomid']}\", ";
							$sql .= "starttime=\"{$start}\", ";
							$sql .= "endtime=\"{$end}\", ";
							$sql .= "purpose=\"{$purpose}\", ";
							$sql .= "repetition=\"{$repetition}\", ";
							$sql .= "lastupdate=CURRENT_TIMESTAMP ";
							$sql .= "WHERE id={$_REQUEST['bookingid']};";
							$book=mysql_query($sql);
							if($book)
								{
								?>
								<script type="text/javascript">
								alert("Details successfully updated");
								</script>
								<?php
								header("Location: my_bookings.php");
								exit();								
								}
							else
								{
								$error="Booking update failed. Please try again";
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
		<title>Edit Booking</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
			include("navigation.php");
		?>
		<h1 class="heading"><b>Edit booking</b></h1>
		<form id="edit_details" action="edit_booking.php" method="post">
			<input type="hidden" name="bookingid" value="<?php if(isset($_REQUEST['bookingid'])) echo $_REQUEST['bookingid']; ?>" />
			<center><table id="form_table" border="0" cellspacing="5" cellpadding="5">
				<tr>
					<th>Room:</th>
					<td>
					<select name="room">
					<?php
					$sql="SELECT id, name FROM rooms;";
					$result=mysql_query($sql);
					while($row=mysql_fetch_array($result))
						{
						echo "<option value=\"{$row['id']}\" ";
						if((isset($_POST['room']) && $_POST['room']==$row['id']) || (!isset($_POST['room']) && $booking['roomid']==$row['id']))
							echo "selected ";
						echo ">{$row['name']}</option>";
						}
					?>
					</select>
					</td>
				</tr>
				
				<tr>
					<th>Date:</th>
					<td><input type="date" name="date" value="<?php if(isset($_POST['date']) && $_POST['date']!=NULL) echo $_POST['date']; else echo DATE("Y-m-d", STRTOTIME($booking['starttime'])); ?>" min="<?php echo date("Y-m-d"); ?>" /></td>
				</tr>
				<tr>
					<th>From:</th>
					<td><input type="text" name="start" value="<?php if(isset($_POST['start']) && $_POST['start']!=NULL) echo $_POST['start']; else echo DATE("h:i", STRTOTIME($booking['starttime'])); ?>" />
					<input type="radio" name="startampm" value="am" <?php if((isset($_POST['startampm']) && $_POST['startampm']=='am') || (!isset($_POST['startampm']) && DATE("a", STRTOTIME($booking['starttime']))=="am")) echo 'checked=\"checked\"'; ?> >A.M.
					<input type="radio" name="startampm" value="pm" <?php if((isset($_POST['startampm']) && $_POST['startampm']=='pm') || (!isset($_POST['startampm']) && DATE("a", STRTOTIME($booking['starttime']))=="pm")) echo 'checked=\"checked\"'; ?> >P.M.
					</td>
				</tr>
				<tr>
					<th>To:</th>
					<td><input type="text" name="end" value="<?php if(isset($_POST['end']) && $_POST['end']!=NULL) echo $_POST['end']; else echo DATE("h:i", STRTOTIME($booking['endtime'])); ?>" />
					<input type="radio" name="endampm" value="am" <?php if((isset($_POST['endampm']) && $_POST['endampm']=='am') || (!isset($_POST['endampm']) && DATE("a", STRTOTIME($booking['endtime']))=="am")) echo 'checked=\"checked\"'; ?> >A.M.
					<input type="radio" name="endampm" value="pm" <?php if((isset($_POST['endampm']) && $_POST['endampm']=='pm') || (!isset($_POST['endampm']) && DATE("a", STRTOTIME($booking['endtime']))=="pm")) echo 'checked=\"checked\"'; ?> >P.M.
					</td>
				</tr>
				
				<tr>
				<th>Purpose:</th>
				<td>
				<textarea name="purpose" rows="4" cols="50" ><?php if(isset($_POST['purpose'])) echo $_POST['purpose']; else echo $booking['purpose']; ?></textarea></td>
				</tr>
			
				<tr>
				<th>Repetition:</th>
				<td>
				<select name="repetition">
					<option value="None" <?php /*default selected is None*/ if((isset($_POST['repetition']) && $_POST['repetition']=='None') || (!isset($_POST['repetition']) && $booking['repetition']=="None")) echo 'selected'; ?> >None</option>
					<option value="Daily" <?php if((isset($_POST['repetition']) && $_POST['repetition']=='Daily') || (!isset($_POST['repetition']) && $booking['repetition']=="Daily")) echo 'selected'; ?> >Daily</option>
					<option value="Weekdays" <?php if((isset($_POST['repetition']) && $_POST['repetition']=='Weekdays') || (!isset($_POST['repetition']) && $booking['repetition']=="Weekdays")) echo 'selected'; ?> >Weekdays</option>
					<option value="Weekly" <?php if((isset($_POST['repetition']) && $_POST['repetition']=='Weekly') || (!isset($_POST['repetition']) && $booking['repetition']=="Weekly")) echo 'selected'; ?> >Weekly</option>
				</select>
				</td>
				</tr>
			
				<tr>
					<td colspan="2" align="center"><input type="submit" name="update" value="Save" style="font-size:18px"/></td>
					<!--<td><input type="reset" name="reset" value="Reset" /></td>-->
				</tr>
			</table>
		</form>
		<?php if(isset($error)) echo "<p style=\"color:#000000\";>{$error}</p>"; ?>
		</center>
	</div>
	</body>
</html>