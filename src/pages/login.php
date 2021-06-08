<?php
    $titre= "Connectez-vous";
    require "../../src/common/template.php";
    $mdpNok = false;
    require "../../src/fonction/mesFonctions.php";
    require "../../src/fonction/dbFonction.php";
    //si mon user est connecté je le renvoi sur l'accueil grace à ma fonction
    estConnecté();
     // traitement du formulaire
    if(isset($_POST["login"]) && isset($_POST["mdp"])){
        echo "<h1>Coucou</h1>";
        $login= htmlspecialchars($_POST["login"]);
        $mdp= htmlspecialchars($_POST["mdp"]);
        
        // mes données sont sécurisées, j'appel ma fonction pour connecter mon user
        login($login, $mdp);
    }else{
?>        
    <section class="register">
    <form action="../../src/pages/login.php" method="POST" class="login">
    <?php
        if(isset($_GET["erreur"])){
            ?>
                <h2><?=$_GET["erreur"]?></h2>
            <?php
        }
    ?>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Connectez-vous</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Login</td>
                    <td><input type="text" name="login"required placeholder="Entrer votre login"></td>
                </tr>
                <tr>
                    <td>Mot de passe</td>
                    <td><input type="password" name="mdp"required placeholder="Entrer votre mot de passe"></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Connectez-vous"></td>
                </tr>
            </tbody>
        </table>
    </form>
</section>
<?php
    }
?>


<?php
    require "../../src/common/footer.php";
?>