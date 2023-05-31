<?php
require '../model/User.php';
$register = new User();
$result = 0;
if(isset($_POST['submit'])) {
    $result = $register->registration($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirmpassword']);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'head.html';
        if ($result == 1){
            echo "<script> $(document).ready(function(){ $('#successful').slideDown('slow');$('#btnsubmint').attr('disabled','disabled');}); </script>";
        } else if ($result == 10){
            echo "<script> $(document).ready(function(){ $('#usermail').slideDown('slow');}); </script>";
        } else if ($result == 100){
            echo "<script> $(document).ready(function(){ $('#passmatch').slideDown('slow');}); </script>";
        }
        ?>
    </head>
    <body>
        <div class="bg">
            <div class="caption">
                <h1 class="text-center text-white" style="text-shadow: 2px 2px 6px black, 0 0 2em dimgrey;"><b>Market Challenger</b></h1>
                <h2 class="text-center text-white mb-3" style="text-shadow: 2px 2px 6px black;">Registration</h2>
                <br>
                <div class="p-3 ml-4 mr-4 container bg-white bg-gradient rounded border border-white center col-12 col-sm-12 col-md-6 col-lg-4 col-lg-3 col-xl-3 col-xxl-3" style="--bs-bg-opacity: .7;">
                    <form class="p-3" action="" method="post" autocomplete="off">
                        <div class="row mb-1">
                            <div class="mb-3">
                                <label class="form-label" for="name">Name: </label>
                                <input class="form-control" type="text" name="name" id="name" required value="<?php (isset($_POST['name'])) ? $_POST['name'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="username">Username: </label>
                                <input class="form-control" type="text" name="username" id="username" required value="<?php (isset($_POST['username'])) ? $_POST['username'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email: </label>
                                <input class="form-control" type="email" name="email" id="email" required value="<?php (isset($_POST['email'])) ? $_POST['email'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password: </label>
                                <input class="form-control" type="password" name="password" id="password" required value="" onkeydown="restrictpass(this);" onkeyup="restrictpass(this);" title="Your password must be 4-6 characters long, contain letters and numbers, and must not contain spaces or special characters.">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="confirmpassword">Confirm Password: </label>
                                <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" required value="">
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <div id="successful" class="alert alert-success mb-6" role="alert" style="display: none;">
                                    <div>Registration Successful!</div>
                                </div>
                                <div id="usermail" class="alert alert-danger mb-6" role="alert" style="display: none;">
                                    <div>Username or Email has already in use!</div>
                                </div>
                                <div id="passmatch" class="alert alert-danger mb-6" role="alert" style="display: none;">
                                    <div>Password not match.</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4" style="float: right;">
                                <button class="btn btn-primary col-12" type="submit" name="submit" id="btnsubmint">Register</button>
                            </div>
                            <div class="d-none d-md-block col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                &nbsp;
                            </div>
                            <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4" style="float: left">
                                <a class="btn btn-secondary col-12" href="login.php">Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script type="application/javascript">
        function restrictpass(element)
        {
            var max_chars = 6;

            if(element.value.length > max_chars) {
                element.value = element.value.substr(0, max_chars);
            }
            var letters = /^[0-9a-zA-Z]+$/;
            if(!element.value.match(letters))
            {
                element.value = element.value.substr(0, element.value.length - 1);
            }
        };
        <?php
        if ($result == 1){
        ?>
          $(document).ready(function(){setTimeout(() => {$('#successful').slideToggle('slow');window.location.replace(<?= DIRSYS ?>"/app/view/login.php");}, 6000);});
        <?php
        } else if ($result == 10){
        ?>
            $(document).ready(function(){setTimeout(() => {$('#usermail').slideToggle('slow');}, 6000);});
        <?php
        } else if ($result == 100){
        ?>
            $(document).ready(function(){setTimeout(() => {$('#passmatch').slideToggle('slow');}, 6000);});
        <?php
        }
        ?>

    </script>
    </body>
</html>