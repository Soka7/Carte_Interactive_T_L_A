<?php
// MAXIMUM ERROR REPORTING
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', __DIR__ . '/php_errors.log');

// Log everything to a file
//file_put_contents('debug_log.txt', "=== NEW REQUEST ===\n", FILE_APPEND);
//file_put_contents('debug_log.txt', "Time: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

session_start();

// DEBUG: Check session
//file_put_contents('debug_log.txt', "Session ID: " . (isset($_SESSION['id']) ? $_SESSION['id'] : 'NOT SET') . "\n", FILE_APPEND);
//file_put_contents('debug_log.txt', "Session data: " . print_r($_SESSION, true) . "\n", FILE_APPEND);

// Check if user is logged in
if(!isset($_SESSION['id'])) {
    //file_put_contents('debug_log.txt', "ERROR: No session ID, redirecting to login\n", FILE_APPEND);
    header('Location: Login.html');
    exit;
}

// Get raw input
$raw_input = file_get_contents('php://input');
//file_put_contents('debug_log.txt', "Raw input: " . $raw_input . "\n", FILE_APPEND);

// Decode JSON
$Receive = json_decode($raw_input, true);
//file_put_contents('debug_log.txt', "Decoded JSON: " . print_r($Receive, true) . "\n", FILE_APPEND);

if (!$Receive) {
    //file_put_contents('debug_log.txt', "ERROR: JSON decode failed\n", FILE_APPEND);
    echo "ERROR: Invalid JSON";
    exit;
}

$Latit = $Receive['latitude'] ?? null;
$Longit = $Receive['longitude'] ?? null;
$lien = $Receive['lien_photo'] ?? null;
$title = $Receive['cam'] ?? null;

//file_put_contents('debug_log.txt', "Latitude: $Latit\n", FILE_APPEND);
//file_put_contents('debug_log.txt', "Longitude: $Longit\n", FILE_APPEND);
//file_put_contents('debug_log.txt', "Link: $lien\n", FILE_APPEND);
//file_put_contents('debug_log.txt', "Title: $title\n", FILE_APPEND);

// Validate inputs
if (empty($Latit) || empty($Longit)) {
    //file_put_contents('debug_log.txt', "ERROR: Missing coordinates\n", FILE_APPEND);
    echo "ERROR: Missing coordinates";
    exit;
}

if (empty($lien)) {
    //file_put_contents('debug_log.txt', "ERROR: Missing photo link\n", FILE_APPEND);
    echo "ERROR: Missing photo link";
    exit;
}

if (empty($title)) {
    //file_put_contents('debug_log.txt', "ERROR: Missing title\n", FILE_APPEND);
    echo "ERROR: Missing title";
    exit;
}

