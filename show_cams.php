<script src="js/app1.js" defer></script>

<?php

    // Connect to database
    //file_put_contents('debug_log.txt', "Attempting database connection...\n", FILE_APPEND);
    $Database = new PDO(
        'mysql:host=localhost;port=3306;dbname=carte_interactive;charset=utf8',
        'root',
        'ChuckNorris44',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    
    $get_all_cam = $Database->prepare("
        SELECT ST_X(coordonnees) AS longitude,
        ST_Y(coordonnees) AS latitude,
        FROM cameras");
    $get_all_cam->execute();
    $all_cam = $get_all_cam->fetchAll();

    var_dump($all_cam);

    


?>


<script>
    const all_cam = <?php echo json_encode($all_cam, JSON_NUMERIC_CHECK); ?>
    console.log(all_cam);
</script>