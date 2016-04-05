<?php
	if(!isset($_GET['s']) && !isset($_SESSION))
		session_start();
	if(isset($_SESSION['name']))
		{
		header("Refresh: 1; url=home.php");
		echo "You are already signed in. Redirecting you to home page.";
		//header("Location: home.php");
		exit();
		}
	$error;
	if(isset($_POST['email']))
		{
		if($_POST['password'])
			{
			//Connecting to database
			include_once("connect_database.php");
			$sql="SELECT *,count(email) AS num FROM users WHERE email=\"{$_POST['email']}\";";
			$data=mysql_query($sql);
			if(!$data)
				die("Data can't be retrieved from database:" . mysql_error());
			$data=mysql_fetch_array($data);
			if($data['num']!=0)
				{	$sql="SELECT password(\"{$_POST['password']}\") as encoded;";
					$pass=mysql_fetch_array(mysql_query($sql));
					$pass=$pass['encoded'];
					if($data['password']==$pass)
						{
						session_start();
						$_SESSION['id']=$data['id'];
						$_SESSION['name']=$data['name'];
						$_SESSION['email']=$data['email'];
						$_SESSION['phone']=$data['phone'];
						$_SESSION['password']=$data['password'];
						$_SESSION['level']=$data['level'];
						header("Location: home.php");
						exit();
						}
					else
						$error="Incorrect Password. Try Again.";
				}
			else
				$error="Email {$_POST['email']} doesn't exist in the database.";
			}
		else
			$error="Please enter the password";
		}
?>
<html>
	<head>
		<title> Sign in </title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1 align="center"> Enter your email and password below. </h1>
		<div class="form">
			<form action="sign_in.php" method="post">
			<table class="form_table">
				<tr>
					<th>Email:</th>
					<td><input type="email" name="email" value="<?php echo isset($_POST['email'])?$_POST['email']:NULL; ?>"></td>
				</tr>
				
				<tr>
					<th>Password:</th>
					<td><input type="password" name="password"></td>
				</tr>
			
				<tr>
					<td colspan="2" align="center"><input type="submit" value="Sign In"></td>
				</tr>
			</table>
			</form>
			<center style="margin-left:-220px;"><?php if(isset($error)) echo "<p style=\"color:#000000\";>{$error}</p>"; ?>
			<h3>Not signed up yet?</h3>
			<a href="sign_up.php">Click here to sign up.</a></center>
		</div>
	</body>
</html>