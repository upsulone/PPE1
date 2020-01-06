<?php

function actionAccueil($twig, $db) {
    echo $twig->render('index.html.twig', array());
}

function actionOne($twig, $db) {
    echo $twig->render('one.html.twig', array());
}

?>