<?php
/*
Commence la session afin d'avoir accès aux donnés stockés dans la session
notement si l'utilisateur est admin.
*/
session_start();

// Renvoie sur la page admin si l'utilisateur est admin, et sur la carte si il ne l'est pas.
if($_SESSION["admin"] == 1)
{
    header('Location: AdminView.php');
}
else{
    header('Location: index1.html');
}
exit;
?>