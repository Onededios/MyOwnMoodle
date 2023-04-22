<?php
// This is a class definition for the Issue class
class Issue
{
    // This is the constructor method for the Issue class
    public function __construct($connection = "")
    {
        // If a connection object is passed in as an argument, set it as the database connection object
        if (gettype($connection) === "object") {
            $this->db = $connection;
            // Get the count of issues in the issuesReport table
            $sql = "SELECT count(*) as id FROM issuesReport";
            $respuesta = $this->consulta($sql);
        }
    }

    // This is a method for setting the database connection object for the Issue class
    public function connection($connection)
    {
        $this->__construct($connection);
    }

    // This is a method for making SQL queries on the database
    public function consulta($sql)
    {
        $db = $this->db;
        $smt = $db->query($sql);
        return $smt;
    }

    //! Inserts
    // This is a method for inserting a new issue into the issuesReport table
    public function insertNewIssue($priority, $title, $content, $userID)
    {
        $db = $this->db;
        $smt = $db->query(
            'INSERT INTO `issuesReport`(`issuePriority`, `ticketTitle`, `ticket`,`reportedBy`) VALUES ("' .
                $priority .
                '","' .
                $title .
                '","' .
                $content .
                '","' .
                $userID .
                '")'
        );
    }

    //! Deletes
    // This is a method for deleting a single issue from the issuesReport table
    public function deleteIssue($id)
    {
        $db = $this->db;
        $smt = $db->query('DELETE FROM issuesReport WHERE id="' . $id . '"');
    }

    // This is a method for deleting all issues submitted by a particular user from the issuesReport table
    public function deleteAllIssuesFromUser($id)
    {
        $db = $this->db;
        $smt = $db->query("DELETE FROM issuesReport WHERE `reportedBy`=" . $id);
    }

    //! Gets
    // This is a method for getting all issues from the issuesReport table
    public function getAllIssues()
    {
        $db = $this->db;
        $smt = $db->query("SELECT * FROM issuesReport");
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // This is a method for getting all issues submitted by a particular user from the issuesReport table
    public function getAllIssuesFromUser($id)
    {
        $db = $this->db;
        $smt = $db->query(
            "SELECT * FROM issuesReport WHERE `reportedBy`=" . $id
        );
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }
}

class IssuePrior
{
    // Constructor that takes a database connection object, checks its type, and initializes a count of issues
    public function __construct($connection = "")
    {
        if (gettype($connection) === "object") {
            $this->db = $connection;
            $sql = "SELECT count(*) as id FROM issues";
            $respuesta = $this->consulta($sql);
        }
    }
    // Connection method that calls the constructor
    public function connection($connection)
    {
        $this->__construct($connection);
    }
    // Query method that takes a SQL statement and returns a statement object
    public function consulta($sql)
    {
        $db = $this->db;
        $smt = $db->query($sql);
        return $smt;
    }
    //! Gets
    // Method that retrieves the name of an issue priority by its ID
    public function getIssuePrior($priorID)
    {
        $db = $this->db;
        $smt = $db->query(
            'SELECT errorName FROM issues WHERE id="' . $priorID . '"'
        );
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }
}
?>
