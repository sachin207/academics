<?php
	include_once("is_logged.php");
	include_once("connect_database.php");
	
	//building search query
	$sql="SELECT * FROM rooms";
	$searched=0;
	if(isset($_GET['name']) || isset($_GET['mincap']) || isset($_GET['maxcap']) || isset($_GET['projector']))
		{
		$searched=1;
		$sql .= " WHERE";
		$prev = 0;
		if(isset($_GET['name']))
			{
			$sql .= " name LIKE '%{$_GET['name']}%'";
			$prev = 1;
			}
		if(isset($_GET['mincap']) && $_GET['mincap']!=NULL)
			{
			if($prev==1)
				$sql .= " &&";
			$sql .= " capacity>={$_GET['mincap']}";
			$prev = 1;
			}
		if(isset($_GET['maxcap']) && $_GET['maxcap']!=NULL)
			{
			if($prev==1)
				$sql .= " &&";
			$sql .= " capacity<={$_GET['maxcap']}";
			$prev = 1;
			}
		if(isset($_GET['projector']))
			{
			if($prev==1)
				$sql .= " &&";
			$sql .= " projector={$_GET['projector']}";
			$prev = 1;
			}
		}
	$sql .= " ORDER BY capacity desc;";
	$search=mysql_query($sql);
	$number;
	if(!$search)
		die("Data can't be retrieved from database:" . mysql_error());
	else
		$number=mysql_num_rows($search);
?>
<html>
	<head>
		<title> Rooms Found </title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
			include("navigation.php");
		?>
		<div class="search_room_form">
			<form action="rooms.php" method="get">
				<center><table>
					<caption style="font-size:22px;"><strong><u><?php echo $searched==0?"S":"Modify your s"; ?>earch for a room</u></strong></caption>
					<tr>
						<th>Name:</th>
						<td><input type="text" name="name" value="<?php echo isset($_GET['name'])?$_GET['name']:NULL; ?>"/></td>
					</tr>
					<tr>
						<th>Minimum Capacity:</th>
						<td><input type="number" name="mincap" min=1 value="<?php echo isset($_GET['mincap'])?$_GET['mincap']:NULL; ?>"/></td>
					</tr>
					<tr>
						<th>Maximum Capacity:</th>
						<td><input type="number" name="maxcap" min=1 value="<?php echo isset($_GET['maxcap'])?$_GET['maxcap']:NULL; ?>"/></td>
					</tr>
					<tr>
						<th>Projector</th>
						<td>
						<input type="radio" name="projector" value="1" <?php if(isset($_GET['projector']) && $_GET['projector']==1) echo "checked=\"checked\""; ?> >Yes
						<input type="radio" name="projector" value="0" <?php if(isset($_GET['projector']) && $_GET['projector']==0) echo "checked=\"checked\""; ?> >No
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="search" value="Search">
					</tr>
				</table></center>
			</form>
		</div>
		<?php
			if($searched==0)
				goto skip_table;
		?>
		<h1 class="heading"> <?php echo $number==0?"No":"Following"; ?> rooms were found. </h1>
		<?php
			if($number==0)
				goto skip_table;
			echo "<center><table class=\"table\" id=\"search_list\" border=\"1\" cellpadding=\"10\" cellspacing=\"0\">
					<caption> Search results </caption>
					<thead>
						<tr class=\"t_heading\">
							<th>Room Name/Number</th>
							<th>Capacity</th>
							<th>Projector</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>";
					
			while($row = mysql_fetch_array($search))
				{
				echo "<tr class=\"t_content\">";
				echo "<td><a href=\"room.php?roomid={$row['id']}\" style=\"text-decoration:none;\" target=\"_blank\" >{$row['name']}</a></td>";
				echo "<td>{$row['capacity']}</td>";
				echo "<td>";
				echo $row['projector']==0?"No":"Yes";
				echo "</td>";
				echo "<td><a href=\"book.php?roomid={$row['id']}\" target=\"_blank\">Book</a>";
				if($_SESSION['level']=="admin")
					echo "/<a href=\"edit_room.php?roomid={$row['id']}\">Edit</a>";
				echo "</td>";
				echo "</tr>";
				}
			echo "	</tbody>
				</table></center>";
			skip_table:
		?>
		</div>
	</div>
	</body>
</html>