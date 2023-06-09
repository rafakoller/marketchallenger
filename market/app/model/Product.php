<?php

//include '../controler/Helper.php';

/**
 * Product class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Product extends Connection
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
        $query = "SELECT * FROM product WHERE `name` = '{$data['name']}'".$key;
        $duplicate = mysqli_query($con, $query) or die(mysqli_error($con));
        if (mysqli_num_rows($duplicate) > 0) {
            $datareturn['status'] = 10;
            // object already exist
        } else {
            if (!isset($data['id'])) {
                $query = "INSERT INTO product VALUES('','{$data['name']}','{$data['type_id']}','{$data['cost']}','{$data['profit']}','{$data['img']}')";
                mysqli_query($con, $query) or die(mysqli_error($con));
                $datareturn['status'] = 1;
                $datareturn['key'] = mysqli_insert_id($con);

                // create a stock
                $querya = "INSERT INTO stock VALUES('','{$datareturn['key']}',0);";
                mysqli_query($con, $querya) or die(mysqli_error($con));

                // Successful saved
            } else {
                $query = "UPDATE product set `name` = '{$data['name']}', `type_id` = '{$data['type_id']}', `cost` = '{$data['cost']}', `profit` = '{$data['profit']}', `img` = '{$data['img']}' WHERE id = '{$data['id']}'";
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
        $query = "SELECT * FROM product WHERE id = '{$id}';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    /**
     * Get an Objects
     * @return array
     */
    public static function getObjs()
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM product ORDER BY `name`;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
    }

    /**
     * Get an Objects by Type
     * @param $type_id
     * @return array
     */
    public static function getObjsByType($type_id)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT * FROM product WHERE type_id = '{$type_id}' ORDER BY `name`;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
    }

    /**
     * Get a Qnt Objects by Type
     * @param $type_id
     * @return array
     */
    public static function getQntObjsByType($type_id)
    {
        $db = new Connection();
        $con = $db->getConnection();
        $query = "SELECT a.* FROM product a JOIN stock b on b.product_id = a.id AND b.stock > 0 AND a.type_id = '{$type_id}' ORDER BY a.`name`;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return mysqli_num_rows($result);
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
        $query = "SELECT * FROM product ORDER BY `name` ASC  LIMIT ".$limite."  OFFSET ".$offset.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $listyps = '';
        $vazio = true;
        foreach ($results as $res)
        {
            $vazio = false;
            $type = TypeProduct::getObj($res['type_id']);
            $valprof = ($res['cost']/100)*$res['profit'];
            $valtax = (($res['cost']+$valprof)/100)*$type['tax'];
            $price= ($res['cost'] + $valtax + $valprof);
            $listyps .= '<tr data-toggle="tooltip" data-placement="top" title="'.$type['type'].' - '.$res['name'].'">
                          <td><img height="40px" class="img mx-auto d-block" onerror="this.onerror=null; this.src=\'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png\'" src="'.$res['img'].'"></td>
                          <td>'.$res['name'].'</td>
                          <td>'.$type['type'].'</td>
                          <td><div class="text-center">$'.$res['cost'].'</div></td>
                          <td><div class="text-center">'.$res['profit'].'% <small>($'.number_format($valprof,2,'.',',').')</small></div></td>
                          <td><div class="text-center">'.$type['tax'].'% <small>($'.number_format($valtax,2,'.',',').')</small></div></td>
                          <td><div class="text-center">$'.number_format($price,2,'.',',').'</div></td>
                          <td>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <a href="front.php?class=Product&key='.$res['id'].'" title="Edit"><i class="fa fa-pencil-square-o text-center" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-6 text-center"> 
                                    <a href="front.php?class=Product&status=del&key='.$res['id'].'" title="Delete"><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></a>
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
                              <th scope="col"><div class="text-center">Img</div></th>
                              <th scope="col"><div class="text-center">Name</div></th>
                              <th scope="col"><div class="text-center">Type</div></th>
                              <th scope="col"><div class="text-center">Cost</div></th>
                              <th scope="col"><div class="text-center">Profit</div></th>
                              <th scope="col"><div class="text-center">Tax Type</div></th>
                              <th scope="col"><div class="text-center">Price to Sell</div></th>
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
        $query = "DELETE FROM product WHERE id = ".$key.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $querya = "DELETE FROM stock WHERE product_id = ".$key.";";
        $results = mysqli_query($con, $querya) or die(mysqli_error($con));
        header("Location: ".DIRSYS."/app/view/front.php?class=ProductList");
    }


}