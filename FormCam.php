<?php
$host = 'localhost';
$db = 'Carte_Interactive';
$user = 'root';
$pass = 'ChuckNorris44';
$charset = 'utf8mb4';

$dsn = 'mysql:host='.$host.';dbname='.$db.';charset='.$charset;

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=Carte_Interactive;charset=utf8', 'root', 'ChuckNorris44');

$act = $pdo->prepare('INSERT INTO cameras(id_camera, coordonnees, lien_photo, origin_user, verifie) VALUES(?, ?, ?, ?, ?)');
$act->execute([1, '2', '3', 4, 5]);
echo '<p>Erreur4</p>';
?>