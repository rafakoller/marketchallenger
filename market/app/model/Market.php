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
     * Get value of products cost in Stock
     * @return integer
     */
    public function getStockValue()
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT SUM(a.stock * b.cost) as total FROM stock a LEFT JOIN product b ON a.product_id = b.id;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return number_format($row['total'],2,'.',',');
    }

    /**
     * Get amount of Orders in the last month
     * @return integer
     */
    public function getLastMonthOrders()
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "select SUM(invoicing) as invoicing, COUNT(qnt) as qnt, date, day from (SELECT SUM((b.valtax * b.qnt) + (b.valprod * b.qnt)) as invoicing, COUNT(a.user_id) as qnt, date(a.created_at) as `date`, DATE_FORMAT(a.created_at, '%d/%m') as `day` FROM `order` a LEFT JOIN order_products b ON a.id = b.order_id  AND a.created_at >= (CURDATE( ) - INTERVAL 30 DAY) GROUP BY a.id, date(a.created_at) ORDER BY a.created_at asc) as ordered group by date order by date asc;";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $orders = [];
        foreach ($results as $res)
        {
            $orders[] =  [
                            'day' => $res['day'],
                            'qnt' => $res['qnt'],
                            'invoicing' => number_format($res['invoicing'],2,'.','')
                        ];
        }
        return $orders;
    }

    /**
     * Get Top 10 Products Seller last month
     * @return integer
     */
    public function getTopSelMonthProducts()
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT a.name, a.profit, b.product_id, b.valprod, b.valtax, SUM(b.qnt) as total FROM product a JOIN order_products b ON a.id = b.product_id JOIN `order` c ON b.order_id = c.id AND c.created_at >= (CURDATE( ) - INTERVAL 10 DAY) GROUP BY a.name ORDER BY total DESC LIMIT 10;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $products = [];
        foreach ($result as $res)
        {
            $percent = ($res['valtax'] / $res['valprod']) * 100;
            $products[] = [
                'Product' => $res['name'],
                'Price/Tax' => '$'.number_format($res['valprod']+$res['valtax'],2,'.',',').'  ('.number_format($percent,2,'.',',').'%)',
                'Profit' => $res['profit'].'%',
                'Quantity' => $res['total']
            ];
        }
        return $products;
    }

    /**
     * Get Price compose of products
     * @return integer
     */
    public function getPriceCompose()
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT SUM(a.cost) as costed, SUM((a.cost / 100) * a.profit) as profited, SUM(((a.cost + ((a.cost / 100) * a.profit)) / 100) * b.tax) as taxed FROM product a LEFT JOIN product_type b ON a.type_id = b.id;";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $count = mysqli_num_rows($results);
        $row = mysqli_fetch_assoc($results);
        $row['count'] = $count;
        return $row;
    }

}