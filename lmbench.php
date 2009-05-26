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
    <title>Lmbench Results</title>
    <link rel="stylesheet" href="lmbench_fichiers/css.css" type="text/css">
</head>
<body link="#1c3388" vlink="#1c3388" alink="#1c3388">
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
	  <td width=100 align=left><img alt="pingouin" src="lmbench_fichiers/opensource.jpg" height=70></td>
	  <td align=center  class="leftt"><b>LMbench Results</b></td>
	  <td width=100 align=right><img alt="logo" src="lmbench_fichiers/logo.jpg" height=70></td>
          <td height="30" bgcolor=#A2C0DF colspan="2"></td>
	</tr>
	</table>
      </td>
    </tr>
     

    
</table> -->

<p> 

<h1>
<b>Table of Contents</b>

</h1>

</p>

<ol>
    <li><a href="#introduction">Introduction</a></li>
    <li><a href="#basic">Basic system parameters</a></li>
    <li><a href="#processor">Processor, Processes latencies</a></li>
    <li><a href="#operations">Basic Mathematiques operations latencies</a></li>
    <li><a href="#context">Context switching latencies</a></li>

     <li><a href="#loccomm"> Local Communication latencies</a></li>
     <li><a href="#remcomm"> Remote Communication latencies</a></li>
     <li><a href="#locbw"> Local Communication bandwith</a></li>
      <li><a href="#mem"> Memory latencies</a></li>
     <li><a href="#File & VM"> File & VM system latencies</a></li>
      
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
$project_name = htmlspecialchars($_GET['project']);
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
<a name="basic"></a>
<h2> Basic system parameters </h2>
<table>
    <caption> Basic system parameters </caption>
    <tbody>
    <tr>

        <td> </td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>
    </tr>
   
    <tr>
	<th> Frequence </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       echo $xml[$j]->frequence;
                       echo'</td>';}?>

    </tr>
    <tr>
	<th> TLB pages </th>
                   
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->basic_sys_par->tlb_page,"     ") == 0)
                        {echo "--";}
                       else
                      { echo $xml[$j]->basic_sys_par->tlb_page;}
                       echo'</td>';}?>

	    
        
    </tr>
    <tr>
	<th> cache lines bytes </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                     if (strcmp($xml[$j]->basic_sys_par->cache_line,"     ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->basic_sys_par->cache_line;}
                       echo'</td>';}?>
	    
           </tr>
    <tr>
	<th> mem par  </th>
	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                    if (strcmp($xml[$j]->basic_sys_par->mem_par,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->basic_sys_par->mem_par;}
                      
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> scal load </th>
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->basic_sys_par->scal_load,"    ") == 0)
                        {echo "--";}
                      else
                      { 
                       echo $xml[$j]->basic_sys_par->scal_load;}
                       
                       echo'</td>';}?>
        
    </tr>
   
    
</tbody></table>
<br></br>
<a name="processor"></a>
<h2> Processor,Processes Latencies</h2>
 
<center>
<table width=500 height=370>
    <caption>Processor, Processes - times in microseconds - </caption>
    <tbody><tr>

        <td> </td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

       

    </tr>
   
    <tr>
	<th> Null call  </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->processor->simp_syscall,"    ") == 0)
                        {echo "--";}
                      else
                      { 
                       echo $xml[$j]->processor->simp_syscall;}
                       echo'</td>';}?>
        
    </tr>
    <tr>
	<th> Null I/O  </th>

	    <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->processor->simp_io,"    ") == 0)
                        {echo "--";}
                      else
                      { 
                       echo $xml[$j]->processor->simp_io;}
                       echo'</td>';}?>
            
        
    </tr>
    <tr>
	<th> simple stat  </th>
           <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->processor->simp_stat,"    ") == 0)
                        {echo "--";}
                      else
                      { 
                       echo $xml[$j]->processor->simp_stat;}
                       echo'</td>';}?>
	
    </tr>
    <tr>
	<th> Open/Close  </th>

	    <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->processor->simp_opcl,"    ") == 0)
                        {echo "--";}
                      else
                      { 
                       echo $xml[$j]->processor->simp_opcl;}
                       echo'</td>';}?>
        
    </tr>
    
    <tr>
	<th> select tcp </th>
        <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->processor->slt_tcp,"    ") == 0)
                        {echo "--";}
                      else
                      { 
                       echo $xml[$j]->processor->slt_tcp;}
                       echo'</td>';}?>  

    </tr>
    
     <tr>
	<th> sig ins </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->processor->sig_hand_ins,"    ") == 0)
                        {echo "--";}
                      else
                      { 
                       echo $xml[$j]->processor->sig_hand_ins;}
                       
                       echo'</td>';}?>  
        
    </tr>
    <tr>
	<th> sig hand </th>
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->processor->sig_hand_ovr,"    ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->processor->sig_hand_ovr;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> fork proc</th>
 
              <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->processor->fork_proc,"    ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->processor->fork_proc;}
                       echo'</td>';}?> 
	
    </tr>
    <tr>
	<th>exec proc</th>

         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->processor->exec_proc,"    ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->processor->exec_proc;};
                       echo'</td>';}?> 

       
    </tr>
    
    <tr>
	<th>sh proc</th>

         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->processor->sh_proc,"    ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->processor->sh_proc;}
                       echo'</td>';}?> 
       
    </tr>
  

    
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img1.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/></center>
<br></br>
<a name="operations"></a>
<h2> Basic Mathematiques operations latencies </h2>

