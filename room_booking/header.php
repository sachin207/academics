<a href="home.php"><img src="head.jpg" alt="Header" style="margin-top:-10px;margin-left:-8px;" width="1366px"></a>
<?php
if(isset($_SESSION['id']))
{
?>
<form class="search_box" id="search" action="search_booking.php" method="get">
	<input type="text" name="q" value="<?php echo isset($_GET['q'])?$_GET['q']:"Search a booking..." ?>" onFocus="if(this.value=='Search a booking...') this.value='';" onBlur="if(this.value=='') this.value='Search a booking...';" />
	<input type="submit" name="search" value="Search"/>
</form>
<?php
}
?>	