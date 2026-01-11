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

$RequestUser = $DataBase->prepare("SELECT admin,id FROM login WHERE pseudo=? AND mdp=?");
$RequestUser->execute([$login, $mdp]);
$User = $RequestUser->fetch(PDO::FETCH_ASSOC);

session_start();
$_SESSION["login"] = $login;
$_SESSION["id"] = (int) $User["id"];
$_SESSION["admin"] = $User["admin"];

header('Location: index1.html');
exit;
?>