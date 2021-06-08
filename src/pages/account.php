<?php
    $titre= "Votre compte";
    require "../../src/common/template.php";
    require "../../src/fonction/dbFonction.php";
    require "../../src/fonction/mesFonctions.php";

?>

<section id="account">
    <div class="account">
        <div class="infosMembre p-2">
                <a href="../../src/pages/account.php?edit=true"><img title="Cliquez pour changer votre avatar" src="<?=$_SESSION["user"]["photo"]?>" alt="avatar du membre"></a>
                <!-- si mon user a clique sur la photo je fais apparaitre un form -->
            <?php
                if(isset($_GET["edit"]) && $_GET["edit"] == true){
            ?>
                <form action="../../src/pages/account.php" method="POST" enctype="multipart/form-data"> 
                        <input type="file" name="fichier">
                        <input type="submit" value="Envoyer votre avatar">           
                </form>
            <?php
                }
            ?>
            <table>
                <tr>
                    <td>Pseudo:</td>
                    <td><?=$_SESSION["user"]["login"]?></td>
                </tr>
                <tr>
                    <td>Nom:</td>
                    <td><?=$_SESSION["user"]["nom"]?></td>
                </tr>
                <tr>
                    <td>Prenom:</td>
                    <td><?=$_SESSION["user"]["prenom"]?></td>
                </tr>
                <tr>
                    <td>role:</td>
                    <td><?=$_SESSION["user"]["role"]?></td>
                </tr>
            </table>
        </div>
        <div class="contenuMembre p-2">
        <?php
        // si le user est au moins auteur j'affiche une liste de ses articles
            if($_SESSION["user"]["role"] == "auteur" || $_SESSION["user"]["role"] == "admin"){
            ?>
                <h2>Vos articles</h2>
                <p>pas d'articles</p>
            <?php
            }
            ?>
                <h2>Vos commentaires</h2>
                <p>pas de commentaires</p>
        </div>

    </div>
</section>


<?php
    //traitement formulaire
    if(isset($_FILES["fichier"])){
        //appel la fonction sendImg()
        $photo = sendImg($_FILES["fichier"], "avatar");
    }

    require "../../src/common/footer.php";
?>