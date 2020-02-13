<?php 



// content="text/plain; charset=utf-8"

$data1y=array(1, 3, 12, 15, 2, 17, 5, 8, 11, 13, 12, 9);



// Create the graph. These two calls are always required
$graph = new Graph(1000,800,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

//$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'));
$graph->yaxis->HideLine(false);
//$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($data1y);
//$b2plot = new BarPlot($data2y);
//$b3plot = new BarPlot($data3y);

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot));

// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#2056ac");

//$b2plot->SetColor("white");
//$b2plot->SetFillColor("#11cccc");
//
//$b3plot->SetColor("white");
//$b3plot->SetFillColor("#1111cc");

//$graph->title->Set("Dates de connexions PPE1");

// Display the graph
$graph->Stroke();



?>