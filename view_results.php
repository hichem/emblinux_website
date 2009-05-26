<?php
	session_start();
	include ('globals.php');
	$user_name = $_SESSION['login'];
	if($user_name == '')
	{
		echo '<BR /><BR /><font size="+3">You must login to view this content</font>';
		return;
	}

	$project_name = $_GET['project'];
//$_SESSION['nom_dossier']= $_GET['nom']; 
?>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
<title>Summary Results</title>
<link rel="stylesheet" href="resume_fichiers/css.css" type="text/css">
</head><body link="#1c3388" vlink="#1c3388" alink="#1c3388">
<table align=center bgcolor=#fefefe border=0  width=100% cellspacing=0 cellpadding=0>
       <tr>
      <td colspan="2" >
        <table cellspacing=3 cellpadding=3 width=100%>   
      <tr>
      
      <td height="30" bgcolor=#A2C0DF colspan="2" class="leftt" >

      <center>
      <font color=#fffffe><b>Benchmarking plateform for real time linux</b></font>
      </center>
      </td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <table border=0  cellspacing=3 cellpadding=3 width=100%>

	<tr>
	  <td width=100 align=left><img alt="pingouin" src="resume_fichiers/opensource.jpg" height=70></td>
	  <td align=center class="leftt"><b>Summary Results</b></td>
	  <td width=100 align=right><img alt="logo" src="resume_fichiers/logo.jpg" height=70></td>
          <td height="30" bgcolor=#A2C0DF colspan="2"></td>
	</tr>
	</table>
      </td>
    </tr>
     
<tr>
    
</table>
-->
<p> 
<h1>
<b>Table of Contents</b>
</h1>
</p>

<ol>
    
    <li><a href="#1">LMbench results</a></li>
    <li><a href="#2">INterbench results</a></li>
    <li><a href="#3">LTP Realtime results</a></li>
    
</ol>
<?php
$url = array();
$rss_file = array();
$xml = array();
$nom_dir=array();
$i=0;
/*$myVar1 = $_GET['nom'];
$myvar= $_SESSION['rep'];
$rep = $myvar."/".$myVar1;*/
$rep = "$home/$user_name/projects/$project_name";
$dir = opendir($rep);
while ($f = readdir($dir))
{
    if ($f != "." && $f != "..")
    {
        if (is_dir($rep."/".$f))
	{  
	if(file_exists($url[$i]=$rep."/".$f."/lmbench.xml"))
	{
           $rss_file[$i] = file_get_contents($url[$i]);
           $xml[$i] = new SimpleXMLElement($rss_file[$i]);
           $nom_dir[$i]=$f;
           $i=$i+1;
	   }
        }
    }
}
closedir($dir);
$max_rep=$i;

?>
<br>
<hr style="width: 70%; height: 2px;">
<br>

