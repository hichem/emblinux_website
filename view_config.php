<?php
	session_start();
	include('globals.php');
	
	$user_name = $_SESSION['login'];
	if($user_name == '')
	{
		echo '<BR /><BR /><font size="+3">You must login to build toolchains</font>';
		return;
	}
	
	$project_name = $_GET['project'];
	$config_name = $_GET['config'];
?>
<H2>Images et fichiers de configuration</H2><BR />
<?php
	if($handle = opendir("$home/$user_name/projects/$project_name/$config_name"))
	{
		while($file = readdir($handle))
		{
			if(($file != '.') && ($file != '..'))
			{
				echo "<A href=\"home/$user_name/projects/$project_name/$config_name/$file\">$file</A><BR />";
			}
		}
	}
?>