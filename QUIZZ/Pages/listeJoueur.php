<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
table{
    width:100%;
    font-size:1.25rem;
    color: grey
}
th{
    text-align:left;
    font-style:italic;
}
</style>
<body>
<?php
    require_once("Traitement/fonctions.php");
    $afficher = getData();
    $joueurs = listeJoueur($afficher);
    $scores = $triDecroissant = [];
    foreach ($joueurs as $key => $value) {
        $scores[] = $value['score'];
    }
    arsort($scores); //Tri un tableau en fonction des valeurs dans un ordre décroissant
    //Recuperation de l'ordre des index après avoir rangé le tableau scores dans un ordre décroissant
    foreach($scores as $key => $val){
        $triDecroissant[] = $key;
    }
    ?>
    <table>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Score</th>
        <tbody>
        <?php for ($i=0; $i<count($joueurs) ; $i++){ ?>
        <tr>
        <td> <?php echo $joueurs[$triDecroissant[$i]]['prenom'];?></td>
        <td> <?php echo $joueurs[$triDecroissant[$i]]['nom'];?></td>
        <td> <?php echo $joueurs[$triDecroissant[$i]]['score'];?></td>
        </tr>
   <?php }?>
    </tbody>
    </table>
</body>
</html>