<?php
for($i=0;$i<$max_rep;$i++)
{ 
$proc_lat[$nom_dir[$i]]=((float)($xml[$i]->processor->simp_syscall)*100+(float)($xml[$i]->processor->simp_io)*100+(float)($xml[$i]->processor->simp_stat)*100+(float)($xml[$i]->processor->simp_opcl)*100+(float)($xml[$i]->processor->slt_tcp)*100 + (float)($xml[$i]->processor->sig_hand_ins)*100 + (float)($xml[$i]->processor->sig_hand_ovr)*100+ (float)($xml[$i]->processor->fork_proc)*3+ (float)($xml[$i]->processor->exec_proc)+ (float)($xml[$i]->processor->sh_proc))/705;


$math_lat[$nom_dir[$i]]=((float)($xml[$i]->integer_operation->int_bit)*10+(float)($xml[$i]->integer_operation->int_add)*10+(float)($xml[$i]->integer_operation->int_mul)*10 + (float)($xml[$i]->integer_operation->int_div)+(float)($xml[$i]->integer_operation->int_mod) + (float)($xml[$i]->int64_operation->int64_bit)*10+(float)($xml[$i]->int64_operation->uint64_add)*10+(float)($xml[$i]->int64_operation->int64_mul)*10 + (float)($xml[$i]->int64_operation->div)+(float)($xml[$i]->int64_operation->int64_mod)+(float)($xml[$i]->float_operation->float_add)*10+(float)($xml[$i]->float_operation->float_mul)*10 + (float)($xml[$i]->float_operation->float_bog)+(float)($xml[$i]->float_operation->float_div)+(float)($xml[$i]->double_operation->double_add)*10+(float)($xml[$i]->double_operation->double_mul)*10 + (float)($xml[$i]->double_operation->double_bog)+(float)($xml[$i]->double_operation->double_div))/108;


$ctsw_lat[$nom_dir[$i]]=((float)($xml[$i]->context_switching->ctxsw_2p_0k)+(float)($xml[$i]->context_switching->ctxsw_2p_16k)+(float)($xml[$i]->context_switching->ctxsw_2p_64k)+(float)($xml[$i]->context_switching->ctxsw_8p_16k)+(float)($xml[$i]->context_switching->ctxsw_8p_64k)+(float)($xml[$i]->context_switching->ctxsw_16p_16k)+(float)($xml[$i]->context_switching->ctxsw_16p_64k))/7;


$local_comm_lat[$nom_dir[$i]]=((float)($xml[$i]->local_communication_latency->ctxsw_2pp_0k)+(float)($xml[$i]->local_communication_latency->pipe_lat)+(float)($xml[$i]->local_communication_latency->af_unix_lat)+(float)($xml[$i]->local_communication_latency->udp_lat)+(float)($xml[$i]->local_communication_latency->udp_rpc_lat)+(float)($xml[$i]->local_communication_latency->tcp_lat)+(float)($xml[$i]->local_communication_latency->tcp_rpc_lat)+(float)($xml[$i]->local_communication_latency->tcp_connec_lat))/8;


$rem_comm_lat[$nom_dir[$i]]=((float)($xml[$i]->network_communication_latency->udp_lat_net)+(float)($xml[$i]->network_communication_latency->udp_rpc_lat_net)+(float)($xml[$i]->network_communication_latency->tcp_lat_net)+(float)($xml[$i]->network_communication_latency->tcp_rpc_lat_net)+(float)($xml[$i]->network_communication_latency->tcp_connec_lat_net))/5;



$local_comm_bw[$nom_dir[$i]]=((float)($xml[$i]->local_communication_bandwith->pipe_bw)+(float)($xml[$i]->local_communication_bandwith->af_unix_bw)+(float)($xml[$i]->local_communication_bandwith->tcp_bw)+(float)($xml[$i]->local_communication_bandwith->filereread_bw)+(float)($xml[$i]->local_communication_bandwith->mmapreread_bw)+(float)($xml[$i]->local_communication_bandwith->bcopylibc_bw)+(float)($xml[$i]->local_communication_bandwith->bcopyhand_bw)+(float)($xml[$i]->local_communication_bandwith->memread_bw)+(float)($xml[$i]->local_communication_bandwith->memwrite_bw))/9;


$mem_lat[$nom_dir[$i]]=((float)($xml[$i]->memory_latencies->L1)*20+(float)($xml[$i]->memory_latencies->L2)*10+(float)($xml[$i]->memory_latencies->mainmem_lat)+(float)($xml[$i]->memory_latencies->randmem_lat)+(float)($xml[$i]->memory_latencies->guesses_lat))/33;



$pos=strpos($xml[$i]->file_vm_latency->mmap_lat,'K');

if($pos===false)
{
$filevm_lat[$nom_dir[$i]]=((float)($xml[$i]->file_vm_latency->create_0k)*100+(float)($xml[$i]->file_vm_latency->delete_0k)*100+(float)($xml[$i]->file_vm_latency->create_10k)*100+(float)($xml[$i]->file_vm_latency->delete_10k)*100+(float)($xml[$i]->file_vm_latency->mmap_lat)+(float)($xml[$i]->file_vm_latency->prot_fault)*1000+(float)($xml[$i]->file_vm_latency->page_fault)*1000+(float)($xml[$i]->file_vm_latency->fd100_select)*1000)/3401;

}
else
{
$filevm_lat[$nom_dir[$i]]=((float)($xml[$i]->file_vm_latency->create_0k)*100+(float)($xml[$i]->file_vm_latency->delete_0k)*100+(float)($xml[$i]->file_vm_latency->create_10k)*100+(float)($xml[$i]->file_vm_latency->delete_10k)*100+(float)(substr($xml[$i]->file_vm_latency->mmap_lat, 0, -1)) * 1000+(float)($xml[$i]->file_vm_latency->prot_fault)*1000+(float)($xml[$i]->file_vm_latency->page_fault)*1000+(float)($xml[$i]->file_vm_latency->fd100_select)*1000)/3401;

}}

for($i=0;$i<$max_rep;$i++)
{ 
if($nom_dir[$i]!="vanilla")
{
if($proc_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][0]= $proc_lat[vanilla]/$proc_lat[$nom_dir[$i]];
if($math_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][1]= $math_lat[vanilla]/$math_lat[$nom_dir[$i]];
if($ctsw_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][2]= $ctsw_lat[vanilla]/$ctsw_lat[$nom_dir[$i]];
if($local_comm_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][3]= $local_comm_lat[vanilla]/$local_comm_lat[$nom_dir[$i]];
if($rem_comm_lat[$nom_dir[$i]]!=0)
{
$data1[$nom_dir[$i]][4]= $rem_comm_lat[vanilla]/$rem_comm_lat[$nom_dir[$i]];
if($local_comm_bw[vanilla]!=0)
$data1[$nom_dir[$i]][5]= $local_comm_bw[$nom_dir[$i]]/$local_comm_bw[vanilla];
if($mem_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][6]= $mem_lat[vanilla]/$mem_lat[$nom_dir[$i]];
if($filevm_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][7]= $filevm_lat[vanilla]/$filevm_lat[$nom_dir[$i]];
}
else 
{
$data1[$nom_dir[$i]][4]=0;
if($local_comm_bw[vanilla]!=0)
$data1[$nom_dir[$i]][5]= $local_comm_bw[$nom_dir[$i]]/$local_comm_bw[vanilla];
if($mem_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][6]= $mem_lat[vanilla]/$mem_lat[$nom_dir[$i]];
if($filevm_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][7]= $filevm_lat[vanilla]/$filevm_lat[$nom_dir[$i]];
}

}
else
{
$data1[vanilla][0]= 1;
$data1[vanilla][1]= 1;
$data1[vanilla][2]= 1;
$data1[vanilla][3]= 1;
if($rem_comm_lat[vanilla]!=0)
$data1[vanilla][4]= 1;
else
$data1[vanilla][4]=0;
$data1[vanilla][5]= 1;
$data1[vanilla][6]= 1;
$data1[vanilla][7]= 1;

}
}
?>

