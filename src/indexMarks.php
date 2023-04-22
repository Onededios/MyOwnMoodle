<?php
include('snippets/snippetPHPh.php');
include_once('functions/functionMarks.php');
$CMark = new Mark($connect);

if (isset($_POST['sendmark'])) {
    if ($_POST['subjectname'] && $_POST['userid'] && $_POST['mark']) {
        $CMark->insertNewMark($_POST['subjectname'], $_POST['mark'], $_POST['userid']);
        header('Location: indexMarks.php');
        die();
    } else {
        header('Location: indexMarks.php?error=13');
        die();
    }
}

if (isset($_POST['deleteMarkbutton'])) {
    if (md5($_POST['adminpassword']) === $userData[0][2]) {
        $CMark->deleteMark($_POST['deleteMarkbutton']);
        header('Location: indexMarks.php');
        die();
    } else {
        header("Location: indexMarks.php?error=3");
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Marks</title>
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
                            <?php include('snippets/snippetErrors.php'); ?>
                            <h1 class="card-title">
                                <?php

                                if ($userData[0][7] != 1) {
                                    echo "Student <strong>" . $userData[0][1] . "</strong> Marks";
                                } else {
                                    echo "All students marks";
                                }
                                ?>
                            </h1>
                            <h3>Marks table</h3>
                            <div class="table-responsive">

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <?php if ($userData[0][7] == 1) { ?>
                                                <th>Subject ID</th>
                                                <th>Subject</th>
                                                <th>Mark</th>
                                                <th>UserID</th>
                                                <th>Username</th>
                                                <th>User First Name</th>
                                                <th>User Last Name</th>
                                                <th></th>
                                            <?php } else { ?>
                                                <th>Subject</th>
                                                <th>Mark</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $mark = $CMark->getUserMarks($_SESSION['id']);
                                        $allMark = $CMark->getAllUserMarks();
                                        if ($userData[0][7] != 1) { ?>
                                            <?php for ($i = 0; $i < count($mark); $i++) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $mark[$i][0]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $mark[$i][1]; ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else {
                                            for ($i = 0; $i < count($allMark); $i++) {
                                                $userStats = $CUsuario->getUserData($allMark[$i][3]);
                                                ?>
                                                <tr>
                                                    <!-- Subject ID -->
                                                    <th scope="row">
                                                        <?php echo $allMark[$i][0]; ?>
                                                    </th>
                                                    <!-- Subject -->
                                                    <td>
                                                        <?php echo $allMark[$i][1]; ?>
                                                    </td>
                                                    <!-- Mark -->
                                                    <td>
                                                        <?php echo $allMark[$i][2]; ?>
                                                    </td>
                                                    <!-- User ID -->
                                                    <td>
                                                        <?php echo $allMark[$i][3]; ?>
                                                    </td>
                                                    <!-- Username -->
                                                    <td>
                                                        <?php echo $userStats[0][1]; ?>
                                                    </td>
                                                    <!-- First name -->
                                                    <td>
                                                        <?php echo $userStats[0][3]; ?>
                                                    </td>
                                                    <!-- Last name -->
                                                    <td>
                                                        <?php echo $userStats[0][4]; ?>
                                                    </td>
                                                    <!-- Button -->
                                                    <td>
                                                        <!-- Button of VIEW -->
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            name="deleteMarkbttn" data-toggle="modal"
                                                            data-target="#deleteMark<?php echo $allMark[$i][0]; ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                            </svg></button>
                                                        <!-- Button of VIEW -->
                                                        <!-- Start of modal of PASSWORD -->
                                                        <?php include('snippets/snippetMarkDelete.php'); ?>
                                                        <!-- End of modal of PASSWORD -->
                                                    </td>
                                                </tr>

                                            <?php }
                                        } ?>
                                        <?php ?>

                                    </tbody>
                                </table>
                                <?php if ($userData[0][7] == 1) { ?>
                                    <h3>Add Marks</h3>
                                    <form action="indexMarks.php" method="post" onsubmit="window.location.reload()">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Subject Name</th>
                                                    <th>User ID</th>
                                                    <th>Mark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input class="form-control" type="text" name="subjectname"
                                                            placeholder="mathematics"></td>
                                                    <td><input class="form-control" type="number" name="userid"
                                                            placeholder="1717"></td>
                                                    <td><input class="form-control" type="number" name="mark"
                                                            placeholder="5"></td>
                                                    <td><input type="submit" value="Add mark" name="sendmark"
                                                            class="btn btn-info"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                <?php } ?>
                            </div>
                        </div> <!-- End of main card -->
                    </div> <!-- End of main content -->

                </div>
            </div>
        </div>
</body>

</html>