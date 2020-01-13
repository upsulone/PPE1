<?php

function actionAccueil($twig, $db) {
    echo $twig->render('index.html.twig', array());
}

function actionDeconnexion($twig) {
    session_unset();
    session_destroy();
    header("Location:index.php");
}


?>