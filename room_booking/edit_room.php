<?php
include_once("is_logged.php");
if($_SESSION['level']!="admin")
	header("Location: home.php");
if(!isset($_REQUEST['roomid']))
	header("Location: rooms.php");
include_once("functions.php");
$room=roomDetails($_REQUEST['roomid']);
if($room==null)
	header("Location: rooms.php");
$error;
if(isset($_POST['update_room']))
	{
	if(!$_POST['name'])
		$error="Please enter a room name.";
	else
		{
		if(!$_POST['capacity'])
			$error="Please enter the capacity of the room.";
		else
			{
			$exist=roomExists($_POST['name']);
			if($exist!=$room['id'] && $exist!=0)
				$error="Room {$_POST['name']} already exists. Please enter a new room name.";
			else
				{
				$sql = "UPDATE rooms SET ";
				$sql .= "name=\"{$_POST['name']}\"";
				$sql .= ", capacity={$_POST['capacity']}";
				$sql .= ", projector={$_POST['projector']}";
				$sql .= " WHERE id={$room['id']};";
				$update=mysql_query($sql);
				if(!$update)
					$error="Unable to update room details. Please try again";
				else
					{
						?>
							<script type="text/javascript">
								alert("Details successfully updated");
							</script>
						<?php
						header("Location: room.php?roomid={$room['id']}");
						exit();								
					}
				}
			}
		}
	
	}
?>
<html>
	<head>
		<title>Edit <?php echo $room['name']; ?></title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php
		include("header.php");
		include("navigation.php");
		?>
		<h1 align="center">Edit details of <?php echo $room['name']; ?></h1>
		<div class="form">
			<form action="edit_room.php" method="post">
			<input type="hidden" name="roomid" value="<?php echo $room['id']; ?>" />
			<table class="form_table">
				<tr>
					<th>Name:</th>
					<td><input type="text" name="name" value="<?php echo isset($_POST['name'])?$_POST['name']:$room['name']; ?>"></td>
				</tr>
				
				<tr>
					<th>Capacity:</th>
					<td><input type="number" name="capacity" min="1" value="<?php echo (isset($_POST['capacity']))?$_POST['capacity']:$room['capacity']; ?>"></td>
				</tr>
			
				<tr>
					<th>Projector:</th>
					<td>
					<input type="radio" name="projector" value="1" <?php if((isset($_POST['projector']) && $_POST['projector']=="1") || (!isset($_POST['projector']) && $room['projector']=="1")) echo "checked=\"checked\""; ?> >Yes
					<input type="radio" name="projector" value="0" <?php if((isset($_POST['projector']) && $_POST['projector']=="0") || (!isset($_POST['projector']) && $room['projector']=="0")) echo "checked=\"checked\""; ?> >No
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="update_room" value="Update"></td>
				</tr>
			</table>
			</form>
			<?php if(isset($error)) echo "<p style=\"color:#000000\";>{$error}</p>"; ?>
		</div>
		</div>
	</body>
</html>