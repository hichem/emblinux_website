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

<!--<html xmlns="http://www.w3.org/1999/xhtml"><head>



    <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
    <title>LTP Realtime Results</title>
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
      <td colspan="2" >
        <table border=0  cellspacing=3 cellpadding=3 width=100%>

	<tr>
	  <td width=100 align=left><img alt="pingouin" src="ltprealt_fichiers/opensource.jpg" height=70></td>
	  <td align=center class="leftt"><b>LTP realtime Results</b></td>
	  <td width=100 align=right><img alt="logo" src="ltprealt_fichiers/logo.jpg" height=70></td>
          <td height="30" bgcolor=#A2C0DF colspan="2"></td>
	</tr>
	</table>
      </td>
    </tr>
     
<tr>
    
</table> -->

<h1>
<b>Table of Contents</b>
</h1>

<ol>
    <li><a href="#introduction">Introduction</a></li>
    <li><a href="#1">Async_handler Results</a></li>
    <li><a href="#2">Gtod_latency Results</a></li>
    <li><a href="#3">Matrix_mult Results</a></li>
    <li><a href="#4">Periodic_cpu_load Results</a></li>
    <li><a href="#5">Pi_perf Results</a></li>
    <li><a href="#6">Pi-tests Results</a></li>
    <li><a href="#7">Prio-preempt Results</a></li>
    <li><a href="#8">Prio-wake Results</a></li>
    <li><a href="#9">Pthread_kill_latency Results</a></li> 
    <li><a href="#10">Sched_football Results</a></li>
    <li><a href="#11">Sched_jitter Results</a></li>
    <li><a href="#12">Sched_latency Results</a></li>
    <li><a href="#13">Thread_clock Results</a></li>
</ol>

<br>

<hr style="width: 70%; height: 2px;">

<br>

<a name="introduction"></a>
<h2> Introduction </h2>
<p class="review">
this test is acheived on  
 <?php
$url = array();
$rss_file = array();
$xml = array();
$nom_dir=array();
$i=0;
/*$myVar1 = $_GET['nomdossier'];
$myvar= $_SESSION['rep'];
$rep = $myvar."/".$myVar1;*/

$dir = opendir($rep);
while ($f = readdir($dir))
{
    if ($f != "." && $f != "..")
    {
        if (is_dir($rep."/".$f))
        {  
	if(file_exists($rep."/".$f."/lmbench.xml"))
	{
	$url[$i]=$rep."/".$f."/lmbench.xml";
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
<?echo $xml[1]->hostname;?>
.the following kernels are tested :
<?
echo'<br>';
for ($j = 0; $j < $max_rep;$j++)
{
echo"***";
echo $xml[$j]->noyau;
echo'</li>';
echo'<br>';
}

?>

<br></br>
</p>

<?php

$i=0;
$project_name = htmlspecialchars($_GET['project']);
$rep = "$home/$user_name/projects/$project_name";
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

?>



<a name="1"></a>
<h2> Async_handler Results</h2>
<h3> Async_Handler_Jk </h3>
<p>
Mimics an async event handler in a real-time JVM. An async event server thread is created that goes to sleep waiting to be woken up to do some work.  A user thread is created that simulates the firing of an event by signalling the async handler thread to do some work.To success this test,Latencies must be lower than 100 us.
</p>
<center>
<table width=700 height=100>
<caption> Async_Handler_Jk Results <br></br></caption>

    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> Delta </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Async_Handler_Jk->delta;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Result </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Async_Handler_Jk->result;
                       echo'</td>';}?>

	    
        
    </tr>
    
</tbody></table>
<br></br>
<img  src="ltprealt_fichiers/img1.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<h3> Async_Handler </h3>
<p>
Measures latencies involved in asynchronous event handlers.Specifically it measures the latency of the pthread_cond_signal call until signalled thread is scheduled.To success this test,Latencies must be lower than 100 us.
</p>
<center>
<table width=700 height=200>
<caption> Async_Handler Results <br></br> </caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> Min </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Async_Handler->min;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Max </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Async_Handler->max;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Avg </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Async_Handler->avg;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Async_Handler->stddev;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Result </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Async_Handler->result;
                       echo'</td>';}?>
        
    </tr>
      
</tbody></table>
<br></br>
<img  src="ltprealt_fichiers/img2.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>

<a name="2"></a>
<h2> Gtod_latency Results </h2>
<p>Simple program to measure the time between several pairs of calls to gettimeofday().</p>  
<center>
<table width=700 height=200>
<caption> Gtod_latency Results </center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>
     
    </tr>
   <tr>
	<th> Iterations </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Gtod_latency->iteration;
                       echo'</td>';}?>
        
    </tr>
   
    <tr>
	<th> Min </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Gtod_latency->min;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Max </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Gtod_latency->max;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Avg </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Gtod_latency->avg;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Gtod_latency->stddev;
                       echo'</td>';}?>
    </tr>
  
