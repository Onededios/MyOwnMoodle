<?php
include('snippets/snippetPHPh.php');
include("functions/functionIssue.php");
$CIssue = new Issue($connect);
$CIssuePrior = new IssuePrior($connect);

$issues = $CIssue->getAllIssues();

if (isset($_POST['issueSend'])) {
    if ($_POST['issueTitle'] !== "" && $_POST['issueContent'] !== "") {
        $CIssue->insertNewIssue($_POST['issuePrior'], $_POST['issueTitle'], $_POST['issueContent'], $_SESSION['id']);
        header('Location: indexIssues.php');
        die();
    } else {
        header('Location: indexIssues.php?error=13');
        die();
    }
}

if (isset($_POST['deleteIssuebutton'])) {
    if (md5($_POST['adminpassword']) === $userData[0][2]) {
        $CIssue->deleteIssue($_POST['deleteIssuebutton']);
        header('Location: indexIssues.php');
        die();
    } else {
        header("Location: indexIssues.php?error=3");
        die();
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
                            <h1 class="card-title">
                                Issue List
                            </h1>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Issue</th>
                                        <th>By User</th>
                                        <th>Priority</th>
                                        <th>Content</th>
                                        <?php if ($userData[0][7] == 1) { ?>
                                            <th>ID</th>
                                            <th></th>
                                        <?php } ?>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($issues); $i++) { ?>
                                        <!-- Start of modal of VIEW -->
                                        <?php include('snippets/snippetIssueView.php'); ?>
                                        <!-- End of modal of VIEW -->
                                        <tr class="table-<?php if ($issues[$i][1] == 2) {
                                            echo "warning";
                                        } elseif ($issues[$i][1] == 3) {
                                            echo "danger";
                                        } else {
                                            echo "secondary";
                                        } ?>">
                                            <td>
                                                <?php echo $issues[$i][2]; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $username = $CUsuario->getUsername($issues[$i][4]);
                                                echo $username[0][0];
                                                ?>
                                            </td>
                                            <th>
                                                <?php
                                                $prior = $CIssuePrior->getIssuePrior($issues[$i][1]);
                                                echo $prior[0][0];
                                                ?>
                                            </th>
                                            <td>
                                                <?php
                                                $strBreak = 30;
                                                if (strlen($issues[$i][3]) > $strBreak) {
                                                    echo substr($issues[$i][3], 0, $strBreak) . str_replace("", "", "...");
                                                } else {
                                                    echo $issues[$i][3];
                                                }
                                                ?>
                                            </td>
                                            <?php if ($userData[0][7] == 1) { ?>
                                                <th>
                                                    <?php echo $issues[$i][0]; ?>
                                                </th>
                                                <td>
                                                    <button type="submit" class="btn btn-sm btn-danger" name="deleteIssue"
                                                        data-toggle="modal"
                                                        data-target="#deleteIssue<?php echo $issues[$i][0]; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                            <path
                                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                        </svg></button>
                                                </td>
                                                <!-- Start of modal of Delete Issue -->
                                                <?php include('snippets/snippetIssueDelete.php'); ?>
                                                <!-- End of modal of Delete Issue -->
                                            <?php } ?>
                                            <td>
                                                <!-- Button of VIEW -->
                                                <button type="submit" class="btn btn-sm btn-info" name="viewIssue"
                                                    data-toggle="modal"
                                                    data-target="#viewIssue<?php echo $issues[$i][0]; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-arrows-angle-expand"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707z" />
                                                    </svg></button>
                                                <!-- Button of VIEW -->
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