<?php
//$myVar = $_GET['nom'];
?>
<br>
<a name="1"></a>
<h2> LMbench results </h2>
<p>The results of lmbench:</p>
<br>

<center>
<table width=500 height=370>
    <caption>Summary results of lmbench for each distribution
    <center>-Note / parameter-</center>
    <br>
    <br>
    </caption>
    
    <tbody><tr>
       
        <td> </td>
         <?for ($j = 0; $j < $max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';
             }
            echo'<th>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>Coefficients</b></font>';
            echo'</th>';
         ?>

      

    </tr>
   
    <tr>
	<th> Processes Latencies </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data1[$nom_dir[$j]][0]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Mathematical operations </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data1[$nom_dir[$j]][1]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Context switching latencies</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f",$data1[$nom_dir[$j]][2]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Local communication latencies </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][3]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
   <tr>
	<th> Remote communication latencies</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][4]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Local communication Bandwidth </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][5]);
                       echo'</td>'; }
            echo'<td>';
           echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Memory latencies </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][6]);
                       echo'</td>'; }
            echo'<td>';
           echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
   <tr>
	<th> File & VM latencies </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f", $data1[$nom_dir[$j]][7]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
       <tr>
	<th> <font size=2 color="#ff0000" face="Verdana"><b>Note Globale </b></font> </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                    if($rem_comm_lat[vanilla]!=0)
                    $note_glob=($data1[$nom_dir[$j]][0]+$data1[$nom_dir[$j]][1]+$data1[$nom_dir[$j]][2]+$data1[$nom_dir[$j]][3]+$data1[$nom_dir[$j]][4]+$data1[$nom_dir[$j]][5]+$data1[$nom_dir[$j]][6]+$data1[$nom_dir[$j]][7])/8;
                     else
                    $note_glob=($data1[$nom_dir[$j]][0]+$data1[$nom_dir[$j]][1]+$data1[$nom_dir[$j]][2]+$data1[$nom_dir[$j]][3]+$data1[$nom_dir[$j]][5]+$data1[$nom_dir[$j]][6]+$data1[$nom_dir[$j]][7])/7;
                      printf("%1.3f", $note_glob);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>--</b></font>';
            echo'</td>';
            ?>
    </tr>

</tbody></table>

</center>

<br>
<br>
<center><img  src="resume_fichiers/img1.php?project=<?php echo $project_name; ?>"  border="2" vspace="10"/></center>
<br>
<p>to view details click  
<? 
//$myVar = $_GET['nom'];
echo "<a href=index.php?page=lmbench&project=$project_name>here</a>";
?>
</p>
<br>
<br>
<?php

$url = array();
$rss_file = array();
$xml = array();
$nom_dir=array();
$sim_aud_lat=array();
$sim_aud_sd=array();
$sim_aud_max_lat=array();
$sim_aud_cpu=array();
$sim_aud_dd=array();


$sim_vd_lat=array();
$sim_vd_sd=array();
$sim_vd_max_lat=array();
$sim_vd_cpu=array();
$sim_vd_dd=array();


$sim_x_lat=array();
$sim_x_sd=array();
$sim_x_max_lat=array();
$sim_x_cpu=array();
$sim_x_dd=array();


$sim_gm_lat=array();
$sim_gm_sd=array();
$sim_gm_max_lat=array();
$sim_gm_cpu=array();
$sim_gm_dd=array();


$i=0;

/*$myvar= $_SESSION['rep'];
$rep = $myvar."/".$_SESSION['nom_dossier'];*/


$dir = opendir($rep);

while ($f = readdir($dir))
{
	if ($f != "." && $f != "..")
	{
		if (is_dir($rep."/".$f))
		{
			$url[$i]=$rep."/".$f."/interbench.xml";
			if(file_exists($url[$i]=$rep."/".$f."/interbench.xml"))
			{
				$rss_file[$i] = file_get_contents($url[$i]);
				$xml[$i] = new SimpleXMLElement($rss_file[$i]);
				$nom_dir[$i]=$f;
				$i=$i+1;
			}
		}
	}
}
closedir($dir);
$max_rep=$i;