<h3> Basic integer operations </h3>
<center>
<table width=500 height=370 >
    <caption> Basic integer operations - times in nanoseconds - </caption>
    <tbody><tr>

        <td> </td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>


    </tr>
   
    <tr>
	<th> int bit  </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                   if (strcmp($xml[$j]->integer_operation->int_bit,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->integer_operation->int_bit;}
                      echo'</td>';}?>     
       
    </tr>
    <tr>
	<th> int add  </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->integer_operation->int_add,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->integer_operation->int_add;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> int mul  </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                     if (strcmp($xml[$j]->integer_operation->int_mul,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->integer_operation->int_mul;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> int div  </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->integer_operation->int_div,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->integer_operation->int_div;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> int mod  </th>
               <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->integer_operation->int_mod,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->integer_operation->int_mod;}
                       echo'</td>';}?> 
    </tr>
       
</tbody></table>
<br></br><img  src="lmbench_fichiers/img2.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
</center>
<br></br>
<h3> Basic uint64 operations </h3>
<center>
<table  width=500 height=370>
    <caption> Basic uint64 operations - times in nanoseconds - </caption>
    <tbody><tr>

        <td> </td>
        <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>
    </tr>
   
    <tr>
	<th> int64 bit  </th>
        
                <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->int64_operation->int64_bit,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->int64_operation->int64_bit;}
                       echo'</td>';}?>    

    </tr>
    <tr>
	<th> int64 add  </th>
           
                <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->int64_operation->uint64_add,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->int64_operation->uint64_add;}
                       
                       echo'</td>';}?>
	
    </tr>
    <tr>
	<th> int64 mul  </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->int64_operation->int64_mul,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->int64_operation->int64_mul;}
                       echo'</td>';}?>  
    </tr>
    <tr>
	<th> int64 div  </th>
                <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                         if (strcmp($xml[$j]->int64_operation->int64_div,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->int64_operation->int64_div;}
                       echo'</td>';}?>  
    </tr>
    <tr>
	<th> int64 mod  </th>
                  <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                         if (strcmp($xml[$j]->int64_operation->int64_mod,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->int64_operation->int64_mod;}
                       echo'</td>';}?>  
    </tr>
    
    
    
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img3.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
</center>