</tbody></table>
<br></br>
<img  src="ltprealt_fichiers/img3.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<a name="3"></a>
<h2> Matrix_mult Results</h2>
<p>
  Compares running sequential matrix multiplication routines to running them in parallel in order to judge multiprocessor performance.Test runs for 100 iterations and calculates the average time.To success this test, 1.50 * average concurrent time must be lower than average sequential time.
</p>
<center>
<table width=700 height=200>
<caption> Matrix_mult Results</caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> Matrix Dimensions </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Matrix_Dimension;
                       echo'</td>';}?>

    </tr>
   
    <tr>
	<th> Calculations per iterations </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Calcul_Iteration;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Number of CPUs </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Num_cpu;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	    <td colspan="6" class="left">
            Running sequential operations:
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Min_seq;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Max_seq;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Avg_seq;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Stddev_seq;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	    <td colspan="6" class="left">
            Running concurrent operations (128x):
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Min_conc_op;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Max_conc_op;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Avg_conc_op;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Stddev_conc_op;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	    <td colspan="6" class="left">
            Concurrent Multipliers:
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Min_conc_Mul;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Max_conc_Mul;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->Avg_conc_Mul;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th>Result</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Matrix_Mult->result;
                       echo'</td>';}?>
        
    </tr>
    
</tbody></table>
<br></br>
<img  src="ltprealt_fichiers/img4.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
<img  src="ltprealt_fichiers/img5.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
</center>
<br></br>

<a name="4"></a>
<h2>Periodic_cpu_load Results</h2>
<h3> Periodic_cpu_load </h3>
<p>
Measures variation in computational execution time at various periods and priorities.This provides the timing information at different CPU loads.To success this test,TIDs did not miss a period.
<center>
<table width=700 height=200>
<caption>Periodic_cpu_load Results<br></br></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
    <tr>
	    <td colspan="6" class="left">
            TID 0 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid0->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid0->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid0->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid0->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid0->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 1 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid1->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid1->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid1->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid1->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid1->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 2 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid2->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid2->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid2->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid2->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid2->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 3 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid3->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid3->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid3->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid3->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid3->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 4 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid4->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid4->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid4->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid4->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid4->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 5 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid5->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid5->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid5->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid5->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid5->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 6 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid6->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid6->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid6->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid6->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid6->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 7 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid7->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid7->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid7->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid7->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid7->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 8 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid8->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid8->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid8->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid8->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid8->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 9 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid9->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid9->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid9->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid9->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid9->result;
                       echo'</td>';}?>
        
    </tr>
        <tr>
	    <td colspan="6" class="left">
            TID 10 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid10->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid10->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid10->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid10->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid10->result;
                       echo'</td>';}?>
        
    </tr>

    <tr>
	    <td colspan="6" class="left">
            TID 11 :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid11->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid11->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid11->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid11->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_Cpu_Load->Tid11->result;
                       echo'</td>';}?>
        
    </tr>
     