for($i=0;$i<$max_rep;$i++)
{ 
//audio

$sim_aud_lat[$nom_dir[$i]]=((float)($xml[$i]->audio->none->latence)+(float)($xml[$i]->audio->video->latence)+(float)($xml[$i]->audio->x->latence)+(float)($xml[$i]->audio->burn->latence)+(float)($xml[$i]->audio->write->latence)+(float)($xml[$i]->audio->read->latence)+(float)($xml[$i]->audio->compile->latence)+(float)($xml[$i]->audio->memload->latence))/8;



$sim_aud_sd[$nom_dir[$i]]=((float)($xml[$i]->audio->none->sd)+(float)($xml[$i]->audio->video->sd)+(float)($xml[$i]->audio->x->sd)+(float)($xml[$i]->audio->burn->sd)+(float)($xml[$i]->audio->write->sd)+(float)($xml[$i]->audio->read->sd)+(float)($xml[$i]->audio->compile->sd)+(float)($xml[$i]->audio->memload->sd))/8;

$sim_aud_max_lat[$nom_dir[$i]]=((float)($xml[$i]->audio->none->max_lat)+(float)($xml[$i]->audio->video->max_lat)+(float)($xml[$i]->audio->x->max_lat)+(float)($xml[$i]->audio->burn->max_lat)+(float)($xml[$i]->audio->write->max_lat)+(float)($xml[$i]->audio->read->max_lat)+(float)($xml[$i]->audio->compile->max_lat)+(float)($xml[$i]->audio->memload->max_lat))/8;

$sim_aud_cpu[$nom_dir[$i]]=((float)($xml[$i]->audio->none->cpu)+(float)($xml[$i]->audio->video->cpu)+(float)($xml[$i]->audio->x->cpu)+(float)($xml[$i]->audio->burn->cpu)+(float)($xml[$i]->audio->write->cpu)+(float)($xml[$i]->audio->read->cpu)+(float)($xml[$i]->audio->compile->cpu)+(float)($xml[$i]->audio->memload->cpu))/8;

$sim_aud_dd[$nom_dir[$i]]=((float)($xml[$i]->audio->none->dead)+(float)($xml[$i]->audio->video->dead)+(float)($xml[$i]->audio->x->dead)+(float)($xml[$i]->audio->burn->dead)+(float)($xml[$i]->audio->write->dead)+(float)($xml[$i]->audio->read->dead)+(float)($xml[$i]->audio->compile->dead)+(float)($xml[$i]->audio->memload->dead))/8;

// video

$sim_vd_lat[$nom_dir[$i]]=((float)($xml[$i]->video->none->latence)+(float)($xml[$i]->video->x->latence)+(float)($xml[$i]->video->burn->latence)+(float)($xml[$i]->video->write->latence)+(float)($xml[$i]->video->read->latence)+(float)($xml[$i]->video->compile->latence)+(float)($xml[$i]->video->memload->latence))/7;

$sim_vd_sd[$nom_dir[$i]]=((float)($xml[$i]->video->none->sd)+(float)($xml[$i]->video->x->sd)+(float)($xml[$i]->video->burn->sd)+(float)($xml[$i]->video->write->sd)+(float)($xml[$i]->video->read->sd)+(float)($xml[$i]->video->compile->sd)+(float)($xml[$i]->video->memload->sd))/7;

$sim_vd_max_lat[$nom_dir[$i]]=((float)($xml[$i]->video->none->max_lat)+(float)($xml[$i]->video->x->max_lat)+(float)($xml[$i]->video->burn->max_lat)+(float)($xml[$i]->video->write->max_lat)+(float)($xml[$i]->video->read->max_lat)+(float)($xml[$i]->video->compile->max_lat)+(float)($xml[$i]->video->memload->max_lat))/7;

$sim_vd_cpu[$nom_dir[$i]]=((float)($xml[$i]->video->none->cpu)+(float)($xml[$i]->video->x->cpu)+(float)($xml[$i]->video->burn->cpu)+(float)($xml[$i]->video->write->cpu)+(float)($xml[$i]->video->read->cpu)+(float)($xml[$i]->video->compile->cpu)+(float)($xml[$i]->video->memload->cpu))/7;

$sim_vd_dd[$nom_dir[$i]]=((float)($xml[$i]->video->none->dead)+(float)($xml[$i]->video->x->dead)+(float)($xml[$i]->video->burn->dead)+(float)($xml[$i]->video->write->dead)+(float)($xml[$i]->video->read->dead)+(float)($xml[$i]->video->compile->dead)+(float)($xml[$i]->video->memload->dead))/7;

//x

$sim_x_lat[$nom_dir[$i]]=((float)($xml[$i]->x->none->latence)+(float)($xml[$i]->x->video->latence)+(float)($xml[$i]->x->burn->latence)+(float)($xml[$i]->x->write->latence)+(float)($xml[$i]->x->read->latence)+(float)($xml[$i]->x->compile->latence)+(float)($xml[$i]->x->memload->latence))/7;

$sim_x_sd[$nom_dir[$i]]=((float)($xml[$i]->x->none->sd)+(float)($xml[$i]->x->video->sd)+(float)($xml[$i]->x->burn->sd)+(float)($xml[$i]->x->write->sd)+(float)($xml[$i]->x->read->sd)+(float)($xml[$i]->x->compile->sd)+(float)($xml[$i]->x->memload->sd))/7;

$sim_x_max_lat[$nom_dir[$i]]=((float)($xml[$i]->x->none->max_lat)+(float)($xml[$i]->x->video->max_lat)+(float)($xml[$i]->x->burn->max_lat)+(float)($xml[$i]->x->write->max_lat)+(float)($xml[$i]->x->read->max_lat)+(float)($xml[$i]->x->compile->max_lat)+(float)($xml[$i]->x->memload->max_lat))/7;

$sim_x_cpu[$nom_dir[$i]]=((float)($xml[$i]->x->none->cpu)+(float)($xml[$i]->x->video->cpu)+(float)($xml[$i]->x->burn->cpu)+(float)($xml[$i]->x->write->cpu)+(float)($xml[$i]->x->read->cpu)+(float)($xml[$i]->x->compile->cpu)+(float)($xml[$i]->x->memload->cpu))/7;

$sim_x_dd[$nom_dir[$i]]=((float)($xml[$i]->x->none->dead)+(float)($xml[$i]->x->video->dead)+(float)($xml[$i]->x->burn->dead)+(float)($xml[$i]->x->write->dead)+(float)($xml[$i]->x->read->dead)+(float)($xml[$i]->x->compile->dead)+(float)($xml[$i]->x->memload->dead))/7;

//Gaming


$sim_gm_lat[$nom_dir[$i]]=((float)($xml[$i]->gaming->none->latence)+(float)($xml[$i]->gaming->video->latence)+(float)($xml[$i]->gaming->x->latence)+(float)($xml[$i]->gaming->burn->latence)+(float)($xml[$i]->gaming->write->latence)+(float)($xml[$i]->gaming->read->latence)+(float)($xml[$i]->gaming->compile->latence)+(float)($xml[$i]->gaming->memload->latence))/8;

$sim_gm_sd[$nom_dir[$i]]=((float)($xml[$i]->gaming->none->sd)+(float)($xml[$i]->gaming->video->sd)+(float)($xml[$i]->gaming->x->sd)+(float)($xml[$i]->gaming->burn->sd)+(float)($xml[$i]->gaming->write->sd)+(float)($xml[$i]->gaming->read->sd)+(float)($xml[$i]->gaming->compile->sd)+(float)($xml[$i]->gaming->memload->sd))/8;

$sim_gm_max_lat[$nom_dir[$i]]=((float)($xml[$i]->gaming->none->max_lat)+(float)($xml[$i]->gaming->video->max_lat)+(float)($xml[$i]->gaming->x->max_lat)+(float)($xml[$i]->gaming->burn->max_lat)+(float)($xml[$i]->gaming->write->max_lat)+(float)($xml[$i]->gaming->read->max_lat)+(float)($xml[$i]->gaming->compile->max_lat)+(float)($xml[$i]->gaming->memload->max_lat))/8;

$sim_gm_cpu[$nom_dir[$i]]=((float)($xml[$i]->gaming->none->cpu)+(float)($xml[$i]->gaming->video->cpu)+(float)($xml[$i]->gaming->x->cpu)+(float)($xml[$i]->gaming->burn->cpu)+(float)($xml[$i]->gaming->write->cpu)+(float)($xml[$i]->gaming->read->cpu)+(float)($xml[$i]->gaming->compile->cpu)+(float)($xml[$i]->gaming->memload->cpu))/8;

}

