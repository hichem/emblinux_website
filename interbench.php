<?php 
	session_start() ;
	include ('globals.php');
	$usr_id = $_SESSION['usr_id'];
	$user_name = $_SESSION['login'];
	if($usr_id == '')
	{
		echo '<BR /><BR /><font size="+3">You must login first</font>';
		return;
	}
//$_SESSION['nom']=$_GET['nomdossier'];
?>
<!--
<html xmlns="http://www.w3.org/1999/xhtml"><head>



    <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
    <title>Interbench Results</title>
    <link rel="stylesheet" href="interbench_fichiers/css.css" type="text/css">
</head>
<body link="#1c3388" vlink="#1c3388" alink="#1c3388">
<table align=center bgcolor=#fefefe border=0  width=100% cellspacing=0 cellpadding=0>
        <tr>
      <td colspan="2" >
        <table cellspacing=3 cellpadding=3 width=100%>   
      <tr>
      
      <td height="30" bgcolor=#A2C0DF colspan="2" class="left" >

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
	  <td width=100 align=left><img alt="pingouin" src="interbench_fichiers/opensource.jpg" height=70></td>
	  <td align=center class="leftt"><b>Interbench Results</b></td>
	  <td width=100 align=right><img alt="logo" src="interbench_fichiers/logo.jpg" height=70></td>
          <td height="30" bgcolor=#A2C0DF colspan="2"></td>
	</tr>
	</table>
      </td>
    </tr>
     
   <tr>
    
</table> -->
<p> 
<h1>
<b>Table of Contents</b>
</h1>
</p>

<ol>
    <li><a href="#introduction">Introduction</a></li>
    <li><a href="#1">Benchmarking simulated cpu of Audio</a></li>
    <li><a href="#2">Benchmarking simulated cpu of Video</a></li>
    <li><a href="#3">Benchmarking simulated cpu of X</a></li>
    <li><a href="#4">Benchmarking simulated cpu of Gaming</a></li>
     
</ol>

<br>

<hr style="width: 70%; height: 2px;">

<br>

<a name="introduction"></a>
<h2> Introduction </h2>

