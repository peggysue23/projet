<?php
//connexion bdd
try{
$bdd = New PDO('mysql:host=localhost;dbname=ateliers_cuisine;charset=utf8', 'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$req=$bdd->query('SELECT * FROM roles');
//var_dump($_POST);   ->pour verrifier les erreur
//die();

//traitement formulaire
if(isset($_POST['form_utilisateur']))
{
    //stock mes valeurs des $_POST
        $nom = htmlspecialchars($_POST['nom_util']);
        $prenom = htmlspecialchars($_POST['prenom_util']);
        $mdp = sha1($_POST['mot_passe']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $tel = htmlspecialchars($_POST['tel']);
        $specialite= htmlspecialchars($_POST['specialite']);
        $role=htmlspecialchars($_POST['roles_utili']);
        //Vérifier existence et si non vide
        if (!empty($nom) AND !empty($prenom) AND !empty($mdp) AND !empty($mail) AND !empty($mail2) AND !empty($tel) AND !empty($specialite) AND !empty($role)) 
        {  //Vérifie si les 2 mail corresponds
            if($mail==$mail2)
                {
                    
                
               

                    //Vérification si le mail existe déja dans la base de donnée
                    $reqmail=$bdd->prepare("SELECT*FROM utilisateurs WHERE email=?"); 
                        $reqmail->execute(array($mail));
                        $mailexist=$reqmail->rowCount();//compte le nbr de colonne existant pour les info saisi avant
                        //Si le mail n'existe pas alors le formulaire est valide
                    if($mailexist==0)
                    {
                
                        //prepare insert into pour envoyer des données dans la BDD
                        $utilisateur = $bdd -> prepare('INSERT INTO utilisateurs (nom, prenom,mdp,email,tel,specialite) VALUES (?,?,?,?,?,?)');
                        $utilisateur ->execute(array($nom, $prenom,$mdp, $mail,$tel,$specialite));
                        $message ="Votre compte a bien été ajoutée! <a href=\"connect.php\">Connexion</a>";

                        //recupère le dernier id utilisateur id role
                        $id=$bdd->lastInsertId();
                        
                        if ($role !=0) 
                        {
                            $utilisateur_role=$bdd->prepare('INSERT INTO utilisateurs_roles(id_utilisateur,id_role) VALUES(?,?)');
                            $utilisateur_role ->execute(array($id,$role));
                        }
                    }//sinon si le mail est >0 c a dire qu'il existe dans la bdd alors le message erreur s'affiche 
                    else{
                    $message="Adresse mail déja utiliser";}
                }
                else
                {
                    $message="Vos adresse mail de correspond pas";
                }
                 
        }
        else
        {
            $message ='Il manque un renseignement.';
        }
    }
?>




<html lang="fr" class="h-100">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    
    </head>
        <body>
            
        <section>
                        <div class="container">
                                <div class="row justify-content-center h-100 my-5">
                                    <div class="cadre">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Inscription</h3>
                                            </div>

                                            <div class="box-body">
                                                
                                            <form method="post" action="">
                                        
                                            
                                                <p> <label for="">Noms</label>
                                                    <input type="text" name="nom_util" placeholder="saisir un nom"> 
                                                </p>
                                            
                                                <p>
                                                    <label>Prenom  </label>
                                                    <input type="text" name="prenom_util" placeholder="saisir un prenom">
                                                </p>

                                                <p>
                                                    <label>Mdp</label>
                                                    <input type="password" name="mot_passe"  placeholder="saisir un mot passe" > 
                                                </p>

                                                <p>
                                                    <label>Mail</label>
                                                    <input type="email" name="mail" placeholder="saisir un mail">
                                                </p>
                                                <p>
                                                <label>Confirmation du mail :</label>
                                                <input type="email" placeholder="Confirmez votre mail"  name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                                                </p>
                                                <p>  
                                                    <label>Tel</label>
                                                    <input type="tel" name="tel"  placeholder="06.92.00.00.00" >
                                                </p>

                                                <p>
                                                    <label>Votre spécialité</label>
                                                    <input type="text" name="specialite" placeholder="ex:Patisseri">

                                                </p>
                                <label>Rôle</label> 
                                        
                                <select name="roles_utili">
                                <?php
                                    
                                    while ($role=$req->fetch())
                                    {
                                ?>
                                             
                                <option value=" <?php echo $role['id'];?>"> <?php echo $role['label'];?> </option>
                                <?php
                                    }
                                
                                ?>
                                </select>       
                                


                                    
                                    <input  type="submit" name="form_utilisateur" value="Valider"  button type="button" class="btn btn-success"></button>
                                        <div class="d-flex justify-content-left links">
                                            <a href="home.html" class="container text-center">Revenir à l'accueille</a>
                                        </div>
                            
                                            </form>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                
                </section>      
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        

                                


                                            





        <?php
        if(isset($message)){
            echo $message;
        }
    
        ?>
        

    






































        </body>
</html>