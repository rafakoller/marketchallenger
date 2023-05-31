<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: ".DIRSYS."/app/view/login.php");
}
$_SESSION = [];
session_unset();
session_destroy();
header("Location: ".DIRSYS."/app/view/login.php");
?>