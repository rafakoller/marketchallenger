<?php
require '../model/Login.php';

/**
 * Market class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Market extends Connection {

    /**
     * Get amount of Products
     * @return integer
     */
    public function getAmountProducts()
    {
        return 173;
    }

    /**
     * Get amount of Tipe of Products
     * @return integer
     */
    public function getAmountTipeProducts()
    {
        return 18;
    }

    /**
     * Get amount of Orders
     * @return integer
     */
    public function getAmountOrders()
    {
        return 47;
    }

    /**
     * Get amount of Orders in the last month
     * @return integer
     */
    public function getLastMonthOrders()
    {
        $orders = ['01' => 12, '02' => 18, '03' => 13, '04' => 10, '05' => 17, '06' => 16, '07' => 17, '08' => 14, '09' => 16, '10' => 9, '11' => 9, '12' => 10, '13' => 6, '14' => 10, '15' => 13, '16' => 16, '17' => 19,'18' => 22,'19' => 18,'20' => 15,'21' => 16,'22' => 15,'23' => 14,'24' => 10,'25' => 9,'26' => 16,'27' => 15,'28' => 16,'29' => 16,'30' => 18];
        return $orders;
    }

    /**
     * Get amount of Cash
     * @return integer
     */
    public function getAmountCash()
    {
        return 7452.86;
    }

    /**
     * Get amount of Tax
     * @return integer
     */
    public function getAmountTax()
    {
        return 1037.24;
    }

    /**
     * Get amount of Cost
     * @return integer
     */
    public function getAmountCost()
    {
        return 3468.45;
    }

    /**
     * Get amount of Profit
     * @return integer
     */
    public function getAmountProfit()
    {
        return 2947.17;
    }

}