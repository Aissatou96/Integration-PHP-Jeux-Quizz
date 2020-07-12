<?php
require_once("./Traitement/fonctions.php");
$infos = getData();
$user = [];
$pseudos = [];
for($i=0; isset($infos[$i]); $i++){
    $pseudos[] = $infos[$i]['login'];
}

$prenom = $nom = $login = $avatar = $erreur = null;
 if(isset($_POST['creer'])){
     $prenom = $_POST['prenom'];
     $nom = $_POST['nom'];
     $login = $_POST['login'];
     $password = $_POST['password'];
     $confirmerPwd = $_POST['passwd'];
     $avatar = $_FILES['avatar'];
     if(!empty($prenom && $nom && $login && $password && $confirmerPwd && $avatar['size'])){
         if(!in_array($login,$pseudos)){
             if($password == $confirmerPwd){
                $type = explode('/',$avatar['type'])[0];
                $extension = explode('/',$avatar['type'])[1];
                if($type == 'image' && in_array($extension,['jpeg','png'])){ 
                    if($avatar['size'] <= 2000000){
                        if($avatar['error'] == 0){
                            $img = "./Data/avatars/$login.$extension";
                            $upload = move_uploaded_file($avatar['tmp_name'],$img);
                            if($upload){
                                if(isset($_SESSION['admin'])){
                                    $user =
                                    [
                                        'prenom' => $prenom,
                                        'nom' => $nom,
                                        'login' => $login,
                                        'password' => $password,
                                        'avatar' => $img,
                                        'profil' => 'admin'
                                    ];
                                    $infos[] = $user;
                                    $infos = json_encode($infos, JSON_PRETTY_PRINT); 
                                    file_put_contents("./Data/utilisateur.json", $infos);
                                    header('location:index.php?lien=accueil');
                                }else{
                                    $user =
                                    [
                                        'prenom' => $prenom,
                                        'nom' => $nom,
                                        'login' => $login,
                                        'password' => $password,
                                        'avatar' => $img,
                                        'profil' => 'joueur',
                                        'score' => 0
                                    ];
                                    $infos[] = $user;
                                    $infos = json_encode($infos, JSON_PRETTY_PRINT); 
                                    file_put_contents("./Data/utilisateur.json", $infos);
                                    header('location:index.php');
                                }
                            }
                        }else{
                            $erreur = "Erreur sur le fichier.";
                        }
                    }else{
                        $erreur = "La taille du fichier ne doit pas dépasser 2MO";
                    }
                }else{
                    $erreur = "L'avatar doit être une image d'extension JPEG ou PNG.";
                }
             }else{
                 $erreur = "veuillez entrer des mots de passe conforme";
             }
         }else{
             $erreur = "Login déjà pris.";
         }
     }else{
         $erreur = "Remplissez tous les champs";
     }
 }
/* var_dump($img)*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/inscription.css">
    <title>Inscription</title>
</head>
<body>
    <div class="formulaire">
        <div style="width:60%">
            <h1>S'INSCRIRE</h1>
            <p>Pour tester votre niveau de culture générale</p>
            <form method="POST" enctype="multipart/form-data">
            <label for="prenom">Prénom</label><br>
                <input value="<?= $prenom ?>" type="text" name="prenom" id="prenom" placeholder="Aaaaa"><br>
    
                <label for="nom">Nom</label><br>
                <input value="<?= $nom ?>" type="text" name="nom" id="nom" placeholder="BBBB"><br>
    
                <label for="log">Login</label><br>
                <input value="<?= $login ?>" type="text" name="login" id="log" placeholder="aabaab"><br>
    
                <label for="pwd">Password</label><br>
                <input type="password" name="password" id="pwd" placeholder="*****************"><br>
    
                <label for="passw">Confirmer Password</label><br>
                <input type="password" name="passwd" id="passw" placeholder="*****************"><br>
    
                <label for="">Avatar</label>
                <input onchange="previsualiser(this)" type="file" name="avatar" id="file">
    
                <button type="submit" name="creer">Créer compte</button>
                <p style="color:red"><?= $erreur ?></p>
            </form>
        </div>
       
        <div class="image">
            <img id="avatar" src="" alt="">
            <h2 for="avatar">Avatar du joueur</h2>
        </div> 
        
    </div>
</body>
</html>
<script>
function previsualiser(input){
    if(input.files && input.files[0]){ /*si l'input en question est un type fichier 
    et que le fichier uploader est une image*/
        var image = new FileReader();
        image.onload = function(e){
            document.getElementById('avatar').src = e.target.result;
        }
        image.readAsDataURL(input.files[0]);
    }
}
</script>