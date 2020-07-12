<?php
   require_once("Traitement/fonctions.php");
   $reponses = $bonne_reponses = [];
    if(isset($_POST['valider']))
    {
        $nbreReponse = $_POST['nbreRep'];
        $question = $_POST['question'];
        $nbPoints = $_POST['nbp'];
        $type= $_POST['typerep'];
        if(!empty($question && $type && $nbPoints))
        {
            $Quest = array();
            if($type!=="choixT")
            {
                $index=1;
                foreach ($_POST as $key => $p) 
                {
                    //je verifie si le nom du champs a "reponse"! 
                    if(strpos($key, "reponse")!== FALSE && $p!="")
                    {
                        $reponses[]=$p;
                        // in_array(substr($key, 7) préléve le numéro de la reponse 
                        //exemple quan on a reponse1 il préleve le 1
                        $idrep=substr($key, 7);

                        //on testsi ce numéro est dans  $_POST['check']
                        //si c'est le cas ca veut dire que c'est une bonne réponse!
                        if(in_array($idrep, $_POST['check']))
                        {
                            $bonne_reponses[]=$index;
                        }
                        $index++;
                    }
                }
            }
            elseif(isset($_POST['bReponses']))
            {
               $bonne_reponses=$_POST['bReponses'];
            }

            if(!empty($reponses && $bonne_reponses)){
                $formulaire = getData('questions');
                $Quest['question'] = $_POST['question'];
                $Quest['nbp'] = $_POST['nbp'];
                $Quest['typerep'] = $_POST['typerep'];
                $Quest['reponses'] = $reponses;
                // les bonnes reponses
                $Quest['bonne_reponses'] = $bonne_reponses;
                $formulaire[]= $Quest;
                $formulaire = json_encode($formulaire,JSON_PRETTY_PRINT); 
                file_put_contents("Data/questions.json", $formulaire);
            }else{
                echo "Veuillez indiquer les bonnes réponses.";
            }
        }
        else
        {
            echo "Veuillez remplir tous les champs";
        }
    }
  ?>

<h1>PARAMETRER VOTRE QUESTION</h1>
<div id="formulaire">
	<form action="" method="POST" id="CreationQ">

        <label for="quest">Questions</label>
        <input type="text" id="quest" name="question" error="error">
        <span id="error"></span><br><br>

        <label for="nbrepts">Nbre de Points</label>
        <input type="number" name="nbp" id="nbrepts" error="error">
        <span id="error"></span><br><br>

        <label for="rep">Type de réponse</label>
        <select name="typerep" id="type" onchange="ifChange()">
            <option value="">Donnez le type de réponse</option>
            <option value="choixS">Réponse à choix simple</option>
            <option value="choixM">Réponse à choix multiple</option>
            <option value="choixT">Réponse texte à saisir</option>
        </select> 
        <button type="button" id="aj" class="ajout btn-form .btn button">+</button> <br><br>
        <div id="ajoutInput"></div>
        <input type="hidden" name="nbreRep" id="nbr">
        <br><br>
        <input type="submit" value="Enregistrer" name="valider" id="envoi">
    </form>
