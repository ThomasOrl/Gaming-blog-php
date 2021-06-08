<?php
    //Enregistrer un nouvel utilisateur dans notre base de données
    function createuser($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban ){
        $bdd= new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8","root","");
        $requete =$bdd->prepare("INSERT INTO users(avatar, login, nom, prenom, email, mdp, roleId, ban)
                                VALUE (?,?,?,?,?,?,?,?)");
        $requete->execute(array($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban)) or die(print_r($requete->errorInfo(),true));                       
        $requete->closeCursor();
    }
        
?>