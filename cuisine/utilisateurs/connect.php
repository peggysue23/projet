<?php
session_start();
//connexion bdd

$bdd = New PDO('mysql:host=localhost;dbname=ateliers_cuisine;charset=utf8', 'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


if(isset($_POST['form_connexion']))
{
    $mailconnect=htmlspecialchars($_POST['mailconnect']);
    $mdpconnect=sha1($_POST['mdpconnect']);
    if(!empty($mailconnect) AND !empty($mdpconnect))
    {
        $requser=$bdd->prepare("SELECT*FROM utilisateurs WHERE email=? AND mdp=?");
        $requser->execute(array($mailconnect,$mdpconnect));
        $userexist=$requser->rowCount();
            if($userexist == 1)
            {
                $userinfo=$requser->fetch();
                $_SESSION['id']=$userinfo['id'];
                $_SESSION['prenom']=$userinfo['prenom'];
                $_SESSION['email']=$userinfo['email'];
                header("Location: profil.php");
            }
            else {
                $erreur="Mauvais mail mdp";
            }
    }
    else
    {
        $erreur="Error";
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
                        <h3>connexion</h3>
                    </div>

                    <div class="box-body">
                                                
                    <form method="post" action="">
                                        
                        <p>
                            <label>Mail</label>
                             <input type="email" name="mailconnect" placeholder="saisir un mail">
                        </p>
                        <p>
                            <label>Mdp</label>
                            <input type="password" name="mdpconnect"  placeholder="saisir un mot passe" > 
                        </p>
                                    
                            <input  type="submit" name="form_connexion" value="Valider"  button type="button" class="btn btn-success"></button>
                                    
                        </form>
                                </div>
                            </div>    
                        </div>
                    </div>
        <?php
        if(isset($erreur))
        {
            echo $erreur;
        }
    
        ?>
            </section>      
                                    
        </body>
</html>