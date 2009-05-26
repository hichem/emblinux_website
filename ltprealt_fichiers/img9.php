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
include ("../jpgraph/jpgraph_mgraph.php");

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

for($i=0;$i<$max_rep;$i++)
{$data[$i] = $nom_dir[$i];}
for($i=0;$i<$max_rep;$i++)
{ 
$data1[$i]=(float)($xml[$i]->tc2c->delta);
}
	
//graphique1

// Création du graphique conteneur
$graph = new Graph(700,250);

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
$graph->xaxis->title->Set('real time linux');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('black');
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black');
$graph->xaxis->SetTitleMargin(10);

// AXE Y
$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('black');
$graph->yaxis->title->Set('time(s)');
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->ygrid->SetColor('black');
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph->title->Set("Mesuring Delta (s)");
// TITRE: marge et apparence
$graph->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot = new BarPlot($data1);
 $bplot->SetFillColor('lightblue');
 $bplot->value->Show();
 $bplot->value->SetFormat('%01.4f');
 $bplot->value->SetColor("black","darkred"); 
 $bplot->SetShadow('black');
 $bplot->SetWidth(0.3);
 $graph->Add($bplot);


//-----------------------
// Create a multigraph
//----------------------
$mgraph = new MGraph();
$mgraph->SetMargin(10,10,10,10);
$mgraph->SetFrame(true,'darkgray',2);
$mgraph->SetBackgroundImage('../fond.png');
$mgraph->AddMix($graph,0,0,85);

$mgraph->Stroke();


?>
