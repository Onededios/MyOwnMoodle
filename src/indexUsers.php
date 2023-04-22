<?php
include('snippets/snippetPHPh.php');
if (!isset($_SESSION["id"]) || $userData[0][7] != 1) {
    header("Location: index.php?error=1");
}

include_once('functions/functionMarks.php');
$CMark = new Mark($connect);

include("functions/functionFile.php");
$CFile = new File($connect);

include('functions/functionSurvey.php');
$CSurveyAnswer = new Answer($connect);
$CSurveyCompleted = new Completed($connect);

include("functions/functionIssue.php");
$CIssue = new Issue($connect);
$CIssuePrior = new IssuePrior($connect);

if (isset($_POST['deleteuserbutton'])) {
    if (md5($_POST['adminpassword']) === $userData[0][2]) {

        // * Issues
        $CIssue->deleteAllIssuesFromUser($_POST['deleteuserbutton']);

        // * Marks
        $CMark->deleteAllMarksFromUser($_POST['deleteuserbutton']);

        // * Surveys
        $CSurveyAnswer->deleteAllAnswersByUser($_POST['deleteuserbutton']);
        $CSurveyCompleted->deleteAllCompletedFromUser($_POST['deleteuserbutton']);

        // * Files
        $files = $CFile->getFilesByUser($_POST['deleteuserbutton']);
        for ($i=0; $i < count($files); $i++) {
            $CFile->deleteFile($files[$i][0]);
            unlink("userFiles/" . $files[$i][1]);
        }
        
        // * Users
        $CUsuario->deleteUser($_POST['deleteuserbutton']);

        header("Location: indexUsers.php");
        die();
    } else {
        header("Location: indexUsers.php?error=3");
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Users</title>
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
                            <h1 class="card-title">List of users</h1>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>USERNAME</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Mail</th>
                                            <th>Tel.</th>
                                            <th>User Type</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $userInfo = $CUsuario->getListOfUsers();
                                        for ($i = 0; $i < count($userInfo); $i++) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $userInfo[$i][0]; ?>
                                                </td> <!-- ID -->
                                                <td>
                                                    <?php echo $userInfo[$i][1]; ?>
                                                </td> <!-- USERNAME -->
                                                <td>
                                                    <?php echo $userInfo[$i][3]; ?>
                                                </td> <!-- First Name -->
                                                <td>
                                                    <?php echo $userInfo[$i][4]; ?>
                                                </td> <!-- Last Name -->
                                                <td>
                                                    <?php echo $userInfo[$i][5]; ?>
                                                </td> <!-- Mail -->
                                                <td>
                                                    <?php echo $userInfo[$i][6]; ?>
                                                </td> <!-- Tel -->
                                                <td>
                                                    <?php $type = $CUserType->getUserType($userInfo[$i][7]);
                                                    echo $type[0][0]; ?>
                                                </td> <!-- UserType -->
                                                <?php if ($type[0][0] !== 'admin') { ?>
                                                    <!-- Buttons -->
                                                    <td> <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                            data-target="#deleteUserModal<?php echo $userInfo[$i][0]; ?>"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                            </svg></button>
                                                    </td>

                                                    <!-- Start of modal -->
                                                    <div class="modal fade" id="deleteUserModal<?php echo $userInfo[$i][0]; ?>"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title">You're about to delete
                                                                    <?php echo "<strong>" . $userInfo[$i][3] . " " . $userInfo[$i][4] . "</strong>" . " as <strong>" . $userInfo[$i][1] . "</strong>"; ?>
                                                                </h3>
                                                                </div>
                                                                <div class="modal-header">
                                                                    <div class="container">
                                                                        <div class="row mb-3">
                                                                            <h5 class="modal-title text-danger">You're about to delete the following records:</h5>
                                                                        </div>
                                                                        <div class="row bg-dark text-white">
                                                                            <div class="col">Record</div>
                                                                            <div class="col text-center">Files</div>
                                                                            <div class="col text-center">Issues</div>
                                                                            <div class="col text-center">Marks</div>
                                                                            <div class="col text-center">Surv Answ</div>
                                                                        </div>
                                                                        <div class="row bg-secondary">
                                                                            <div class="col text-white">QTY</div>
                                                                            <div class="col text-warning text-center"><strong><?php echo count($CFile->getFilesByUser($userInfo[$i][0]));?></strong></div>
                                                                            <div class="col text-warning text-center"><strong><?php echo count($CIssue->getAllIssuesFromUser($userInfo[$i][0])); ?></strong></div>
                                                                            <div class="col text-warning text-center"><strong><?php echo count($CMark->getUserMarks($userInfo[$i][0])); ?></strong></div>
                                                                            <div class="col text-warning text-center"><strong><?php echo count($CSurveyCompleted->getAllSurveysCompletedByUser($userInfo[$i][0])); ?></strong></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <form action="indexUsers.php" method="post">
                                                                    <div class="modal-body">
                                                                        <h4>Introduce the password of
                                                                            <?php echo "<strong>" . $userData[0][1] . "</strong>"; ?>
                                                                            in the next field:
                                                                        </h4>
                                                                        <input type="password" name="adminpassword"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-danger"
                                                                            name="deleteuserbutton"
                                                                            value="<?php echo $userInfo[$i][0]; ?>">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End of modal -->
                                                <?php } else {
                                                    echo "<td></td>";
                                                } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- End of main card -->
                    </div> <!-- End of main content -->

                </div>
            </div>
        </div>
        <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myInput').trigger('focus')
            })
        </script>
</body>

</html>