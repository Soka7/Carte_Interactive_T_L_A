<?php
$mail = $_POST["email"];
$mdp = $_POST["mdp"];

$DataBase = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8','root','ChuckNorris44');

$RequestMdp = $DataBase->prepare("SELECT mdp FROM login WHERE email=?");
$RequestMdp->execute([$mail]);
$GetMdp = $RequestMdp->fetch();

$RequestValidity = $DataBase->prepare("SELECT COUNT(*) AS counter FROM login WHERE email=? AND mdp=?");
$RequestValidity->execute([$mail, $GetMdp['mdp']]);
$Validity = $RequestValidity->fetch();

if($Validity["counter"] == 1 && password_verify($mdp, $GetMdp['mdp']))
{
    $RequestUser = $DataBase->prepare("SELECT admin,id_user FROM login WHERE email=? AND mdp=?");
    $RequestUser->execute([$mail, $GetMdp['mdp']]);
    $User = $RequestUser->fetch(PDO::FETCH_ASSOC);

    session_start();
    $_SESSION["mail"] = $mail;
    $_SESSION["id"] = (int) $User["id_user"];
    $_SESSION["admin"] = $User["admin"];

    $RequestIdLog = $DataBase->prepare("SELECT MAX(id_log) AS max FROM log");
    $RequestIdLog->execute();
    $GetIdLog = $RequestIdLog->fetch();
    $IdLog = $GetIdLog['max'] + 1;

    $RequestLog = $DataBase->prepare("INSERT INTO 
                                        `log` (id_log, temps, `type`, id_user)
                                        VALUES (?, ?, ?, ?)");
    $RequestLog->execute([$IdLog, date("H:i:s"), "Connexion", (int) $User["id_user"]]);

    header('Location: index1.html');
}
else
{
    header('Location: Login.html');
}
exit;
?>