<?php
session_start();
include("../globals.php");
$user_name=$_SESSION["login"];
if($user_name == "")
{	echo "You must login to view this content";
	return;
}
$project_name = $_GET["project"];
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_bar.php");
$url = array();
$rss_file = array();
$xml = array();
$nom_dir=array();
$data1=array ();
$i=0;


$rep="$home/$user_name/projects/$project_name";
$dir = opendir($rep);
//echo $rep;
while ($f = readdir($dir))
{
    if ($f != "." && $f != "..")
    {
        if (is_dir($rep."/".$f))
        {  if(file_exists($rep."/".$f."/lmbench.xml"))
			{
			$url[$i]=$rep."/".$f."/lmbench.xml";
           $rss_file[$i] = file_get_contents($url[$i]);
           $xml[$i] = new SimpleXMLElement($rss_file[$i]);
           $nom_dir[$i]=$f;
           $i=$i+1;}
          
            
        }
    }
}
closedir($dir);
$max_rep=$i;

$data = array("pipe","af_unix","tcp","file-re","mmap-re","Bpy lbc","Bpy hd","Mem_rd ","Mem_wte");

for($i=0;$i<$max_rep;$i++)
{ if(strcmp($xml[$i]->local_communication_bandwith->pipe_bw,"    ") == 0)
{$data1[$nom_dir[$i]][0]=0;}
else{$data1[$nom_dir[$i]][0]=(float)($xml[$i]->local_communication_bandwith->pipe_bw);}
if (strcmp($xml[$i]->local_communication_bandwith->af_unix_bw,"    ")==0)
{$data1[$nom_dir[$i]][1]=0;}
else{$data1[$nom_dir[$i]][1]=(float)($xml[$i]->local_communication_bandwith->af_unix_bw);}
if (strcmp($xml[$i]->local_communication_bandwith->tcp_bw,"    ") == 0)
{$data1[$nom_dir[$i]][2]=0;}
else{$data1[$nom_dir[$i]][2]=(float)($xml[$i]->local_communication_bandwith->tcp_bw);}

if (strcmp($xml[$i]->local_communication_bandwith->filereread_bw,"      ") == 0)
{$data1[$nom_dir[$i]][3]=0;}
else{$data1[$nom_dir[$i]][3]=(float)($xml[$i]->local_communication_bandwith->filereread_bw);}

if (strcmp($xml[$i]->local_communication_bandwith->mmapreread_bw,"      ") == 0)
{$data1[$nom_dir[$i]][4]=0;}
else{$data1[$nom_dir[$i]][4]=(float)($xml[$i]->local_communication_bandwith->mmapreread_bw);}

if (strcmp($xml[$i]->local_communication_bandwith->bcopylibc_bw,"      ") == 0)
{$data1[$nom_dir[$i]][5]=0;}
else{$data1[$nom_dir[$i]][5]=(float)($xml[$i]->local_communication_bandwith->bcopylibc_bw);}

if (strcmp($xml[$i]->local_communication_bandwith->bcopyhand_bw,"      ") == 0)
{$data1[$nom_dir[$i]][6]=0;}
else{$data1[$nom_dir[$i]][6]=(float)($xml[$i]->local_communication_bandwith->bcopyhand_bw);}

if (strcmp($xml[$i]->local_communication_bandwith->memread_bw,"    ") == 0)
{$data1[$nom_dir[$i]][7]=0;}
else{$data1[$nom_dir[$i]][7]=(float)($xml[$i]->local_communication_bandwith->memread_bw);}
if (strcmp($xml[$i]->local_communication_bandwith->memwrite_bw,"     ") == 0)
{$data1[$nom_dir[$i]][8]=0;}
else{$data1[$nom_dir[$i]][8]=(float)($xml[$i]->local_communication_bandwith->memwrite_bw);}
}
// Création du graphique conteneur
$graph = new Graph(750,370);
//$graph->SetBackgroundImage('../fond.png',BGIMG_COPY);
// Type d'échelle
$graph->SetScale("textlin");
// Fixer les marges
$graph->img->SetMargin(60,100,30,40);
// Positionner la légende
$graph->legend->Pos(0,0.05);
// Couleur de l'ombre et du fond de la légende
$graph->legend->SetShadow('darkgray');
$graph->legend->SetFillColor('lightblue');
$graph->xaxis->SetTickLabels($data);
$graph->xaxis->title->Set('parametres');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('black');
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black');
$graph->xaxis->SetTitleMargin(10);

// AXE Y
$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('black');
$graph->yaxis->title->Set('bandwith(MB/s)');
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->ygrid->SetColor('black');
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph->title->Set("Local Communication bandwidths in MB/s");
// TITRE: marge et apparence
$graph->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme
$aColors=array('pink', 'teal', 'navy','lightblue', 'red', 'green');
$i=0;
$aGroupBarPlot = array();
foreach ($data1 as $key => $value) {
 $bplot = new BarPlot($data1[$key]);
 $bplot->SetFillColor($aColors[$i++]);
 $bplot->SetLegend($key);
 $bplot->SetShadow('black');
 $bplot->SetWidth(0.6);
 $aGroupBarPlot[] = $bplot;
}
// Création de l'objet qui regroupe nos histogrammes
$gbarplot = new GroupBarPlot($aGroupBarPlot);
$gbarplot->SetWidth(0.5);
// Ajouter au graphique
$graph->Add($gbarplot);
// Afficher
$graph->Stroke();


?>
