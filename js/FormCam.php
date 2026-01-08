<?php
if (isset($_POST['cam'])){
    $nom = $_POST['cam'];
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if($nom !== ""): ?>
        <p><?php echo "Bonjour" . htmlspecialchars($nom); ?></p>
    <?php endif; ?>
</body>
</html>