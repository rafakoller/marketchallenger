<?php
session_start();
require '../config/parameters..php';
date_default_timezone_set (TIMEZONE);
if(!isset($_SESSION['id'])) {
    header("Location: /app/view/login.php");
}

include '../controler/HomeView.php';
include '../model/Stock.php';
include '../controler/StockList.php';
include '../model/Product.php';
include '../controler/ProductList.php';
include '../controler/ProductForm.php';
include '../model/Order.php';
include '../controler/OrderList.php';
include '../controler/OrderForm.php';
include '../model/OrderProduct.php';
include '../model/TypeProduct.php';
include '../controler/TypeProductList.php';
include '../controler/TypeProductForm.php';
include '../model/Purchase.php';
include '../controler/PurchaseList.php';
include '../controler/PurchaseForm.php';
include '../controler/UserView.php';
include '../controler/UserList.php';
include '../controler/ErrorView.php';

$classes = get_declared_classes();

// load top menu and set the name of logged user
$menu = file_get_contents('menu.phtml');


// consult if have a class in url
if (isset($_GET['class']) && !empty($_GET['class'])) {

    // load status, key and pagination from obj wen have it
    $data = [];
    $data = (isset($_GET)) ? $_GET : null;

    if(!empty($data['page']))
    {
        if ($data['page'] == 0) {$data['page'] = 1;}
        $page = $data['page'];

    }
    $data['page'] = (isset($page))?$page:null;

    // load object of class wen edit
    if (isset($data['key']) && $data['key'] != null && ($data['class'] != 'Order') && (isset($data['status']) && $data['status'] != 'hownow')) {
        $data['obj'] = $data['class']::getObj($data['key']);
    }

    // consult if class exist
    if (!in_array($data['class'],$classes)) {

        // error view wen class dont exist
        $class = new ErrorView;
        $container_data = $class->getData($data);
        $menu_replace =  str_replace("{ErrorView}",'active',$menu);

    } else {

        // point to class form wen object is set
        $reclass = ((isset($data['obj']) && $data['class'] != 'OrderList') || (isset($data['status']) && $data['status']==10) || (isset($data['status']) && $data['status']==5))?$data['class'].'Form':$data['class'];
        if ($reclass == 'UserForm') {$reclass = 'User';}
        $class = new $reclass();

        // consult if is a post or not to redirect to rigth place
        if (isset($_POST) && !empty($_POST)) {

            // if a post, return so same class to show confirm and load obj
            $returndata = $class->onPost($_POST);
            $status = (!empty($returndata['status']))?'&status='.$returndata['status']:'';
            $key = (!empty($returndata['key']))?'&key='.$returndata['key']:'';
            if(isset($returndata['status']) && $returndata['status'] == 'sale') {
                header("Location: /app/view/front.php?class=OrderList".$status.$key);
            } else {
                header("Location: /app/view/front.php?class=".$data['class'].$status.$key);
            }

        } else {

            // load data status and obj wen have it
            $container_data = $class->getData($data);
            $menu_replace =  str_replace("{".$data['class']."}",'active',$menu);
        }
    }

} else {

    // set the home as default class, when we don't have one
    $class = new HomeView;
    $container_data = $class->getData();
    $menu_replace =  str_replace("{HomeView}",'active',$menu);

}

$menu_replace =  str_replace("{usuario}",$_SESSION['firstname'],$menu);

// change container size to POS
$containerclass = (isset($data['class']) && $data['class'] == 'OrderForm')? 'col-12' : 'container';
$stylepos = (isset($data['class']) && $data['class'] == 'OrderForm')? 'style="background: linear-gradient(to bottom, #9DA3A9, transparent) no-repeat bottom; background-size: 100% 100%; height: 60em;background-attachment: fixed;"' : 'class="bg-light bg-gradient"';



?>
<!DOCTYPE html>
<html lang="en">
    <?php
    include 'header.phtml';
    ?>
    <script>
        $(window).on("load", function(){
            $('#containerload').fadeOut('slow');
        });
    </script>
    <body <?= $stylepos ?>>
        <?php
        echo $menu_replace;
        ?>
        <div id="containerload">
<!--            <img id="loading-image" src="path/to/ajax-loader.gif" alt="Loading..." />-->
<!--            <div id="loading-image" class="sbl-circ-ripple"></div>-->
<!--            <i id="loading-image" class="fa fa-spin fa-plus-square fa-4x text-black-50" aria-hidden="true"></i>-->
            <div id="loading-image" class="spinner-grow" style="width: 100px; height: 100px;" role="status">
                <span class="sr-only"></span>
            </div>
        </div>
        <!--<div class="sbl-circ-ripple"></div>-->
        <div id="container" class="<?= $containerclass ?> p-4">
            <?php
            echo $container_data;
            ?>
        </div><br><br>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
        <?php
        include 'footer.phtml';
        ?>
</html>
