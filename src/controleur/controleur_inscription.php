<?php

function actionInscrire($twig, $db) {
    $form = array();
    $dateinscription = date("d-m-Y");
    if (isset($_POST['btInscrire'])) {
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $inputPassword2 = $_POST['inputPassword2'];
        $nom = $_POST['inputSurname'];
        $prenom = $_POST['inputName'];
        $role = $_POST['role'];
        $photo = NULL;
        $dateinscription = date("Y-m-d"); //Ici le format n'est pas important dans le sens ou on ne le voit pas, et on l'affiche dans le profil en tant que date au bon format.
        $datedernier = date("Y-m-d"); 
        $numunique= uniqid();
        if (isset($_FILES['photo'])) {
            if (!empty($_FILES['photo']['name'])) {
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 500000;
                $dest_dossier = '/var/www/html/symfony4-4059/public/PPE1/web/images/';
                if (!in_array(substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok)) {
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                } else {
                    if (file_exists($_FILES['photo']['tmp_name']) && (filesize($_FILES['photo']
                                    ['tmp_name'])) > $taille_max) {
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    } else {
                        $photo = basename($_FILES['photo']['name']);
                        // enlever les accents

                        $photo = strtr($photo, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAA
AAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                        // copie du fichier
                        move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier . $photo);
                    }
                }
            }
        }

        $form['valide'] = true;
        if ($inputPassword != $inputPassword2) {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        } else {
            $utilisateur = new Utilisateurppe1($db);
            if ($photo == NULL) {
                $photo = 'vide.jpg'; //fait en sorte que si $photo est vide (lors de l'insertion) alors on mets le vide.png de base
            }
            $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword,
                            PASSWORD_DEFAULT), $role, $nom, $prenom, $photo, $dateinscription, $datedernier, $numunique); 
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
            }
        }
        $form['email'] = $inputEmail;
        $form['role'] = $role;
        $form['datedernier'] = $datedernier;
        $form['numunique'] = $numunique;
    }
    echo $twig->render('inscrire.html.twig', array('form' => $form));
}

?>