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
            <script src="js/app3.js" defer></script>         <!-- Lien avec le fichier JS -->
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
            
            //foreach ($reponse as $val){
            //    echo $val["nom"]."<br>";
            //    }       
            ?>
            </div>

            <div id="affichage"> </div>
        </div>

    <!-- LIEN JS ET PHP -->
        <script>
            // on encode au format JSON la variable php $reponse résultat de la requete
            // (pratique car les 'array' php sont dans un format similaire au 'dico' JSON)
            const produits = <?php echo json_encode($reponse, JSON_NUMERIC_CHECK); ?>
                            
            // la ligne ci-dessous va envoyer dans la console du navigateur la valeur
            // de la variable produits pour debug
            console.log(produits)

            // ... on voit tous les éléments de l'objet json

        </script>
    </body>
</html>