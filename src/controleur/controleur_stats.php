<?php

function actionStats($twig, $db) {
    $graph = new Graphique($db);
    $data = array(15, 3, 12, 15, 2, 17, 5, 8, 11, 13, 12, 9);
    $r = $graph->top($data,'barres');
    
    $data = array(30, 60, 10);
    $r2 = $graph->top($data,'pie');
    
    echo $twig->render('stats.html.twig', array("graph" => $r,"graph2" => $r2));
}





?>