</div>
    <script>    
           function ifChange(){
            let suppr = document.getElementById("ajoutInput");
            suppr.innerHTML="";
            }
           
            let choix = document.getElementById("aj");
            choix.addEventListener('click', ajouterInput);
           let nbreInput = 0;
            function ajouterInput(){
                nbreInput++;
                let nbreRep = document.getElementById("nbr");
                let forme = document.getElementById("ajoutInput");
                let typerep = document.getElementById("type").value;
                let div = document.createElement("div");
                div.setAttribute('id','div'+nbreInput);
                
                if(typerep=="choixS"){
                    nbreRep.setAttribute('value', nbreInput);


                    let label = document.createElement("Label");
                    label.textContent = "Réponse "+nbreInput;

                    let inputT = document.createElement("input");
                    inputT.setAttribute('type','text');
                    inputT.setAttribute('id','rep');
                        //changement j'ai mis nombre a valeur!
                    inputT.setAttribute('name','reponse'+ nbreInput);
                    inputT.setAttribute('error','error'+ nbreInput);
                    let span = document.createElement("span");
                    span.setAttribute('id','error'+ nbreInput);

                    let input = document.createElement("input")
                    input.setAttribute('type','radio');
                    input.setAttribute('name','check[]');
                    input.setAttribute('value', nbreInput);

                    let button = document.createElement ("input");
                    button.setAttribute('type','button');
                    button.setAttribute('id','suppr');
                    button.setAttribute('onclick','deleteInput('+nbreInput+')');
                    button.innerText = "X";

                    div.appendChild(label);
                    div.appendChild(inputT);
                    div.appendChild(input);
                    div.appendChild(button);
                    div.appendChild(span);
                    forme.appendChild(div);

                } else
                    if(typerep=="choixM"){
                        nbreRep.setAttribute('value', nbreInput);
                        let label = document.createElement("Label");
                        label.textContent = "Réponse "+nbreInput;

                        let inputT = document.createElement("input");
                        inputT.setAttribute('type','text');
                        inputT.setAttribute('name','reponse' + nbreInput);
                        inputT.setAttribute('error','error'+ nbreInput);
                        let span = document.createElement("span");
                        span.setAttribute('id','error'+ nbreInput);

                        let input = document.createElement("input")
                        input.setAttribute('type','checkbox');
                        input.setAttribute('name','check[]');
                        //changement j'ai mis nombre a valeur!
                        input.setAttribute('value', nbreInput);
                        let button = document.createElement ("input");
                        button.setAttribute('type','button');
                        button.setAttribute('id','suppr');
                        button.setAttribute('onclick','deleteInput('+nbreInput+')');
                        button.innerText = "X";
                        div.appendChild(label);
                        div.appendChild(inputT);
                        div.appendChild(input);
                        div.appendChild(button);
                        div.appendChild(span);
                        forme.appendChild(div);

                    }else
                    if(typerep=="choixT" && nbreInput==1){
                        nbreRep.setAttribute('value', nbreInput);
                        let label = document.createElement("Label");
                        label.textContent = "Réponse";

                        let inputT = document.createElement("input");
                        inputT.setAttribute('type','text');
                        inputT.setAttribute('error','error'+ nbreInput);
                        inputT.setAttribute('name','bReponses[]');
                        let span = document.createElement("span");
                        span.setAttribute('id','error'+ nbreInput);
                        let button = document.createElement ("input");
                        button.setAttribute('type','button');
                        button.setAttribute('id','suppr');
                        button.setAttribute('onclick','deleteInput('+nbreInput+')');
                        button.innerText = "X";
                        div.appendChild(label);
                        div.appendChild(inputT);
                        div.appendChild(input);
                        div.appendChild(button);
                        div.appendChild(span);
                        forme.appendChild(div);
                    }
                    else{
                        alert("veuillez choisir un type");
                    }  
            }

            function deleteInput(nbreInput){
               let target = document.getElementById('div'+nbreInput);
               target.remove();
            }


        const inputs = document.getElementsByTagName("input");
        for(input of inputs){
         input.addEventListener("keyup",function(e){
            if(e.target.hasAttribute("error")){
                var idDivError=e.target.getAttribute("error");
                document.getElementById(idDivError).innerText=""
            }
         })
     }

    document.getElementById("CreationQ").addEventListener("submit",function(e){
        const inputs = document.getElementsByTagName("input");
        var error = false;
        for(input of inputs){
            if(input.hasAttribute("error")){
                var idDivError=input.getAttribute("error");
                if(!input.value){
                    document.getElementById(idDivError).innerText="Ce champ est obligatoire"
                    document.getElementById(idDivError).style.color="red";
                    error=true;
                }
               
            }     
        }
        if(error)
        {
        e.preventDefault();
        return false;
        }
    });

</script>