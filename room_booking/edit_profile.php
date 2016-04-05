<?php
include_once("is_logged.php");
include_once("functions.php");
$user;
$error;
if(isset($_POST))
	$user=$_POST;
if(!isset($_POST['update']))	//if form is not submitted
	{
	$user=userDetails($_SESSION['id']);
	}
else
	{
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']))
		{
		if(filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ))
			{
			$sql="SELECT id FROM users WHERE email=\"{$_POST['email']}\" || phone=\"{$_POST['phone']}\";;";
			$result=mysql_query($sql);
			while($row=mysql_fetch_array($result))
				{
				if($row['id'] != $_SESSION['id'])
					{
					$error="Email id or phone already in use by some other user.";
					goto form;
					}
				/* Updating details if everything is fine */
				$sql="UPDATE users
					SET name=\"{$_POST['name']}\",
					email=\"{$_POST['email']}\",
					phone=\"{$_POST['phone']}\"
					WHERE id={$_SESSION['id']};";
				$update_details=mysql_query($sql);
				if($update_details)
					{
					$_SESSION['name']=$_POST['name'];
					$_SESSION['email']=$_POST['email'];
					$_SESSION['phone']=$_POST['phone'];
					$_GET['userid']=$_SESSION['id'];
					$error="Details updated successfully";
					include("profile.php");
					exit();
					}
				$error="Details could not be updated. Please try again.<br/>";
				}
			}
		else
			{
			$error="Invalid Email. Please try again.<br/>";
			}
		}
	}
form:
?>
<html>
	<head>
		<title>Edit Your Profile</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
			include("navigation.php");
		?>
		<h1 class="heading"><b>Update your profile</b></h1>
		<form id="edit_details" action="edit_profile.php" method="post">
			<center><table id="form_table" border="0" cellspacing="5" cellpadding="5">
				<tr>
					<th>Name:</th>
					<td><input type="text" name="name" value="<?php echo $user['name']; ?>" /></td>
				</tr>
				<tr>
					<th>Email ID:</th>
					<td><input type="email" name="email" value="<?php echo $user['email']; ?>" /></td>
				</tr>
				<tr>
					<th>Phone:</th>
					<td><input type="text" name="phone" value="<?php echo $user['phone']; ?>" /></td>
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