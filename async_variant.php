<?php
	session_start();
	include('globals.php');
	
	$usr_id = $_SESSION['usr_id'];
	if($usr_id == '')
	{
		echo '<BR /><BR /><font size="+3">You must login first</font>';
		return;
	}
	
	$arch = $_POST['arch'];
	
	mysql_connect($mysql_server,$mysql_user,$mysql_passwd) or die(mysql_error());	
	mysql_select_db($mysql_db) or die(mysql_error());
	
	$response = mysql_query("select variant from arch_variant where arch='$arch'") or die(mysql_error());
	$record_count = mysql_num_rows($response);
	if($record_count != 0)
	{
		echo "Choisissez l'une parmi les variantes de l'architecture $arch.";
		echo "<BR />";
		echo "<SELECT name=\"cmb_variant\">";
		while($record = mysql_fetch_array($response))
		{
			echo "<OPTION>".$record['variant']."</OPTION>";
		}
		echo "</SELECT><BR /><BR />";
	}
	mysql_close() or die(mysql_error());
?>