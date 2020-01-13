<?php

function actionConnexion($twig, $db) {
    $form = array();
    if (isset($_POST['btConnecter'])) {
        $form['valide'] = true;
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $utilisateur = new Utilisateurppe1($db); // lien avec la classe Utilisateurppe1
        $unUtilisateur = $utilisateur->connect($inputEmail);
        if ($unUtilisateur != null) {
            if (!password_verify($inputPassword, $unUtilisateur['mdp'])) {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            } else {
                $_SESSION['login'] = $inputEmail;
                $_SESSION['role'] = $unUtilisateur['idRole']; 
                $datedernier = date("Y-m-d");
                $unUtilisateur = $utilisateur->updateconnect($inputEmail, $datedernier);
                header("Location:index.php");
            }
        } else {
            $form['valide'] = false;
            $form['message'] = 'Login ou mot de passe incorrect';
        }
    }
    echo $twig->render('connexion.html.twig', array('form' => $form));
}

?>
