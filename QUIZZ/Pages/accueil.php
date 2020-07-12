<?php
    $user = $_SESSION['user'];
?>
<link rel="stylesheet" href="Style/accueil.css">
<div class="container-acc">
    <div class="container-header-acc">
        <div class="titre">CREER ET PARAMETRER VOS QUIZZ</div> 
        <div class="btn">
                <button type="submit"><a href="index.php?statut=logout">DECONNEXION</a> </button>
        </div>
    </div>
    <div class="container-acc-body">
        <div class="container-left">
        <div class="avatar">
                <div class="avatar-header">
                    <img src="<?= $user['avatar'] ?>" alt="">
                    <h3><?= $user['prenom']." ".$user['nom'] ?></h3>
                </div>
                <div class="liste">
                <ul>
                    <li><a href="index.php?lien=accueil&p=listQ">Liste Questions</a><img src="Icônes/ic-liste.png" alt=""></li><br><br>
                    <li><a href="index.php?lien=accueil&p=add">Créer Admin</a><img src="Icônes/ic-ajout.png" alt=""></li><br><br>
                    <li><a href="index.php?lien=accueil&p=listJ">Liste Joueurs</a><img src="Icônes/ic-liste-active.png" alt=""></li><br><br>
                    <li><a href="index.php?lien=accueil&p=addQ">Créer Questions</a><img src="Icônes/ic-ajout.png" alt=""></li><br><br>
                </ul>
                </div>
        </div>
        </div>
    <div class="container-right">
            <?php
                if(isset($_GET['p'])){
                    $page = $_GET['p'];
                    switch($page){
                        case 'listQ':
                            include("listeQuestions.php");
                        break;
                        case 'add':
                            include("inscription.php");
                        break;
                        case 'listJ':
                            include("listeJoueur.php");
                        break;
                        case 'addQ':
                            include("creerQuestions.php");
                    }
                }
            ?>
            
    </div>
    </div>
</div>