<?php
include('snippets/snippetPHPh.php');

if (!isset($_SESSION["id"]) || $userData[0][7] != 1) {
    header("Location: index.php?error=1");
}

include('functions/functionSurvey.php');
$CSurvey = new Survey($connect);

$surveys = $CSurvey->getAllSurveys();
$CSurveyQuestion = new Question($connect);

$CSurveyAnswer = new Answer($connect);

$CSurveyCompleted = new Completed($connect);

$surveysCompletedByAll = $CSurveyCompleted->surveyCompletedByAll();

if (isset($_POST['sendSurveyCreate'])) {
    $active = 0;
    if ($_POST['surveyActive'] == "on") {$active = 1;} else {$active=0;}
    $CSurvey->insertNewSurvey($_POST['surveyName'], $_POST['surveyDesc'], $active, $_SESSION['id']);
    $newSurvey = $CSurvey->getNewSurvey($_SESSION['id']);
    for ($i=0; $i < $_POST['questionQTY']; $i++) {
        $CSurveyQuestion->insertNewQuestion($newSurvey[0][0], $_POST[$i], $_SESSION['id']);
    }
    header('Location: indexSurveysAll.php');
}

if (isset($_POST['deleteSurveyAnswer'])) {
    if (md5($_POST['adminpassword']) === $userData[0][2]) {
        $CSurveyAnswer->deleteAnswer($_POST['deleteSurveyAnswer'], $_POST['userID']);
        $CSurveyCompleted->deleteUserFromCompletedSurvey($_POST['deleteSurveyAnswer'], $_POST['userID']);
        header('Location: indexSurveysAll.php');
    } else {
        header("Location: indexSurveysAll.php?error=3");
    }
}

if (isset($_POST['deleteSurvey'])) {
    if (md5($_POST['adminpassword']) === $userData[0][2]) {
        $CSurvey->deleteSurvey($_POST['deleteSurvey']);
        $CSurveyQuestion->deleteQuestionsBySurvey($_POST['deleteSurvey']);
        $CSurveyAnswer->deleteAnswersBySurvey($_POST['deleteSurvey']);
        $CSurveyCompleted->deleteAllUsersFromSurvey($_POST['deleteSurvey']);
        header('Location: indexSurveysAll.php');
    } else {
        header("Location: indexSurveysAll.php?error=3");
    }
}

