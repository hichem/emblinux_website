<?php
	session_start();
	include('globals.php');
	
	if((! empty($_POST)) && (($_POST['title'] == '')||($_POST['description']=='')))
	{
		echo 'Tous les champs doivent etre remplis';
	}
	elseif(! empty($_POST))
	{
		$title = htmlspecialchars($_POST['title']);
		$description = htmlspecialchars($_POST['description']);
		$arch = htmlspecialchars($_POST['cmb_arch']);
		$variant = htmlspecialchars($_POST['cmb_variant']);
		
		mysql_connect($mysql_server,$mysql_user,$mysql_passwd) or die(mysql_error());	
		mysql_select_db($mysql_db) or die(mysql_error());
		$usr_id = $_SESSION['usr_id'];
		$response=mysql_query("select title from project where user_id='".$usr_id."' and title='".$title."'") or die(mysql_error());
		$donnée=mysql_fetch_array($response);	
		if(empty($donnée))
		{
			//Ajouter un nouveau projet
			mysql_query("insert into project values ('','".$usr_id."','".$title."','".$description."','".$arch."','".$variant."','".date("d-m-y")."')") or die (mysql_error());
			$response=mysql_query("select id from project where user_id='$usr_id' and title='$title'");
			$donnée = mysql_fetch_array($response);
			$project_id = $donnée['id'];
			mysql_close() or die(mysql_error());
			system("$perl $work_dir/adduser.pl add -p ".$_SESSION['login']." ".$title." &");
			//$_SESSION['arch']=$arch;
			header("location:index.php?page=addconfig&project=$project_id");
		}
		else
		{
			//Un projet avec le meme nom existe
			mysql_close() or die(mysql_error());
			echo 'Projet existant';
		}
	}
?>
<SCRIPT language="JavaScript">
	function send_request(data, page, method, id)
	{
		if (window.ActiveXObject)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}
		else
		{
			var XhrObj = new XMLHttpRequest();
		}
		
		//définition de l'endroit d'affichage:
		var content = document.getElementById(id);
		
		//Ouverture du fichier en methode POST
		XhrObj.open(method, page);
		
		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText;
		}
		
		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(data);
	}
	function req_variant()
	{
		send_request('cmb_arch='+document.form1.cmb_arch.value,'async_variant.php','post','async_variant');
	}
</SCRIPT>
<FORM name="form1" method="POST" action="index.php?page=start_project">
	<H2>Nouveau projet</H2>
	<LABEL>Titre du projet :</LABEL><BR />
	<INPUT type="text" name="title" size="30" value="<?php echo $title; ?>"><BR /><BR /><BR />
	<LABEL>Description du projet :</LABEL><BR />
	<TEXTAREA name="description" rows="10" cols="40" title="<?php echo $description; ?>"></TEXTAREA><BR /><BR /><BR />
	<LABEL>Architecture cible</LABEL><BR />
	<SELECT name="cmb_arch" onchange="req_variant();">
		<OPTION <?php if(($arch == 'arm')||($arch=='')){echo 'selected="selected"';} ?> value="arm">arm</OPTION>
		<OPTION <?php if($arch == 'alpha'){echo 'selected="selected"';} ?> value="alpha">alpha</OPTION>
		<OPTION <?php if($arch == 'mips'){echo 'selected="selected"';} ?> value="mips">mips</OPTION>
		<OPTION <?php if($arch == 'powerpc'){echo 'selected="selected"';} ?> value="powerpc">powerpc</OPTION>
		<OPTION <?php if($arch == 'sh'){echo 'selected="selected"';} ?> value="sh">SuperH</OPTION>
		<OPTION <?php if($arch == 'x86'){echo 'selected="selected"';} ?> value="x86">x86</OPTION>
		<OPTION <?php if($arch == 'x86_64'){echo 'selected="selected"';} ?> value="x86_64">x86_64</OPTION>
	</SELECT><BR /><BR />
	<SPAN id="async_variant">
	</SPAN>
	<HR>
	<INPUT type="submit" value="Valider">
	<INPUT type="reset" value="Annuler" onclick="window.location='index.php'">
</FORM>