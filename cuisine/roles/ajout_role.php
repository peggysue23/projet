<?php
//connexion bdd
try{
$bdd = New PDO('mysql:host=localhost;dbname=ateliers_cuisine;charset=utf8', 'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}
// fin connexion bdd

//traitement du formulaire
if(isset($_POST['form_roles']))
    {
        //stock mes valeurs des $_POST
        $label = htmlspecialchars($_POST['label']);
       
        //Vérifier existence et si non vide
        if (isset($label) AND !empty($label))                               
        {          
            //prepare insert into pour envoyer des données dans la BDD
            $role = $bdd -> prepare('INSERT INTO roles (label) VALUES (?)');
            $role ->execute(array($label));
            $message ='La ligne a bien été ajoutée!';  
           
           
        }
        else
        {
            $message ='Il manque un renseignement.';
        }
    }else
    
    {
      $message = 'Tous les champs doivent être complétés.';
    }
    //fin traitement
?>

<!DOCTYPE html>
<html>
<head>
<!--FORMULAIRE-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Formulaire</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="main.css">
        <script src="main.js"></script>
    </head>
    <body>
    <form action=" " method="POST">
    

        <label for="id_role">Selectionner le rôle</label>
            <select name="label" class="form-control" required>
                <option value="Cuisiner"> Cuisinier</option>
                <option value="Particulier"> Particulier</option>
            </select>

        <input type="submit" name="form_roles" value="ajouter le roles">
      
	</form>

    <?php
    if(isset($message)){
        echo $message;
    }
    ?>
    







    </body>
</html>