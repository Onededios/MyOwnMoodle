<?php

class DBConnection
{
    //! Attr
    public $connection; // Public attribute that will hold the connection to the database
    private $server; // Private attribute that stores the server name
    private $base; // Private attribute that stores the database name
    private $user; // Private attribute that stores the username used to connect to the database
    private $password; // Private attribute that stores the password used to connect to the database

    //! Constr
    public function __construct()
    {
        $this->loadConf(); // Call the function that loads the configuration data
        $this->connection = $this->connect(); // Call the function that connects to the database and store the connection in the public attribute
    }

    //! Meth
    public function connect()
    {
        try {
            $db = new mysqli(
                $this->server,
                $this->user,
                $this->password,
                $this->base
            ); // Creates the connection using mysqli class
            mysqli_set_charset($db, "utf8"); // Set the character set to utf8
            return $db; // Returns the connection if the connection was successful
        } catch (PDOException $e) {
            // If connection its not correct returns an error message
            echo "ERROR: Cannot connect to the DB.";
        }
    }

    public function loadConf()
    {
        $this->server = "localhost"; // Server name where the database is located
        $this->base = "loginHTML"; // Name of the database
        $this->user = "root"; // Username used to connect to the database
        $this->password = ""; // Password used to connect to the database
    }
}

?>
