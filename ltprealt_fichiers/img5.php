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
$data1[$i]=(float)($xml[$i]->Matrix_Mult->Min_conc_op);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data2[$i]=(float)($xml[$i]->Matrix_Mult->Max_conc_op);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data3[$i]=(float)($xml[$i]->Matrix_Mult->Avg_conc_op);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data4[$i]=(float)($xml[$i]->Matrix_Mult->Stddev_conc_op);
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
$graph->xaxis->title->Set('solutious linux temps reel');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('black');
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black');
$graph->xaxis->SetTitleMargin(10);

// AXE Y
$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('black');
$graph->yaxis->title->Set('time(us)');
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->ygrid->SetColor('black');
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph->title->Set("Running concurrent operations -Mesuring Min(us)-");
// TITRE: marge et apparence
$graph->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot = new BarPlot($data1);
 $bplot->SetFillColor('teal');
 $bplot->value->Show();
 $bplot->value->SetFormat('%01.3f');
 $bplot->value->SetColor("black","darkred"); 
 $bplot->SetShadow('black');
 $bplot->SetWidth(0.3);
 $graph->Add($bplot);

//graphique2

// Création du graphique conteneur
$graph1 = new Graph(700,250);
// Type d'échelle
$graph1->SetScale("textlin");
// Fixer les marges
$graph1->img->SetMargin(60,100,30,40);
// Positionner la légende
$graph1->legend->Pos(0,0.05);
// Couleur de l'ombre et du fond de la légende
$graph1->legend->SetShadow('darkgray');
$graph1->legend->SetFillColor('lightblue');
$graph1->xaxis->SetTickLabels($data);
$graph1->xaxis->title->Set('solutious linux temps reel');
$graph1->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph1->xaxis->title->SetColor('black');
$graph1->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph1->xaxis->SetColor('black');
$graph1->xaxis->SetTitleMargin(10);

// AXE Y
$graph1->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph1->yaxis->SetColor('black');
$graph1->yaxis->title->Set('time(us)');
$graph1->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph1->ygrid->SetColor('black');
$graph1->yaxis->SetTitleMargin(45);
$graph1->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph1->title->Set("Running concurrent operations -Mesuring Max(us)");
// TITRE: marge et apparence
$graph1->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot1 = new BarPlot($data2);
 $bplot1->SetFillColor('lightblue');
  $bplot1->value->Show();
 $bplot1->value->SetFormat('%01.3f');
 $bplot1->value->SetColor("black","darkred"); 
 $bplot1->SetShadow('black');
 $bplot1->SetWidth(0.3);
 $graph1->Add($bplot1);


//graphique2

// Création du graphique conteneur
$graph2 = new Graph(700,250);
// Type d'échelle
$graph2->SetScale("textlin");
// Fixer les marges
$graph2->img->SetMargin(60,100,30,40);
// Positionner la légende
$graph2->legend->Pos(0,0.05);
// Couleur de l'ombre et du fond de la légende
$graph2->legend->SetShadow('darkgray');
$graph2->legend->SetFillColor('lightblue');
$graph2->xaxis->SetTickLabels($data);
$graph2->xaxis->title->Set('real time linux');
$graph2->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph2->xaxis->title->SetColor('black');
$graph2->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph2->xaxis->SetColor('black');
$graph2->xaxis->SetTitleMargin(10);

// AXE Y
$graph2->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph2->yaxis->SetColor('black');
$graph2->yaxis->title->Set('time(us)');
$graph2->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph2->ygrid->SetColor('black');
$graph2->yaxis->SetTitleMargin(45);
$graph2->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph2->title->Set("Async_Handler Results -Mesuring Average(us)");
// TITRE: marge et apparence
$graph2->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot2 = new BarPlot($data3);
 $bplot2->SetFillColor('pink');
 $bplot2->value->Show();
 $bplot2->value->SetFormat('%01.3f');
 $bplot2->value->SetColor("black","darkred"); 
 $bplot2->SetShadow('black');
 $bplot2->SetWidth(0.3);
 $bplot2->SetShadow('black');
 $bplot2->SetWidth(0.3);
 $graph2->Add($bplot2);

//graphique3

// Création du graphique conteneur
$graph3 = new Graph(700,250);
// Type d'échelle
$graph3->SetScale("textlin");
// Fixer les marges
$graph3->img->SetMargin(60,100,30,40);
// Positionner la légende
$graph3->legend->Pos(0,0.05);
// Couleur de l'ombre et du fond de la légende
$graph3->legend->SetShadow('darkgray');
$graph3->legend->SetFillColor('lightblue');
$graph3->xaxis->SetTickLabels($data);
$graph3->xaxis->title->Set('real time linux');
$graph3->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph3->xaxis->title->SetColor('black');
$graph3->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph3->xaxis->SetColor('black');
$graph3->xaxis->SetTitleMargin(10);

// AXE Y
$graph3->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph3->yaxis->SetColor('black');
$graph3->yaxis->title->Set('time(us)');
$graph3->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph3->ygrid->SetColor('black');
$graph3->yaxis->SetTitleMargin(45);
$graph3->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph3->title->Set("Running concurrent operations -Mesuring Standard Deviation(us)");
// TITRE: marge et apparence
$graph3->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot3 = new BarPlot($data4);
 $bplot3->SetFillColor('red');
 $bplot3->value->SetFormat('%01.3f');
 $bplot3->value->Show();
 $bplot3->SetShadow('black');
 $bplot3->value->SetColor("black","darkred"); 
 $bplot3->SetShadow('black');
 $bplot3->SetWidth(0.3);
 $graph3->Add($bplot3);
//-----------------------
// Create a multigraph
//----------------------
$mgraph = new MGraph();
$mgraph->SetMargin(10,10,10,10);
$mgraph->SetFrame(true,'darkgray',2);
$mgraph->SetBackgroundImage('../fond.png');
$mgraph->AddMix($graph,0,0,85);
$mgraph->AddMix($graph1,0,270,85);
$mgraph->AddMix($graph2,0,540,85);
$mgraph->AddMix($graph3,0,810,85);
$mgraph->Stroke();


?>
