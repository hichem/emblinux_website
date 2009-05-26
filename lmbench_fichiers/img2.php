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

for($i=0;$i<$max_rep;$i++)
{$data[$i] = $nom_dir[$i];}
//echo $data[0];
for($i=0;$i<$max_rep;$i++)
{ 
if (strcmp($xml[$i]->integer_operation->int_bit,"      ")==0)
{$data1[$i]=0;}
else{$data1[$i]=(float)($xml[$i]->integer_operation->int_bit);}
}
for($i=0;$i<$max_rep;$i++)
{
if(strcmp($xml[$i]->integer_operation->int_add,"      ")==0)
{$data2[$i]=0;}
else{$data2[$i]=(float)($xml[$i]->integer_operation->int_add);}
}
for($i=0;$i<$max_rep;$i++)
{
if (strcmp($xml[$i]->integer_operation->int_mul,"      ")==0)
{$data3[$i]=0;}
else{$data3[$i]=(float)($xml[$i]->integer_operation->int_mul);}
}

for($i=0;$i<$max_rep;$i++)
{
if (strcmp($xml[$i]->integer_operation->int_div,"      ")==0)
{$data4[$i]=0;}
else{$data4[$i]=(float)($xml[$i]->integer_operation->int_div);}
}
for($i=0;$i<$max_rep;$i++)
{
if(strcmp($xml[$i]->integer_operation->int_mod,"      ")==0)
{$data5[$i]=0;}
else{$data5[$i]=(float)($xml[$i]->integer_operation->int_mod);}
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
$graph->yaxis->title->Set('time(nano-sec)');
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->ygrid->SetColor('black');
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph->title->Set("Mesuring latency Bit operation (nano-sec)");
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
//$graph1->SetBackgroundImage('../fond.png',BGIMG_COPY);

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
$graph1->yaxis->title->Set('time(nano-sec)');
$graph1->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph1->ygrid->SetColor('black');
$graph1->yaxis->SetTitleMargin(45);
$graph1->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph1->title->Set("Mesuring latency Add operation (nano-sec)");
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
//$graph1->SetBackgroundImage('../fond.png',BGIMG_COPY);
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
$graph2->yaxis->title->Set('time(nano-sec)');
$graph2->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph2->ygrid->SetColor('black');
$graph2->yaxis->SetTitleMargin(45);
$graph2->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph2->title->Set("Mesuring latency Mul operation(nano-sec)");
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
$graph3->yaxis->title->Set('time(nano-sec)');
$graph3->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph3->ygrid->SetColor('black');
$graph3->yaxis->SetTitleMargin(45);
$graph3->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph3->title->Set("Mesuring latency Div operation (nano-sec)");
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

// Type d'échelle
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
$graph4->yaxis->title->Set('time(nano-sec)');
$graph4->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph4->ygrid->SetColor('black');
$graph4->yaxis->SetTitleMargin(45);
$graph4->yaxis->scale->SetGrace(30);
// TITRE: texte
$graph4->title->Set("Mesuring latency Mod operation (nano-sec)");
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
$mgraph->Stroke();
?>
