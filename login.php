<?php
	session_start();
	include('globals.php');
	
	if(! isset($_POST['txt_login']) || ! isset($_POST['txt_password']))
	{
		$_POST['txt_login']="";
		$_POST['txt_password']="";
	}
	$login=htmlspecialchars($_POST['txt_login']);
	$pass=htmlspecialchars($_POST['txt_password']);
	if(($login == '') || ($pass==''))
	{
		//echo "Le champ est vide";
	}

	mysql_connect($mysql_server,$mysql_user,$mysql_passwd) or die(mysql_error());	
	mysql_select_db($mysql_db) or die(mysql_error());
	$response=mysql_query("select id, login, passwd, email, rights from users where login='".$login."' and passwd='".$pass."'") or die(mysql_error());
	$donnée=mysql_fetch_array($response);
	mysql_close() or die(mysql_error());
	if(! empty($donnée))
	{
		$_SESSION['usr_id']= $donnée['id'];
		$_SESSION['login']=$donnée['login'];
		$_SESSION['email']=$donnée['email'];
		$_SESSION['rights']=$donnée['rights'];
	}
	else
	{
		print 'Vos paramètres de connexion sont incorrect ou vous n\'etes pas encore enregistrés';
	}
	header('location:index.php');
?>