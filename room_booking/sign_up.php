<?php
	session_start();
	$error;
	if(isset($_SESSION['name']))
		{
		header("Refresh: 1; url=home.php");
		echo "You need to sign out first to sign up.";
		exit();
		}
	if(isset($_POST['sign_up']))
		{
		include_once("connect_database.php");
		$sql="CREATE TABLE IF NOT EXISTS users (
		id int AUTO_INCREMENT,
		name char(30),
		password text,
		phone char(20),
		email char(30),
		level char(10),
		primary key(id));";
		$crtab=mysql_query($sql);
		if(!$crtab)
			die("Table Creation Failed: " . mysql_error());
		if($_POST['name'] && $_POST['password'] && $_POST['password2'] && $_POST['email'] && $_POST['phone'])
		{
		$name=$_POST['name'];
		$pass=$_POST['password'];
		$pass2=$_POST['password2'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$level=$_POST['level'];
		$sql="SELECT count(email) AS num FROM users WHERE email='{$email}';";
		$num=mysql_fetch_array(mysql_query($sql));
		$num_email=$num['num'];
		$sql="SELECT count(phone) AS num FROM users WHERE phone='{$phone}';";
		$num=mysql_fetch_array(mysql_query($sql));
		$num_phone=$num['num'];
		if($num_email == 0 && $num_phone == 0)
			{
			if($pass == $pass2)
				{
				if(filter_var( $email, FILTER_VALIDATE_EMAIL ))
					{
					$sql="INSERT INTO users (name,password,phone,email,level) VALUES ('";
					$sql .= $name . "', ";
					$sql .= "password('". $pass . "'), '";
					$sql .= $phone . "', '";
					$sql .= $email . "', '";
					$sql .= $level . "');";
					$saveuser = mysql_query($sql);
					if($saveuser)
						{
						?>
						<script type="text/javascript">
						alert("Successfully added new user <?php echo $name; ?>");
						</script>
						<?php
						unset($_POST);
						include("sign_in.php");
						exit();
						}
					else
						$error="Sign Up failed." . mysql_error();
					}
				else
					$error="E-mail ID invalid. Please try again.";
				}
			else
				$error="The passwords don't match. Please enter again";
			}
		else
			{
			if($num_email !=0)
				echo "Email {$email} <b>already in use</b>. Please fill in a new email.";
			else
				echo "Phone number {$phone} <b>already in use</b>. Please fill in a new phone number.";
			}
		}
		else //check whats missing
			{if(!$_POST['name'])
				echo "Please enter your name.";
			elseif(!$_POST['password'])
				echo "Please enter a password.";
			elseif(!$_POST['password2'])
				echo "Please confirm the password.";
			elseif(!$_POST['email'])
				echo "Please enter your e-mail address.";
			elseif(!$_POST['phone'])
				echo "Please enter your phone number.";
			}
		}
?>
<html>
	<head>
		<title> Sign Up! </title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			include("header.php");
		?>
		<center>
		<h1>Welcome New User!</h1>
		
		<h2>Please enter your details below</h2>
		<br/>
		<form action="sign_up.php" method="post">
			<table>
				<tr>
				<th>Name:</th>
				<td><input type="text" name="name" value="<?php echo isset($_POST['name'])?$_POST['name']:NULL; ?>"></td>
				</tr>
				
				<tr>
				<th>E-mail ID:</th>
				<td><input type="email" name="email" value="<?php echo isset($_POST['email'])?$_POST['email']:NULL; ?>"></td>
				</tr>
				
				<tr>
				<th>Phone:</th>
				<td><input type="text" name="phone" value="<?php echo isset($_POST['phone'])?$_POST['phone']:NULL; ?>"></td>
				</tr>
				
				<tr>
				<th>Level:</th>
				<td><select name="level">
				<option value="admin" <?php if(isset($_POST['level']) && $_POST['level']=='admin') echo 'selected'; ?> >Administrator</option>
				<option value="student" <?php /*default selected is student*/ if(!isset($_POST['level']) || $_POST['level']=='student') echo 'selected'; ?>>Student</option>
				<option value="faculty" <?php if(isset($_POST['level']) && $_POST['level']=='faculty') echo 'selected'; ?>>Faculty</option>
				<option value="staff" <?php if(isset($_POST['level']) && $_POST['level']=='staff') echo 'selected'; ?>>Staff</option>
				</select></td>
				</tr>
				
				<tr>
				<th>Password:</th>
				<td><input type="password" name="password"></td>
				</tr>
				
				<tr>
				<th>Confirm Password:</th>
				<td><input type="password" name="password2"></td>
				</tr>
				
				<tr>
				<td colspan="2" align="center">
				<input type="submit" name="sign_up" value="Sign Me Up!">
				</td>
				</tr>
			</table>
			</form>
			<br/>
		<h3>Already a member?</h3>
		<a href="sign_in.php">Click here to sign in.</a>
		</center>
	</body>
</html>