//print_r($sim_aud_lat);

for($i=0;$i<$max_rep;$i++)
{ 
if($nom_dir[$i]!="vanilla")
{
//audio
if($sim_aud_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][0]= $sim_aud_lat[vanilla]/$sim_aud_lat[$nom_dir[$i]];

if($sim_aud_sd[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][1]= $sim_aud_sd[vanilla]/$sim_aud_sd[$nom_dir[$i]];

if($sim_aud_max_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][2]= $sim_aud_max_lat[vanilla]/$sim_aud_max_lat[$nom_dir[$i]];


if($sim_aud_cpu[vanilla]!=0)
$data1[$nom_dir[$i]][3]= $sim_aud_cpu[$nom_dir[$i]]/$sim_aud_cpu[vanilla];

if($sim_aud_dd[vanilla]!=0)
$data1[$nom_dir[$i]][4]= $sim_aud_dd[$nom_dir[$i]]/$sim_aud_dd[vanilla];
//video

if($sim_vd_lat[$nom_dir[$i]]!=0)
$data2[$nom_dir[$i]][0]= $sim_vd_lat[vanilla]/$sim_vd_lat[$nom_dir[$i]];

if($sim_vd_sd[$nom_dir[$i]]!=0)
$data2[$nom_dir[$i]][1]= $sim_vd_sd[vanilla]/$sim_vd_sd[$nom_dir[$i]];

if($sim_vd_max_lat[$nom_dir[$i]]!=0)
$data2[$nom_dir[$i]][2]= $sim_vd_max_lat[vanilla]/$sim_vd_max_lat[$nom_dir[$i]];


if($sim_vd_cpu[vanilla]!=0)
$data2[$nom_dir[$i]][3]= $sim_vd_cpu[$nom_dir[$i]]/$sim_vd_cpu[vanilla];

if($sim_vd_dd[vanilla]!=0)
$data2[$nom_dir[$i]][4]= $sim_vd_dd[$nom_dir[$i]]/$sim_vd_dd[vanilla];


//x

if($sim_x_lat[$nom_dir[$i]]!=0)
$data3[$nom_dir[$i]][0]= $sim_x_lat[vanilla]/$sim_x_lat[$nom_dir[$i]];

if($sim_x_sd[$nom_dir[$i]]!=0)
$data3[$nom_dir[$i]][1]= $sim_x_sd[vanilla]/$sim_x_sd[$nom_dir[$i]];

if($sim_x_max_lat[$nom_dir[$i]]!=0)
$data3[$nom_dir[$i]][2]= $sim_x_max_lat[vanilla]/$sim_x_max_lat[$nom_dir[$i]];


if($sim_x_cpu[vanilla]!=0)
$data3[$nom_dir[$i]][3]= $sim_x_cpu[$nom_dir[$i]]/$sim_x_cpu[vanilla];

if($sim_x_dd[vanilla]!=0)
$data3[$nom_dir[$i]][4]= $sim_x_dd[$nom_dir[$i]]/$sim_x_dd[vanilla];

//gm

if($sim_gm_lat[$nom_dir[$i]]!=0)
$data4[$nom_dir[$i]][0]= $sim_gm_lat[vanilla]/$sim_gm_lat[$nom_dir[$i]];

if($sim_gm_sd[$nom_dir[$i]]!=0)
$data4[$nom_dir[$i]][1]= $sim_gm_sd[vanilla]/$sim_gm_sd[$nom_dir[$i]];

if($sim_gm_max_lat[$nom_dir[$i]]!=0)
$data4[$nom_dir[$i]][2]= $sim_gm_max_lat[vanilla]/$sim_gm_max_lat[$nom_dir[$i]];


if($sim_gm_cpu[vanilla]!=0)
$data4[$nom_dir[$i]][3]= $sim_gm_cpu[$nom_dir[$i]]/$sim_gm_cpu[vanilla];




}

else
{
$data1[vanilla][0]= 1;
$data1[vanilla][1]= 1;
$data1[vanilla][2]= 1;
$data1[vanilla][3]= 1;
$data1[vanilla][4]= 1;

$data2[vanilla][0]= 1;
$data2[vanilla][1]= 1;
$data2[vanilla][2]= 1;
$data2[vanilla][3]= 1;
$data2[vanilla][4]= 1;


$data3[vanilla][0]= 1;
$data3[vanilla][1]= 1;
$data3[vanilla][2]= 1;
$data3[vanilla][3]= 1;
$data3[vanilla][4]= 1;


$data4[vanilla][0]= 1;
$data4[vanilla][1]= 1;
$data4[vanilla][2]= 1;
$data4[vanilla][3]= 1;
}

}
?>
<a name="2"></a>
<h2> INterbench results </h2>
<p>the results of interbench : </p>
<br>
<center>
<table width=650 height=370>
    <caption>Summary results of Interbench for each distribution
    <center>-Note / parameter-</center>
    <br>
    </caption>
    <tbody><tr>

        <td> </td>
         <?for ($j = 0; $j < $max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';
             }
            echo'<th>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>Coefficients</b></font>';
            echo'</th>';
         ?>

      

    </tr>
    <tr>
	    <td colspan="6" class="left">
            <b>Benchmarking simulated cpu of audio in the presence of simulated loading</b>
	    </td>
    </tr>
   
    <tr>
	<th>Latency</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data1[$nom_dir[$j]][0]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th>SD</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data1[$nom_dir[$j]][1]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Max_lat </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f",$data1[$nom_dir[$j]][2]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Cpu </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][3]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
   <tr>
	<th> Deadline met </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][4]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
    <tr>
	<th> <font size=2 color="#ff0000" face="Verdana"><b>Note Audio </b></font> </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