</tbody></table>
<br></br>
</center>
<br></br>
<h3>Periodic_cpu_load_single Results </h3>
<p>
Measures variation in computational execution time at specified period priority and loop.To pass this test,thread dont miss period.
<center>
<table width=700 height=200>
<caption> Periodic_cpu_load_single Results<br></br></center></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

         
       

    </tr>
   
    <tr>
	<th> Iterations </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->iteration;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> Priority </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->thread_priority ;
                       echo'</td>';}?>
	    
        
    </tr>
    <tr>
	<th> Period </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->period;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Loops </th>
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->loops;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	    <td colspan="6" class="left">
           Execution Time Statistics :
	    </td>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->time_statistics->min;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->time_statistics->max;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->time_statistics->avg;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->time_statistics->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Periodic_cpu_load_single->result;
                       echo'</td>';}?>
        
    </tr>
     
</tbody></table>
<img  src="ltprealt_fichiers/img6.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
<br></br>
</center>
<br></br>
<a name="5"></a>
<h2> Pi_perf Results</h2>
<p>
Create a scenario with one high, one low and several medium priority threads. Low priority thread holds a PI lock, high priority thread later tries to grab it. The test measures the maximum amount of time the high priority thread has to wait before it gets the lock. This time should be bound by the duration for which low priority thread holds the lock.
</p>
<center>
<table width=700 height=200>
<caption> Pi_perf Results </caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
    </tr>
   
    <tr>
	    <td colspan="6" class="left">
            Time taken for high prio thread to get the lock once released by low prio thread
	    </td>
    </tr>
    <tr>
	<th> Min wait time </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pi_perf->Min_wait;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Max wait time </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pi_perf->Max_Wait;
                       echo'</td>';}?>
        
    </tr>
 
    <tr>
	<th> Avg wait time</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pi_perf->Avg_Wait;
                       echo'</td>';}?>
        
    </tr>
   
    <tr>
	<th> Standard Deviation </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pi_perf->stddev;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Low prio lock held time (min) </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pi_perf->Low_prio_held;
                       echo'</td>';}?>
        
    </tr>
   <tr>
	<th> High prio lock wait time (max) </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pi_perf->High_prio_wait;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th>Result</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pi_perf->result;
                       echo'</td>';}?>
        
    </tr>
    
</tbody></table>
<br></br>
</center>
<br></br>
<a name="6"></a>
<h2> Pi_tests Results</h2>
<p>
Testpi-0: Tests whether the priority inheritance feature is present in kernel.
<br>
<br>
Testpi-1: Priority inheritance under two different scenarios.It checks whether the presence of priority inheritance allows higher priority threads to make more progress than in absence of the same.To pass this test, Low Priority Thread should Preempt Higher Priority Noise Thread.
<br>
<br>
Testpi-2: Introduces a noise thread in above test and checks if the high priority thread preempts low prio thread multiple times. To pass this test, Low Priority Thread and High Priority Thread should prempt each other multiple times.
<br>
<br>
Testpi-4: The scheduling policies of threads are different from previous testcase.
<br>
<br>
Testpi-5: Uses priority inheritance protocol (PTHREAD_PRIO_INHERIT) and uses test-skeleton.Test creates a child thread which tries to acquire lock twice.
<br>
<br>
Testpi-6:Uses robust mutex lock (PTHREAD_MUTEX_ROBUST_NP) and uses test-skeleton for other things.
</p>
<center>
<table width=700 height=200>
<caption> Pi_Tests Results <br></br></caption>
    <tbody>
     <tr>

        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
    </tr>
   
    <tr>
	    <td colspan="6" class="left">
            Testpi-0:
	    </td>
    </tr>
    <tr>
	<th> Priority inheritance </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                    if(strcmp($xml[$j]->testpi0->information,"Prio inheritance support present")==0)
                       echo "yes";
                       echo'</td>';}?>
        
    </tr>
    <tr>
	    <td colspan="6" class="left">
            Testpi-1:
	    </td>
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->testpi1->result;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	    <td colspan="6" class="left">
            Testpi-2:
	    </td>
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->testpi2->result;
                       echo'</td>';}?>
        
    </tr>
     <tr>
	    <td colspan="6" class="left">
            Testpi-4:
	    </td>
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->testpi4->result;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	    <td colspan="6" class="left">
            Testpi-5:
	    </td>
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->testpi5->result;
                       echo'</td>';}?>
        
    </tr>
    <tr>
	    <td colspan="6" class="left">
            Testpi-6:
	    </td>
    </tr>
    <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->testpi6->result;
                       echo'</td>';}?>
        
    </tr>
    
