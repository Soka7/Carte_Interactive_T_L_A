<?
$host = '127.0.0.1';
$db = 'carte_interactive';
$user = 'root';
$pass = 'ChuckNorris44';
$charset = 'utf8mb4';

$dsn = "mysqul:host=$host;dbname=$db;charset=$charset";

$pdo = new PDO($dsn, $user, $pass);

if (isset($_POST['cam'])){
    $id = $_POST['cam']
    $act = $pdo -> prepare("INSERT into cameras (id_camera) VALUES (:id)");
    $act -> execute(['nom'=>$nom]);

    echo "<p>Bonjour " . htmlspecialchars($nom) . ", votre nom a été enregistré !</p>";
}