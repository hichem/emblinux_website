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
        {  if(file_exists($rep."/".$f."/interbench.xml"))
			{
			$url[$i]=$rep."/".$f."/interbench.xml";
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
$data1[$i]=(float)($xml[$i]->audio->none->max_lat);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data2[$i]=(float)($xml[$i]->audio->video->max_lat);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data3[$i]=(float)($xml[$i]->audio->x->max_lat);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data4[$i]=(float)($xml[$i]->audio->burn->max_lat);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data5[$i]=(float)($xml[$i]->audio->write->max_lat);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data6[$i]=(float)($xml[$i]->audio->read->max_lat);
}

for($i=0;$i<$max_rep;$i++)
{ 
$data7[$i]=(float)($xml[$i]->audio->compile->max_lat);
}
for($i=0;$i<$max_rep;$i++)
{ 
$data8[$i]=(float)($xml[$i]->audio->memload->max_lat);
}
//graphique1

// Création du graphique conteneur
$graph = new Graph(700,250);
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
$graph->xaxis->title->Set('real time linux');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('black');
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black');
$graph->xaxis->SetTitleMargin(10);

// AXE Y
$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('black');
$graph->yaxis->title->Set('time(ms)');
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->ygrid->SetColor('black');
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph->title->Set("Benchmarking simulated cpu of Audio in the presence of simulated None -Mesuring max_lat-");
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
$graph1->xaxis->title->Set('real time linux');
$graph1->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph1->xaxis->title->SetColor('black');
$graph1->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph1->xaxis->SetColor('black');
$graph1->xaxis->SetTitleMargin(10);

// AXE Y
$graph1->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph1->yaxis->SetColor('black');
$graph1->yaxis->title->Set('time(ms)');
$graph1->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph1->ygrid->SetColor('black');
$graph1->yaxis->SetTitleMargin(45);
$graph1->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph1->title->Set("Benchmarking simulated cpu of Audio in the presence of simulated Video -Mesuring max_lat-");
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
$graph2->yaxis->title->Set('time(ms)');
$graph2->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph2->ygrid->SetColor('black');
$graph2->yaxis->SetTitleMargin(45);
$graph2->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph2->title->Set("Benchmarking simulated cpu of Audio in the presence of simulated X -Mesuring max_lat-");
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
$graph3->yaxis->title->Set('time(ms)');
$graph3->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph3->ygrid->SetColor('black');
$graph3->yaxis->SetTitleMargin(45);
$graph3->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph3->title->Set("Benchmarking simulated cpu of Audio in the presence of simulated burn -Mesuring max_lat-");
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

//graphique4

// Création du graphique conteneur
$graph4 = new Graph(700,250);

$graph4->SetScale("textlin");
// Fixer les marges
$graph4->img->SetMargin(60,100,30,40);
// Positionner la légende
$graph4->legend->Pos(0,0.05);
// Couleur de l'ombre et du fond de la légende
$graph4->legend->SetShadow('darkgray');
$graph4->legend->SetFillColor('lightblue');
$graph4->xaxis->SetTickLabels($data);
$graph4->xaxis->title->Set('real time linux');
$graph4->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph4->xaxis->title->SetColor('black');
$graph4->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph4->xaxis->SetColor('black');
$graph4->xaxis->SetTitleMargin(10);

// AXE Y
$graph4->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph4->yaxis->SetColor('black');
$graph4->yaxis->title->Set('time(ms)');
$graph4->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph4->ygrid->SetColor('black');
$graph4->yaxis->SetTitleMargin(45);
$graph4->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph4->title->Set("Benchmarking simulated cpu of Audio in the presence of simulated write -Mesuring max_lat-");
// TITRE: marge et apparence
$graph4->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot4 = new BarPlot($data5);
 $bplot4->value->Show();
 $bplot4->SetFillColor('blue');
 $bplot4->value->SetFormat('%01.3f');
 $bplot4->value->SetColor("black","darkred"); 
 $bplot4->SetShadow('black');
 $bplot4->SetWidth(0.3);
 $graph4->Add($bplot4);

//graphique5

// Création du graphique conteneur
$graph5 = new Graph(700,250);
// Type d'échelle
$graph5->SetScale("textlin");
// Fixer les marges
$graph5->img->SetMargin(60,100,30,40);
// Positionner la légende
$graph5->legend->Pos(0,0.05);
// Couleur de l'ombre et du fond de la légende
$graph5->legend->SetShadow('darkgray');
$graph5->legend->SetFillColor('lightblue');
$graph5->xaxis->SetTickLabels($data);
$graph5->xaxis->title->Set('real time linux');
$graph5->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph5->xaxis->title->SetColor('black');
$graph5->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph5->xaxis->SetColor('black');
$graph5->xaxis->SetTitleMargin(10);

// AXE Y
$graph5->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph5->yaxis->SetColor('black');
$graph5->yaxis->title->Set('time(ms)');
$graph5->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph5->ygrid->SetColor('black');
$graph5->yaxis->SetTitleMargin(45);
$graph5->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph5->title->Set("Benchmarking simulated cpu of Audio in the presence of simulated Read -Mesuring max_lat-");
// TITRE: marge et apparence
$graph5->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot5 = new BarPlot($data6);
 $bplot5->SetFillColor('gray');
 $bplot5->SetShadow('black');
 $bplot5->value->SetColor("black","darkred"); 
 $bplot5->value->SetFormat('%01.3f');
 $bplot5->value->Show();
 $bplot5->SetWidth(0.3);
 $graph5->Add($bplot5);

//graphique6

// Création du graphique conteneur
$graph6 = new Graph(700,250);
// Type d'échelle
$graph6->SetScale("textlin");
// Fixer les marges
$graph6->img->SetMargin(60,100,30,40);
// Positionner la légende
$graph6->legend->Pos(0,0.05);
// Couleur de l'ombre et du fond de la légende
$graph6->legend->SetShadow('darkgray');
$graph6->legend->SetFillColor('lightblue');
$graph6->xaxis->SetTickLabels($data);
$graph6->xaxis->title->Set('real time linux');
$graph6->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph6->xaxis->title->SetColor('black');
$graph6->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph6->xaxis->SetColor('black');
$graph6->xaxis->SetTitleMargin(10);

// AXE Y
$graph6->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph6->yaxis->SetColor('black');
$graph6->yaxis->title->Set('time(ms)');
$graph6->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph6->ygrid->SetColor('black');
$graph6->yaxis->SetTitleMargin(45);
$graph6->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph6->title->Set("Benchmarking simulated cpu of Audio in the presence of simulated Compile -Mesuring max_lat-");
// TITRE: marge et apparence
$graph6->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot6 = new BarPlot($data7);
 $bplot6->SetFillColor('black');
 $bplot6->SetShadow('black');
 $bplot6->value->Show();
 $bplot6->value->SetColor("black","darkred"); 
 $bplot6->value->SetFormat('%01.3f');
 $bplot6->SetWidth(0.3);
 $graph6->Add($bplot6);

//graphique7

// Création du graphique conteneur
$graph7 = new Graph(700,250);

// Type d'échelle
$graph7->SetScale("textlin");
// Fixer les marges
$graph7->img->SetMargin(60,100,30,40);
// Positionner la légende
$graph7->legend->Pos(0,0.05);
// Couleur de l'ombre et du fond de la légende
$graph7->legend->SetShadow('darkgray');
$graph7->legend->SetFillColor('lightblue');
$graph7->xaxis->SetTickLabels($data);
$graph7->xaxis->title->Set('real time linux');
$graph7->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph7->xaxis->title->SetColor('black');
$graph7->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph7->xaxis->SetColor('black');
$graph7->xaxis->SetTitleMargin(10);

// AXE Y
$graph7->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph7->yaxis->SetColor('black');
$graph7->yaxis->title->Set('time(ms)');
$graph7->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph7->ygrid->SetColor('black');
$graph7->yaxis->SetTitleMargin(45);
$graph7->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph7->title->Set("Benchmarking simulated cpu of Audio in the presence of simulated Memload -Mesuring max_lat-");
// TITRE: marge et apparence
$graph7->title->SetFont(FF_FONT1,FS_BOLD,11);
// Couleurs et transparence par histogramme

 $bplot7 = new BarPlot($data8);
 $bplot7->SetFillColor('green');
 $bplot7->value->Show();
 $bplot7->value->SetFormat('%01.3f');
 $bplot7->value->SetColor("black","darkred"); 
 $bplot7->SetShadow('black');
 $bplot7->SetWidth(0.3);
 $graph7->Add($bplot7);

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
$mgraph->AddMix($graph4,0,1080,85);
$mgraph->AddMix($graph5,0,1350,85);
$mgraph->AddMix($graph6,0,1620,85);
$mgraph->AddMix($graph7,0,1890,85);

$mgraph->Stroke();



?>