</tbody></table></center>
<br></br>
<a name="7"></a>
<h2> Prio-preempt Results</h2>
<p>
Tests priority preemption.Main thread creates multiple number of threads with different priorities, all fight for holding mutexes. Threads sleep and wake-up with condvars.Testcase exhibit scheduling of threads in accordance with priority preemption.To pass this test,All threads must be appropriately preempted within 1 loop(s).
</p>
<center>
<table width=700 height=200>
<caption> Prio-preempt Results<br></br> </caption>
    <tbody>
     <tr>
        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
     </tr>
     <tr>
	<th>Busy Thread</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Priority_Preemption->Busy_thread;
                       echo'</td>';}?>
    </tr>
     <tr>
	<th>Worker Thread</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Priority_Preemption->Worker_thread;
                       echo'</td>';}?>
    </tr>
     <tr>
	<th>Result</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Priority_Preemption->result;
                       echo'</td>';}?>
    </tr>
    
</tbody></table>
</center>

<a name="8"></a>
<h2> Prio-wake Results</h2>
<p>
Tests priority ordered wakeup with pthread_cond_*.  It creates number of worker threads with increasing FIFO priorities.  By default, the number of worker threads is equal to number of cpus.  The time when worker thread starts running is noted.  Each of the worker thread then waits on same  _condvar_. The time it wakes up is also noted.  Once all the threads finish execution, the start and wakeup times of all the threads are displayed. The output must indicate that the thread wakeup happened in a priority order.To pass this test successfully,Threads should be woken up in priority order.
</p>
<center>
<table width=700 height=150>
<caption> Prio-wake Results<br></br> </caption>
    <tbody>
     <tr>
        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
     </tr>
    <tr>
	<th>Worker Thread</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Prio_Wake->Worker_thread;
                       echo'</td>';}?>
    </tr>
     <tr>
	<th>Result</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Prio_Wake->result;
                       echo'</td>';}?>
    </tr>
    
</tbody></table>
</center>
<a name="9"></a>
<h2> Pthread_kill_latency Results </h2>
<p>
     Measures the latency involved in sending a signal to a thread using pthread_kill.Two threads are created: the one that recieves the signal (thread1) and other that sends signal (thread2).Before sending the signal,the thread2 waits for thread1 to initialize, notes the time and sends pthread_kill signal to thread1.Thread2, which has defined a handler for the signal, notes the time it receives the signal. The maximum and minimum latency is reported.To pass this test successfully,Time must be lower than 20 us.
</p>
<center>
<table width=700 height=100>
<caption>  Pthread_kill_latency Results <br></br> </caption>
    <tbody>
     <tr>
        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
     </tr>
    <tr>
	<th>Iteration</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pthread_Kill_Latency->iteration;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th>Min</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pthread_Kill_Latency->min;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th>Max</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pthread_Kill_Latency->max;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th>Avg</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pthread_Kill_Latency->avg;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th>Standard Deviation</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pthread_Kill_Latency->stddev;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Failures </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pthread_Kill_Latency->failures;
                       echo'</td>';}?>
    </tr>
     <tr>
	<th>Result</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Pthread_Kill_Latency->result;
                       echo'</td>';}?>
    </tr>
    
