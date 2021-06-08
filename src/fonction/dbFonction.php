<?php
    //Enregistrer un nouvel utilisateur dans notre base de données
    function createuser($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban ){
        $bdd= new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8","root","");
        $requete =$bdd->prepare("INSERT INTO users(avatar, login, nom, prenom, email, mdp, roleId, ban)
                                VALUE (?,?,?,?,?,?,?,?)");
        $requete->execute(array($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban)) or die(print_r($requete->errorInfo(),true));                       
        $requete->closeCursor();
    }
    // Fonction pour se connecter au site
function login($user, $password){
    // connection à la db
    $bdd = new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8", "root", "");
    // requete pour récupérer l'user correspondant au login entré
    $requete = $bdd->query('SELECT * 
                            FROM users u 
                            INNER JOIN role r ON r.roleId = u.roleId;') or die(print_r($requete->errorInfo(), TRUE));

    // Traitement de la requete
    while($result = $requete->fetch()){
        if($result["login"] == $user){
            // sel du mdp envoyé avec le sel contenu dans la colonne ban
            $sel = md5($password) . $result["ban"];
            
            //J'active ma session user avec les infos dont je pourrai avoir besoin
            // tant que mon utilisateur est connecté 
            if($result["mdp"] == $sel){
                $_SESSION["connect"] = true;
                $_SESSION["user"] = [
                    "id" => $result["userId"],
                    "nom" => $result["nom"],
                    "prenom" => $result["prenom"],
                    "photo" => $result["avatar"],
                    "login" => $result["login"],
                    "email" => $result["email"],
                    "role" => $result["nomRole"]
                ];
                // J'active la session connecté
                $_SESSION["connecté"] = true;
                // Je redirige vers la page account
                header("location: ../../src/pages/account.php");
                exit();
            }
            else{
                
                header("location: ../../src/pages/login.php?erreur=Mot de passe incorrect");
                exit();
            }
        }
    }
    // Si mon script arrive ici, il est sorti de ma boucle sans trouver de user
    header("location: ../../src/pages/login.php?erreur=Identifiant inconnu, veuillez recommencer!");
    exit();
}

?>