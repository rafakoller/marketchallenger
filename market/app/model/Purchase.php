<?php

//include '../controler/Helper.php';

/**
 * Purchase class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Purchase extends Connection
{
    public $datareturn;

    public $helper = Helper::class;

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
        if (!isset($data['id'])) {
            $query = "INSERT INTO `purchase` VALUES('','{$_SESSION['id']}', '{$data['product_id']}', '{$data['qnt']}', '{$data['supplier']}', '".date('Y-m-d H:i:s')."');";
            mysqli_query($con, $query) or die(mysqli_error($con));
            $datareturn['status'] = 1;
            $datareturn['key'] = mysqli_insert_id($con);

            // update the qnt of balance of stock
            Stock::updateStock('+',$data['qnt'],$data['product_id']);

            // Successful saved
        } else {
            $query = "UPDATE `purchase` set `user_id` = '{$_SESSION['id']}', `product_id` = '{$data['product_id']}', `qnt` = '{$data['qnt']}', `supplier` = '{$data['supplier']}', `created_at` = '".date('Y-m-d H:i:s')."' WHERE id = '{$data['id']}';";
            mysqli_query($con, $query) or die(mysqli_error($con));
            $datareturn['status'] = 1;
            $datareturn['key'] = $data['id'];
            // Successful updated
        }
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
        $query = "SELECT * FROM `purchase` WHERE id = '{$id}';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return $row;
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
        $query = "SELECT * FROM `purchase` ORDER BY `id`;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return $row;
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
        $query = "SELECT * FROM `purchase` ORDER BY `id` ASC  LIMIT ".$limite."  OFFSET ".$offset.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $listyps = '';
        $vazio = true;
        foreach ($results as $res)
        {
            $vazio = false;
            $product = Product::getObj($res['product_id']);
            $user = User::getObj($res['user_id']);
            $listyps .= '<tr>
                          <th scope="row"><div class="text-center">'.$res['id'].'</div></th>
                          <td>'.$product['name'].'</td>
                          <td><div class="text-center">'.$res['qnt'].'</div></td>
                          <td>'.$res['supplier'].'</td>
                          <td>'.$user['name'].'</td>
                          <td><div class="text-center">'.$res['created_at'].'</div></td>
                          <td><div class="row">
                                    <div class="col-12 text-center"> 
                                        <a href="front.php?class=Purchase&status=del&key='.$res['id'].'" title="Delete"><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></a>
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
                              <th scope="col"><div class="text-center">Product</div></th>
                              <th scope="col"><div class="text-center">Qnt</div></th>
                              <th scope="col"><div class="text-center">Supplier</div></th>
                              <th scope="col"><div class="text-center">User</div></th>
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
     * Delete a objetc
     * @param $key
     */
    public function deleteObj($key)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $stock = $this::getObj($key);

        // get the qnt of balance of stock
        $queryb = "SELECT * FROM `stock` WHERE product_id = ".$stock['product_id'].";";
        $resultsb = mysqli_query($con, $queryb) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($resultsb);
        if ($row['stock'] >= $stock['qnt']) {
            // remove the qnt of balance of stock
            Stock::updateStock('-',$stock['qnt'],$stock['product_id']);

            // remove purchase
            $query = "DELETE FROM `purchase` WHERE id = ".$key.";";
            $results = mysqli_query($con, $query) or die(mysqli_error($con));
            header("Location: ".DIRSYS."/app/view/front.php?class=PurchaseList");
        } else {
            header("Location: ".DIRSYS."/app/view/front.php?class=Purchase&status=oos&key=".$key);
        }
    }


}