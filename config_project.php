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
	
	//fill the configurations' table
	$project = htmlspecialchars($_GET['project']);
	
	//Security check to see whether the user has the permission to access the page
	$response=mysql_query("select * from project where user_id='".$usr_id."' and id='".$project."'") or die(mysql_error());
	$record = mysql_fetch_array($response);
	$project_name = $record['title'];
	$record_count = mysql_num_rows($response);
	if($record_count == 0)
	{
		echo '<BR /><BR /><font size="+3">You are not allowed to view this page</font>';
		return;
	}
	
	//delete selected configurations
	if($_POST['nb_chkbox']!= 0)
	{
		for($i=1;$i<=$_POST['nb_chkbox'];$i++)
		{
			$del = $_POST['chk_'.$i];
			if($del)
			{
				mysql_query("delete from configuration where proj_id='".$project."' and name='".$del."'") or die(mysql_error());
				system("perl $work_dir/adduser.pl del -c ".$_SESSION['login']." ".$project_name." ".$del."&");
			}
		}	
	}
	
	//Retrieving the configuration
	$response=mysql_query("select * from project inner join configuration on (id = proj_id) where user_id='".$usr_id."' and id='".$project."'") or die(mysql_error());
	$record_count = mysql_num_rows($response);
?>
<SCRIPT language="JavaScript">
	function Invert()
	{
		if(document.form1.check_all.checked)
		{
			for(i=0; i<document.form1.length;i++)
			{
				if(document.form1.elements[i].type == "checkbox")
				{
					document.form1.elements[i].checked = true;
				}
			}
		}
		else
		{
			for(i=0; i<document.form1.length;i++)
			{
				if(document.form1.elements[i].type == "checkbox")
				{
					document.form1.elements[i].checked = false;
				}
			}
		}
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
</SCRIPT>
<H2>Configurations du projet</H2><BR /><BR />
<FORM name="form1" method="POST" action="<?php echo $PHP_SELF; ?>">
	<INPUT type="button" value="Créer une configuration" onclick="<?php echo "window.location='index.php?page=addconfig&project=$project'";?>">
	<INPUT type="submit" value="Supprimer la sélection" name="btn_delete"><BR />
	<HR align="left" width="100%">
	<?php
	if($record_count == 0)
	{
		echo 'Vous n\'avez encore aucune configuration.';
	}
	else
	{
	?>
	<TABLE bgcolor="Gray" border="1" width="200">
		<TR>
			<TD><INPUT type="checkbox" name="check_all" onchange="Invert();"></TD>
			<TD>Nom</TD>
			<TD>chaine de compilation</TD>
			<TD>Configuration du noyau</TD>
			<TD>Extension temps réel</TD>
			<TD>Statut</TD>
		</TR>
		<?php
			$j=0;
			while($record = mysql_fetch_array($response))
			{
				$j++;
				echo '<TR>';					
				echo "<TD align=\"center\"><INPUT type=\"checkbox\" name=\"chk_".$j."\" value=\"".$record['name']."\" ></TD>";
				echo "<TD><A href=\"index.php?page=view_config&project=$project_name&config=".$record['name']."\">".$record['name']."</A></TD>";				
				echo "<TD><A href=\"index.php?page=view_toolchain&toolchain=".$record['toolchain']."\" >".$record['toolchain']."</A></TD>";
				echo "<TD>".$record['kernel_config']."</TD>";
				echo "<TD>".$record['rt_extension']."</TD>";
				echo "<TD>".$record['status']."</TD>";
				echo '</TR>';
			}
		mysql_close() or die(mysql_error());
		?>
	</TABLE><BR />			
	<INPUT type="hidden" name="nb_chkbox" value="<?php echo $record_count; ?>">
</FORM>
<?php
     }
?>