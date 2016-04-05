<?php
include("is_logged.php");
include("connect_database.php");
$error;
if(isset($_POST['confirm']) && $_POST['confirm']=="Confirm")
	{
	if(!isset($_POST['oldp']) || $_POST['oldp']==NULL)
		{
		$error="Please enter your current password.";
		}
	else
		{
		if(!isset($_POST['newp1']) || $_POST['newp1']==NULL)
			{
			$error="Please enter the new password.";
			}
		else
			{
			if(!isset($_POST['newp2']) || $_POST['newp2']==NULL)
				{
				$error="Please confirm your password.";
				}
			else
				{
				if($_POST['newp1']!=$_POST['newp2'])
					{
					$error="Passwords do not match.";
					}
				else
					{
					$sql="SELECT password(\"{$_POST['oldp']}\") as encoded;";
					$encoded=mysql_fetch_array(mysql_query($sql));
					$encoded=$encoded['encoded'];
					$sql="SELECT password FROM users WHERE id={$_SESSION['id']};";
					$saved=mysql_fetch_array(mysql_query($sql));
					$saved=$saved['password'];
					if($saved!=$encoded)
						{
						$error="Current password incorrect.";
						}
					else
						{
						$sql="UPDATE users
								SET password=password(\"{$_POST['newp1']}\")
								WHERE id={$_SESSION['id']};";
						$update=mysql_query($sql);
						if(!$update)
							{
							$error="Could not change your password. Please try again.";
							}
						else
							{
							?>
							<script type="text/javascript">
								alert("Password changed successfully.");
							</script>
							<?php
							header("Location: profile.php");
							exit();
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
		<title>Change your password</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
			include("navigation.php");
		?>
		<h1 class="heading">Change Your Password</h1>
		<center>
		<form id="change_password" action="change_password.php" method="post">
			<table id="form_table" border="0" cellpadding="5" cellspacing="5">
				<tr>
					<th>Current Password:</th>
					<td>
						<input type="password" name="oldp" value="" />
					</td>
				</tr>
				<tr>
					<th>New Password:</th>
					<td>
						<input type="password" name="newp1" value="" />
					</td>
				</tr>
				<tr>
					<th>Confirm New Password:</th>
					<td>
						<input type="password" name="newp2" value="" />
					</td>
				</tr>
				<tr>
					<th colspan="2" align="center">
						<input type="submit" name="confirm" value="Confirm" style="font-size:15px"/>
					</th>
				</tr>
			</table>
		</form>
		<?php if(isset($error)) echo "<p style=\"color:#000000\";>{$error}</p>"; ?>
		</center>
	</div>
	</body>
</html>