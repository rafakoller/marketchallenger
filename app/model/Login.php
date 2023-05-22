<?php
require 'User.php';

/**
 * Login User class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Login extends Connection {

    public $id;
    public $name;
    public $firstname;

    public $email;

    /**
     * Login user on system
     * @return void|null
     */
    public function login($username,$password)
    {
        $db = new Connection();
        $con = $db->getConnection();

        $query = "SELECT * FROM user WHERE username = '$username';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0){
            if (Cript::check($password, $row['password'])) {
                $fnam = explode(' ',$row['name']);
                $this->id        = $row['id'];
                $this->name      = $row['name'];
                $this->firstname = $fnam[0];
                $this->email     = $row['email'];
                return 1;
                // Successful Login
            } else {
                return 10;
                // Wrong Password
            }
        } else {
            return 100;
            // User not registered
        }
    }

    /**
     * Get id from user logged
     * @return integer
     */
    public function idUser()
    {
        return $this->id;
    }

    /**
     * Get name from user logged
     * @return integer
     */
    public function nameUser()
    {
        return $this->name;
    }

    /**
     * Get first name from user logged
     * @return integer
     */
    public function firstnameUser()
    {
        return $this->firstname;
    }

    /**
     * Get email from user logged
     * @return integer
     */
    public function emailUser()
    {
        return $this->email;
    }

    /**
     * Register Session when user logged
     * @return void|null
     */
    public function registerSession($result)
    {
        if ($result == 1 && !empty($this->id))
        {
            session_start();

            return true;
        }
        return false;
    }
}