<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz</title>
</head>
<body style="font-family:calibri">
    <div class="content">
    <?php
     session_start();
        require_once("Traitement/fonctions.php");
        if(isset($_GET["lien"])){
            switch($_GET["lien"]){
                case "accueil":
                    require_once("Pages/accueil.php");
                break;
                case "jeux":
                    require_once("Pages/InterfaceJoueur.php");
                break;
                case "inscription":
                    require_once("Pages/inscription.php");
                break;
            }
        }else{
            if(isset($_GET['statut']) && $_GET['statut']==="logout"){
                deconnexion();
            }
            require_once("Pages/connexion.php");
       }
            
          #require_once("Pages/inscription.php");
          #require_once("Pages/interfaceJoueur.php");
    ?>
    </div>
</body>
</html>