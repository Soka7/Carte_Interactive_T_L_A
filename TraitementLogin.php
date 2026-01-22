<?php
// Méthode post pour faire transiter les données de manière sécurisé.
$mail = $_POST["email"];
$mdp = $_POST["mdp"];

$DataBase = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8','root','ChuckNorris44');

// Récupère le mot de passe hashé de l'utilisateur.
$RequestMdp = $DataBase->prepare("SELECT mdp FROM login WHERE email=?");
$RequestMdp->execute([$mail]);
$GetMdp = $RequestMdp->fetch();

// Récupère le nombre d'utilisateurs avec ce mot de passe et cet email.
$RequestValidity = $DataBase->prepare("SELECT COUNT(*) AS counter FROM login WHERE email=? AND mdp=?");
$RequestValidity->execute([$mail, $GetMdp['mdp']]);
$Validity = $RequestValidity->fetch();

/*
Vérifie qu'il n'y a qu'un seul utilisateur avec ce mot de passe et cet email.
Et vérifie que le mot de passe donné par l'utilisateur est bien le mot de passe correspondant au hash.
@note l'algorithme de hashage PASSWORD_BCRYPT utilisé sale les mot de passe, on ne peut donc pas directement vérifier.
*/
if($Validity["counter"] == 1 && password_verify($mdp, $GetMdp['mdp']))
{
    // Récupère l'id de l'utilisateur et si il est admin ou non.
    $RequestUser = $DataBase->prepare("SELECT admin,id_user FROM login WHERE email=? AND mdp=?");
    $RequestUser->execute([$mail, $GetMdp['mdp']]);
    $User = $RequestUser->fetch(PDO::FETCH_ASSOC);

    /*
    Crée une session pour l'utilisateur qui sera supprimé quand il fermera le site.
    Une session permet de temporairement stocker des données, un peu comme des cookies.
    Ici on stock l'id de l'utlisateur, si il est admin et son mail, afin qu'ils soientt acessible partout.
    */
    session_start();
    $_SESSION["mail"] = $mail;
    $_SESSION["id"] = (int) $User["id_user"]; // Force l'id à être un int a causes de potentiel bug.
    $_SESSION["admin"] = $User["admin"];

    // Récupère l'id de la dernière log pour l'incrémenter et l'ajouter à la base.
    $RequestIdLog = $DataBase->prepare("SELECT MAX(id_log) AS max FROM log");
    $RequestIdLog->execute();
    $GetIdLog = $RequestIdLog->fetch();
    $IdLog = $GetIdLog['max'] + 1;

    $RequestLog = $DataBase->prepare("INSERT INTO 
                                        `log` (id_log, temps, `type`, id_user)
                                        VALUES (?, ?, ?, ?)");

    // Méthode pour la date : https://www.w3schools.com/php/func_date_date.asp
    $RequestLog->execute([$IdLog, date("j/m/Y h:i:s"), "Connexion", (int) $User["id_user"]]);
    header('Location: index1.html');
    // Renvoie l'utilisateur sur la carte si la connexion a réussi.
}
else
{
    // renvoie l'utilisateur sur la page de connexion si la connexion a échoué.
    header('Location: Login.html');
}
exit;
?>