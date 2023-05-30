<?php

#include '../controler/Helper.php';

/**
 * OrderProduct class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class OrderProduct extends Order
{

    /**
     * Get a Objects by order
     * @param $order_id
     * @return array
     */
    public static function getObjsByOrder($order_id)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM order_products WHERE order_id = {$order_id};";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
    }

    /**
     * Get a Stats by order
     * @param $order_id
     * @return array
     */
    public static function getStatsByOrder($order_id)
    {
        $orders = self::getObjsByOrder($order_id);
        $resord = [];
        $resord['totprods'] = 0;
        $resord['tottaxs'] = 0;
        $resord['totorder'] = 0;
        $resord['pertax'] = 0;
        foreach ($orders as $prod)
        {
            $resord['totprods'] = $resord['totprods'] + ($prod['valprod'] * $prod['qnt']);
            $resord['tottaxs'] = $resord['tottaxs'] + ($prod['valtax'] * $prod['qnt']);
        }
        $resord['totorder'] = $resord['totprods'] + $resord['tottaxs'];
        $resord['pertax'] = ($resord['tottaxs'] / $resord['totprods']) * 100;
        return $resord;
    }

//    /**
//     * Delete Object by Product
//     * @param $order_id
//     * @param $product_id
//     */
//    public function deleteObj($order_id,$product_id)
//    {
//        $db = new Connection();
//        $con = $db->getConnection();
//
//        $query = "DELETE FROM order_products WHERE product_id = {$product_id} AND order_id = {$order_id};";
//        $results = mysqli_query($con, $query) or die(mysqli_error($con));
//        header("Location: ".DIRSYS."/app/view/front.php?class=OrderList");
//    }
}