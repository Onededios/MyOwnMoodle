<?php
class File
{
    public function __construct($connection = "")
    {
        // Check if the connection object is provided
        if (gettype($connection) === "object") {
            // If provided, set it to the 'db' property of this object
            $this->db = $connection;

            // Execute a query to get the count of files in the 'files' table
            $sql = "SELECT count(*) as id FROM files";
            $respuesta = $this->consulta($sql);
        }
    }
    public function connection($connection)
    {
        $this->__construct($connection); // Calls the __construct method with the passed connection
    }

    public function consulta($sql)
    {
        $db = $this->db; // Uses the database connection
        $smt = $db->query($sql); // Executes the query and stores the result in $smt
        return $smt; // Returns the result of the query
    }

    //! Inserts
    public function insertNewFile($filePath, $filename, $user, $type, $size)
    {
        $db = $this->db; // Uses the database connection
        $smt = $db->query(
            'INSERT INTO `files`(`fileName`, `filePath`, `size`, `type`, `userWhoUploaded`) VALUES ("' .
                $filename .
                '","' .
                $filePath .
                '","' .
                $size .
                '","' .
                $type .
                '","' .
                $user .
                '")'
        ); // Executes an insert statement with the passed values
    }

    //! Deletes
    public function deleteFile($id)
    {
        $db = $this->db; // Uses the database connection
        $smt = $db->query("DELETE FROM files WHERE id=" . $id); // Executes a delete statement with the passed ID
    }

    //This function retrieves all the files from the database
    public function getAllFiles()
    {
        $db = $this->db;
        $smt = $db->query("SELECT * FROM files");
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }
    //This function retrieves all the files uploaded by a specific user from the database
    public function getFilesByUser($id)
    {
        $db = $this->db;
        $smt = $db->query("SELECT * FROM files WHERE userWhoUploaded=" . $id);
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    //This function retrieves a file by its ID from the database
    public function getFileByID($id)
    {
        $db = $this->db;
        $smt = $db->query('SELECT * FROM files WHERE id="' . $id . '"');
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }
}
?>