</tbody></table>
<br></br>
<img  src="ltprealt_fichiers/img7.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
</center>
<a name="10"></a>
<h2> Sched_football Results </h2>
<p>
A scheduler test that uses a football analogy.  The premise is that we want to make sure that lower priority threads (the offensive team) do not preempt higher priority threads (the defensive team).
</p>
<center>
<table width=700 height=80>
<caption> Sched_football Results <br></br> </caption>
    <tbody>
     <tr>
        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
     </tr>
    
     <tr>
	<th>Result</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Sched_Football->result;
                       echo'</td>';}?>
    </tr>
    
</tbody></table>
</center>
<a name="11"></a>
<h2> Sched_jitter Results </h2>
<p>
 Measures scheduling jitter between realtime processes.It spawns a realtime thread that repeatedly times how long it takes to do a fixed amount of work. It then prints out the maximum jitter seen (longest execution time the shortest execution time).It also spawns off a realtime thread of higher priority that simply wakes up and goes back to sleep. This tries to measure how much overhead the scheduler adds in switching quickly to another task and back.
</p>
<center>
<table width=700 height=80>
<caption> Sched_jitter Results <br></br> </caption>
    <tbody>
     <tr>
        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
     </tr>
    
     <tr>
	<th>  Max jitter </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->Sched_Jitter->Max_jitter;
                       echo'</td>';}?>
    </tr>
    
</tbody></table>
<br></br>
<img  src="ltprealt_fichiers/img8.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
</center>
<br></br>
<a name="12"></a>
<h2> Sched_Latency Results </h2>
<p>
Measures the latency involved with periodic scheduling.  A thread is created at priority 89.  It periodically sleeps for a specified duration (PERIOD).The delay is measured as delay = (now - start - i*PERIOD) converted to microseconds where now = CLOCK_MONOTONIC gettime in ns, start = CLOCK_MONOTONIC gettime at the start of the test, i = iteration number,PERIOD = the period chosen.To pass this test successfully,latencies must be lower than 100 us.

</p>
<center>
<table width=700 height=80>
<caption> Sched_Latency Results <br></br> </caption>
    <tbody>
     <tr>
        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
     </tr>
    
     <tr>
	<th> Start </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->sched_latency->start;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Min </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->sched_latency->min;
                       echo'</td>';}?>
    </tr>
   <tr>
	<th> Max </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->sched_latency->max;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Avg </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->sched_latency->avg;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Standard deviation</th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->sched_latency->stddev;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Information </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->sched_latency->information;
                       echo'</td>';}?>
    </tr>
    
     <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->sched_latency->result;
                       echo'</td>';}?>
    </tr>
    
</tbody></table>
<br></br>
<img  src="ltprealt_fichiers/img10.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
</center>
<br></br>
<a name="13"></a>
<h2> Thread_clock Results </h2>
<p>
Check if clock_gettime is working properly.  This test creates NUMSLEEP threads that just sleep and NUMWORK threads that spend time on the CPU . It then reads the thread cpu clocks of all these threads and compares the sum of thread cpu clocks with the process that spend time on the CPU . It then reads the cpu clock of all these threads and compares the sum of thread cpu clocks with the process cpu clock value . The test expects that: the cpu clock of every sleeping thread shows close to zero value.Sum of cpu clocks of all threads is comparable with the process cpu clock.To pass this test successfully,delta must be lower than 0.5000 s. </p>
<center>
<table width=700 height=80>
<caption> Thread_clock Results <br></br> </caption>
    <tbody>
     <tr>
        <td></td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>       
     </tr>
    
     <tr>
	<th> Process </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->tc2c->process;
                       echo'</td>';}?>
    </tr>
    <tr>
	<th> Threads </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->tc2c->thread;
                       echo'</td>';}?>
    </tr>
   <tr>
	<th> Delta </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->tc2c->delta;
                       echo'</td>';}?>
    </tr>
        
     <tr>
	<th> Result </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->tc2c->result;
                       echo'</td>';}?>
    </tr>
    
</tbody></table>
<br></br>
<img  src="ltprealt_fichiers/img9.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
</center>
<br></br>
<hr style="width: 70%; height: 2px;">
</body></html>