if (isset($_POST['modifySurvey'])) {
    if (md5($_POST['adminpassword']) === $userData[0][2]) {
        if ($_POST['surveyName'] !== $surveys[$_POST['modifySurvey']][1]) {
            $CSurvey->setSurveyName($_POST['modifySurvey'], $_POST['surveyName']);}
        if ($_POST['surveyDesc'] !== $surveys[$_POST['modifySurvey']][2]) {
            $CSurvey->setSurveyDesc($_POST['modifySurvey'], $_POST['surveyDesc']);}
        $questions = $CSurveyQuestion->getAllQuestionsBySurvey($_POST['modifySurvey']);
        for ($i=0; $i < count($questions); $i++) {
            if ($questions[$i][2] !== $_POST[$i]) {
                $CSurveyQuestion->setQuestionByID($questions[$i][0], $_POST[$i]);
                $CSurveyAnswer->deleteAnswersBySurvey($_POST['modifySurvey']);
                $CSurveyCompleted->deleteAllUsersFromSurvey($_POST['modifySurvey']);
            }
        }
        
        if ($_POST['surveyActive'] == "on") {$active = 1;} else {$active = 0;}
        $actSurvey = $CSurvey->getSurveyById($_POST['modifySurvey']);
        if ($active != $actSurvey[0][3]) {
            $CSurvey->setSurveyOpen($_POST['modifySurvey'], $active);
        } 

        header('Location: indexSurveysAll.php');
    } else {
        header("Location: indexSurveysAll.php?error=3");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Issues</title>
    <link rel="stylesheet" href="styles/styleMain.css">
</head>

<body>
    <!-- Top Nav -->
    <?php include('snippets/snippetNavbar.php'); ?>
    <!-- End Top Nav-->

    <div class="row">
        <!-- Sidebar -->
        <?php include('snippets/snippetMenu.php'); ?>
        <!-- End Siderbar -->

        <div class="maincontent col-11">
            <div class="row first-row">
                <div class="col-4">
                    <div class="card maincard">
                        <div class="card-body">
                            <!-- Error Start -->
                            <?php include('snippets/snippetErrors.php'); ?>
                            <!-- Error End -->
                            <h1 class="card-title">All Surveys  <button type="submit" class="btn btn-info" data-toggle="modal"
                                                        data-target="#surveyCreate">Create New</button></h1>
                            <?php include("snippets/snippetSurveyCreate.php"); ?>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Content</th>
                                        <th>Active</th>
                                        <th></th>
                                        <th>QTY</th>
                                        <th>C BY</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($surveys); $i++) { ?>
                                        <tr class="surveyViewBorder table-dark clickable" data-toggle="collapse" data-target="#primary<?php echo $surveys[$i][0]; ?>">
                                            <th><?php echo $surveys[$i][0]; ?></th>
                                            <td><?php echo $surveys[$i][1]; ?></td>
                                            <td><?php echo $surveys[$i][2]; ?></td>
                                            <td><input class="form-check-input activeMark" type="checkbox"
                                                    style="opacity: 1;" <?php if ($surveys[$i][3] == 1) {
                                                        echo "checked";
                                                    } ?> disabled></td>
                                                    <td>
                                                    <button type="button" class="btn btn-sm btn-light" data-toggle="modal"
                                                            data-target="#modifySurvey<?php echo $surveys[$i][0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg></button>
                                                    </td>
                                            <td><?php
                                                echo count($CSurveyCompleted->getSurveryCompletedBySurvey($surveys[$i][0]));
                                                ?></td>
                                            <td><?php $username = $CUsuario->getUsername($surveys[$i][4]); echo $username[0][0]; ?></td>
                                            <td>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                            data-target="#deleteSurvey<?php echo $surveys[$i][0]; ?>"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                            </svg></button>
                                            </td>
                                            <?php include('snippets/snippetSurveyDelete.php'); ?>
                                            <?php include('snippets/snippetSurveyModify.php'); ?>
                                        </tr>
                                        <tr id="primary<?php echo $surveys[$i][0]; ?>" class="collapse">
                                            <td colspan="10">
                                                <table class="table table-sm bm-0">
                                                    <tr>
                                                        <th></th>
                                                        <th>Q ID</th>
                                                        <th>Question</th>
                                                        <th></th>
                                                    </tr>
                                                    <?php
                                                        $allQuestions = $CSurveyQuestion->getAllQuestionsBySurvey($surveys[$i][0]);
                                                    for ($j = 0; $j < count($allQuestions); $j++) {
                                                        ?>
                                                    <tr class="surveyViewBorder table-secondary " data-toggle="collapse" data-target="#secondary<?php echo $allQuestions[$j][0]; ?>">
                                                        <th></th>
                                                        <th><?php echo $allQuestions[$j][0]; ?></th>
                                                        <td><?php echo $allQuestions[$j][2]; ?></td>
                                                        <td>
                                                            <!-- <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                            data-target="#deleteQuestion<?php echo $allQuestions[$j][0]; ?>"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                            </svg></button> -->
                                                        </td>
                                                        <!-- <?php include('snippets/snippetSurveyDeleteQ.php'); ?> -->
                                                    </tr>
                                                    <tr id="secondary<?php echo $allQuestions[$j][0]; ?>" class="collapse">
                                                        <td colspan="15">
                                                            <table class="table table-sm bm-0">
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th>A ID</th>
                                                                    <th>By</th>
                                                                    <th>Answer</th>
                                                                    <th></th>
                                                                </tr>
                                                                <?php 
                                                                $answer = $CSurveyAnswer->getAllAnswersBySurveyAndQuestion($surveys[$i][0],$allQuestions[$j][0]);
                                                                for ($k=0; $k < count($answer); $k++) { 
                                                                ?>
                                                                <tr class="surveyViewBorder table-light">
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th><?php echo $answer[$k][0]; ?></th>
                                                                    <td>
                                                                        <?php
                                                                        $username = $CUsuario->getUsername($answer[$k][4]);
                                                                        echo $username[0][0]; 
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $answer[$k][3]; ?></td>
                                                                    <td>
                                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                            data-target="#deleteAnswers<?php echo $answer[$k][0]; ?>"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                            </svg></button>
                                                                    </td>
                                                                    <?php include('snippets/snippetSurveyDeleteA.php'); ?>
                                                                </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </td>
                                        </tr>
                                        
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div> <!-- End of main card -->
                    </div> <!-- End of main content -->
                </div>
            </div>
        </div>
</body>

</html>