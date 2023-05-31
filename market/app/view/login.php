<?php
session_start();
require '../model/Login.php';
require '../config/parameters.php';
date_default_timezone_set (TIMEZONE);
$login = new Login();

$result = 0;
if(isset($_SESSION['id'])) {
    header("Location: ".DIRSYS."/index.php");
}
if(isset($_POST['submit'])) {
    $result = $login->login($_POST['username'], $_POST['password']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include 'head.html';
    if ($result == 1){
        echo "<script> $(document).ready(function(){ $('#successful').slideDown('slow');$('#btnsubmint').attr('disabled','disabled');}); </script>";
        $_SESSION['login'] = true;
        $_SESSION['id'] = $login->idUser();
        $_SESSION['name'] = $login->nameUser();
        $_SESSION['firstname'] = $login->firstnameUser();
        $_SESSION['email'] = $login->emailUser();
        $_SESSION['pos'] = [];
        header("Location: ".DIRSYS."/index.php");
    } else if ($result == 10){
        echo "<script> $(document).ready(function(){ $('#wrongpass').slideDown('slow');}); </script>";
    } else if ($result == 100){
        echo "<script> $(document).ready(function(){ $('#ukuser').slideDown('slow');}); </script>";
    }
    ?>
</head>
<body>
<div class="bg">
    <div class="caption">
        <h1 class="text-center text-white" style="text-shadow: 2px 2px 6px black, 0 0 2em dimgrey;"><b>Market Challenger</b></h1>
        <h2 class="text-center text-white mb-3" style="text-shadow: 2px 2px 6px black;">Login</h2>
        <br>
        <div class="p-3 ml-4 mr-4 container bg-white bg-gradient rounded border border-white center col-12 col-sm-12 col-md-6 col-lg-4 col-lg-3 col-xl-3 col-xxl-3" style="--bs-bg-opacity: .7;">
            <form class="p-3" action="" method="post" autocomplete="off">
                <div class="row mb-1">
                    <div class="mb-3">
                        <label class="form-label" for="username">Username: </label>
                        <input class="form-control" type="text" name="username" id="username" required value="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password: </label>
                        <input class="form-control" type="password" name="password" id="password" required value="">
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-12">
                        <div id="successful" class="alert alert-success mb-6" role="alert" style="display: none;">
                            <div>Login Successful!</div>
                        </div>
                        <div id="wrongpass" class="alert alert-danger mb-6" role="alert" style="display: none;">
                            <div>Wrong Password!</div>
                        </div>
                        <div id="ukuser" class="alert alert-danger mb-6" role="alert" style="display: none;">
                            <div>User inactive or not registered!</div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4" style="float: right;">
                        <button class="btn btn-primary col-12" type="submit" name="submit" id="btnsubmint">Login</button>
                    </div>
                    <div class="d-none d-md-block col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                        &nbsp;
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4" style="float: left">
                        <a class="btn btn-secondary col-12" href="registration.php">Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script type="application/javascript">
    <?php
    if ($result == 1){
    ?>
    $(document).ready(function(){setTimeout(() => {$('#successful').slideToggle('slow');window.location.replace(<?= DIRSYS ?>"/index.php");}, 6000);});
    <?php
    } else if ($result == 10){
    ?>
    $(document).ready(function(){setTimeout(() => {$('#wrongpass').slideToggle('slow');}, 6000);});
    <?php
    } else if ($result == 100){
    ?>
    $(document).ready(function(){setTimeout(() => {$('#ukuser').slideToggle('slow');}, 6000);});
    <?php
    }
    ?>
</script>
</body>
</html>