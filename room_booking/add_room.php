<?php
include_once("is_logged.php");
if($_SESSION['level']!="admin")
	header("Location: home.php");
include_once("functions.php");
$error;
if(isset($_POST['add_room']))
	{
	if(!$_POST['name'])
		$error="Please enter a room name.";
	else
		{
		if(!$_POST['capacity'])
			$error="Please enter the capacity of the room.";
		else
			{
			if(roomExists($_POST['name']))
				$error="Room {$_POST['name']} already exists. Please enter a new room name.";
			else
				{
				$sql = "INSERT INTO rooms (name, capacity, projector) VALUES (";
				$sql .= "\"{$_POST['name']}\"";
				$sql .= ", {$_POST['capacity']}";
				$sql .= ", {$_POST['projector']}";
				$sql .= ");";
				$add=mysql_query($sql);
				if(!$add)
					$error="Unable to add room. Please try again";
				else
					$error="Room added successfully.";
				}
			}
		}
	
	}
?>
<html>
	<head>
		<title>Add a room</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php
		include("header.php");
		include("navigation.php");
		?>
		<h1 align="center"> Enter details of the new room. </h1>
		<div class="form" style="margin-left:400px;">
			<form action="add_room.php" method="post">
			<table class="form_table">
				<tr>
					<th>Name:</th>
					<td><input type="text" name="name" value="<?php echo isset($_POST['name'])?$_POST['name']:NULL; ?>"></td>
				</tr>
				
				<tr>
					<th>Capacity:</th>
					<td><input type="number" name="capacity" min="1" value="<?php echo isset($_POST['capacity'])?$_POST['capacity']:50; ?>"></td>
				</tr>
			
				<tr>
					<th>Projector:</th>
					<td>
					<input type="radio" name="projector" value="1" <?php if(!isset($_POST['projector']) || $_POST['projector']==1) echo "checked=\"checked\""; ?> >Yes
					<input type="radio" name="projector" value="0" <?php if(isset($_POST['projector']) && $_POST['projector']==0) echo "checked=\"checked\""; ?> >No
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="add_room" value="Add room"></td>
				</tr>
			</table>
			</form>
			<?php if(isset($error)) echo "<p style=\"color:#000000;\">{$error}</p>"; ?>
		</div>
		</div>
	</body>
</html>