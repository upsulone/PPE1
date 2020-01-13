<?php

function actionContact($twig) {
    $form = array();
    if (isset($_POST['btContact'])) {
        $inputEmail = $_POST['inputEmail'];
        $Nom = $_POST['inputNom'];
        $Message = $_POST['inputMessage'];
        $form['valide'] = true;
        $form['email'] = $inputEmail;
        $form['nom'] = $Nom;
        $form['message'] = $Message;
    }
    echo $twig->render('contact.html.twig', array('form' => $form));
}

?>