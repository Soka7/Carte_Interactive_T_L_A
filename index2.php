<!DOCTYPE html>
<html lang="fr">
    <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Introduction à Leaflet</title>
        
    <!-- LEAFLET --> 
            <!-- Leaflet css -->	
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
            crossorigin=""/>
            <!-- Leaflet Libraries  - Make sure you put this AFTER Leaflet's CSS -->
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <!-- JS et CSS -->        
            <script src="js/app2.js" defer></script>         <!-- Lien avec le fichier JS -->
            <link rel="stylesheet" href="css/style.css">    <!-- Lien avec le fichier CSS -->

    <!-- ACCES BASE -->
            <?php   // création objet pdo pour la base food
            $bdd = new PDO('mysql:host=localhost;port=3306;dbname=food;charset=utf8', 'root', 'MOTDEPASSE');
            ?>

    </head>
    <body>
        <div  class="content">
            <div id="map"></div>
            <div> 
            <?php 
            // effectue une requête sur table Aliment + Affiche les valeurs
            $requete = $bdd->prepare("SELECT nom, marque FROM Aliment"); 
            $requete->execute();
            $reponse = $requete->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($reponse as $val){
                echo $val["nom"]."<br>";
                }       
            ?>
            </div>
        </div>
    </body>
</html>
