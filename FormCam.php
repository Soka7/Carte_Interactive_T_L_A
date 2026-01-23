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

$act = $Receive['action'];
$Database = new PDO('mysql:host=localhost;port=3306;dbname=Carte_Interactive;charset=utf8', 'root', 'ChuckNorris44');

switch ($act){

    case "Add":
        $Latit = $Receive['latitude'];
        $Longit = $Receive['longitude'];
        $lien = $Receive['lien_photo'];
        $title = $Receive['cam'];

        // Récupère et incrémente l'id qui sera utilisé pour créer la caméra.
        $RequestMaxId = $Database->prepare("SELECT MAX(id_camera) AS max FROM cameras");
        $RequestMaxId->execute();
        $GetMaxId = $RequestMaxId->fetch();
        $MaxId = $GetMaxId['max'] + 1;

        // Ajoute la caméra a la base.
        $AddCam = $Database->prepare('INSERT INTO cameras(id_camera, coordonnees, lien_photo, origin_user, verifie, Titre) VALUES(?, POINT(?, ?), ?, ?, ?, ?)');
        $AddCam->execute([$MaxId, $Longit, $Latit, $lien, $_SESSION['id'], 0, $title]);
        break;

    case "Ask":
        $GetCams = $Database->prepare('SELECT id_camera, Titre, lien_photo, X(coordonnees) AS longitude, Y(coordonnees) AS latitude FROM cameras');
        $GetCams->execute();
        $Datas = $GetCams->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($Datas);
        exit;
};
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
exit;
?>