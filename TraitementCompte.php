<?php
$login = $_POST["login"];
$mail = $_POST["mail"];
$mdp = $_POST["mdp"];

$DataBase = new PDO('mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8','root','ChuckNorris44');

$RequestExistingUser = $DataBase->prepare("SELECT COUNT(*) AS valid FROM login WHERE email=?");
$RequestExistingUser->execute([$mail]);
$ExistingUser = $RequestExistingUser->fetch();

if($ExistingUser['valid'] > 0)
{
    header('Location: Login.html');
}
else{
    $RequestGetMaxId = $DataBase->prepare("SELECT MAX(id) AS max FROM login");
    $RequestGetMaxId->execute();
    $GetMaxId = $RequestGetMaxId->fetch();
    $MaxId = $GetMaxId['max'] + 1;

    $RequestCreateUser = $DataBase->prepare("INSERT INTO login (id, pseudo, mdp, email, admin) VALUES (?, ?, ?, ?, ?)");
    $RequestCreateUser->execute([$MaxId, $login, $mdp, $mail, 0]);
    header('Location: index1.html');
}
?>