<?php

include '../controler/Helper.php';

/**
 * TypeProduct class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class TypeProduct extends Connection
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
        $query = "SELECT * FROM product_type WHERE `type` = '{$data['type']}'".$key;
        $duplicate = mysqli_query($con, $query) or die(mysqli_error($con));
        if (mysqli_num_rows($duplicate) > 0) {
            $datareturn['status'] = 10;
            // object already exist
        } else {
            if (!isset($data['id'])) {
                $query = "INSERT INTO product_type VALUES('','{$data['type']}','{$data['tax']}','{$data['img']}')";
                mysqli_query($con, $query) or die(mysqli_error($con));
                $datareturn['status'] = 1;
                $datareturn['key'] = mysqli_insert_id($con);
                // Successful saved
            } else {
                $query = "UPDATE product_type set `type` = '{$data['type']}', `tax` = '{$data['tax']}', `img` = '{$data['img']}' WHERE id = '{$data['id']}'";
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
        $query = "SELECT * FROM product_type WHERE id = '{$id}';";
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
        $query = "SELECT * FROM product_type ORDER BY `type`;";
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
        $query = "SELECT * FROM product_type ORDER BY `type` ASC  LIMIT ".$limite."  OFFSET ".$offset.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        $listyps = '';
        foreach ($results as $res)
        {
            $listyps .= '<tr>
                          <td><img height="40px" class="img mx-auto d-block" onerror="this.onerror=null; this.src=\'https://www.contentviewspro.com/wp-content/uploads/2017/07/default_image.png\'" src="'.$res['img'].'"></td>
                          <td>'.$res['type'].'</td>
                          <td><div class="text-center">'.$res['tax'].'%</div></td>
                          <td>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <a href="front.php?class=TypeProduct&key='.$res['id'].'" title="Edit"><i class="fa fa-pencil-square-o text-center" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-6 text-center"> 
                                    <a href="front.php?class=TypeProduct&status=del&key='.$res['id'].'" title="Delete"><i class="fa fa-trash text-danger text-center" aria-hidden="true"></i></a>
                                </div>
                            </div>
                          </td>
                        </tr>';
        }
        $registers = '<table class="table table-bordered mw-100">
                          <thead>
                            <tr>
                              <th scope="col"><div class="text-center">Img</div></th>
                              <th scope="col"><div class="text-center">Type</div></th>
                              <th scope="col"><div class="text-center">Tax</div></th>
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
     * Delete Object
     * @param $key
     */
    public function deleteObj($key)
    {
        $db = new Connection();
        $con = $db->getConnection();

        $query = "SELECT * FROM product WHERE type_id = ".$key.";";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        if (mysqli_num_rows($result) >= 1) {
            header("Location: /app/view/front.php?class=TypeProduct&status=havchi&key=".$key);
        }

        $query = "DELETE FROM product_type WHERE id = ".$key.";";
        $results = mysqli_query($con, $query) or die(mysqli_error($con));
        header("Location: /app/view/front.php?class=TypeProductList");
    }


}