<br></br>
<h3> Basic float operations </h3>
<center>
<table  width=500 height=370>
    <caption> Basic float operations - times in nanoseconds - </caption>
    <tbody><tr>
        <td> </td>
        <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

    </tr>
   
    
    <tr>
	<th> float add  </th>

	  <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->float_operation->float_add,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->float_operation->float_add;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> float mul  </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->float_operation->float_mul,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->float_operation->float_mul;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> float div  </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->float_operation->float_div,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->float_operation->float_div;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> float bogo  </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->float_operation->float_bog,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->float_operation->float_bog;}
                       echo'</td>';}?> 
    </tr>
    
    
    
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img4.php?project=<?php echo $project_name ?>"  border="2" vspace="10"/>
</center>
<h3> Basic double operations </h3>
<center>
<table   width=500 height=370>
    <caption> Basic double operations - times in nanoseconds - </caption>
    <tbody><tr>
        <td> </td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

    </tr>
   
    
    <tr>
	<th> double add  </th>
               <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->double_operation->double_add,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->double_operation->double_add;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> double mul  </th>

	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->double_operation->double_mul,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->double_operation->double_mul;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> double div  </th>

	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->double_operation->double_div,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->double_operation->double_div;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> double bogo  </th>

	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->double_operation->double_bog,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->double_operation->double_bog;}
                       echo'</td>';}?> 
    </tr>
    
    
    
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img5.php"  border="2" vspace="10"/>
</center>
<br></br>
<a name="context"></a>
<h2>  Context switching latencies </h2>
<center> 
  <table width=500 height=370>
    <caption> Context switching -times in microseconds- </caption>
    <tbody><tr>
        <td> </td>
        <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>


    </tr>
   
    
    <tr>
	<th> 2p/0K ctxsw  </th>
          
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                     if (strcmp($xml[$j]->context_switching->ctxsw_2p_0k,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->context_switching->ctxsw_2p_0k;}  
                      echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> 2p/16K ctxsw  </th>

	    <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->context_switching->ctxsw_2p_16k,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->context_switching->ctxsw_2p_16k;}
                       echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> 2p/64K ctxsw </th>

	   <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->context_switching->ctxsw_2p_64k,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->context_switching->ctxsw_2p_64k;}
                       echo'</td>';}?>   
        
    </tr>
    <tr>
	<th> 8p/16K ctxsw  </th>
                  <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->context_switching->ctxsw_8p_16k,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->context_switching->ctxsw_8p_16k;}
                       echo'</td>';}?>   
	
    </tr>
    <tr>
	<th> 8p/64K ctxsw </th>

	    
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                         if (strcmp($xml[$j]->context_switching->ctxsw_8p_64k,"      ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->context_switching->ctxsw_8p_64k;}
                       echo'</td>';}?>  
    </tr>
    <tr>
	<th> 16p/16K ctxsw  </th>
    
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->context_switching->ctxsw_16p_16k,"       ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->context_switching->ctxsw_16p_16k;}
                     echo'</td>';}?>  
    </tr>
    <tr>
	<th> 16p/64K ctxsw </th>

	
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                    if (strcmp($xml[$j]->context_switching->ctxsw_16p_64k,"       ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->context_switching->ctxsw_16p_64k;}
                       echo'</td>';}?>  
    </tr>
    
    
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img6.php?project=<?php echo $project_name ?>"  border="2" vspace="10" /> </center>
<br></br>
<a name="loccomm"></a>
<h2>  Local Communication latencies </h2>
<center>
  <table width=500 height=370>
    <caption> Local Communication latencies in microseconds - </caption>
    <tbody><tr>
        <td> </td>
        <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>


    </tr>
   
    
    <tr>
	<th> 2p/0K ctxsw  </th>
              
	
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                         if (strcmp($xml[$j]->local_communication_latency->ctxsw_2pp_0k,"     ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->local_communication_latency->ctxsw_2pp_0k;}
                      echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> Pipe  </th>
                  <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->local_communication_latency->pipe_lat,"     ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->local_communication_latency->pipe_lat;}
                     echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> AF UNIX </th>
               <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->local_communication_latency->af_unix_lat,"    ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->local_communication_latency->af_unix_lat;}
                     echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> UDP  </th>

	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       
                       if (strcmp($xml[$j]->local_communication_latency->udp_lat,"     ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->local_communication_latency->udp_lat;}
                       echo'</td>';}?>    
      
    </tr>
    <tr>
	<th> RPC/UDP </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->local_communication_latency->udp_rpc_lat,"     ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->local_communication_latency->udp_rpc_lat;}
                       echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> TCP  </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                     if (strcmp($xml[$j]->local_communication_latency->tcp_lat,"     ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->local_communication_latency->tcp_lat;}
                       echo'</td>';}?> 
       
    </tr>
    <tr>
	<th> RPC/TCP </th>

	     <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->local_communication_latency->tcp_rpc_lat,"     ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->local_communication_latency->tcp_rpc_lat;}
                       echo'</td>';}?> 
            
        
    </tr>
    <tr>
	<th> TCP CONNECTION </th>
            <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->local_communication_latency->tcp_connec_lat,"    ") == 0)
                      {echo "--";}
                      else
                      {echo $xml[$j]->local_communication_latency->tcp_connec_lat;}
                      echo'</td>';}?> 
	
    </tr>
    
    
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img7.php"  border="2" vspace="10" /> 
</center>
<br></br>
<a name="remcomm"></a>
<h2>  Remote Communication latencies </h2>
<center> 
  <table width=500 height=370>
    <caption> Remote Communication latencies in microseconds - </caption>
    <tbody><tr>
        <td> </td>
       <?for ($j = 0; $j < $max_rep;$j++)
             {  echo'<th>';
               
                echo $nom_dir[$j];
                echo'</th>';}?>

    </tr>
      
   
    <tr>
	<th> UDP  </th>
                <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->network_communication_latency->udp_lat_net,"     ") == 0)
                           {echo "--";}
                       else
                      { echo $xml[$j]->network_communication_latency->udp_lat_net;}
                       echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> RPC/UDP </th>
              <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->network_communication_latency->udp_rpc_lat_net,"     ") == 0)
                           {echo "--";}
                       else
                      { 
                       echo $xml[$j]->network_communication_latency->udp_rpc_lat_net;}
                       echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> TCP  </th>
          <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->network_communication_latency->tcp_lat_net,"     ") == 0)
                       {echo "--";}
                       else
                      { 
                       echo $xml[$j]->network_communication_latency->tcp_lat_net;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> RPC/TCP </th>
                 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->network_communication_latency->tcp_rpc_lat_net,"     ")== 0)
                           {echo "--";}
                       else
                      { 
                       echo $xml[$j]->network_communication_latency->tcp_rpc_lat_net;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> TCP CONNECTION </th>

	    <?for ($j = 0; $j < $max_rep;$j++)
                    {  echo'<td>';
                     if (strcmp($xml[$j]->network_communication_latency->tcp_connec_lat_net,"    ")== 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->network_communication_latency->tcp_connec_lat_net;}
                       echo'</td>';}?> 
        
    </tr>
    
    
</tbody></table>
<br></br>
<?
if(strcmp($xml[1]->network_communication_latency->udp_rpc_lat_net,"     ") != 0)
echo '<img  src="lmbench_fichiers/img8.php"  border="2" vspace="10"/>';
?>
</center>
<a name="locbw"></a>
<h2>  Local Communication bandwidths </h2>
<center>
  <table width=500 height=370>
    <caption> Local Communication bandwidths in MB/s - </caption>
    <tbody><tr>
        <td> </td>
         <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

    </tr>
      
   
    <tr>
	<th> Pipe </th>

	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->local_communication_bandwith->pipe_bw,"    ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->pipe_bw;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> AF UNIX </th>

	
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->local_communication_bandwith->af_unix_bw,"    ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->af_unix_bw;}
                       echo'</td>';}?> 
    </tr>
    
    <tr>
	<th> TCP  </th>

	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->local_communication_bandwith->tcp_bw,"    ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->tcp_bw;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> File reread </th>

	 
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->local_communication_bandwith->filereread_bw,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->filereread_bw;}
                       echo'</td>';}?>    
      
    </tr>
    
    <tr>
	<th> Mmap reread  </th>
            
	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->local_communication_bandwith->mmapreread_bw,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->mmapreread_bw;}
                       echo'</td>';}?>   
    
    </tr>
    <tr>
	<th> Bcopy libc</th>
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                         if (strcmp($xml[$j]->local_communication_bandwith->bcopylibc_bw,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->bcopylibc_bw;}
                       echo'</td>';}?>   
                              
       
    </tr>
    <tr>
	<th> Bcopy hand </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                         if (strcmp($xml[$j]->local_communication_bandwith->bcopyhand_bw,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->bcopyhand_bw;}
                       echo'</td>';}?>          
     </tr>
    <tr>
	<th> Memory read </th>
          
	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->local_communication_bandwith->memread_bw,"    ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->memread_bw;}
                       echo'</td>';}?>     
    </tr>
    <tr>
	<th> Memory write </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->local_communication_bandwith->memwrite_bw,"     ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->local_communication_bandwith->memwrite_bw;}
                       echo'</td>';}?> 
    </tr>
    
    
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img10.php?project=<?php echo $project_name ?>"  border="2" vspace="10" /></center>
<br></br>
<a name="mem"></a>
<h2> Memory latencies </h2>
<center>
  <table width=500 height=370>
    <caption> Memory latencies in nanoseconds - </caption>
    <tbody><tr>
        <td> </td>
        <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>

    </tr>
      
   
    <tr>
	<th> L1 $ </th>
             <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                    if (strcmp($xml[$j]->memory_latencies->L1,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->memory_latencies->L1;}
                       echo'</td>';}?> 
    </tr>
   <tr>
	<th> L2 $ </th>

	 <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->memory_latencies->L2,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->memory_latencies->L2;}
                       echo'</td>';}?> 
                       
    </tr>
    
   <tr>
	<th> Main mem </th>
           <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->memory_latencies->mainmem_lat,"           ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->memory_latencies->mainmem_lat;}
                       echo'</td>';}?> 
                       
	
    </tr>
     <tr>
	<th> Rand mem </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->memory_latencies->randmem_lat,"           ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->memory_latencies->randmem_lat;}
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> Guesses </th>

	  <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->memory_latencies->guesses_lat," ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->memory_latencies->guesses_lat;}
                      
                      echo'</td>';}?>
      
    </tr>
    
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img11.php"  border="2" vspace="10" /></center>
<br></br>
<a name="File & VM"></a>
<h2>  File & VM system latencies </h2>

