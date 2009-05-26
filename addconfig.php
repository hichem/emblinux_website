<?php
	session_start();
	include('globals.php');
	mysql_connect($mysql_server,$mysql_user,$mysql_passwd) or die(mysql_error());	
	mysql_select_db($mysql_db) or die(mysql_error());
	
	$usr_id = $_SESSION['usr_id'];
	if($usr_id == '')
	{
		echo '<BR /><BR /><font size="+3">You must login first</font>';
		return;
	}
	
	$project = $_GET['project'];

	//Security check to see whether the user has the permission to access the page
	$response=mysql_query("select * from project where user_id='".$usr_id."' and id='".$project."'") or die(mysql_error());
	$record_count = mysql_num_rows($response);
	if($record_count == 0)
	{
		echo '<BR /><BR /><font size="+3">You are not allowed to view this page</font>';
		return;
	}
	else
	{
		$record = mysql_fetch_array($response);
		$arch = $record['architecture'];
		$variant = $record['variant'];
		$project_name = $record['title'];
	}
	
	if((! empty($_POST)) && ($_POST['config_name'] == ''))
	{
		echo '<font color="red">Vous devez donner un nom à la configuration</font>';
	}
	elseif (! empty($_POST))
	{
		$config_name = htmlspecialchars($_POST['config_name']);
		$toolchain = htmlspecialchars($_POST['cmb_toolchain']);
		$kernel_version = htmlspecialchars($_POST['cmb_kernel_version']);
		$kernel_config = htmlspecialchars($_POST['cmb_kernel_config']);
		$rtsolution = htmlspecialchars($_POST['cmb_rtsolution']);
		$rtpatch = htmlspecialchars($_POST['cmb_rtpatch']);
		$user_name = $_SESSION['login'];
		
		if(is_dir("$home/$user_name/projects/$project_name/$config_name"))
		{
			echo "<FONT color=\"red\" size=\"+1\">Une configuration avec un nom pareil existe déjà. Choisissez en un autre.</FONT>";
		}
		else
		{
			if($rtpatch == '')
			{
				$rtpatch = 'none';
			}
			
			//Install the Vanilla Linux (Without any RT patch)
			if(! is_dir("$home/$user_name/projects/$project_name/vanilla"))
			{
				mysql_query("insert into configuration values ('','".$project."','vanilla','".$toolchain."','".preg_replace('/.*\/configs\/(.*)_defconfig/',"$1",$kernel_config)."','".$rtsolution."','Pending','','".$kernel_version."' )") or die (mysql_error());
				system("$perl $work_dir/adduser.pl add -c ".$user_name." ".$project_name." vanilla &");
				system("$ts $perl $work_dir/build_system.pl $arch $toolchain $kernel_version $kernel_config none $home/$user_name/projects/$project_name/vanilla");
				if(! $f = fopen("$home/$user_name/projects/$project_name/vanilla/build_command",'w'))
				{
					print 'Can not create the command file';
					return;
				}
				fwrite($f, "$perl $work_dir/build_system.pl $arch $toolchain $kernel_version ". $kernel_config." $rtpatch $home/$user_name/projects/$project_name/vanilla");
				fclose($f);
			}
			
			mysql_query("insert into configuration values ('','".$project."','".$config_name."','".$toolchain."','".preg_replace('/.*\/configs\/(.*)_defconfig/',"$1",$kernel_config)."','".$rtsolution."','Pending','','".$kernel_version."')") or die (mysql_error());
			system("$perl $work_dir/adduser.pl add -c ".$user_name." ".$project_name." ".$config_name." &");
			system("$ts $perl $work_dir/build_system.pl $arch $toolchain $kernel_version $kernel_config $rtpatch $home/$user_name/projects/$project_name/$config_name");
			if(! $f = fopen("$home/$user_name/projects/$project_name/$config_name/build_command",'w'))
			{
				print 'Can not create the command file';
				return;
			}
			fwrite($f, "$perl $work_dir/build_system.pl $arch $toolchain $kernel_version ". $kernel_config." $rtpatch $home/$user_name/projects/$project_name/$config_name");
			fclose($f);
			mysql_close() or die (mysql_error());
			echo '<font size="+1">Votre demande a été transmise</font><BR />';
			echo '<FONT size="+1">Cliquer <A href="index.php?page=config_project&project='.$project.'">ici</A> pour revenir aux configurations de ce projet</FONT>';
			return;
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
	function popitup(url)
	{
		newwindow=window.open(url,'name','height=500,width=600,scrollbars');
		if (window.focus)
		{
			newwindow.focus();
		}
		return false;
	}
	function req_patches()
	{
		send_request('cmb_rtsolution='+document.form1.cmb_rtsolution.value+'&cmb_kernel_version='+document.form1.cmb_kernel_version.value+'&arch='+document.form1.arch.value,'async_rtconfig.php','post','async_rtconfig');
	}
</SCRIPT>
<H2>Nouvelle configuration</H2>
<H4>Architecture cible : <?php echo $arch;if($variant != ''){echo " ($variant)";} ?></H4>
<FORM name="form1" method="POST" action="<?php echo $PHP_SELF;?>">
	<LABEL>Donnez un nom à cette configuration :</LABEL>
	<INPUT type="text"  name="config_name" size="20" value="<?php echo $_POST['config_name'];?>"><BR />
		<DIV class="paragraph">
		<H3>Choix de la chaine de compilation</H3>
		<p align="justify">
		Vous avez ici une liste des chaines de compilation croisée disponibles sur le Vlab qui correspondent à l'architecture cible que vous avez choisie. Vous pouvez choisir celle qui convient le mieux à vos besoins, ou le cas échéant en créer une <A href="index.php?page=toolchain">ici</FONT></A>.
		</p>
		<?php
		     if($handle = opendir("$work_dir/config-toolchains"))
		{
		?>
			<SELECT name="cmb_toolchain">
		<?php
			if($variant != '')
			{
				if(preg_match('/i.86/',$variant))
				{
					$arch_pattern='i.86';
				}
				else
				{
					$arch_pattern = $variant;
				}
			}
			else
			{
				$arch_pattern = $arch;
			}
			while(($file = readdir($handle)) != false)
			{
				$xml_file = preg_replace('/(.*)\.xml/',"$1",$file);
				if(preg_match("/^$arch_pattern.*/", $xml_file))
				{
					echo "<OPTION>".$xml_file."</OPTION>";
				}
			}
			closedir($handle);
		}
		?>
			</SELECT>
			<INPUT type="button" value="Voir la configuration" onclick="popitup('view_toolchain.php?toolchain='+document.form1.cmb_toolchain.value);">
	</DIV>
	<DIV class="paragraph">
		<H3>Fichier de configuration du noyau Linux</H3>
		<P align="justify">
			Vous avez la possibilité de choisir parmi les configurations suivantes celle qui coorespond le mieux à la cartes sur laquelle vous travaillez, ou d'utiliser votre propre fichier de configuration.
		</P><BR />
		<LABEL>Version du noyau Linux</LABEL>
		<SELECT name="cmb_kernel_version" onchange="req_patches();">
			<OPTION>2.6.20</OPTION>
			<OPTION>2.6.21</OPTION>
			<OPTION>2.6.22</OPTION>
			<OPTION>2.6.23</OPTION>
			<OPTION>2.6.24</OPTION>
			<OPTION>2.6.25</OPTION>
			<OPTION>2.6.26</OPTION>
			<OPTION>2.6.27</OPTION>
			<OPTION>2.6.28</OPTION>
		</SELECT><BR />
		<LABEL>Fichier de configuration</LABEL>
		<?php
			$arch_folder=$arch;
			if($arch == 'x86_64')
			{
				$arch_folder='x86';
			}
			$config_dir = "$work_dir/arch/$arch_folder/configs";
			if($handle = opendir($config_dir))
			{
		?>
		<SELECT name="cmb_kernel_config">
		<?php
				while(($file = readdir($handle)) != false)
				{
					if(($file != '.') && ($file != '..'))
					{
						echo "<OPTION value=\"".$config_dir."/".$file."\">".preg_replace('/(.*)_defconfig/',"$1",$file)."</OPTION>";
					}
				}
				closedir($handle);
			}
		?>
		</SELECT>
	</DIV>
	<DIV class="paragraph">
		<H3>Choix de la solution Linux temps réel</H3>
		<P align="justify">Séléctionner dans cette liste l'extension temps réel que vous voulez utiliser ou laissez le choix par défaut si vous voulez seulement construire un système Linux minimale pour votre architecture :</P>
		<SELECT name="cmb_rtsolution" onchange="req_patches();">
			<OPTION value="xenomai">Xenomai</OPTION>
			<OPTION value="rtai">RTAI</OPTION>
			<OPTION value="preempt-rt">Patch Preempt-RT</OPTION>
		</SELECT><BR /><BR />
	</DIV>
	<DIV id="async_rtconfig" class="paragraph">
	</DIV>
	<HR align="left" width="100%">
	<INPUT type="submit" value="Enregistrer">
	<INPUT type="reset" value="Annuler" onclick="<?php echo "window.location='index.php?page=config_project&project=$project'";?>">
	<INPUT type="hidden" name="arch" value="<?php echo $arch; ?>">
</FORM>