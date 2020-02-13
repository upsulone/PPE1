<?php 


// content="text/plain; charset=utf-8"

// Some data
$data = array(30, 60, 10);

// Create the Pie Graph. 
$graph = new PieGraph(1000,800);

// Don't display the border
$graph->SetFrame(false);
 

$theme_class= new VividTheme;
$graph->SetTheme($theme_class);

// Set A title for the plot
//$graph->title->Set("Membres les plus actifs");


// requette sql : SELECT * FROM `connexions` WHERE `dateco` between '2020-01-01' and '2020-12-01'

// ou alors SELECT COUNT(*) as nbcount FROM `connexions` WHERE `dateco` between '2020-01-01' and '2020-12-01'

// Create
$p1 = new PiePlot3D($data);
$graph->Add($p1);



$p1->ShowBorder();
$p1->SetColor('black');
$p1->ExplodeSlice(1);
$graph->Stroke();

?>