<?php
    $titre= "Enregistrez-vous";
    require "../../src/common/template.php";
    require "../../src/fonction/mesFonctions.php";
    require "../../src/fonction/dbFonction.php";

    // si mon user est connecté je le renvoi sur la page d'accueil grace a ma fonction
    estConnecté();

    // definir la variable qui definira si le mdp est correct ou pas 
    if(isset($_SESSION["mdpNok"])&& $_SESSION["mdpNok"]== true){
         $mdpNok = $_SESSION["mdpNok"];
         $_SESSION["mdpNok"]= false;
    }
    else{
        $mdpNok = false;
    }
    
?>
<?php
    // Verifier si les input sont bien présent, et que ma méthod POST à été déclenché
    if(isset($_POST["nom"])&& !empty($_POST["nom"]) && !empty($_POST["login"])&& !empty($_POST["prenom"])&& !empty($_POST["email"])&& !empty($_POST["mdp"])&& !empty($_POST["mdp2"])){

        //Si l'avatar du user est vide, j'utiliserai l'avatar par défaut
        $photo =  "../../src/img/site/defaut_avatar.png";
        //je constuis un tableau avec les données recues
        $option = array(
            "nom"     =>FILTER_SANITIZE_STRING,
            "prenom"   =>FILTER_SANITIZE_STRING,
            "login"   =>FILTER_SANITIZE_STRING,
            "email"   =>FILTER_SANITIZE_EMAIL,
            "mdp"     =>FILTER_SANITIZE_STRING,
            "mdp2"    =>FILTER_SANITIZE_STRING
        );

        // creer un variable résult qui va accueillir les données saines
        $result= filter_input_array(INPUT_POST, $option);

        $nom= $result["nom"];
        $prenom= $result["prenom"];
        $login= $result["login"];
        $email= $result["email"];
        $mdp= $result["mdp"];
        $mdp2= $result["mdp2"];
        $role= 4;

        //verifier si les mdp sont identiques
        if($mdp == $mdp2){
            //hash du mdp
            $mdpHash = md5($mdp);
            //generer grain de sel
            $sel = grainDeSel(rand(5,20));
            //mot de passe à envoyer
            $mdpToSend = $mdpHash. $sel;
            $mdpNoK= false;
        }else{
            //booleen de controle
            $mdpNoK = TRUE;
            // j'active une session pour indiquer que les mdp sont noOk
            $_SESSION["mdpNok"]= true;
            //je recharge ma page
            header("location: ../../src/pages/register.php");
            exit();
        }
        //verifier si le user ou le mail n'est pas present dans la db 
        $bdd= new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8","root","");

        //check login
        $requete= $bdd->prepare("SELECT COUNT(*) AS x
                                    FROM users
                                    WHERE login= ?");
        $requete->execute(array($login));
        
        while($result= $requete->fetch()){
            if($result["x"] !=0){
                $_SESSION["msgLogin"]= true;
                header("location: ../../src/pages/register.php");
                exit();
            }
        }
        //check mail
        $requete= $bdd->prepare("SELECT COUNT(*) AS x
                                    FROM users
                                    WHERE email= ?");
        $requete->execute(array($email));
        
        while($result= $requete->fetch()){
            if($result["x"] !=0){
                $_SESSION["msgEmail"]= true;
                header("location: ../../src/pages/register.php");
                exit();
            }
        }

        // verifier si user a envoyer photo et agit en conséquence
        if(isset($_FILES["fichier"])&& $_FILES["fichier"]["error"]==0){
            $photo= sendImg($_FILES["fichier"],"avatar");
        }

        //mes données sont correctes elles sont saines, je peux créer mon user
        createuser($photo, $login, $nom, $prenom, $email, $mdpToSend, $role, $sel);

        // tout s'est bien passé
?>        
        <h2 class="registerOk">Votre compte est maintenant créer, vous pouvez vous <a href="../../src/pages/login.php">CONNECTER</a></h2>
<?php
    }else{

?>

<section class="register">   
    <form action="" method="POST" class="login" enctype="multipart/form-data">  
        <?php
        //si le booleen est true, afficher information pour inviter a connecter
            if(isset($_SESSION["msgEmail"]) && $_SESSION["msgEmail"]==true){
                echo "<h2> cet email possede deja un compte, veuillez vous connecter </h2>";
                $_SESSION["msgEmail"]= false;
            }
            //si le booleen est true afficher information pour inviter a connecter
            if(isset($_SESSION["msgLogin"]) && $_SESSION["msgLogin"]==true){
                echo "<h2> ce login possede deja un compte, veuillez vous connecter </h2>";
                $_SESSION["msgLogin"]= false;
            }
            if($mdpNok== true){
                $mdpNok=false;
                echo "<h2>Les mots de passes ne sont pas identiques </h2>";
            }
        ?>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Créer votre compte</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Prénom</td>
                    <td><Input type="text" name="prenom" required placeholder="Entrez votre Prénom"></td>
                </tr>
                <tr>
                    <td>Nom</td>
                    <td><Input type="text" name="nom" required placeholder="Entrez votre Nom"></td>
                </tr>
                <tr>
                    <td>Login</td>
                    <td><Input type="text" name="login" required placeholder="Entrez votre Login"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><Input type="email" name="email" required placeholder="Entrez votre email"></td>
                </tr>
                <tr>
                    <td>Mot de passe</td>
                    <td><Input type="password" name="mdp" required placeholder="Entrez votre mot de passe"></td>
                </tr>
                <tr>
                    <td>Mot de passe</td>
                    <td><Input type="password" name="mdp2" required placeholder="Répétez votre mot de passe"></td>
                </tr>
                <tr>
                    <td>Envoyer votre avatar</td>
                    <td><Input type="file" name="fichier" ></td>
                </tr>
                <tr>
                    <td><Input type="submit" value="Créer votre compte"></td>
                </tr>
            </tbody>
        </table>
    </form> 
</section> 
<?php
    }
    require "../../src/common/footer.php"
?>