$note_glob1[$j]=($data1[$nom_dir[$j]][0]*2+$data1[$nom_dir[$j]][1]+$data1[$nom_dir[$j]][2]+$data1[$nom_dir[$j]][3]*2+$data1[$nom_dir[$j]][4]*2)/8;
         printf("%1.3f", $note_glob1[$j]);
         echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>--</b></font>';
            echo'</td>';
            
            ?>
        
    </tr>
   <tr>
	    <td colspan="6" class="left">
            <b>Benchmarking simulated cpu of video in the presence of simulated loading</b>
	    </td>
    </tr>
   
    <tr>
	<th>Latency</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data2[$nom_dir[$j]][0]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th>SD</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data2[$nom_dir[$j]][1]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Max_lat </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f",$data2[$nom_dir[$j]][2]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Cpu </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data2[$nom_dir[$j]][3]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
   <tr>
	<th> Deadline met </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data2[$nom_dir[$j]][4]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
    <tr>
	<th> <font size=2 color="#ff0000" face="Verdana"><b>Note Video </b></font> </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
$note_glob2[$j]=($data2[$nom_dir[$j]][0]*2+$data2[$nom_dir[$j]][1]+$data2[$nom_dir[$j]][2]+$data2[$nom_dir[$j]][3]*2+$data2[$nom_dir[$j]][4]*2)/8;
         printf("%1.3f", $note_glob2[$j]);
            echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>--</b></font>';
            echo'</td>';
            
            ?>
        
    </tr>
   <tr>
	    <td colspan="6" class="left">
            <b>Benchmarking simulated cpu of x in the presence of simulated loading</b>
	    </td>
    </tr>
   
    <tr>
	<th>Latency</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data3[$nom_dir[$j]][0]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th>SD</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data3[$nom_dir[$j]][1]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Max_lat </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f",$data3[$nom_dir[$j]][2]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Cpu </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data3[$nom_dir[$j]][3]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
   <tr>
	<th> Deadline met </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data3[$nom_dir[$j]][4]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
    <tr>
	<th> <font size=2 color="#ff0000" face="Verdana"><b>Note X </b></font> </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
$note_glob3[$j]=($data3[$nom_dir[$j]][0]*2+$data3[$nom_dir[$j]][1]+$data3[$nom_dir[$j]][2]+$data3[$nom_dir[$j]][3]*2+$data3[$nom_dir[$j]][4]*2)/8;
         printf("%1.3f", $note_glob3[$j]);
            echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>--</b></font>';
            echo'</td>';
            
            ?>
        
    </tr>   

   <tr>
	    <td colspan="6" class="left">
            <b>Benchmarking simulated cpu of gaming in the presence of simulated loading</b>
	    </td>
    </tr>
   
    <tr>
	<th>Latency</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data4[$nom_dir[$j]][0]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th>SD</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data4[$nom_dir[$j]][1]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Max_lat </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f",$data4[$nom_dir[$j]][2]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Cpu </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data4[$nom_dir[$j]][3]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>2</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
  
    <tr>
	<th> <font size=2 color="#ff0000" face="Verdana"><b>Note Gaming </b></font> </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
