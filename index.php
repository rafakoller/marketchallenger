<?php
session_start();
if(isset($_SESSION['id'])) {
    header("Location: ".DIRSYS."/app/view/front.php");
} else {
    header("Location: ".DIRSYS."/app/view/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include 'head.html';
    ?>
</head>
<body>
<div class="bg">
    <div class="caption">
        <h1 class="text-center text-white" style="text-shadow: 2px 2px 6px black, 0 0 2em dimgrey;"><b>Market Challenger</b></h1>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>