<?php
  require_once("Traitement/fonctions.php");
  const NPARPAGE = 5;
  $questions = getData('questions');
  $nquestions = count($questions);
  $NbQ = (int)file_get_contents('Data/QuesParJeux.json');
  if(isset($_POST['valider'])){
    $NbQ = $_POST['nbre'];
    if(!empty($NbQ)){
      if($NbQ>=5 && $NbQ<=$nquestions){
        file_put_contents("Data/QuesParJeux.json", $NbQ);

      }else{
        echo "La valeur du nombre de question par jeu doit être comprise entre 5 et le nombre de questions enregistrées.";
      }
    }else{
      echo "Veuillez entrer un nombre";
    }
  }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>listeQuestions</title>
</head>
<body>
    <form action="" method="POST" onsubmit="return enregistrer();">
    <div id="jeu">
    Nbre de questions/jeu
    <input type="text" name="nbre" id="nbq" error="error">
    <input type="submit" value="OK" id="valid" name="valider" onclick="enregistrer();">
    <br><br>
    <span id="error"></span>
    </div>
<fieldset>
<script>
 
/* function enregistrer(){
  let nbreQ = document.getElementById('nbq').value;
  if(!nbreQ){
    let idDivError=input.getAttribute("error");
    document.getElementById(idDivError).innerText="Ce champ est obligatoire"
    document.getElementById(idDivError).style.color="red";
 
    return false;
  }else if(!Number.isInteger(+nbreQ)){
    alert("Veuillez entrer un nombre");
    return false;
  }else if(nbreQ<5){
    alert("Veuillez entrer un nombre supérieure ou égale à 5");
    return false;
  }
  return true;
 }*/
  
</script>
<?php
$totalValeur = count($questions);
$nbrePage = ceil($totalValeur/NPARPAGE);
//clic d'un numéro de page
if(isset($_GET['page'])){
  $pageActuelle = $_GET['page'];
  if($pageActuelle >= $nbrePage){
    $pageActuelle = $nbrePage;
  }elseif($pageActuelle <=1 ){
    $pageActuelle = 1;
  }
}else{
  $pageActuelle = 1;
}
$min = ($pageActuelle-1) * NPARPAGE;
$max = $min + NPARPAGE;
if($pageActuelle == $nbrePage){
  $reste = $totalValeur % NPARPAGE;
  if($reste != 0){
    $max = $min + $reste;
  }
}

for ($i = $min; $i < $max ; $i++) {  
  if($questions[$i]['typerep']=="choixS"){
    echo ($i+1). ". " .$questions[$i]['question'];?>
    <br>
    <?php
    for ($j=0; $j<count($questions[$i]['reponses']); $j++){
      ?>
      <input type="radio" name="" id="">
      <?php  
        echo $questions[$i]['reponses'] [$j];
        ?> 
        <br>
        <?php
    }
    ?>
    <br>
    <?php
  }
  else if($questions[$i]['typerep']=="choixM"){
    echo ($i+1). ". " .$questions[$i]['question'];?>
    <br>
    <?php
    for ($j=0; $j<count($questions[$i]['reponses']); $j++){
      ?>
      <input type="checkbox" name="" id="">
      <?php  
        echo $questions[$i]['reponses'] [$j];
        ?> 
        <br>
        <?php
    }
    ?>
    <br>
    <?php
 }
     else if($questions[$i]['typerep']=="choixT"){
        echo ($i+1). ". " .$questions[$i]['question'];?>
    <br>
    <input type="text" name="" id="">
    <br><br>
    <?php
  
      }
    }

?>
</fieldset>
<br><br>
<a href="index.php?lien=accueil&p=listQ&page=<?= $pageActuelle-1 ?>"><input type="button" value="Précédent"></a>
<a href="index.php?lien=accueil&p=listQ&page=<?= $pageActuelle+1 ?>"><input type="button" value="Suivant"></a>
</form>
</body>
</html>
