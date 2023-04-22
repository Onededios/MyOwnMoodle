<?php
class Survey
{
    public function __construct($connection = "")
    {
        // Constructor function that sets up a connection to the database.
        // If no connection is provided, it defaults to an empty string.
        if (gettype($connection) === "object") {
            $this->db = $connection;
            // Retrieves the total number of surveys from the database
            $sql = "SELECT count(*) as id FROM surveys";
            $respuesta = $this->consulta($sql);
        }
    }

    // This function is used to set up a new database connection.
    public function connection($connection)
    {
        $this->__construct($connection);
    }

    // Function to execute a SQL query against the database and return the result.
    public function consulta($sql)
    {
        $db = $this->db;
        $smt = $db->query($sql);
        return $smt;
    }

    // Insert a new survey into the database.
    public function insertNewSurvey($name, $description, $open, $createdBy)
    {
        $db = $this->db;
        $smt = $db->query(
            'INSERT INTO `surveys`(`name`, `description`, `open`, `createdBy`) VALUES ("' .
                $name .
                '","' .
                $description .
                '","' .
                $open .
                '","' .
                $createdBy .
                '")'
        );
    }

    // Retrieve all surveys from the database.
    function getAllSurveys()
    {
        $db = $this->db;
        $smt = $db->query("SELECT * FROM `surveys`");
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // Retrieve the latest survey created by a given user.
    function getNewSurvey($createdBy)
    {
        $db = $this->db;
        $smt = $db->query(
            "SELECT max(id) FROM `surveys` WHERE `createdBy`=" . $createdBy . ""
        );
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // Retrieve a survey from the database by its ID.
    function getSurveyById($id)
    {
        $db = $this->db;
        $smt = $db->query("SELECT * FROM `surveys` WHERE `id`=" . $id . "");
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // Delete a survey from the database.
    public function deleteSurvey($Survey)
    {
        $db = $this->db;
        $smt = $db->query('DELETE FROM surveys WHERE id="' . $Survey . '"');
    }

    // Update the name of a survey in the database.
    public function setSurveyName($id, $name)
    {
        $db = $this->db;
        $smt = $db->query(
            'UPDATE surveys SET name="' . $name . '" where id=' . $id . ""
        );
    }

    // Update the description of a survey in the database.
    public function setSurveyDesc($id, $desc)
    {
        $db = $this->db;
        $smt = $db->query(
            'UPDATE surveys SET description="' .
                $desc .
                '" where id=' .
                $id .
                ""
        );
    }

    // Update the "open" status of a survey in the database.
    public function setSurveyOpen($id, $open)
    {
        $db = $this->db;
        $smt = $db->query(
            "UPDATE `surveys` SET `open`=" . $open . " WHERE `id`=" . $id
        );
    }
}

class Question
{
    // Constructor to initialize the database connection
    public function __construct($connection = "")
    {
        // If the provided connection is an object, set it as the database connection and retrieve the count of rows in surveysQuestions table
        if (gettype($connection) === "object") {
            $this->db = $connection;
            $sql = "SELECT count(*) as id FROM surveysQuestions";
            $respuesta = $this->consulta($sql);
        }
    }

    // Function to set the database connection
    public function connection($connection)
    {
        $this->__construct($connection);
    }

    // Function to execute a SQL query and return the result
    public function consulta($sql)
    {
        $db = $this->db;
        $smt = $db->query($sql);
        return $smt;
    }

    // Insert a new question in surveysQuestions table
    public function insertNewQuestion($surveyAssigned, $content, $createdBy)
    {
        $db = $this->db;
        $smt = $db->query(
            'INSERT INTO `surveysQuestions`(`surveyAssigned`, `content`, `createdBy`) VALUES ("' .
                $surveyAssigned .
                '","' .
                $content .
                '","' .
                $createdBy .
                '")'
        );
    }

    // Get all questions for a given survey ID
    function getAllQuestionsBySurvey($SurveyID)
    {
        $db = $this->db;
        $smt = $db->query(
            'SELECT * FROM `surveysQuestions` WHERE surveyAssigned="' .
                $SurveyID .
                '"'
        );
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // Delete all questions for a given survey
    public function deleteQuestionsBySurvey($Survey)
    {
        $db = $this->db;
        $smt = $db->query(
            'DELETE FROM surveysQuestions WHERE surveyAssigned="' .
                $Survey .
                '"'
        );
    }

    // Update a question content by its ID
    public function setQuestionByID($id, $val)
    {
        $db = $this->db;
        $smt = $db->query(
            'UPDATE surveysQuestions SET content="' .
                $val .
                '" where id=' .
                $id .
                ""
        );
    }
}

class Answer
{
    public function __construct($connection = "")
    {
        // Constructor method that sets the class's $db property if the argument passed is an object.
        // It also queries the database to count the number of rows in the "surveysAnswers" table.
    }

    public function connection($connection)
    {
        // Method that calls the constructor with the provided connection object.
    }

    public function consulta($sql)
    {
        // Method that queries the database with the provided SQL statement and returns the result.
    }

    // Inserts
    public function insertNewAnswer(
        $surveyAssigned,
        $questionAssigned,
        $content,
        $answerBy
    ) {
        // Method that inserts a new answer into the "surveysAnswers" table with the provided survey, question, answer content, and answerer ID.
    }

    // Gets
    function getAllAnswersBySurveyAndQuestion($SurveyID, $QuestionID)
    {
        // Method that gets all answers from the "surveysAnswers" table that match the provided survey and question IDs.
    }

    function getAllAnswersByQuestionAndUser($QuestionID, $QuestionUser)
    {
        // Method that gets all answers from the "surveysAnswers" table that match the provided question ID and answerer ID.
    }

    function getAnswersBySurveyAndQuestionAndUser(
        $SurveyID,
        $QuestionID,
        $UserID
    ) {
        // Method that gets all answers from the "surveysAnswers" table that match the provided survey, question, and answerer IDs.
    }

    // Deletes
    public function deleteAnswer($Survey, $By)
    {
        // Method that deletes an answer from the "surveysAnswers" table that matches the provided survey and answerer IDs.
    }

    public function deleteAllAnswersFromQuestion($QuestionID)
    {
        // Method that deletes all answers from the "surveysAnswers" table that match the provided question ID.
    }

    public function deleteAnswersBySurvey($Survey)
    {
        // Method that deletes all answers from the "surveysAnswers" table that match the provided survey ID.
    }

    public function deleteAllAnswersByUser($id)
    {
        // Method that deletes all answers from the "surveysAnswers" table that match the provided answerer ID.
    }
}

// This class provides methods to interact with a database table named surveysCompleted
// It has methods for inserting, getting, and deleting data from the table.
class Completed
{
    public function __construct($connection = "")
    {
        // Check if $connection is an object
        if (gettype($connection) === "object") {
            // If it is, assign $connection to $this->db property
            $this->db = $connection;

            // Define a SQL query to count the number of rows in a table
            $sql = "SELECT count(*) as id FROM surveysCompleted";

            // Call the consulta() method with the SQL query and assign the result to $respuesta variable
            $respuesta = $this->consulta($sql);
        }
    }

    public function connection($connection)
    {
        // This method calls the constructor with the given connection parameter
        $this->__construct($connection);
    }

    public function consulta($sql)
    {
        // This method executes a SQL query on the database connection and returns the result
        $db = $this->db;
        $smt = $db->query($sql);
        return $smt;
    }

    //! Inserts
    public function insertSurveyCompleted($surveyCompleted, $surveyCompletedBy)
    {
        $db = $this->db;
        // Execute an SQL query to insert a new completed survey with the given survey and user IDs
        $smt = $db->query(
            'INSERT INTO `surveysCompleted`(`surveyCompleted`, `surveyCompletedBy`) VALUES ("' .
                $surveyCompleted .
                '","' .
                $surveyCompletedBy .
                '")'
        );
    }

    //! Gets
    // Retrieves all the completed surveys regardless of the user who completed them
    function surveyCompletedByAll()
    {
        $db = $this->db;
        $smt = $db->query("SELECT * FROM `surveysCompleted`");
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // Retrieves all the completed surveys for a specific survey ID
    function getSurveryCompletedBySurvey($SurveyID)
    {
        $db = $this->db;
        $smt = $db->query(
            'SELECT * FROM `surveysCompleted` WHERE surveyCompleted="' .
                $SurveyID .
                '"'
        );
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // Retrieves all the completed surveys for a specific survey ID and user ID
    function getSurveyCompletedBySurveyAndUser($SurveyID, $UserID)
    {
        $db = $this->db;
        $smt = $db->query(
            'SELECT * FROM `surveysCompleted` WHERE surveyCompleted="' .
                $SurveyID .
                '" AND surveyCompletedBy="' .
                $UserID .
                '"'
        );
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    // Retrieves all the surveys completed by a specific user ID
    function getAllSurveysCompletedByUser($id)
    {
        $db = $this->db;
        $smt = $db->query(
            "SELECT * FROM `surveysCompleted` WHERE surveyCompletedBy=" . $id
        );
        if ($smt) {
            return $smt->fetch_all();
        } else {
            return "error";
        }
    }

    //! Deleted
    /**
     * Deletes a user from a specific completed survey
     *
     * @param string $surveyID The ID of the completed survey
     * @param string $userID The ID of the user to be deleted from the survey
     */
    function deleteUserFromCompletedSurvey($surveyID, $userID)
    {
        // Get the database connection object
        $db = $this->db;

        // Execute a delete query to remove a user from the completed survey
        $smt = $db->query(
            'DELETE FROM surveysCompleted WHERE surveyCompleted="' .
                $surveyID .
                '" AND surveyCompletedBy="' .
                $userID .
                '"'
        );
    }

    /**
     * Deletes all users from a specific survey
     *
     * @param string $surveyID The ID of the survey to delete users from
     */
    function deleteAllUsersFromSurvey($surveyID)
    {
        // Get the database connection object
        $db = $this->db;

        // Execute a delete query to remove all users from a specific survey
        $smt = $db->query(
            'DELETE FROM surveysCompleted WHERE surveyCompleted="' .
                $surveyID .
                '"'
        );
    }

    /**
     * Deletes all completed surveys from a user
     *
     * @param string $id The ID of the user
     */
    function deleteAllCompletedFromUser($id)
    {
        // Get the database connection object
        $db = $this->db;

        // Execute a delete query to remove all completed surveys from a user
        $smt = $db->query(
            'DELETE FROM surveysCompleted WHERE surveyCompletedBy="' . $id . '"'
        );
    }
}
?>