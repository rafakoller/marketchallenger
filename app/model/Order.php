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
        $query = "SELECT * FROM `order` WHERE `name` = '{$data['name']}'".$key;
        $duplicate = mysqli_query($con, $query) or die(mysqli_error($con));
        if (mysqli_num_rows($duplicate) > 0) {
            $datareturn['status'] = 10;
            // object already exist
        } else {
            if (!isset($data['id'])) {
                $query = "INSERT INTO `order` VALUES('','{$data['name']}','{$data['type_id']}','{$data['cost']}','{$data['profit']}')";
                mysqli_query($con, $query) or die(mysqli_error($con));
                $datareturn['status'] = 1;
                $datareturn['key'] = mysqli_insert_id($con);
                // Successful saved
            } else {
                $query = "UPDATE `order` set `name` = '{$data['name']}', `type_id` = '{$data['type_id']}', `cost` = '{$data['cost']}', `profit` = '{$data['profit']}' WHERE id = '{$data['id']}'";
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
        $query = "SELECT * FROM `order` WHERE id = '{$id}';";
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
        $query = "SELECT * FROM `order` ORDER BY `name`;";
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
        $query = "SELECT * FROM `order` ORDER BY `name` ASC  LIMIT ".$limite."  OFFSET ".$offset.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $listyps = '';
        $vazio = true;
        foreach ($results as $res)
        {
            $vazio = false;
            $type = TypeProduct::getObj($res['type_id']);
            $valprof = ($res['cost']/100)*$res['profit'];
            $valtax = (($res['cost']+$valprof)/100)*$type['tax'];
            $price= number_format(($res['cost'] + $valtax + $valprof),2,'.','');
            $listyps .= '<tr>
                          <th scope="row"><div class="text-center">'.$res['id'].'</div></th>
                          <td>'.$res['name'].'</td>
                          <td>'.$type['type'].'</td>
                          <td><div class="text-center">$'.$res['cost'].'</div></td>
                          <td><div class="text-center">'.$res['profit'].'% <small>($'.number_format($valprof,2,'.','').')</small></div></td>
                          <td><div class="text-center">'.$type['tax'].'% <small>($'.number_format($valtax,2,'.','').')</small></div></td>
                          <td><div class="text-center">$'.$price.'</div></td>
                          <td><div class="row">
                                    <div class="col-6 text-center">
                                        <a href="front.php?class=Order&key='.$res['id'].'" title="Edit"><i class="fa fa-pencil-square-o text-center" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-6 text-center"> 
                                        <a href="front.php?class=Order&status=del&key='.$res['id'].'" title="Delete"><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></a>
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
                              <th scope="col"><div class="text-center">Name</div></th>
                              <th scope="col"><div class="text-center">Type</div></th>
                              <th scope="col"><div class="text-center">Cost</div></th>
                              <th scope="col"><div class="text-center">Profit</div></th>
                              <th scope="col"><div class="text-center">Tax</div></th>
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
        $query = "DELETE FROM `order` WHERE id = ".$key.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        header("Location: /app/view/front.php?class=OrderList");
    }


}