<?php
require 'Connection.php';
require 'Cript.php';

/**
 * User system class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class User extends Connection {

    /**
     * Register User on DB
     * @return integer
     */
    public function registration($name,$username,$email,$password,$confirmpassword){

        $db = new Connection();
        $con = $db->getConnection();

        $hash = Cript::hash($password);

        $query = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
        $duplicate = mysqli_query($con, $query) or die(mysqli_error($con));

        if (mysqli_num_rows($duplicate) > 0){
            return 10;
            // Username or email has already in use
        } else {
            if ($password == $confirmpassword) {
                $query = "INSERT INTO user VALUES('','$name','$username','$email','$hash')";
                mysqli_query($con, $query) or die(mysqli_error($con));
                return 1;
                // Successful registration
            } else {
                return 100;
                // Password does not equals
            }
        }
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
        $query = "SELECT * FROM `user` WHERE id = '{$id}';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
}