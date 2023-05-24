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
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM product;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $count = mysqli_num_rows($result);
        return $count;
    }

    /**
     * Get amount of Type of Products
     * @return integer
     */
    public function getAmountTypeProducts()
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM product_type;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $count = mysqli_num_rows($result);
        return $count;
    }

    /**
     * Get amount of Products out off
     * @return integer
     */
    public function getAmountOutOffProducts()
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM stock WHERE `stock` = 0;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $count = mysqli_num_rows($result);
        return $count;
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
     * Get Top 10 Products Seller last month
     * @return integer
     */
    public function getTopSelMonthProducts()
    {
        $products = [
            [
                'Product' => 'Tomatoes',
                'Price' => 6.88,
                'Proportion' => "78/100"
            ],[
                'Product' => 'Chicken',
                'Price' => 16.32,
                'Proportion' => "76/100"
            ],[
                'Product' => 'Whey Protein',
                'Price' => 55.18,
                'Proportion' => "74/100"
            ],[
                'Product' => 'Integral Rice',
                'Price' => 1.82,
                'Proportion' => "73/100"
            ],[
                'Product' => 'Sugar',
                'Price' => 1.28,
                'Proportion' => "73/100"
            ],[
                'Product' => 'Flavor',
                'Price' => 2.04,
                'Proportion' => "72/100"
            ],[
                'Product' => 'Whiskey',
                'Price' => 5.87,
                'Proportion' => "70/100"
            ],[
                'Product' => 'Cookies',
                'Price' => 0.88,
                'Proportion' => "69/100"
            ],[
                'Product' => 'Coca-Cola',
                'Price' => 3.08,
                'Proportion' => "66/100"
            ],[
                'Product' => 'Milk',
                'Price' => 2.56,
                'Proportion' => "65/100"
            ]];
        return $products;
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