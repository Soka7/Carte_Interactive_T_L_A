<?php
$login = $_GET["login"];
$mail = $_GET["mail"];
$mdp = $_GET["mdp"];

$DataBase = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8','root','ChuckNorris44');

$RequestValidity = $DataBase->prepare("SELECT COUNT(*) AS counter FROM login WHERE pseudo=? AND mdp=?");
$RequestValidity->execute([$login, $mdp]);
$Validity = $RequestValidity->fetchAll(PDO::FETCH_ASSOC);

$RequestAdmin = $DataBase->prepare("SELECT admin AS adm FROM login WHERE pseudo=? AND mdp=?");
$RequestAdmin->execute([$login, $mdp]);
$AdminUser = $RequestAdmin->fetch();

if($Validity["counter"] == 1 || $AdminUser["adm"] == 1)
{
    header('Location: AdminView.html');
}
elseif($Validity["counter"] == 1 && $AdminUser["adm"] == 0)
{
    header('Location: index1.html');
}
else
{
    header('Location: Enjeux.html');
}
?>