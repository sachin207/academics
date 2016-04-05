<?php
include_once("connect_database.php");
function isFree($roomid, $starttime, $endtime, $skip=0)
	{
	$sql="SELECT id, starttime, endtime, repetition FROM bookings WHERE roomid={$roomid};";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result))
		{
		if($row['id']==$skip)
			goto cont;
		switch($row['repetition'])
			{
			case "None":	if($endtime>$row['starttime'] && $starttime<$row['endtime'])
								return $row['id'];
							break;
			case "Daily":	if(DATE("Y-m-d", STRTOTIME($starttime))>=DATE("Y-m-d", STRTOTIME($row['starttime'])) && DATE("H:i", STRTOTIME($endtime))>DATE("H:i", STRTOTIME($row['starttime'])) && DATE("H:i", STRTOTIME($starttime))<DATE("H:i", STRTOTIME($row['endtime'])))
								return $row['id'];
							break;
			case "Weekly":	if(DATE("w", STRTOTIME($starttime))==DATE("w", STRTOTIME($row['starttime'])) && DATE("Y-m-d", STRTOTIME($starttime))>=DATE("Y-m-d", STRTOTIME($row['starttime'])) && DATE("H:i", STRTOTIME($endtime))>DATE("H:i", STRTOTIME($row['starttime'])) && DATE("H:i", STRTOTIME($starttime))<DATE("H:i", STRTOTIME($row['endtime'])))
								return $row['id'];
							break;
			case "Weekdays":	$day_saved=DATE("w", STRTOTIME($row['starttime']));
								$day_new=DATE("w", STRTOTIME($starttime));
								if($day_saved!=0 && $day_saved!=6 && $day_new!=0 && $day_new!=6 && DATE("Y-m-d", STRTOTIME($starttime))>=DATE("Y-m-d", STRTOTIME($row['starttime'])) && DATE("H:i", STRTOTIME($endtime))>DATE("H:i", STRTOTIME($row['starttime'])) && DATE("H:i", STRTOTIME($starttime))<DATE("H:i", STRTOTIME($row['endtime'])))
									return $row['id'];
								break;
			}
		cont:
		}
	return 0;
	}
function bookingDetails($bookingid)
	{
	$sql="SELECT b.id as bookingid, b.userid, b.roomid, b.bookingtime, b.lastupdate, b.starttime, b.endtime, timediff(b.endtime,b.starttime) as duration, b.purpose, b.repetition, r.name as roomname, u.name as username FROM bookings b, rooms r, users u WHERE b.id={$bookingid} && b.userid=u.id && b.roomid=r.id;";
	$result=mysql_query($sql);
	if($row=mysql_fetch_array($result))
		return $row;
	return null;
	}
function userDetails($userid)
	{
	$sql="SELECT id, name, phone, email, level FROM users WHERE id={$userid};";
	$result=mysql_query($sql);
	if($row=mysql_fetch_array($result))
		return $row;
	return null;
	}
function roomDetails($roomid)
	{
	$sql="SELECT * FROM rooms WHERE id={$roomid};";
	$result=mysql_query($sql);
	if($row=mysql_fetch_array($result))
		return $row;
	return null;
	}
function roomExists($roomname)
	{
	$sql="SELECT id FROM rooms WHERE name=\"{$roomname}\";";
	$result=mysql_query($sql);
	if($row=mysql_fetch_array($result))
		return $row['id'];
	return 0;
	}
function searchBooking($query)
	{
	$query=implode("|",explode(" ",$query));
	$sql="SELECT b.id as bookingid, b.userid, b.roomid, b.starttime, b.endtime, b.purpose, r.name as roomname, u.name as username FROM bookings b, rooms r, users u WHERE (b.purpose regexp \"{$query}\" || r.name regexp \"{$query}\" || u.name regexp \"{$query}\") && b.userid=u.id && b.roomid=r.id ORDER BY b.starttime desc;";
	$result=mysql_query($sql);
	return $result;
	}
function dateFrom($string)
	{
	return DATE("jS F, Y", STRTOTIME($string));
	}
function timeFrom($string)
	{
	return DATE("h:i A", STRTOTIME($string));
	}
function addDays($time, $days='1')
	{
	$newtime = DATE('Y-m-d H:i:s', STRTOTIME("+$days days", STRTOTIME($time)));
	return $newtime;
	}
function updateBookings()
	{
	$sql="SELECT id, starttime, endtime, repetition FROM bookings WHERE endtime<=CURRENT_TIMESTAMP && repetition!=\"None\";";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result))
		{
		$newstarttime=NULL;
		$newendtime=NULL;
		switch($row['repetition'])
			{
			case "Daily":
							$newstarttime=DATE("Y-m-d H:i:s", STRTOTIME(DATE("Y-m-d ", time()) . DATE("H:i:s", STRTOTIME($row['starttime']))));
							$newendtime=DATE("Y-m-d H:i:s", STRTOTIME(DATE("Y-m-d ", time()) . DATE("H:i:s", STRTOTIME($row['endtime']))));
							if($newendtime<DATE("Y-m-d H:i:s", time()))
								{
								$newstarttime=addDays($newstarttime);
								$newendtime=addDays($newendtime);
								}
							break;
			case "Weekly":
							$day=DATE("w", STRTOTIME($row['starttime']));
							$newstarttime=DATE("Y-m-d H:i:s", STRTOTIME(DATE("Y-m-d ", time()) . DATE("H:i:s", STRTOTIME($row['starttime']))));
							$newendtime=DATE("Y-m-d H:i:s", STRTOTIME(DATE("Y-m-d ", time()) . DATE("H:i:s", STRTOTIME($row['endtime']))));
							if($newendtime<DATE("Y-m-d H:i:s", time()))
								{
								$newstarttime=addDays($newstarttime);
								$newendtime=addDays($newendtime);
								}
							while(DATE("w", STRTOTIME($newstarttime))!=$day)
								{
								$newstarttime=addDays($newstarttime);
								$newendtime=addDays($newendtime);
								}
							break;
			case "Weekdays":
							$newstarttime=DATE("Y-m-d H:i:s", STRTOTIME(DATE("Y-m-d ", time()) . DATE("H:i:s", STRTOTIME($row['starttime']))));
							$newendtime=DATE("Y-m-d H:i:s", STRTOTIME(DATE("Y-m-d ", time()) . DATE("H:i:s", STRTOTIME($row['endtime']))));
							if($newendtime<DATE("Y-m-d H:i:s", time()))
								{
								$newstarttime=addDays($newstarttime);
								$newendtime=addDays($newendtime);
								}
							while(true)
								{
								$day=DATE("w", STRTOTIME($newstarttime));
								if($day!=0 && $day!=6)
									break;
								$newstarttime=addDays($newstarttime);
								$newendtime=addDays($newendtime);
								}
							break;
			}
			$sql="UPDATE bookings SET
					starttime=\"{$newstarttime}\",
					endtime=\"{$newendtime}\"
					WHERE id={$row['id']};";
			$update=mysql_query($sql);
		}
	}
updateBookings();
?>