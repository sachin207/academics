<?php
	if(!isset($_SESSION))
		session_start();
	if(!isset($_SESSION['name']))
		{
		header("Refresh: 1;url=sign_in.php");
		echo "You must log in to continue";
		exit();
		}
?>