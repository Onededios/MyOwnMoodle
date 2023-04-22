<?php
class Mark
{
    // Constructor that initializes the class with a database connection
    public function __construct($connection = "")
    {
        if (gettype($connection) === "object") {
            $this->db = $connection;
            // Get the count of rows in the `marks` table
            $sql = "SELECT count(*) as id FROM marks";
            $respuesta = $this->consulta($sql);
        }
    }

    // A method to set the database connection after object creation
    public function connection($connection)
    {
        $this->__construct($connection);
    }

    // A utility method to execute a SQL query and return the result
    public function consulta($sql)
    {
        $db = $this->db;
        $smt = $db->query($sql);
        return $smt;
    }

    //! Inserts

    // A method to insert a new row in the `marks` table
    public function insertNewMark($subject, $id, $mark)
    {
        $db = $this->db;
        $smt = $db->query(
            'INSERT INTO `marks`(`subject`, `mark`, `idUser`) VALUES ("' .
                $subject .
                '","' .
                $id .
                '","' .
                $mark .
                '")'
        );
    }

    //! Deletes

    // A method to delete a row from the `marks` table based on ID
    public function deleteMark($id)
    {
        $db = $this->db;
        $smt = $db->query('DELETE FROM marks WHERE id="' . $id . '"');
    }

    // A method to delete all rows from the `marks` table based on `idUser` field
    public function deleteAllMarksFromUser($id)
    {
        $db = $this->db;
        $smt = $db->query("DELETE FROM marks WHERE `idUser`=" . $id);
    }

    //! Gets

    // A method to get all marks of a user from the `marks` table based on `idUser` field
    public function getUserMarks($id)
    {
        $db = $this->db;
        $smt = $db->query(
            'SELECT subject,mark FROM marks WHERE idUser="' . $id . '"'
        );
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // A method to get all rows from the `marks` table
    public function getAllUserMarks()
    {
        $db = $this->db;
        $smt = $db->query("SELECT * FROM marks");
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }
}
?>