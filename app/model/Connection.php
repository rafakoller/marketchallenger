<?php

/**
 * Connection DB class
 *
 * @author Rafael Koller <rafakoller@gmail.com>
 */
class Connection{

    public $conn;

    function __construct()
    {
        $this->connect();
    }

    function __destruct()
    {
        $this->close();
    }

    /**
     * Connecting on DB
     * @return void|null
     */
    private function connect()
    {
        if($this->conn)
        {
            return NULL;
        }

        require_once '../config/db_config.php';
        $this->conn = mysqli_connect(HOST, USER, PASS,DB_NAME);
    }

    /**
     * Get Connection
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Closing Connection
     */
    private function close()
    {
        mysqli_close($this->conn);
    }
}
