<?php
session_start();
//connexion bdd

$bdd = New PDO('mysql:host=localhost;dbname=ateliers_cuisine;charset=utf8', 'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//ici tu dois vérifier si $_SESSION isset bruno m'a dit de ne pas mettre le id session dans la redirection car c pas sûr

if(isset($_SESSION['id']) AND $_SESSION['id']>0)
{
    $getid=intval($_SESSION['id']);
    $requser=$bdd->prepare('SELECT*FROM utilisateurs WHERE id=?');
    $requser->execute(array($getid));
    $userinfo=$requser->fetch();

 

?>




<html>
    <head>
   <title>Profil</title>
    </head>
    <body>
  <nav>
  <ul>
  <li><a href="../ateliers/ajout_atelier.php">Ajouter un atelier</a></li>
  </ul>
  </nav>              
        <section>
                    
             <div>       
                <h3>Profil de <?php echo $userinfo['nom'];?></h3>
                            
                prenom:<?php echo $userinfo['prenom'];?>
                    <br/>
                mail:<?php echo $userinfo['email'];?>
                <br/>

                <?php
                //on vérifie que la session id existe puis qu'elle est égale à id utilisateur
                if(isset($_SESSION['id']) AND ($userinfo['id']==$_SESSION['id']) )
                {
                ?>
                
                <a href="deco.php">Deconnexion</a>
                <?php
                }
                ?>
            </div>
            
            








        

                                            
                                    
                                            
                            
                    
              
        </section>      
        <?php
}
?>                  
 
    </body>
   
</html>
