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
$pass=0;
$fail=0;

$rep="$home/$user_name/projects/$project_name";

$dir = opendir($rep);

while ($f = readdir($dir))
{
    if ($f != "." && $f != "..")
    {
        if (is_dir($rep."/".$f))
        {  if(file_exists($rep."/".$f."/ltprealtime.xml"))
			{
			$url[$i]=$rep."/".$f."/ltprealtime.xml";
           $rss_file[$i] = file_get_contents($url[$i]);
           $xml[$i] = new SimpleXMLElement($rss_file[$i]);
           $nom_dir[$i]=$f;
           $i=$i+1;}
          
            
        }
    }
}
closedir($dir);
$max_rep=$i;

$data = array("Pass","Fail");
//echo $data[0];
for($i=0;$i<$max_rep;$i++)
{ 
if(strstr($xml[$i]->sched_latency->start,"PASS")!=NULL)
{$pass++;}
if(strstr($xml[$i]->sched_latency->start,"FAIL")!=NULL)
{$fail++;}
if(strstr($xml[$i]->sched_latency->min,"PASS")!=NULL)
{$pass++;}
if(strstr($xml[$i]->sched_latency->min,"FAIL")!=NULL)
{$fail++;}
if(strstr($xml[$i]->sched_latency->max,"PASS")!=NULL)
{$pass++;}
if(strstr($xml[$i]->sched_latency->max,"FAIL")!=NULL)
{$fail++;}
if(strstr($xml[$i]->sched_latency->avg,"PASS") !=NULL)
{$pass++;}
if(strstr($xml[$i]->sched_latency->avg,"FAIL")!=NULL)
{$fail++;}
$data1[$nom_dir[$i]][0]=($pass/4)*100;
$data1[$nom_dir[$i]][1]=($fail/4)*100;
$pass=0;
$fail=0;
}	
// Création du graphique conteneur
$graph = new Graph(700,400);
// Type d'échelle
$graph->SetScale("textlin");
// Fixer les marges
$graph->img->SetMargin(60,100,30,40);
//$graph->SetBackgroundImage('../fond.png',BGIMG_COPY);
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
$graph->yaxis->title->Set('(%)');
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->ygrid->SetColor('black');
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph->title->Set("Pass and Fail rate");
// TITRE: marge et apparence
$graph->title->SetFont(FF_FONT1,FS_BOLD,10);
// Couleurs et transparence par histogramme
$aColors=array('pink', 'teal', 'navy','lightblue', 'red', 'green');
$i=0;
$aGroupBarPlot = array();
foreach ($data1 as $key => $value) {
 $bplot = new BarPlot($data1[$key]);
 $bplot->SetFillColor($aColors[$i++]);
 $bplot->value->Show();
 $bplot->value->SetFormat('%01.2f');
 $bplot->value->SetColor("black","darkred");
 $bplot->SetLegend($key);
 $bplot->SetShadow('black');
 $bplot->SetWidth(0.2);
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
