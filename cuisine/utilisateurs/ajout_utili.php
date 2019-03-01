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
        
        if (!empty($nom) AND !empty($prenom) AND !empty($mdp) AND !empty($mail) AND !empty($mail2) AND isset($tel) AND isset($specialite) AND !empty($role)) 
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
                {//si les 2mail saisi correspond pas alors le message erreur s'affiche
                    $message="Vos adresse mail de correspond pas";}
                 
        }
        else
        {
            $message ='Il manque un renseignement.';
        }
}
?>








<!DOCTYPE html>
<html lang="fr" class="h-100">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/ajoututil.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="js/ajoututil.js"/>
    
    <script type="text/javascript" src="http://www.clubdesign.at/floatlabels.js"></script>
    </head>
    <body>
            
        <div class="container">
            <div class="row centered-form">
            <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                            <h3 class="panel-title-center">INSCRIPTION</h3>
                            </div>
                            <div class="panel-body">
                            <!--Saisi du formulaire-->
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <!--NOM-->
                                        <div class="form-group">
                                <input type="text" name="nom_util" id="nom" class="form-control input-sm floatlabel" placeholder="Saisir un Nom*"required>
                                        </div>fil
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <!--PRENOM-->
                                        <div class="form-group">
                                            <input type="text" name="prenom_util" id="last_name" class="form-control input-sm" placeholder="Saisir un Prénom*" required  minlength="3" maxlength="6">
                                        </div>
                                    </div>
                                </div>
                                        <!--MAIL-->
                                <div class="form-group">
                                    <input type="email" name="mail" id="email" class="form-control input-sm" placeholder="adresse@gmail.com*"required >
                                </div>
                                <!--CONFIRMATION DU MAIL-->
                                <div class="form-group">
                                    <input type="email" name="mail2" id="email" class="form-control input-sm" required value="<?php if(isset($mail2)) { echo $mail2; } ?>" placeholder="Confirmation adresse mail*" >
                                </div>


                                        <!--MDP-->
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="password" name="mot_passe" id="password" class="form-control input-sm" placeholder="Saisir mot de passe*"required>
                                        </div>
                                    </div>
                                   
                                    <!--TEL-->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <input type="tel" name="tel" id="telephone" class="form-control input-sm" placeholder="06 92 12 34 56">
                                        </div>
                                    </div>
                                    <!--ROLE-->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Rôle*</label>   
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
                                        </div>

                                    </div>
                                    <!--SPECIALITER-->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="specialite" id="specialite_util" class="form-control input-sm" placeholder="Spécialités*" required>
                                        </div>
                                    </div>
                                </div>
                                <!--Valider-->
                                <input type="submit" value="Valider" name="form_utilisateur" class="btn btn-primary btn-block">
                                <!--Revenir à acceuil-->
                                <a class="btn btn-primary btn-block" href="home.html"role=button> Retour à l'accueil</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                      
                    

        <?php
        if(isset($message)){
            echo $message;
        }
    
        ?>
    </body>
</html>