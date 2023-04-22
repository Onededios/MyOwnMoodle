<?php
include('snippets/snippetPHPh.php');
include('functions/functionSurvey.php');
$CSurvey = new Survey($connect);

$surveys = $CSurvey->getAllSurveys();
$CSurveyQuestion = new Question($connect);

$CSurveyAnswer = new Answer($connect);

$CSurveyCompleted = new Completed($connect);

$surveysCompletedByAll = $CSurveyCompleted->surveyCompletedByAll();


//! MODALS
if (isset($_POST['sendSurveyAnswer'])) {
    $allQuestionsOfSurvey = $CSurveyQuestion->getAllQuestionsBySurvey($_POST['sendSurveyAnswer']);
    $allQuestionsAnswered = true;
    for ($i=0; $i < count($allQuestionsOfSurvey); $i++) { 
        if ($_POST[$allQuestionsOfSurvey[$i][0]] === "") {
            $allQuestionsAnswered = false;
            break;
        }
    }
    if ($allQuestionsAnswered) {
        for ($i = 0; $i < count($allQuestionsOfSurvey); $i++) {
            $CSurveyAnswer->insertNewAnswer($_POST['sendSurveyAnswer'], $allQuestionsOfSurvey[$i][0], $_POST[$allQuestionsOfSurvey[$i][0]], $_SESSION['id']);
        }
        $CSurveyCompleted->insertSurveyCompleted($_POST['sendSurveyAnswer'], $_SESSION['id']);
        header("Location: indexSurvey.php");
        die();
    }
    else {
        header('Location: indexSurvey.php?error=13');
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Survey</title>
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
                            <h1 class="card-title">Active Surveys</h1>
                            <table class="table table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Content</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($surveys); $i++) {
                                        if ($surveys[$i][3] == 1) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $surveys[$i][1]; ?>
                                                </td>
                                                <td>
                                                    <?php echo $surveys[$i][2]; ?>
                                                </td>
                                                <td>
                                                    <!-- Button of ANSWER -->
                                                    <button type="submit" class="btn btn-info" data-toggle="modal"
                                                        data-target="#surveyAnswer<?php echo $surveys[$i][0]; ?>" <?php
                                                           $completed = $CSurveyCompleted->getSurveyCompletedBySurveyAndUser($surveys[$i][0], $_SESSION['id']);
                                                           if ($completed[0][0] != null) {
                                                               echo "disabled";
                                                           } ?>>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                                        </svg></button>
                                                    <!-- Button of ANSWER -->
                                                </td>
                                                <?php include("snippets/snippetSurveyAnswer.php"); ?>
                                            </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                            <h1 class="card-title">Completed Surveys</h1>
                            <table class="table table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Content</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($surveys); $i++) { ?>
                                        <?php
                                        $completed = $CSurveyCompleted->getSurveyCompletedBySurveyAndUser($surveys[$i][0], $_SESSION['id']);
                                        if ($completed[0][0] != null) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $surveys[$i][1]; ?>
                                                </td>
                                                <td>
                                                    <?php echo $surveys[$i][2]; ?>
                                                </td>
                                                <td>
                                                    <!-- BUTTON of VIEW -->
                                                    <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#surveyView<?php echo $surveys[$i][0]; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                            <path
                                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                            <path
                                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                        </svg>
                                                    </button>
                                                    <!-- BUTTON of VIEW -->
                                                </td>
                                                <!-- View Survey -->
                                                <?php include('snippets/snippetSurveyView.php'); ?>
                                                <!-- View Survey -->
                                            </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div> <!-- End of main card -->
                    </div> <!-- End of main content -->
                </div>
            </div>
        </div>
</body>

</html>