<?php
session_start();
if($_SESSION["admin"] == 1)
{
    header('Location: AdminView.php');
}
else{
    header('Location: index1.html');
}
exit;
?>