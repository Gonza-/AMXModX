<?php
	session_start();
	
	if($_SESSION['clan_access'] == 1)
	{
		die("Sorry, users do not have access to the admin section.");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Clan API Web Interface by Hawk552</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
	include 'config.php';
	
	if(!isset($_SESSION['clan_id']))
	{
		die("You are not logged in and cannot view this page.");
	}
	
	$user = $_REQUEST['user'];

	$db = mysql_connect ($hostname, $username, $password) or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db($database);
	
	$result = mysql_query("SELECT * FROM $webinterface_table WHERE username='$user'") or die("Could not query table:" . mysql_error());
	if(!mysql_num_rows($result))
	{
		die("No users by that name.");
	}
	
	$access = mysql_result($result,0,"access");
	if($access >= $_SESSION['clan_access'])
	{
		die("You cannot delete someone of equal or greater access to you.");
	}	
	
	$query = "DELETE from $webinterface_table WHERE CONVERT(username using utf8)='" . $user . "'";
	mysql_query($query) or die("Query failed " . mysql_error());
		
	mysql_free_result($result);
	mysql_close($db);
		
	echo 'Member deleted.';
?>
<br><br>
<a href="webadmins.php">Main Page</a><br>
<br>
(c) Hawk552, 2006
</body>
</html>
