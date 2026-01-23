<?php
//methode claude pour afficher erreur
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Méthode post pour faire transiter les données de manière sécurisé.
$mail = $_POST["mail"];
$mdp = $_POST["mdp"];

$DataBase = new PDO('mysql:host=localhost;port=3306;dbname=Carte_Interactive;charset=utf8','root','ChuckNorris44');

// Vérifie que l'email de l'utilisateur n'est pas déja utilisé.
$RequestExistingUser = $DataBase->prepare("SELECT COUNT(*) AS valid FROM login WHERE email=?");
$RequestExistingUser->execute([$mail]);
$ExistingUser = $RequestExistingUser->fetch();

// Si l'email est déja utilisé ou que l'utilisateur n'a pas fournit de mail ou de mot de passe, il est renvoyé sur la page de création.
if($ExistingUser['valid'] > 0 || !$mail || !$mdp)
{
    header('Location: AccountCreation.html');
}
else{
    // Récupère et incrémente l'id qui sera utilisé pour créer le compte de l'utilisateur.
    $RequestGetMaxId = $DataBase->prepare("SELECT MAX(id_user) AS max FROM login");
    $RequestGetMaxId->execute();
    $GetMaxId = $RequestGetMaxId->fetch();
    $MaxId = $GetMaxId['max'] + 1;

    // Hash le mot de passe afin de le protéger dans la base de donnée.
    $HashedMdp = password_hash($mdp, PASSWORD_BCRYPT);

    $RequestCreateUser = $DataBase->prepare("INSERT INTO
                                             login (id_user, mdp, email, admin)
                                             VALUES (?, ?, ?, ?)");
    $RequestCreateUser->execute([$MaxId, $HashedMdp, $mail, 0]); // Par défaut l'utilisateur n'est pas admin.

    // Récupère et incrémente l'id des logs pour l'utilisé dans la base.
    $RequestIdLog = $DataBase->prepare("SELECT MAX(id_log) AS max FROM log");
    $RequestIdLog->execute();
    $GetIdLog = $RequestIdLog->fetch();
    $IdLog = $GetIdLog['max'] + 1;

    $RequestLog = $DataBase->prepare("INSERT INTO 
                                     `log` (id_log, temps, `type`, id_user)
                                      VALUES (?, ?, ?, ?)");

    // Méthode pour les dates : https://www.w3schools.com/php/func_date_date.asp
    $RequestLog->execute([$IdLog, date("j/m/Y h:i:s"), "Création de compte", $MaxId]);

    // Redirecte l'utilisateur sur la page de connexion pour qu'il se connecte au compte crée.
    header('Location: Login.html');
}
exit;
?>