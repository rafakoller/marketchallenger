<?php

//include '../controler/Helper.php';

/**
 * Stock class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Stock extends Connection
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
        $key = (isset($data['id']))?' AND `id` <> '.$data['id']:'';
        $query = "SELECT * FROM stock WHERE `product_id` = '{$data['product_id']}'".$key;
        $duplicate = mysqli_query($con, $query) or die(mysqli_error($con));
        if (mysqli_num_rows($duplicate) > 0) {
            $datareturn['status'] = 10;
            // object already exist
        } else {
            if (!isset($data['id'])) {
                $query = "INSERT INTO stock VALUES('','{$data['name']}','{$data['type_id']}','{$data['cost']}','{$data['profit']}')";
                mysqli_query($con, $query) or die(mysqli_error($con));
                $datareturn['status'] = 1;
                $datareturn['key'] = mysqli_insert_id($con);
                // Successful saved
            } else {
                $query = "UPDATE stock set `name` = '{$data['name']}', `type_id` = '{$data['type_id']}', `cost` = '{$data['cost']}', `profit` = '{$data['profit']}' WHERE id = '{$data['id']}'";
                mysqli_query($con, $query) or die(mysqli_error($con));
                $datareturn['status'] = 1;
                $datareturn['key'] = $data['id'];
                // Successful updated
            }
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
        $query = "SELECT * FROM stock WHERE id = '{$id}';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    /**
     * Get stock from a Object
     * @param $product_id
     * @return array
     */
    public static function getStock($product_id)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT qnt FROM stock WHERE product_id = '{$product_id}';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return $row['qnt'];
    }

    /**
     * Get a Object by product
     * @param $product_id
     * @return array
     */
    public static function getObjByProduct($product_id)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM stock WHERE product_id = '{$product_id}';";
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
        $query = "SELECT * FROM stock ORDER BY `name`;";
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
        $query = "SELECT a.*, b.name, b.cost FROM stock a LEFT JOIN product b ON a.product_id = b.id ORDER BY b.name ASC  LIMIT ".$limite."  OFFSET ".$offset.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $listyps = '';
        $vazio = true;
        foreach ($results as $res)
        {
            $vazio = false;
            $value = ($res['stock'] <=0 ) ? 0 : '$'.number_format(($res['stock'] * $res['cost']),2,'.',',');
            #$product = Product::getObj($res['product_id']);
            $btnsell = ($res['stock']<=0)?'':'<a href="front.php?class=Order&status=sell&prod='.$res['product_id'].'" title="Sell"><i class="fa fa-sign-out text-danger text-center" aria-hidden="true"></i></a>';
            $listyps .= '<tr>
                          <th scope="row">'.$res['name'].'</th>
                          <td><div class="text-center">'.$res['stock'].'</div></td>
                          <td><div class="text-center">'.$value.'</div></td>
                          <td><div class="row">
                                    <div class="col-6 text-center">
                                        <a href="front.php?class=Purchase&status=5&key='.$res['product_id'].'" title="Purchase"><i class="fa fa-sign-in text-center" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-6 text-center"> 
                                        '.$btnsell.'
                                    </div>
                                </div>
                            </td>
                        </tr>';
        }
        if ($vazio)
        {
            $listyps = '<tr>
                          <td colspan="3"><div class="text-center">There are no registers!</div></td>
                        </tr>';
        }
        $registers = '<table class="table table-bordered mw-100">
                          <thead>
                            <tr>
                              <th scope="col"><div class="text-center">Product</div></th>
                              <th scope="col"><div class="text-center">Quantity</div></th>
                              <th scope="col"><div class="text-center">Value</div></th>
                              <th scope="col"><div class="text-center">Actions</div></th>
                            </tr>
                          </thead>
                          <tbody>
                            '.$listyps.'
                          </tbody>
                        </table> ';

        return $registers;
    }

    /**
     * Update object
     * @return void
     */
    public static function updateStock($operation,$qnt,$product_id)
    {
        $db = new Connection();
        $con = $db->getConnection();
        if ($operation == 'set') {
            $querya = "UPDATE `stock` a SET a.stock = " . $qnt . " WHERE a.product_id = " . $product_id . ";";
        } else {
            $querya = "UPDATE `stock` a SET a.stock = (a.stock " . $operation . " " . $qnt . ") WHERE a.product_id = " . $product_id . ";";
        }
        mysqli_query($con, $querya) or die(mysqli_error($con));
    }

    /**
     * Delete a objetc
     * @param $key
     */
    public function deleteObj($key)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "DELETE FROM stock WHERE id = ".$key.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        header("Location: ".DIRSYS."/app/view/front.php?class=StockList");
    }


}