$note_glob4[$j]=($data4[$nom_dir[$j]][0]*2+$data4[$nom_dir[$j]][1]+$data4[$nom_dir[$j]][2]+$data4[$nom_dir[$j]][3]*2)/6;
         printf("%1.3f", $note_glob4[$j]);
            echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>--</b></font>';
            echo'</td>';
            
            ?>
        
    </tr> 

     <tr>
	<th> <font size=2 color="#ff0000" face="Verdana"><b>Note Globale </b></font> </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
        $note_glob=($note_glob1[$j]+$note_glob2[$j]+$note_glob3[$j]+$note_glob4[$j])/4;
        printf("%1.3f", $note_glob);
            echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>--</b></font>';
            echo'</td>';
            
            ?>
        
    </tr>     

</tbody></table>

</center>
<br>
<center><img  src="resume_fichiers/img2.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br>
<p>to view details click
<?
echo "<a href=index.php?page=interbench&project=$project_name>here</a>"
?>
</p>
<a name="3"></a>
<?php

$url = array();
$rss_file = array();
$xml = array();
$nom_dir=array();
$async_hand=array();
$Gtod_lat=array();
$cpu_load=array();
$Pi_perf=array();
$Pi_test=array();
$Pthread_kill_lat=array();
$Sched_jit=array();
$Sched_lat=array();
$Sched_foot=array();
$Thread_clock=array();
$Prio_Wake=array();
$Prio_pree=array();
$i=0;
$temp=0;

/*$myvar= $_SESSION['rep'];
$rep = $myvar."/".$_SESSION['nom_dossier'];*/

$dir = opendir($rep);

while ($f = readdir($dir))
{
	if ($f != "." && $f != "..")
	{
		if (is_dir($rep."/".$f))
		{  
			if(file_exists($rep."/".$f."/ltprealtime.xml"))
			{
				$url[$i]=$rep."/".$f."/ltprealtime.xml";
				$rss_file[$i] = file_get_contents($url[$i]);
				$xml[$i] = new SimpleXMLElement($rss_file[$i]);
				$nom_dir[$i]=$f;
				$i=$i+1;
			}
		}
	}
}
closedir($dir);
$max_rep=$i;


