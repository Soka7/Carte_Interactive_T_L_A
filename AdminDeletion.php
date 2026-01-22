<?php
$Type = $_POST['type'];
$IdLog = $_POST['idform'];
$DataBase = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8','root','ChuckNorris44');

if($Type == 'Log')
{
    $ReqDelLog = $DataBase->prepare("DELETE FROM log WHERE id_log = ?");
    $ReqDelLog->execute([$IdLog]);
}
else if($Type == 'Camera')
{
    $ReqIdCam = $DataBase->prepare("SELECT id_cam AS cam FROM log WHERE id_log = ?");
    $ReqIdCam->execute([$IdLog]);
    $GetIdCam = $ReqIdCam->fetch();
    $IdCam = $GetIdCam['cam'];

    $ReqDelLog = $DataBase->prepare("DELETE FROM log WHERE id_cam = ?");
    $ReqDelLog->execute([$IdCam]);

    $ReqDelCam = $DataBase->prepare("DELETE FROM cameras WHERE id_camera = ?");
    $ReqDelCam->execute([$IdCam]);
}
else if($Type == "Utilisateur")
{
    $ReqIdUser = $DataBase->prepare("SELECT id_user AS id FROM log WHERE id_log = ?");
    $ReqIdUser->execute([$IdLog]);
    $GetIdUser = $ReqIdUser->fetch();
    $IdUser = $GetIdUser['id'];

    $ReqDelLog = $DataBase->prepare("DELETE FROM log WHERE id_user = ?");
    $ReqDelLog->execute([$IdUser]);

    $ReqDelUser = $DataBase->prepare("DELETE FROM login WHERE id_user = ?");
    $ReqDelUser->execute([$IdUser]);
}
else if($Type == "Vérification")
{
    $ReqIdCam = $DataBase->prepare("SELECT id_cam AS cam FROM log WHERE id_log = ?");
    $ReqIdCam->execute([$IdLog]);
    $GetIdCam = $ReqIdCam->fetch();
    $IdCam = $GetIdCam['cam'];

    $ReqUpdateCam = $DataBase->prepare("UPDATE cameras SET verifie = 1 WHERE id_camera = ?")
    $ReqUpdateCam->execute[$IdCam]
}

header('Location: AdminView.php');
exit;
?>