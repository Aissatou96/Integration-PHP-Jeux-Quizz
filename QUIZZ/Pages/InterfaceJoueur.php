<?php
is_connect();
$user = $_SESSION['user'];
require_once("Traitement/fonctions.php");
$questions = getData('questions');
$nquestions = count($questions);
$NbQ = (int)file_get_contents('Data/QuesParJeux.json');
if(isset($_GET['page'])){
    $pageActuelle = $_GET['page'];
  }else{
    $pageActuelle = 1;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/jeu.css">
    <title>Document</title>
</head>
<body>
<div class="container-interf">
    <div class="container-header-interf">
        <div class="joueur">
            <img src="../Images/img5.jpg" alt="">
            <label for=""><?= $user['prenom']." ".$user['nom'] ?></label>
        </div>
        <div class="titre">
              
        </div>
        <div class="btn">
            <button type="submit">Déconnexion</button>
        </div>
    </div>
    <div class="body-content">
        <div class="left">
            <div class="left-header">
                <h1>Question <?= $pageActuelle." / ".$NbQ ?></h1>
                <p><?= $questions[$pageActuelle]['question'] ?></p>
            </div>
            <?php
            if($questions[$pageActuelle]['typerep']=="choixS"){
                ?>
                <br>
                <?php
                for ($j=0; $j<count($questions[$pageActuelle]['reponses']); $j++){
                  ?>
                  <input type="radio" name="" id="">
                  <?php  
                    echo $questions[$pageActuelle]['reponses'] [$j];
                    ?> 
                    <br>
                    <?php
                }
                ?>
                <br>
                <?php
              }
              else if($questions[$pageActuelle]['typerep']=="choixM"){
                  ?>
                <br>
                <?php
                for ($j=0; $j<count($questions[$pageActuelle]['reponses']); $j++){
                  ?>
                  <input type="checkbox" name="" id="">
                  <?php  
                    echo $questions[$pageActuelle]['reponses'] [$j];
                    ?> 
                    <br>
                    <?php
                }
                ?>
                <br>
                <?php
             }
                 else if($questions[$pageActuelle]['typerep']=="choixT"){
                     ?>
                <br>
                <input type="text" name="" id="">
                <br><br>
                <?php
              
                  }
            ?>
        </div>
        
        <div class="right">
        <?php
            require_once("Traitement/fonctions.php");
            $afficher = getData();
            $joueurs = listeJoueur($afficher);
        ?>
        
        </div>
    
    </div>
    <div class="bouton">
    <a href="index.php?lien=jeux&page=<?= $pageActuelle-1 ?>"><input type="button" value="Précédent"></a>
    <a href="index.php?lien=jeux&page=<?= $pageActuelle+1 ?>"><input type="button" value="Suivant"></a>
    </div>    
    

</div>
</body>
</html>


