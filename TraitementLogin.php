<?php
$login = $_POST["login"];
$mdp = $_POST["mdp"];

$DataBase = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8','root','ChuckNorris44');

$RequestValidity = $DataBase->prepare("SELECT COUNT(*) AS counter FROM login WHERE pseudo=? AND mdp=?");
$RequestValidity->execute([$login, $mdp]);
$Validity = $RequestValidity->fetch();

if($Validity["counter"] != 1)
{
    header('Location: Login.html');
    exit;
}

$RequestUser = $DataBase->prepare("SELECT admin,id_user FROM login WHERE pseudo=? AND mdp=?");
$RequestUser->execute([$login, $mdp]);
$User = $RequestUser->fetch(PDO::FETCH_ASSOC);

session_start();
$_SESSION["login"] = $login;
$_SESSION["id"] = (int) $User["id_user"];
$_SESSION["admin"] = $User["admin"];

$RequestIdLog = $DataBase->prepare("SELECT MAX(id_log) AS max FROM log");
$RequestIdLog->execute();
$GetIdLog = $RequestIdLog->fetch();
$IdLog = $GetIdLog['max'] + 1;

$RequestLog = $DataBase->prepare("INSERT INTO 
                                    `log` (id_log, temps, `type`, id_user)
                                    VALUES (?, ?, ?, ?)");
$RequestLog->execute([$IdLog, date("H:i:s"), "Login", (int) $User["id_user"]]);

header('Location: index1.html');
exit;
?>