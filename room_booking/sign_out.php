<?php
	session_start();
	if(isset($_SESSION['name']))
		{
		session_destroy();
		header("Refresh: 1;url=sign_in.php?s=out");
		echo "Signed out successfully.<br/>";
		exit();
		}
	header("Location: sign_in.php");
	exit();
?>