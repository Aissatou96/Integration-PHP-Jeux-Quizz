<?php
    function connexion($login,$pwd){
        $users=getData();
        foreach($users as $key => $user){
            if($user["login"]===$login && $user["password"]===$pwd){
                $_SESSION["user"]=$user;
                $_SESSION['statut']="login";
                if($user["profil"]==="admin"){
                    $_SESSION['admin'] = true;
                    return "accueil";
                }else{
                    $_SESSION['joueur'] = true;
                    return "jeux";
                } 
            }
        }
        return "error";
    }

    function is_connect(){
        if(!isset($_SESSION['statut'])){
            header("location:index.php");
        }
    }

    function deconnexion(){
        unset($_SESSION['user']);
        unset($_SESSION['statut']);
        session_destroy();
    }


    /*fonction pour le chargement du fichier JSON*/
    function getData($file="utilisateur"){
        $data=file_get_contents("./Data/".$file.".json");
        $data=json_decode($data,true);
        return $data;
    }


    function listeJoueur($user){
        $joueur = array();
        for($i=0;$i<count($user);$i++){
            if($user[$i]['profil']=='joueur'){
                $joueur[] = $user[$i];
            }
        }
        return $joueur;
    }

    