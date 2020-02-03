<?php

class Connexion {

    private $db;    // déclaration de la variable en privé (uniquement pour la classe) // $db c'est la variable de connection
    private $connexion;

//    private $selectByEmailPhoto;



    public function __construct($db) {
        $this->db = $db;    //je parle à db dans le private et je lui donne la valeur qui est dans le __construct
        $this->connexion = $db->prepare("insert into connexions(emailco, dateco) values (:emailco, :dateco)");
    }


    public function connexion($inputEmail, $dateco) {
        $r = true;
        $this->connexion->execute(array(':emailco' => $inputEmail, ':dateco' => $dateco));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->connexion->errorCode() != 0) {
            print_r($this->connexion->errorInfo());
            $r = false;
        }
        return $r;
    }

}

?>