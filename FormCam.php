<?php
session_start();

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vérifie qu'une session a été commencé suite a une connexion, sinon, renvoie sur la page de connexion.
if(!$_SESSION['id'])
{
    header('Location: Login.html');
    exit;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////

$Receive = json_decode(file_get_contents('php://input'), true);
$Latit = $Receive['latitude'];
$Longit = $Receive['longitude'];
$lien = $Receive['lien_photo'];
$title = $Receive['cam'];
$Couple = ($Latit . ',' . $Longit);

//recupere db
$Database = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8', 'root', 'ChuckNorris44');


/////////Verifie doublons
//selectionne les coordonnes des cameras etant dans un rayon de 10m ou moins de la camera qu'on va ajouter
$verif_coordonnes = $Database->prepare("SELECT coordonnes
    FROM cameras
    WHERE ST_Distance_Sphere(
        coordonnees,
        ST_GeomFromText('POINT($Longit $Latit)')
    ) < 10; -- 10 mètres");

$verif_coordonnes->execute();
$resultats_verif_coordonnes = $verif_coordonnes->fetchAll();
/////////fait avec claude au dessus

//ajoute la camera s'il n'en existe pas déjà dans un rayon de 10m, sinon un popup alerte
if (count($$resultats_verif_coordonnes) > 0) {
    echo "<script>alert('Il existe déjà une caméra dans cette zone (rayon de 10m). Votre requête à été rejetée pour éviter le création de doublons');</script>";
} else {
    
// Récupère et incrémente l'id qui sera utilisé pour créer la caméra.
$RequestMaxId = $Database->prepare("SELECT MAX(id_camera) AS max FROM cameras");
$RequestMaxId->execute();
$GetMaxId = $RequestMaxId->fetch();
$MaxId = $GetMaxId['max'] + 1;

// Ajoute la caméra a la base.
$AddCam = $Database->prepare('INSERT INTO cameras(id_camera, coordonnees, lien_photo, origin_user, verifie, Titre) VALUES(?, ?, ?, ?, ?, ?)');
$AddCam->execute([$MaxId, $Couple, $lien, $_SESSION['id'], 0, $title]);



}


///////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////
// Récupère et incrémente l'id qui sera utilisé pour créer la log.
$RequestMaxIdLog = $Database->prepare("SELECT MAX(id_log) AS max FROM log");
$RequestMaxIdLog->execute();
$GetMaxIdLog = $RequestMaxIdLog->fetch();
$MaxIdLog = $GetMaxIdLog['max'] + 1;

// Ajoute la log, méthode pour la date : https://www.w3schools.com/php/func_date_date.asp
$RequestLog = $Database->prepare("INSERT INTO 
                                    `log` (id_log, temps, `type`, id_user)
                                    VALUES (?, ?, ?, ?)");
$RequestLog->execute([$MaxIdLog, date("j/m/Y h:i:s"), "Ajout Caméra", $_SESSION['id']]);
header('Location: index1.html');
exit;
?>