<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: /login.php");
}

include '../controler/HomeView.php';

if (isset($_GET['class']) && !empty($_GET['class'])) {
    $container = '..\controler\\'.$_GET['class'].'.php';
    $class = new $_GET['class'];
    $container_data = $class->getData();
} else {
    $container = '..\controler\HomeView.php';
    $class = new HomeView;
    $container_data = $class->getData();
}

$menu = file_get_contents('menu.phtml');
$menu_replace =  str_replace("{usuario}",$_SESSION['firstname'],$menu);

?>
<!DOCTYPE html>
<html lang="en">
    <?php
    include 'header.phtml';
    ?>
<body class=" bg-light bg-gradient">
    <?php
    echo $menu_replace;
    ?>
<div class="container p-4 bg-white">
    <?php
    //include $container;
    echo $container_data;
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
    <?php
    include 'footer.phtml';
    ?>
</html>