try {
    // Connect to database
    //file_put_contents('debug_log.txt', "Attempting database connection...\n", FILE_APPEND);
    $Database = new PDO(
        'mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8',
        'root',
        'ChuckNorris44',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    //file_put_contents('debug_log.txt', "Database connected successfully\n", FILE_APPEND);

    // Check for duplicates within 10 meters
    //file_put_contents('debug_log.txt', "Checking for duplicates...\n", FILE_APPEND);
    
    $verif_coordonnes = $Database->prepare("
        SELECT id_camera
        FROM cameras
        WHERE ST_Distance_Sphere(
            coordonnees,
            ST_GeomFromText(CONCAT('POINT(', ?, ' ', ?, ')'))
        ) < 10
    ");
    $verif_coordonnes->execute([$Longit, $Latit]);
    $resultats_verif_coordonnes = $verif_coordonnes->fetchAll();
    
    if (count($resultats_verif_coordonnes) > 0) {
        //file_put_contents('debug_log.txt', "ERROR: Duplicate camera found within 10m\n", FILE_APPEND);
        echo "ERROR: Une caméra existe déjà dans cette zone (rayon de 10m)";
        exit;
    }
    
    //file_put_contents('debug_log.txt', "No duplicates found\n", FILE_APPEND);
    
    // Get next camera ID
    //file_put_contents('debug_log.txt', "Getting next camera ID...\n", FILE_APPEND);
    $RequestMaxId = $Database->prepare("SELECT MAX(id_camera) AS max FROM cameras");
    $RequestMaxId->execute();
    $GetMaxId = $RequestMaxId->fetch();
    $MaxId = ($GetMaxId['max'] ?? 0) + 1;
    //file_put_contents('debug_log.txt', "Next camera ID: $MaxId\n", FILE_APPEND);

    // Insert camera with POINT geometry
    // CRITICAL FIX: Use ST_GeomFromText to create proper POINT geometry
    //file_put_contents('debug_log.txt', "Attempting to insert camera...\n", FILE_APPEND);
    
    // Check if Titre column exists
    $columns_query = $Database->query("SHOW COLUMNS FROM cameras");
    $columns = $columns_query->fetchAll(PDO::FETCH_COLUMN);
    //file_put_contents('debug_log.txt', "Available columns: " . print_r($columns, true) . "\n", FILE_APPEND);
    
    if (in_array('Titre', $columns)) {
        //file_put_contents('debug_log.txt', "Using INSERT with Titre column\n", FILE_APPEND);
        $AddCam = $Database->prepare("
            INSERT INTO cameras(id_camera, coordonnees, lien_photo, origin_user, verifie, Titre) 
            VALUES(?, ST_GeomFromText(CONCAT('POINT(', ?, ' ', ?, ')')), ?, ?, ?)
        ");
        $AddCam->execute([$MaxId, $Longit, $Latit, $lien, $_SESSION['id'], 0, $title]);
    } else {
        //file_put_contents('debug_log.txt', "Using INSERT without Titre column\n", FILE_APPEND);
        // THE KEY FIX: Use ST_GeomFromText() to convert string to POINT geometry
        $AddCam = $Database->prepare("
            INSERT INTO cameras(id_camera, coordonnees, lien_photo, origin_user, verifie) 
            VALUES(?, ST_GeomFromText(CONCAT('POINT(', ?, ' ', ?, ')')), ?, ?, ?)
        ");
        $AddCam->execute([$MaxId, $Longit, $Latit, $lien, $_SESSION['id'], 0]);
    }
    
    //file_put_contents('debug_log.txt', "Camera inserted successfully! ID: $MaxId\n", FILE_APPEND);

    // Get next log ID
    //file_put_contents('debug_log.txt', "Getting next log ID...\n", FILE_APPEND);
    $RequestMaxIdLog = $Database->prepare("SELECT MAX(id_log) AS max FROM log");
    $RequestMaxIdLog->execute();
    $GetMaxIdLog = $RequestMaxIdLog->fetch();
    $MaxIdLog = ($GetMaxIdLog['max'] ?? 0) + 1;
    //file_put_contents('debug_log.txt', "Next log ID: $MaxIdLog\n", FILE_APPEND);

    // Add log entry
    //file_put_contents('debug_log.txt', "Attempting to insert log...\n", FILE_APPEND);
    $RequestLog = $Database->prepare("
        INSERT INTO `log` (id_log, temps, `type`, id_user, id_cam)
        VALUES (?, ?, ?, ?, ?)
    ");
    $RequestLog->execute([
        $MaxIdLog, 
        date("j/m/Y h:i:s"), 
        "Ajout Caméra", 
        $_SESSION['id'],
        $MaxId
    ]);
    
    //file_put_contents('debug_log.txt', "Log inserted successfully! ID: $MaxIdLog\n", FILE_APPEND);
    //file_put_contents('debug_log.txt', "=== SUCCESS ===\n\n", FILE_APPEND);

    echo "SUCCESS: Camera added with ID: $MaxId";
    
    // Uncomment this after testing to redirect
    // header('Location: index1.html');

} catch (PDOException $e) {
    //file_put_contents('debug_log.txt', "DATABASE ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    //file_put_contents('debug_log.txt', "Stack trace: " . $e->getTraceAsString() . "\n", FILE_APPEND);
    echo "DATABASE ERROR: " . $e->getMessage();
    exit;
} catch (Exception $e) {
    //file_put_contents('debug_log.txt', "GENERAL ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    echo "ERROR: " . $e->getMessage();
    exit;
}

//file_put_contents('debug_log.txt', "Script completed\n\n", FILE_APPEND);

//fichier modifié par claude pour debugger
//enlever les file_put_contents qui sont utilisés pour debugger
?>




