<?php

/**
 * TypeProduct class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class TypeProduct extends Connection
{

    public $datareturn;

    public function onPost($data)
    {
        //print_r($data);die();

        $datareturn = [];

        $db = new Connection();
        $con = $db->getConnection();

        $key = (isset($data['id']))?' AND `id` <> '.$data['id']:'';

        $query = "SELECT * FROM product_type WHERE `type` = '{$data['type']}'".$key;
        $duplicate = mysqli_query($con, $query) or die(mysqli_error($con));

        if (mysqli_num_rows($duplicate) > 0) {
            $datareturn['status'] = 10;
            // type has already in use
        } else {
            if (!isset($data['id'])) {
                $query = "INSERT INTO product_type VALUES('','{$data['type']}','{$data['tax']}')";
                mysqli_query($con, $query) or die(mysqli_error($con));
                $datareturn['status'] = 1;
                $datareturn['key'] = mysqli_insert_id($con);
            } else {
                $query = "UPDATE product_type set `type` = '{$data['type']}', `tax` = '{$data['tax']}' WHERE id = '{$data['id']}'";
                mysqli_query($con, $query) or die(mysqli_error($con));
                $datareturn['status'] = 1;
                $datareturn['key'] = $data['id'];
            }

            // Successful saved
        }

        return $datareturn;
    }

    public static function getObj($id)
    {
        $db = new Connection();
        $con = $db->getConnection();

        $query = "SELECT * FROM product_type WHERE id = '{$id}';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);

        return $row;
    }
}