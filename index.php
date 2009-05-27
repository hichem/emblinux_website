<?php
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>	 
	  <TITLE>Embedded Linux Virtual Laboratory</TITLE>
	  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	  <link rel="stylesheet" media="screen" type="text/css" title="Exemple" href="site.css" />
	  <link rel="stylesheet" media="screen" type="text/css" title="Exemple" href="css.css" />
  </head>
  <body>
	<DIV id="entete">		
		  <IMG class="logo" src="images/pingouin.png" height="180" width="180" vspace="10">
		  <FONT class="site_name" color="Blue" size="+3">Embedded Linux Virtual Laboratory</FONT>
		  <!--<IMG src="images/nom-site.png" >-->
    	</DIV>
    <br>
	<DIV id="left">
		<DIV class="menu">
			<UL>
				<LI>
					<A href="index.php" title="Accueil">Accueil</A>
				</LI>
			</UL>
		</DIV>
		<DIV class="login">
			<?php
			     if(isset($_SESSION['usr_id']))
			     {
			?>
			<FORM method="POST" action="logout.php">
			<LABEL>Bonjour <?php echo $_SESSION['login']; ?></LABEL><BR /><BR />
			<INPUT type="submit" value="Se déconnecter">
			</FORM>
			<?php
			     }
			     else
			     {
			?>
			<FORM method="POST" action="index.php?page=login">
				<LABEL>Nom d'utilisateur</LABEL><BR />
				<INPUT type="text" name="txt_login" size="15"><BR />
				<LABEL>Mot de passe</LABEL><BR />
				<INPUT type="password" name="txt_password" size="15"><BR />
				<INPUT type="submit" size="10" value="Se connecter"><BR />
				<A href="index.php?page=register"><FONT size="-1">S'enregistrer</FONT></A><BR />
				<A href="index.php?page=reset_password"><FONT size="-1">Mot de passe oublié ?</FONT></A>
			</FORM>
			<?php
			     }
			?>
			
		</DIV>
		<?php
			if($_SESSION['rights'] == 'admin')
			{
		?>
		<DIV class="control_panel">
			<LABEL>Panneau de controle</LABEL><BR />
			<UL>
				<LI>
					<A href="index.php?page=jobs">Taches en cours</A>
				</LI>
				<LI>
					<A href="index.php">Extensions temps réel</A>
				</LI>
			</UL>
		</DIV>
		<?php
			}
		?>
		<?php
		     if(isset($_SESSION['usr_id']))
			     {
		?>
		<DIV class="workbench">
			<UL>
				<LI>
					<A href="index.php?page=myprojects" title="Mes projets">Mes projets</A>
				</LI>
				<LI>
					<A href="index.php?page=mytoolchains" title="Mes chaines">Mes chaines</A>
				</LI>
				<LI>
					<A href="index.php?page=start_project" title="Toolchain configuration">Nouveau projet</A>
				</LI>
				<LI>
					<A href="index.php?page=toolchain" title="Toolchain configuration">Nouvelle chaine</A>
				</LI>
			</UL>
		</DIV>
		<?php
		     }
		?>
		<DIV class="utils">
			<LABEL>Liens utiles</LABEL>
			<UL>
				<LI>
					<A href="http://www.kernel.org/">Linux</A>
				</LI>	
				<LI>
					<A href="http://ymorin.is-a-geek.org/dokuwiki/projects/crosstool">Crosstool-ng</A>
				</LI>
				<LI>
					<A href="http://github.com/tmonjalo/miniroot/tree/master">Miniroot</A>
				</LI>				
				<LI>
					<A href="http://buildroot.uclibc.org/">Buildroot</A>
				</LI>
				<LI>
					<A href="http://www.scratchbox.org/">ScratchBox</A>
				</LI>
				<LI>
					<A href="http://www.denx.de/wiki/DULG/ELDK">ELDK</A>
				</LI>
				<LI>
					<A href="http://wiki.openembedded.net/index.php/Main_Page">OpenEmbedded</A>
				</LI>
				<LI>
					<A href="http://www.xenomai.org/">Xenomai</A>
				</LI>
				<LI>
					<A href="https://www.rtai.org/">RTAI</A>
				</LI>
				<LI>
					<A href="http://free-electrons.com/">Free-Electrons</A>
				</LI>
			</UL>
		</DIV>
	</DIV>
    <DIV id="corps">
	<?php
	     	$authorized_pages = Array('addconfig' => 'addconfig.php', 'build_toolchain' => 'build_toolchain.php', 'config_project' => 'config_project.php', 'login' => 'login.php', 'logout' => 'logout.php', 'myprojects' => 'myprojects.php', 'mytoolchains' => 'mytoolchains.php', 'read_config' => 'read_config.php', 'register' => 'register.php', 'reset_password' => 'reset_password.php', 'start_project' => 'start_project.php', 'toolchain' => 'toolchain.php', 'view_toolchain' => 'view_toolchain.php', 'jobs' => 'jobs.php', 'view_config' => 'view_config.php', 'view_results' => 'view_results.php', 'lmbench' => 'lmbench.php', 'interbench' => 'interbench.php', 'ltprealt' => 'ltprealt.php');
		$page = $_GET['page'];
		if($page != '')
		{
			if(isset($authorized_pages[$page]))
			{
				include ($authorized_pages[$page]);
			}
			else
			{
				echo '<BR /><BR /><font size="+3">This page does not exist</font>';
			}
		}
		else
		{
			include ('accueil.htm');
		}
	?>
    </DIV>
  </body>
</html>