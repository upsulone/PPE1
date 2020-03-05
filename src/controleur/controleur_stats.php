<?php

function actionStats($twig, $db) {
    $graph = new Graphique($db);
    $liste = $graph->selectCountCo();
    $liste2 = $graph->selectJusteCo();


    $data = array(15, 3, 12, 15, 2, 17, 5, 8, 11, 13, 12, 9);

    $r = $graph->top($data, 'barres');

    $data = array(30, 60, 10);
    var_dump($data);
    var_dump($liste2);
    $r2 = $graph->top($data, 'pie');

//    $liste = $graph->selectCountCo();
//    var_dump($liste);

    echo $twig->render('stats.html.twig', array('graph' => $r, 'graph2' => $r2, 'liste' => $liste));
}

?>