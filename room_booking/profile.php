<?php
include_once("is_logged.php");
if(!isset($_REQUEST['userid']))
	{
	header("Location: profile.php?userid={$_SESSION['id']}");
	exit();
	}
include_once("functions.php");
$user=userDetails($_REQUEST['userid']);
if($user==null)
	{
	header("Location: profile.php?userid={$_SESSION['id']}");
	exit();
	}
?>
<html>
	<head>
		<title><?php echo $user['name']; ?></title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
			include("navigation.php");
		?>
		<h1 class="heading"><b><?php echo $user['name'] . "'s profile"; ?></b></h1>
		<center>
		<table id="form_table" border="0" cellspacing="5" cellpadding="5">
			
			<tr>
				<th>Name:</th>
				<td><?php echo $user['name']; ?></td>
			</tr>
			<tr>
				<th>Phone Number:</th>
				<td><?php echo $user['phone']; ?></td>
			</tr>
			<tr>
				<th>Roll Number:</th>
				<td><?php echo explode("@",$user['email'])[0]; ?></td>
			</tr>
			<tr>
				<th>Email:</th>
				<td><?php echo "<a href=\"mailto:{$user['email']}\">{$user['email']}</a>"; ?></td>
			</tr>
		
		<?php
			for($i=0;$i<5;$i++)
				echo "<tr></tr>";
			if($user['id']==$_SESSION['id'])
				echo "<tr>
						<td colspan=\"2\" align=\"center\">
							<a href=\"edit_profile.php\" style=\"text-decoration:none;\"><strong>Edit Profile</strong></a>
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" align=\"center\">
							<a href=\"change_password.php\" style=\"text-decoration:none;\"><strong>Change Password</strong></a>
						</td>
					</tr>";
		?>
		</table>
		</center>
		</div>
	</body>
</html>
