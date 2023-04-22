<?php
class User
{
    public function __construct($connection = '')
    {
        // Constructor method that optionally takes a parameter $connection
        if (gettype($connection) === 'object')
        {
            // Check if $connection is an object
            $this->db = $connection;
            // Set the $db property of the object to the value of $connection
            $sql = 'SELECT count(*) as id FROM users';
            // Execute a SQL query that counts the number of rows in the users table using the consulta() method
            $respuesta = $this->consulta($sql);
        }
    }

    public function connection($connection)
    {
        // Public method to call the constructor and pass in the $connection parameter
        $this->__construct($connection);
    }

    public function consulta($sql)
    {
        // Method to execute a SQL query and return the result as a statement object
        $db = $this->db;
        // Get the $db property of the object
        $smt = $db->query($sql);
        // Execute the SQL query using the query() method of $db
        return $smt;
        // Return the result as a statement object

    }

    public function comprobarUsuario($usuario)
    {
        // Method to check if a user exists in the users table
        $db = $this->db;
        // Get the $db property of the object
        $smt = $db->query('SELECT * FROM users where username="' . $usuario . '"');
        // Execute a SQL query to select all columns from the users table where the username matches $usuario
        if ($smt)
        {
            // Check if the query was successful
            return $smt->fetch_all();
            // Return the result as an array of all rows fetched

        }
        else
        {
            // Return an error message if the query was not successful
            return "error";
        }
    }

    // This function retrieves all data for a given user ID from the "users" table.
    //! Gets
    public function getUserData($id)
    {
        $db = $this->db; // Get the database connection from the class instance.
        $smt = $db->query('SELECT * FROM users where id=' . $id . ''); // Execute a SQL query to retrieve all data for the specified user ID.
        if ($smt)
        { // If the query executed successfully...
            return $smt->fetch_all(); // Return all rows returned by the query.

        }
        else
        { // If the query did not execute successfully...
            return "error"; // Return an error message.

        }
    }

    // This function retrieves all data for all users in the "users" table.
    public function getListOfUsers()
    {
        $db = $this->db; // Get the database connection from the class instance.
        $smt = $db->query('SELECT * FROM users'); // Execute a SQL query to retrieve all data from the "users" table.
        if ($smt)
        { // If the query executed successfully...
            return $smt->fetch_all(); // Return all rows returned by the query.

        }
        else
        { // If the query did not execute successfully...
            return "error"; // Return an error message.

        }
    }

    // This function retrieves the username for a given user ID from the "users" table.
    public function getUsername($id)
    {
        $db = $this->db; // Get the database connection from the class instance.
        $smt = $db->query('SELECT username FROM users WHERE id="' . $id . '"'); // Execute a SQL query to retrieve the username for the specified user ID.
        if ($smt)
        { // If the query executed successfully...
            return $smt->fetch_all(); // Return all rows returned by the query.

        }
        else
        { // If the query did not execute successfully...
            return "error"; // Return an error message.

        }
    }

    //! Inserts
    public function insertNewUser($username, $passwd, $fname, $lname, $mail, $tel)
    {
        // Connect to database
        $db = $this->db;
        // Insert a new user into the `users` table with the given data
        $smt = $db->query('INSERT INTO `users`(`username`, `password`, `fname`, `lname`, `mail`, `tel`) VALUES ("' . $username . '","' . $passwd . '","' . $fname . '","' . $lname . '","' . $mail . '","' . $tel . '")');
    }

    //! Sets
    public function setPassword($id, $password)
    {
        // Connect to database
        $db = $this->db;
        // Update the password of the user with the given ID
        $smt = $db->query('UPDATE users SET password="' . $password . '" where id=' . $id . '');
    }

    public function setUsername($id, $username)
    {
        // Connect to database
        $db = $this->db;
        // Update the username of the user with the given ID
        $smt = $db->query('UPDATE users SET username="' . $username . '" where id=' . $id . '');
    }

    public function setFName($id, $fname)
    {
        // Connect to database
        $db = $this->db;
        // Update the first name of the user with the given ID
        $smt = $db->query('UPDATE users SET fname="' . $fname . '" where id=' . $id . '');
    }

    public function setLName($id, $lname)
    {
        // Connect to database
        $db = $this->db;
        // Update the last name of the user with the given ID
        $smt = $db->query('UPDATE users SET lname="' . $lname . '" where id=' . $id . '');
    }

    public function setMail($id, $mail)
    {
        // Connect to database
        $db = $this->db;
        // Update the email address of the user with the given ID
        $smt = $db->query('UPDATE users SET mail="' . $mail . '" where id=' . $id . '');
    }

    public function setTel($id, $tel)
    {
        // Connect to database
        $db = $this->db;
        // Update the telephone number of the user with the given ID
        $smt = $db->query('UPDATE users SET tel="' . $tel . '" where id=' . $id . '');
    }

    //! Deletes
    public function deleteUser($id)
    {
        $db = $this->db;
        $smt = $db->query('DELETE FROM users WHERE id=' . $id); // Delete user from the database where id matches

    }

    //! Special
    public function usernameExists($username)
    {
        $db = $this->db;
        $smt = $db->query('SELECT username FROM `users`'); // Select all usernames from the users table
        if ($smt)
        {
            $array = $smt->fetch_all();
            $exists = false;
            foreach ($array as $val)
            {
                if ($username === $val[0])
                { // Check if the given username exists in the array
                    $exists = true;
                }
            }
            return $exists;
        }
        else
        {
            return "error";
        }
    }

    public function mailExists($mail)
    {
        $db = $this->db;
        $smt = $db->query('SELECT mail FROM `users`'); // Select all emails from the users table
        if ($smt)
        {
            $array = $smt->fetch_all();
            $exists = false;
            foreach ($array as $val)
            {
                if ($mail === $val[0])
                { // Check if the given email exists in the array
                    $exists = true;
                }
            }
            return $exists;
        }
        else
        {
            return "error";
        }
    }

}

class UserType
{
    // Constructor method
    public function __construct($connection = '')
    {
        // Check if $connection is an object
        if (gettype($connection) === 'object')
        {
            // Set the $db property of the object to the value of $connection
            $this->db = $connection;
            // Execute a SQL query that counts the number of rows in the usersTypes table using the consulta() method
            $sql = 'SELECT count(*) as id FROM usersTypes';
            $respuesta = $this->consulta($sql);
        }
    }

    // Public method to call the constructor and pass in the $connection parameter
    public function connection($connection)
    {
        $this->__construct($connection);
    }

    // Method to execute a SQL query and return the result as a statement object
    public function consulta($sql)
    {
        // Get the $db property of the object
        $db = $this->db;
        // Execute the SQL query using the query() method of $db
        $smt = $db->query($sql);
        // Return the result as a statement object
        return $smt;
    }

    //! Gets
    // Method to get the user type from the usersTypes table
    public function getUserType($userType)
    {
        // Get the $db property of the object
        $db = $this->db;
        // Execute a SQL query to select the userType from the usersTypes table where the id matches $userType
        $smt = $db->query('SELECT userType FROM usersTypes where id="' . $userType . '"');
        // Check if the query was successful
        if ($smt)
        {
            // Return the result as an array of all rows fetched
            return $smt->fetch_all();
        }
        else
        {
            // Return an error message if the query was not successful
            return "error";
        }
    }
}
?>