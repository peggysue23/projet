<?php
session_start();
//connexion bdd
{
    $getid=intval($_SESSION['id']);
//connexion bdd
try{
$bdd = New PDO('mysql:host=localhost;dbname=ateliers_cuisine;charset=utf8', 'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

//ici tu dois vérifier si $_SESSION existe
if(isset($_SESSION['id']) AND $_SESSION['id']>0)
$req=$bdd->query('SELECT * FROM ateliers');
//traitement formulaire

if(!empty($_POST['form_ajout_ateliers']))
    {
        //stock mes valeurs des $_POST
        $titres = htmlspecialchars($_POST['ajout_titres']);
        $descriptif = htmlspecialchars($_POST['ajout_descriptif']);
        $date = htmlspecialchars(date("Y-m-d", strtotime($_POST['ajout_date'])));
        $times = htmlspecialchars($_POST['ajout_times']); //null; 
        $duree = htmlspecialchars($_POST['ajout_duree']); //null; 
        $dispo = htmlspecialchars($_POST['ajout_dispo']);
        $reserver = 0 ;
        $prix = htmlspecialchars($_POST['ajout_prix']);
        $actif = 1;
        
        var_dump($reserver);
        //Vérifier existence et si non vide
        
        if (!empty($titres) AND !empty($descriptif) AND !empty($date) AND !empty($times) AND !empty($duree) AND !empty($dispo) AND isset($reserver) AND !empty($prix) AND isset($actif) )                                    
        {          
            //prepare insert into pour envoyer des données dans la BDD
            $ateliers = $bdd ->prepare('INSERT INTO ateliers (titre, descriptif, date_atelier, debut, duree, places_dispo, places_reserver, prix, actif, id_cuisinier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $ateliers ->execute(array($titres, $descriptif, $date, $times, $duree, $dispo, $reserver, $prix, $actif, $getid) );
            $message ='donnees bien enregistrer!';  
            header('Location: liste.php');
        }

        else
        {
         $message ='Saisi incorrect.';
        }
    }
   
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ateliers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <script src="main.js"></script>
</head>
<body>
<form action="" style="align:center" method="POST">
        <!-- Titre -->
        <div class="form-group">
            <label for="ajout_titres">Titre : </label>
            <input class="" type="text" name="ajout_titres" placeholder="titres">
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="ajout_descriptif">descriptif : </label>
            <input   type="text" name="ajout_descriptif" placeholder="descriptif">
        </div>

        <!-- Date -->
        <div class="form-group">
            <label for="ajout_date">Date : </label>
            <input type="date" name="ajout_date" placeholder="date">
        </div>

        <!-- Horaire de début -->
        <div class="form-group">
            <!-- to do : à rectifier le type de la date dans la BDD -->
            <label for="ajout_times">Horaire de debut : </label>
            <input type="text" name="ajout_times" placeholder="horaire du debut">
        </div>

        <!-- Durée -->
        <div class="form-group">
            <!-- to do : à rectifier le type de la date dans la BDD -->
            <label for="ajout_duree">Durée : </label>
            <input type="text" name="ajout_duree" placeholder="la duree">
        </div>

        <!-- Place Disponible -->
        <div class="form-group">
            <label for="ajout_dispo">Place Dispo. : </label>
            <input type="number" name="ajout_dispo" placeholder="place dispo">
        </div>

        <!-- Places Réserver 
        <div class="form-group">
            <label for="ajout_reserver">Place Réserver : </label>
            <input type="number" name="ajout_reserver" placeholder="place reserver">
        </div>-->

        <!-- Prix -->
        <div class="form-group">
            <label for="ajout_prix">Prix : </label>
            <input type="number" name="ajout_prix" placeholder="prix">€
        </div>

        <button type="submit" class="btn btn-primary mb-2" name="form_ajout_ateliers" value="ajouter un ateliers">ajouter</button>
      
	</form>

    <?php if(isset($message)): ?>
         
        <span class="alert">
            <?php echo $message; ?>
        </span>
        <?php endif;?>

</body>
</html>
<?php }?>