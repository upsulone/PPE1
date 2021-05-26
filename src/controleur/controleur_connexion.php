<?php

    function actionConnexion($twig, $db)
    {
        $form = array();

        if (isset($_POST['btConnecter'])) {
            $form['valide'] = true;
            $inputEmail = $_POST['inputEmail'];
            $inputPassword = $_POST['inputPassword'];
            $utilisateur = new Utilisateurppe1($db); // lien avec la classe Utilisateurppe1
            $connexion = new Connexion($db);
            $unUtilisateur = $utilisateur->connect($inputEmail);

            $unUtilisateur2 = $utilisateur->selectByEmail($_POST['inputEmail']);


            if ($unUtilisateur != null) { //si l'utilisateur existe
                if (!password_verify($inputPassword, $unUtilisateur['mdp'])) { //si le mot de passe n'est pas bon
                    $form['valide'] = false;

                    $testCo = $utilisateur->getnbtests($_POST['inputEmail']);
                    $utilisateur->updatetests($_POST['inputEmail'], $testCo[0]+1);
                    $testConex = $utilisateur->getnbtests($_POST['inputEmail']);
                    $dateco = date("Y-m-d H:i:s");
                    
                    if ($testConex[0] >= 3){ //si le nombre d'essais est suppérieur ou égal à 3
                        if ($testConex[0] == 3){

                            $connexion->connexion($inputEmail, $dateco, 0);
                        }
                        $testDelai10Min = $utilisateur->selectbloquer($_POST['inputEmail']);

                        // Create two new DateTime-objects...
                        $date1 = new DateTime($testDelai10Min[0][0]);
                        $date2 = new DateTime($testDelai10Min[0][1]);

                        // The diff-methods returns a new DateInterval-object...
                        $diff = $date2->diff($date1);

                        // Call the format method on the DateInterval-object
                        //var_dump($diff->format('%i')); // Nombres de minutes séparant le moment présent de la dernière connexion avec échec
                        if ($diff->format('%i') <= 10){

                            $differenceavec0 = 10- $diff->format('%i');
                            $form['message'] = 'Vous avez plus de 3 échecs, merci de patienter 10 minutes ('. $differenceavec0 .' minute(s) restante(s)) !';
                        }
                        else{
                            $utilisateur->updatetests($_POST['inputEmail'], 0);
                            $_SESSION['login'] = $inputEmail;
                            $_SESSION['role'] = $unUtilisateur['idRole'];
                            header("Location:index.php");
                        }


                    }
                    else{ //si le nombre d'essais est inférieur à 3
                        $valide = 0;
                        $connexion->connexion($inputEmail, $dateco, $valide);

                        $nbCoRestantes = 3 - intval($testConex[0]);
                        $form['message'] = "Login ou mot de passe incorrect, il vous reste ". $nbCoRestantes . " essai(s) !";

                    }



                } else { // si le mot de passe est bon
                    if ($unUtilisateur2['valide'] == 1) {
                        date_default_timezone_set('Europe/Paris');
                        $datedernier = date("Y-m-d H:i:s");
                        $dateco = date("Y-m-d H:i:s");
                        $utilisateur->updateconnect($inputEmail, $datedernier);

                        $testCo = $utilisateur->getnbtests($_POST['inputEmail']);

                        if ($testCo[0] < 3) { //si succès donc nbTests < 3
                            $_SESSION['login'] = $inputEmail;
                            $_SESSION['role'] = $unUtilisateur['idRole'];
                            $valide = 1;
                            $utilisateur->updatetests($_POST['inputEmail'], 0);
                            $connexion->connexion($inputEmail, $dateco, $valide);
                            header("Location:index.php");
                        }
                        else { //si echec donc nbTests > 3

                            $form['valide'] = false;


                            if ($testCo[0] >= 3){ //si le nombre d'essais est suppérieur ou égal à 3
                                $testDelai10Min = $utilisateur->selectbloquer($_POST['inputEmail']);

                                // Create two new DateTime-objects...
                                $date1 = new DateTime($testDelai10Min[0][0]);
                                $date2 = new DateTime($testDelai10Min[0][1]);

                                // The diff-methods returns a new DateInterval-object...
                                $diff = $date2->diff($date1);

                                // Call the format method on the DateInterval-object
                                //var_dump($diff->format('%i')); // Nombres de minutes séparant le moment présent de la dernière connexion avec échec
                                if ($diff->format('%i') < 10){
                                    $differenceavec0 = 10- $diff->format('%i');
                                    $form['message'] = 'Vous avez plus de 3 échecs, merci de patienter 10 minutes ('. $differenceavec0 .' minute(s) restante(s)) !';
                                }
                                else{
                                    //$form['message'] = '10 minutes écoulées, vous pouvez rententer de vous connecter !';
                                    $utilisateur->updatetests($_POST['inputEmail'], 0);
                                    $_SESSION['login'] = $inputEmail;
                                    $_SESSION['role'] = $unUtilisateur['idRole'];
                                    header("Location:index.php");
                                    $connexion->connexion($inputEmail, $dateco, 1);
                                }

                            }
                            else{
                                $nbCoRestantes = 3 - intval($testCo[0]);
                                $form['message'] = "Login ou mot de passe incorrect, il vous reste ". $nbCoRestantes . " essai(s) !";
                            }



                        }


                    } else {
                        $form['valide'] = false;
                        $form['message'] = 'Connexion non validée.';
                    }
                }
            } else { //si l'utilisateur n'existe pas
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';

            }
        }
        echo $twig->render('connexion.html.twig', array('form' => $form));
    }

