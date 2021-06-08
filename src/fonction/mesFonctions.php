<?php
    //je cree ma fonction grain de sel qui va généré une chaine aléatoire que l'on rajoutera

    function grainDeSel($x){
        $chars= "1234";
        $string= "";
        //je cree une boucle qui va choisir une serie de x caractères
        //le x étant le paramètre de ma fonction qui sera lui aussi généré automatiquement
        for($i=0; $i<$x; $i++){
            $string .= $chars[rand(0, strlen($chars)-1)];
        }
        return $string;
    }


    function sendImg($photo, $destination){
        //décider ou doit aller ma fonction
        if($destination == "avatar"){
            $dossier= "../../src/img/avatar/" .time();
        }
        else{
            $dossier= "../../src/img/articles/" .time();
        }

        //créer un tableau avec les extension autorisées
        $extensionArray= ["png","jpg","jpeg","jfif","PNG","JPG","JPEG","JFIF"];
        //recuperer toutes les infos du fichier envoyer
        $infofichier= pathinfo($photo["name"]);
        //je recupere l'extension du fichier envoyé
        $extensionImage= $infofichier["extension"];

        //extension autorisée?
        if(in_array($extensionImage, $extensionArray)){
            //preparer le chemin repertoire + nom fichier
            $dossier .= basename($photo["name"]);
            //envoyer mon fichier
            move_uploaded_file($photo["tmp_name"],$dossier);
        }
        return $dossier;

    }
    // fonction pour savoir si un user est connecté ou non
    function estConnecté(){
        if(isset($_SESSION["connecté"])&& $_SESSION["connecté"]== true){
            header("location: ../../index.php");
        }
    }
    
?>