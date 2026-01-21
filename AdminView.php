<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="https://livejs.com/live.js"></script>
    <title>Administration</title>
</head>
<body>
    <div class = "Top">
        <img src="OIP.webp" alt="Pin" class="top-image">
        <button class="styled" type="button" onclick="window.location.href='Enjeux.html';">Sources</button>
        <button class="Home" type="button" onclick="window.location.href='index1.html';">Home</button>
        <button class="AboutUs" type="button" onclick="window.location.href='AboutUs.html';">A propos</button>
        <button class="Login" type="button" onclick="window.location.href='Login.html';">Connexion</button>
        <button class="AdminButton" type="button" onclick="window.location.href='AdminViewChecker.php';">Administration</button>
    </div>
    <div class="content">
    <table class="AdminTable">
        <thead class="AdminHead">
            <tr>
                <th>Log N°</th>
                <th>Heure</th>
                <th>Action</th>
                <th>Utilisateur N°</th>
            </tr>
        </thead>
        <tbody class="AdminBody">
            <?php
            // Récupère la table log afin de la montrer dans le tableau.
            $DataBase = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8','root','ChuckNorris44');
            $RequestGetAll = $DataBase->prepare("SELECT * FROM log");
            $RequestGetAll->execute();
            $Logs = $RequestGetAll->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <!-- Créer une ligne pour chaque donnée de la table et y met les informations correspondantes. -->
            <?php foreach($Logs as $row): ?>
            <tr>
                <th><?= $row['id_log']?></th> <!-- php syntax from chatgpt, it is a shortcut to the php echo-->
                <th><?= $row['temps']?></th>
                <th><?= $row['type']?></th>
                <th><?= $row['id_user']?></th>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>