<center>
  <table width=500 height=370 >
    <caption> File & VM system latencies in microseconds - </caption>
    <tbody><tr>
        <td> </td>
        <?for ($j = 0; $j <$max_rep;$j++)
             {  echo'<th>';
                echo $nom_dir[$j];
                echo'</th>';}?>
    </tr>
      
   
    <tr>
	<th> 0k File create  </th>
            <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->file_vm_latency->create_0k,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->file_vm_latency->create_0k;}
                      echo'</td>';}?> 
	
    </tr>
    <tr>
	<th> 0k File delete </th>
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->file_vm_latency->delete_0k,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->file_vm_latency->delete_0k;}
                      echo'</td>';}?> 
    </tr>
    
    <tr>
	<th> 10k File create  </th>
                <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                        if (strcmp($xml[$j]->file_vm_latency->create_10k,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->file_vm_latency->create_10k;};
                       echo'</td>';}?> 
    </tr>
    <tr>
	<th> 10k File delete </th>

	<?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                         if (strcmp($xml[$j]->file_vm_latency->delete_10k,"      ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->file_vm_latency->delete_10k;}
                       echo'</td>';}?> 
    </tr>
    
    <tr>
	<th> Mmap latency  </th>
    

         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                      if (strcmp($xml[$j]->file_vm_latency->mmap_lat,"       ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->file_vm_latency->mmap_lat;}
                      
                       echo'</td>';}?> 
      
    </tr>
    <tr>
	<th> Prot fault</th>
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->file_vm_latency->prot_fault,"     ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->file_vm_latency->prot_fault;}
                       echo'</td>';}?> 
      

    </tr>
    <tr>
	<th> Page fault</th>

        <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->file_vm_latency->page_fault,"       ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->file_vm_latency->page_fault;}
                       echo'</td>';}?> 
      
    </tr>
    <tr>
	<th> 100fd select </th>
         <?for ($j = 0; $j <$max_rep;$j++)
                    {  echo'<td>';
                       if (strcmp($xml[$j]->file_vm_latency->fd100_select,"     ") == 0)
                        {echo "--";}
                       else
                      { 
                       echo $xml[$j]->file_vm_latency->fd100_select;}
                       echo'</td>';}?> 
    </tr>
</tbody></table>
<br></br>
<img  src="lmbench_fichiers/img9.php?project=<?php echo $project_name ?>"  border="2" vspace="10" /></center>
 <br></br>                                       
 <center><img  src="lmbench_fichiers/img0.php?project=<?php echo $project_name ?>"  border="2" vspace="10"  width=500 height=370 /></center>
<br></br>

<br></br>
<br></br>
<hr style="width: 70%; height: 2px;">
<!-- </body></html> -->

