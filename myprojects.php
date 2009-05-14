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
	
	//delete selected projects
	if($_POST['nb_chkbox']!= 0)
	{
		for($i=1;$i<=$_POST['nb_chkbox'];$i++)
		{
			$del = $_POST['chk_'.$i];
			if($del)
			{
				mysql_query("delete from project where user_id='".$usr_id."' and title='".$del."'") or die(mysql_error());
				system("$perl $work_dir/adduser.pl del -p ".$_SESSION['login']." ".$del." &");
			}
		}	
	}
	
	//fill the projects' table
	$response=mysql_query("select * from project where user_id='".$usr_id."'") or die(mysql_error());
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
</SCRIPT>
<H2>Mes projets</H2><BR /><BR />
<FORM name="form1" method="POST" action="index.php?page=myprojects">
	<INPUT type="button" value="Créer un nouveau projet" onclick="window.location='index.php?page=start_project'">
	<INPUT type="submit" value="Supprimer la sélection" name="btn_delete"><BR />
	<HR align="left" width="100%">
	<?php
		if($record_count == 0)
		{		
			echo "Vous n'avez aucun projet.";
		}
		else
		{
	?>
	<TABLE bgcolor="Gray" border="1" width="200">
		<TR>
			<TD><INPUT type="checkbox" name="check_all" onchange="Invert();"></TD>
			<TD>Titre</TD>
			<TD>Architecture</TD>
			<TD>Description</TD>
			<TD>Date de création</TD>
		</TR>
		<?php
			$j=0;
			while($record = mysql_fetch_array($response))
			{
				$j++;
				echo '<TR>';
				echo "<TD align=\"center\"><INPUT type=\"checkbox\" name=\"chk_".$j."\" value=\"".$record['title']."\" ></TD>";
					echo "<TD><A href=\"index.php?page=config_project&project=".$record['id']."\">".$record['title']."</A></TD>";
				echo "<TD>".$record['architecture']."</TD>";
				echo "<TD>".$record['variant']."</TD>";
				echo "<TD>".$record['description']."</TD>";
				echo "<TD>".$record['creation_date']."</TD>";
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