<p class="review">
the test is acheived using 
<?php
$url = array();
$rss_file = array();
$xml = array();
$nom_dir=array();
$i=0;
/*$myVar1 = $_GET['nomdossier'];
$myvar= $_SESSION['rep'];
$rep = $myvar."/".$myVar1;*/
$project_name = $_GET['project'];
$rep = "$home/$user_name/projects/$project_name";
$dir = opendir($rep);
while ($f = readdir($dir))
{
    if ($f != "." && $f != "..")
    {
        if (is_dir($rep."/".$f))
        {  
	if(file_exists($rep."/".$f."/interbench.xml"))
	{
	$url[$i]=$rep."/".$f."/interbench.xml";
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
<?echo $xml[1]->informations->loop;?>
,each load takes <?echo $xml[1]->informations->duree_load;?> .the following kernels are tested by interbench: 
<?
echo'<br>';
for ($j = 0; $j <$max_rep;$j++)
{
echo"***";
echo $xml[$j]->informations->noyau;
echo'<br>';
}

?>

<br></br>
</p>
<a name="1"></a>
<h2> Benchmarking simulated cpu of Audio </h2>
<h3> Latency </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Audio in the presence of simulated  
<center>-Mesuring Latency(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->none->latence;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->video->latence;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->x->latence;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->burn->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->write->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->read->latence;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->compile->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->memload->latence;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img1.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<h3> SD </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Audio in the presence of simulated  
<center>-Mesuring SD(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->none->sd;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->video->sd;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->x->sd;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->burn->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->write->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->read->sd;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->compile->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->memload->sd;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img2.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Max latency  </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Audio in the presence of simulated  
<center>-Mesuring Max latency(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->none->max_lat;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->video->max_lat;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->x->max_lat;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->burn->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->write->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->read->max_lat;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->compile->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->memload->max_lat;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img3.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Desired CPU </h3>

<center> <table width=700 height=320>
<caption> Benchmarking simulated cpu of Audio in the presence of simulated  
<center>-Mesuring Desired CPU(%)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

      </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->none->cpu;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->video->cpu;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->x->cpu;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->burn->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->write->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->read->cpu;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->compile->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->memload->cpu;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img4.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Deadlines Met </h3>
<center><table width=700 height=320>
<caption> Benchmarking simulated cpu of Audio in the presence of simulated  
<center>-Mesuring Deadlines Met(%)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

      </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->none->dead;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->video->dead;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->x->dead;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->burn->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->write->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->read->dead;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->compile->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->audio->memload->dead;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img5.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<a name="2"></a>
<h2> Benchmarking simulated cpu of Video </h2>
<h3> Latency </h3>
<center><table width=700 height=320>
<caption> Benchmarking simulated cpu of Video in the presence of simulated  
<center>-Mesuring Latency(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->none->latence;
                       echo'</td>';}?>

    </tr>
   
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->x->latence;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->burn->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->write->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->read->latence;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->compile->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->memload->latence;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img6.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> SD </h3>
<center><table width=700 height=320>
<caption> Benchmarking simulated cpu of Video in the presence of simulated  
<center>-Mesuring SD(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->none->sd;
                       echo'</td>';}?>

    </tr>
    
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->x->sd;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->burn->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->write->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->read->sd;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->compile->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->memload->sd;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img7.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Max latency  </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Video in the presence of simulated  
<center>-Mesuring Max latency(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->none->max_lat;
                       echo'</td>';}?>

    </tr>
   
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->x->max_lat;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->burn->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->write->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->read->max_lat;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->compile->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->memload->max_lat;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img8.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Desired CPU </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Video in the presence of simulated  
<center>-Mesuring Desired CPU(%)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

      </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->none->cpu;
                       echo'</td>';}?>

    </tr>
   
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->x->cpu;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->burn->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->write->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->read->cpu;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->compile->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->memload->cpu;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img9.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Deadlines Met </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Video in the presence of simulated  
<center>-Mesuring Deadlines Met(%)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

      </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->none->dead;
                       echo'</td>';}?>

    </tr>
   
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->x->dead;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->burn->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->write->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->read->dead;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->compile->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->video->memload->dead;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img10.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<a name="3"></a>
<h2> Benchmarking simulated cpu of X </h2>
<h3> Latency </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of X in the presence of simulated  
<center>-Mesuring Latency(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->none->latence;
                       echo'</td>';}?>

    </tr>
   
    <tr>
	<th> video </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->video->latence;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->burn->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->write->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->read->latence;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->compile->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->memload->latence;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img11.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> SD </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of X in the presence of simulated  
<center>-Mesuring SD(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->none->sd;
                       echo'</td>';}?>

    </tr>
    
   <tr>
	<th> video </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->video->sd;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->burn->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->write->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->read->sd;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->compile->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->memload->sd;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img12.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Max latency  </h3>
<center>
<table width=400 height=320>
<caption> Benchmarking simulated cpu of X in the presence of simulated  
<center>-Mesuring Max latency(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->none->max_lat;
                       echo'</td>';}?>

    </tr>
   
     <tr>
	<th> video </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->video->max_lat;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->burn->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->write->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->read->max_lat;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->compile->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->memload->max_lat;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img13.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Desired CPU </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of X in the presence of simulated  
<center>-Mesuring Desired CPU(%)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

      </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->none->cpu;
                       echo'</td>';}?>

    </tr>
   
     <tr>
	<th> video </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->video->cpu;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->burn->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->write->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->read->cpu;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->compile->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->memload->cpu;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img14.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Deadlines Met </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of X in the presence of simulated  
<center>-Mesuring Deadlines Met(%)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

      </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->none->dead;
                       echo'</td>';}?>

    </tr>
   
     <tr>
	<th> video </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->video->dead;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->burn->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->write->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->read->dead;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->compile->dead;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->x->memload->dead;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img15.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<a name="4"></a>
<h2> Benchmarking simulated cpu of Gaming </h2>
<h3> Latency </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Gaming in the presence of simulated  
<center>-Mesuring Latency(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->none->latence;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->video->latence;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->x->latence;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->burn->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->write->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->read->latence;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->compile->latence;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->memload->latence;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img16.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> SD </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Gaming in the presence of simulated  
<center>-Mesuring SD(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->none->sd;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->video->sd;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->x->sd;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->burn->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->write->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->read->sd;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->compile->sd;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->memload->sd;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img17.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Max latency  </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Gaming in the presence of simulated  
<center>-Mesuring Max latency(ms)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->none->max_lat;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->video->max_lat;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->x->max_lat;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->burn->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->write->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->read->max_lat;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->compile->max_lat;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->memload->max_lat;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img18.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<h3> Desired CPU </h3>
<center>
<table width=700 height=320>
<caption> Benchmarking simulated cpu of Gaming in the presence of simulated  
<center>-Mesuring Desired CPU(%)-</center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

      </tr>
   
    <tr>
	<th> None </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->none->cpu;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Video </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->video->cpu;
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> X </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->x->cpu;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Burn  </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->burn->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Write </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->write->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Read </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->read->cpu;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Compile </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->compile->cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> memload </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->gaming->memload->cpu;
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<img  src="interbench_fichiers/img19.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<br></br>
<hr style="width: 70%; height: 2px;">
<!--</body></html>-->

