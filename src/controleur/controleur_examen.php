<?php

    function actionLangExam($twig, $db)
    {
        $form = array();
        $coder = new Coder($db);
        $r = $coder->selectCountByUser();

        if(isset($_GET['nbMini'])){ // si nb mini

            $nbMini = $_GET['nbMini'];

            $graph = new Graphique($db);
            $tableau = array();

            foreach ($r as $tabDonnees) {
                if($tabDonnees[1] >= $nbMini){
                    array_push($tableau, $tabDonnees[1]);
                }
            }

            if(empty($tableau)){
                header("Location: http://serveur1.arras-sio.com/symfony4-4059/PPE1/web/index.php?page=langexam");
            }

            $rr = $graph->top($tableau, 'barresExam');
            
        }
        else{ // si pas de nb mini
            $graph = new Graphique($db);
            $tableau = array();

            foreach ($r as $tabDonnees) {
                array_push($tableau, $tabDonnees[1]);
            }

            $rr = $graph->top($tableau, 'barresExam');
        }

        echo $twig->render('langexam.html.twig', array('form' => $form, 'liste' => $r, 'graph' => $rr));
    }



