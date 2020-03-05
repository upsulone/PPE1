<?php

function actionConnexion($twig, $db) {
    $form = array();
    if (isset($_POST['btConnecter'])) { 
        $form['valide'] = true;
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $utilisateur = new Utilisateurppe1($db); // lien avec la classe Utilisateurppe1
        $connexion = new Connexion($db);
        $unUtilisateur = $utilisateur->connect($inputEmail);
        if ($unUtilisateur != null) {
            if (!password_verify($inputPassword, $unUtilisateur['mdp'])) {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            } else {
                $_SESSION['login'] = $inputEmail;
                $_SESSION['role'] = $unUtilisateur['idRole'];
                date_default_timezone_set('Europe/Paris');
                $datedernier = date("Y-m-d H:i:s");
                $dateco = date("Y-m-d H:i:s");
                $unUtilisateur = $utilisateur->updateconnect($inputEmail, $datedernier);
                $connexion->connexion($inputEmail, $dateco);
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
