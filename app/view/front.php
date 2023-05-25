<?php
session_start();
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
include '../model/TypeProduct.php';
include '../controler/TypeProductList.php';
include '../controler/TypeProductForm.php';
include '../model/Purchase.php';
include '../controler/PurchaseList.php';
include '../controler/PurchaseForm.php';
include '../controler/UserView.php';
include '../controler/ErrorView.php';

$classes = get_declared_classes();

// load top menu and set the name of logged user
$menu = file_get_contents('menu.phtml');


// consult if have a class in url
if (isset($_GET['class']) && !empty($_GET['class'])) {

    // load status, key and pagination from obj wen have it
    $data = [];
    $data['status'] = (isset($_GET['status'])) ? $_GET['status'] : null;
    $data['key'] = (isset($_GET['key'])) ? $_GET['key'] : null;
    //echo $_GET['page'].'<br>';
    if(!empty($_GET['page']))
    {
        if ($_GET['page'] == 0) {$_GET['page'] = 1;}
        $page = $_GET['page'];

    }
    $data['page'] = (isset($page))?$page:null;

    // load object of class wen edit
    if ($data['key'] != null) {
        $data['obj'] = $_GET['class']::getObj($data['key']);
    }

    // consult if class exist
    if (!in_array($_GET['class'],$classes)) {

        // error view wen class dont exist
        $class = new ErrorView;
        $container_data = $class->getData($data);
        $menu_replace =  str_replace("{ErrorView}",'active',$menu);

    } else {

        // point to class form wen object is set
        $reclass = (isset($data['obj']) || $data['status']==10 || $data['status']=='5')?$_GET['class'].'Form':$_GET['class'];
        $class = new $reclass();

        // consult if is a post or not to redirect to rigth place
        if (isset($_POST) && !empty($_POST)) {

            // if a post, return so same class to show confirm and load obj
            $returndata = $class->onPost($_POST);
            $status = (!empty($returndata['status']))?'&status='.$returndata['status']:'';
            $key = (!empty($returndata['key']))?'&key='.$returndata['key']:'';
            header("Location: /app/view/front.php?class=".$_GET['class'].$status.$key);

        } else {

            // load data status and obj wen have it
            $container_data = $class->getData($data);
            $menu_replace =  str_replace("{".$_GET['class']."}",'active',$menu);
        }
    }

} else {

    // set the home as default class, when we don't have one
    $class = new HomeView;
    $container_data = $class->getData();
    $menu_replace =  str_replace("{HomeView}",'active',$menu);

}

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
<div class="container p-4">
    <?php
    echo $container_data;
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
    <?php
    include 'footer.phtml';
    ?>
</html>
