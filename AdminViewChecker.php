<?php
session_start();
if($_SESSION["admin"] == 1)
{
    header('Location: AdminView.html');
}
else{
    header('Location: index1.html');
}
exit;
?>