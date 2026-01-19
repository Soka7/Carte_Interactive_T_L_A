<?php
$login = $_POST["login"];
$mail = $_POST["mail"];
$mdp = $_POST["mdp"];

$DataBase = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8','root','ChuckNorris44');

$RequestExistingUser = $DataBase->prepare("SELECT COUNT(*) AS valid FROM login WHERE email=?");
$RequestExistingUser->execute([$mail]);
$ExistingUser = $RequestExistingUser->fetch();

if($ExistingUser['valid'] > 0 || !$login || !$mail || !$mdp)
{
    header('Location: AccountCreation.html');
}
else{
    $RequestGetMaxId = $DataBase->prepare("SELECT MAX(id_user) AS max FROM login");
    $RequestGetMaxId->execute();
    $GetMaxId = $RequestGetMaxId->fetch();
    $MaxId = $GetMaxId['max'] + 1;

    $RequestCreateUser = $DataBase->prepare("INSERT INTO
                                             login (id_user, pseudo, mdp, email, admin)
                                             VALUES (?, ?, ?, ?, ?)");
    $RequestCreateUser->execute([$MaxId, $login, $mdp, $mail, 0]);

    $RequestIdLog = $DataBase->prepare("SELECT MAX(id_log) AS max FROM log");
    $RequestIdLog->execute();
    $GetIdLog = $RequestIdLog->fetch();
    $IdLog = $GetIdLog['max'] + 1;

    $RequestLog = $DataBase->prepare("INSERT INTO 
                                     `log` (id_log, temps, `type`, id_user)
                                      VALUES (?, ?, ?, ?)");
    $RequestLog->execute([$IdLog, date("H:i:s"), "Account Creation", $MaxId]);
    header('Location: Login.html');
}
exit;
?>