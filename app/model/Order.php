<?php

//include '../controler/Helper.php';

/**
 * Order class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Order extends Connection
{
    public $datareturn;

    public $helper = Helper::class;


    public function getData($data = null)
    {
        if (isset($data['status']) && $data['status'] == 'sell')
        {
            header("Location: /app/view/front.php?class=OrderForm&qnt=1&prod=".$data['prod']);
        } else {
            $this->deleteObj($data['key']);
        }
    }



    /**
     * Save or Update a received Post
     * @param $data
     * @return array
     */
    public function onPost($data)
    {
        $datareturn = [];
        $db = new Connection();
        $con = $db->getConnection();

        $query = "INSERT INTO `order` VALUES('','{$_SESSION['id']}','".date('Y-m-d H:i:s')."')";
        $execute = mysqli_query($con, $query) or die(mysqli_error($con));
        $datareturn['status'] = 'sale';
        $datareturn['key'] = mysqli_insert_id($con);

        if ($execute)
        {
            foreach ($data['product_id'] as $key => $product_id)
            {
                // save the products
                $querya = "INSERT INTO `order_products` VALUES({$datareturn['key']},{$product_id},{$data['qnt'][$product_id]},{$data['valprod'][$product_id]},{$data['valtax'][$product_id]})";
                $executea = mysqli_query($con, $querya) or die(mysqli_error($con));

                if ($executea)
                {
                    // update the stock
                    Stock::updateStock('-', $data['qnt'][$product_id], $product_id);
                }
            }
        }

        // empty the cart
        $_SESSION['pos'] = [];

        // Successful saved, back to POS
        return $datareturn;
    }

    /**
     * Get a Object
     * @param $id
     * @return array
     */
    public static function getObj($id)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM `order` WHERE id = '{$id}';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    /**
     * Get a Objects of products
     * @param $id
     * @return array
     */
    public static function getObjsProds($orderid)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM `order_product` WHERE `order_id` = {$orderid} ORDER BY `created_at` DESC;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
    }

    /**
     * Get a Objects
     * @param $id
     * @return array
     */
    public static function getObjs()
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM `order` ORDER BY `created_at` DESC;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
    }

    /**
     * Get a html table of Paginated Registers
     * @param $limite
     * @param $pagecurr
     * @return void
     */
    public function getRegisters($limite,$pagecurr)
    {
        $offset = ($pagecurr == 1 || $pagecurr == 0)?0:($pagecurr - 1)*$limite;
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM `order` ORDER BY `created_at` DESC LIMIT ".$limite."  OFFSET ".$offset.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $listyps = '';
        $vazio = true;
        foreach ($results as $res)
        {
            $vazio = false;
            $user = User::getObj($res['user_id']);
            $products = OrderProduct::getStatsByOrder($res['id']);
            $totprods = $products['totprods'];
            $tottaxs = $products['tottaxs'];
            $pertax = $products['pertax'];
            $totorder = $products['totorder'];
            $listyps .= '<tr>
                          <th scope="row"><div class="text-center">'.str_pad($res['id'] , 4 , '0' , STR_PAD_LEFT).'</div></th>
                          <td>'.$user['name'].'</td>
                          <td><div class="text-center">$'.number_format($totprods,2,'.',',').'</div></td>
                          <td><div class="text-center">'.number_format($pertax,2,'.',',').'% <small>($'.number_format($tottaxs,2,'.',',').')</small></div></td>
                          <td><div class="text-center">$'.number_format($totorder,2,'.',',').'</div></td>
                          <td><div class="text-center">'.$res['created_at'].'</div></td>
                          <td><div class="row">
                                    <div class="col-6 text-center">
                                        <a href="front.php?class=OrderList&status=sale&key='.$res['id'].'" title="Edit"><i class="fa fa-pencil-square-o text-center" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-6 text-center"> 
                                        <a href="front.php?class=OrderList&status=del&key='.$res['id'].'" title="Delete"><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </td>
                        </tr>';
        }
        if ($vazio)
        {
            $listyps = '<tr>
                          <td colspan="8"><div class="text-center">There are no registers!</div></td>
                        </tr>';
        }
        $registers = '<table class="table table-bordered mw-100">
                          <thead>
                            <tr>
                              <th scope="col"><div class="text-center">Id</div></th>
                              <th scope="col"><div class="text-center">User</div></th>
                              <th scope="col"><div class="text-center">Produts Value</div></th>
                              <th scope="col"><div class="text-center">Tax Type</div></th>
                              <th scope="col"><div class="text-center">Order Value</div></th>
                              <th scope="col"><div class="text-center">Date/Time</div></th>
                              <th scope="col"><div class="text-center">Action</div></th>
                            </tr>
                          </thead>
                          <tbody>
                            '.$listyps.'
                          </tbody>
                        </table> ';

        return $registers;
    }

    /**
     * Get an Obj paginated
     * @param $limite
     * @param $pagecurr
     * @return array
     */
    public function getRegistersPaginated($limite,$pagecurr)
    {
        $offset = ($pagecurr == 1 || $pagecurr == 0)?0:($pagecurr - 1)*$limite;
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM `order` ORDER BY `created_at` DESC  LIMIT ".$limite."  OFFSET ".$offset.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        return $results;
    }

    /**
     * Delete a objetc
     * @param $key
     */
    public function deleteObj($order_id)
    {
        $db = new Connection();
        $con = $db->getConnection();

        $products = OrderProduct::getObjsByOrder($order_id);
        foreach($products as $prod)
        {
            // update the stock
            Stock::updateStock('+',$prod['qnt'],$prod['product_id']);

            // delete product from order
            $queryd = "DELETE FROM `order_products` WHERE order_id = {$order_id} AND product_id = {$prod['product_id']};";
            mysqli_query($con, $queryd) or die(mysqli_error($con));
        }

        // delete order
        $query = "DELETE FROM `order` WHERE id = ".$order_id.";";
        mysqli_query($con, $query) or die(mysqli_error($con));
        header("Location: /app/view/front.php?class=OrderList");
    }

}