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

$lien = $_POST['lien_photo'];
$title = $_POST['cam'];
$Database = new PDO('mysql:host=localhost;port=3306;dbname=Carte_Interactive;charset=utf8', 'root', 'ChuckNorris44');

// Récupère et incrémente l'id qui sera utilisé pour créer la caméra.
$RequestMaxId = $Database->prepare("SELECT MAX(id_camera) AS max FROM cameras");
$RequestMaxId->execute();
$GetMaxId = $RequestMaxId->fetch();
$MaxId = $GetMaxId['max'] + 1;

// Ajoute la caméra a la base.
$AddCam = $Database->prepare('INSERT INTO cameras(id_camera, coordonnees, lien_photo, origin_user, verifie, Titre) VALUES(?, ?, ?, ?, ?, ?)');
$AddCam->execute([$MaxId, 'To Do like fr', $lien, $_SESSION['id'], 0, $title]);

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