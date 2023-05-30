<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: /app/view/login.php");
}
$_SESSION = [];
session_unset();
session_destroy();
header("Location: /app/view/login.php");
?>