for($i=0;$i<$max_rep;$i++)
{ 
//audio
$async_hand[$nom_dir[$i]]=((float)($xml[$i]->Async_Handler_Jk->delta)+(float)($xml[$i]->Async_Handler->avg))/2;
$Gtod_lat[$nom_dir[$i]]=(float)($xml[$i]->Gtod_latency->avg);
$Matrix_mult[$nom_dir[$i]]=((float)($xml[$i]->Matrix_Mult->Avg_seq)+(float)($xml[$i]->Matrix_Mult->Avg_conc_op))/2;

$cpu_load[$nom_dir[$i]]=((float)($xml[$i]->Periodic_Cpu_Load->Tid0->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid1->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid2->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid3->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid4->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid5->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid6->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid7->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid8->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid9->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid10->avg)+(float)($xml[$i]->Periodic_Cpu_Load->Tid11->avg)+(float)($xml[$i]->Periodic_cpu_load_single->time_statistics->avg))/12;

$Pi_perf[$nom_dir[$i]]=((float)($xml[$i]->Pi_perf->Avg_Wait));

if(strcmp($xml[$i]->testpi1->result,"PASS ")==0)
$temp++;
if(strcmp($xml[$i]->testpi2->result,"PASS ")==0)
$temp++;
if(strcmp($xml[$i]->testpi4->result,"PASS ")==0)
$temp++;
if(strcmp($xml[$i]->testpi5->result,"PASS")==0)
$temp++;
if(strcmp($xml[$i]->testpi6->result,"PASS")==0)
$temp++;



$Pi_test[$nom_dir[$i]]=$temp/5;

if(strcmp($xml[$i]->Prio_Wake->result," PASS")==0)
$Prio_Wake[$nom_dir[$i]]=1;
else
$Prio_Wake[$nom_dir[$i]]=0;

if(strcmp($xml[$i]->Priority_Preemption->result," PASS")==0)
$Prio_pree[$nom_dir[$i]]=1;
else
$Prio_pree[$nom_dir[$i]]=0;

$Pthread_kill_lat[$nom_dir[$i]]=((float)($xml[$i]->Pthread_Kill_Latency->avg));
if(strcmp($xml[$i]->Sched_Football->result,"PASS ")==0)
$Sched_foot[$nom_dir[$i]]=1;
else
$Sched_foot[$nom_dir[$i]]=0;

$Sched_jit[$nom_dir[$i]]=((float)($xml[$i]->Sched_Jitter->Max_jitter));
$Sched_lat[$nom_dir[$i]]=((float)($xml[$i]->sched_latency->avg));
$Thread_clock[$nom_dir[$i]]=((float)($xml[$i]->tc2c->delta));

$temp=0;

}
for($i=0;$i<$max_rep;$i++)
{ 
if($nom_dir[$i]!="vanilla")
{
if($async_hand[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][0]= $async_hand[vanilla]/$async_hand[$nom_dir[$i]];

if($Gtod_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][1]= $Gtod_lat[vanilla]/$Gtod_lat[$nom_dir[$i]];

if($Matrix_mult[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][2]= $Matrix_mult[vanilla]/$Matrix_mult[$nom_dir[$i]];

if($cpu_load[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][3]= $cpu_load[vanilla]/$cpu_load[$nom_dir[$i]];

if($Pi_perf[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][4]= $Pi_perf[vanilla]/$Pi_perf[$nom_dir[$i]];

if($Pi_test[vanilla]!=0)
$data1[$nom_dir[$i]][5]=$Pi_test[$nom_dir[$i]]/$Pi_test[vanilla];
else
$data1[$nom_dir[$i]][5]=$Pi_test[$nom_dir[$i]];

if($Prio_Wake[vanilla]!=0)
$data1[$nom_dir[$i]][6]= $Prio_Wake[$nom_dir[$i]]/$Prio_Wake[vanilla];
elseif($Prio_Wake[$nom_dir[$i]]==0)
$data1[$nom_dir[$i]][6]=1;
else
$data1[$nom_dir[$i]][6]=2;

if($Prio_pree[vanilla]!=0)
$data1[$nom_dir[$i]][7]= $Prio_pree[$nom_dir[$i]]/$Prio_pree[vanilla];
elseif($Prio_pree[$nom_dir[$i]]==0)
$data1[$nom_dir[$i]][7]=1;
else
$data1[$nom_dir[$i]][7]=2;

if($Pthread_kill_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][8]= $Pthread_kill_lat[vanilla]/$Pthread_kill_lat[$nom_dir[$i]];


if($Sched_foot[vanilla]!=0)
$data1[$nom_dir[$i]][9]= $Sched_foot[$nom_dir[$i]]/$Sched_foot[vanilla];
elseif($Sched_foot[$nom_dir[$i]]== 0)
$data1[$nom_dir[$i]][9]=1;
else
$data1[$nom_dir[$i]][9]=2;

if($Sched_jit[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][10]=$Sched_jit[vanilla]/$Sched_jit[$nom_dir[$i]];

if($Sched_lat[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][11]= $Sched_lat[vanilla]/$Sched_lat[$nom_dir[$i]];

if($Thread_clock[$nom_dir[$i]]!=0)
$data1[$nom_dir[$i]][12]= $Thread_clock[vanilla]/$Thread_clock[$nom_dir[$i]];




}
else
{
$data1[vanilla][0]= 1;
$data1[vanilla][1]= 1;
$data1[vanilla][2]= 1;
$data1[vanilla][3]= 1;
$data1[vanilla][4]= 1;
if($Pi_test[vanilla]!=0)
$data1[vanilla][5]= 1;
else
$data1[vanilla][5]= 0;
$data1[vanilla][6]= 1;
$data1[vanilla][7]= 1;
$data1[vanilla][8]= 1;
$data1[vanilla][9]= 1;
$data1[vanilla][10]= 1;
$data1[vanilla][11]= 1;
$data1[vanilla][12]= 1;

}
}
?>


<h2> LTP realtime results </h2>
<p>the results of ltp realtime testcases</p>
<br>
<center>
<table width=500 height=370>
    <caption>Summary results of ltp realtime for each distribution
    <center>-Note / parameter-</center>
    <br>
    <br>
    </caption>
    <tbody><tr>

        <td> </td>
         <?for ($j = 0; $j < $max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';
             }
            echo'<th>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>Coefficients</b></font>';
            echo'</th>';
         ?>

      

    </tr>
   
    <tr>
	<th>Async_handler</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data1[$nom_dir[$j]][0]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Gtod_latency</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f", $data1[$nom_dir[$j]][1]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Matrix_mult</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f",$data1[$nom_dir[$j]][2]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Periodic_cpu_load </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][3]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
   <tr>
	<th> Pi_perf </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][4]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Pi-tests </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][5]);
                       echo'</td>'; }
            echo'<td>';
           echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Prio-wake</th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       printf("%1.3f",$data1[$nom_dir[$j]][6]);
                       echo'</td>'; }
            echo'<td>';
           echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
   <tr>
	<th> Prio-preempt </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f", $data1[$nom_dir[$j]][7]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    
    <tr>
	<th> Pthread_kill_latency </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f", $data1[$nom_dir[$j]][8]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Sched_football </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f", $data1[$nom_dir[$j]][9]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
      </tr>
    <tr>
	<th> Sched_jitter </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f", $data1[$nom_dir[$j]][10]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
      </tr>
      <tr>
	<th> Sched_latency  </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f", $data1[$nom_dir[$j]][11]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
    <tr>
	<th> Thread_clock  </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      printf("%1.3f", $data1[$nom_dir[$j]][12]);
                       echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>1</b></font>';
            echo'</td>';
         ?>
        
    </tr>
       <tr>
	<th> <font size=2 color="#ff0000" face="Verdana"><b>Note Globale </b></font> </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                   
                    $note_glob=($data1[$nom_dir[$j]][0]+$data1[$nom_dir[$j]][1]+$data1[$nom_dir[$j]][2]+$data1[$nom_dir[$j]][3]+$data1[$nom_dir[$j]][4]+$data1[$nom_dir[$j]][5]+$data1[$nom_dir[$j]][6]+$data1[$nom_dir[$j]][7]+$data1[$nom_dir[$j]][8]+$data1[$nom_dir[$j]][9]+$data1[$nom_dir[$j]][10]+$data1[$nom_dir[$j]][11]+$data1[$nom_dir[$j]][12])/13;
         printf("%1.3f", $note_glob);
         echo'</td>'; }
            echo'<td>';
            echo '<font size=2 color="#ff0000" face="Verdana"><b>--</b></font>';
            echo'</td>';
            
            ?>
        
    </tr>
    

</tbody></table>

</center>

<br>
<center><img  src="resume_fichiers/img3.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<p>to view details click
<?
echo "<a href=index.php?page=ltprealt&project=$project_name>here</a>";?>
</p>
<br></br>
<hr style="width: 70%; height: 2px;">
<!-- </body></html> -->

