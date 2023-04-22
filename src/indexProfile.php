<?php
include('snippets/snippetPHPh.php');
if ($_POST['updateInfo'] && $_POST['fname'] !== "") {
    if ($_POST['fname'] !== $userData[0][3]) {
        $CUsuario->setFName($_SESSION['id'], $_POST['fname']);
    }
    header('Location: profile.php?error=5');
}

if ($_POST['updateInfo'] && $_POST['lname'] !== "") {
    if ($_POST['lname'] !== $userData[0][4]) {
        $CUsuario->setLName($_SESSION['id'], $_POST['lname']);
    }
    header('Location: profile.php?error=6');
}

if ($_POST['updateInfo'] && $_POST['tel'] !== "") {
    if ($_POST['tel'] !== $userData[0][6]) {
        $CUsuario->setTel($_SESSION['id'], $_POST['tel']);
    }
    header('Location: profile.php?error=7');
}

if ($_POST['updateInfo'] && $_POST['mail'] !== "") {
    if ($_POST['mail'] !== $userData[0][5]) {
        if (!$CUsuario->mailExists($_POST['mail'])) {
            $CUsuario->setMail($_SESSION['id'], $_POST['mail']);
        } else {
            header('Location: profile.php?error=9');
        }
    } else {
        header('Location: profile.php?error=8');
    }
}

if ($_POST['actualpassword'] !== "" && $_POST['changePass']) {
    if (md5($_POST['actualpassword']) === $userData[0][2]) {
        if ($_POST['newpassword'] !== "" && $_POST['new2password'] !== "") {
            if (md5($_POST['newpassword']) !== $userData[0][2]) {
                if ($_POST['newpassword'] === $_POST['new2password']) {
                    $CUsuario->setPassword($_SESSION['id'], md5($_POST['new2password']));
                } else {
                    header('Location: profile.php?error=12');
                }
            } else {
                header('Location: profile.php?error=11');
            }

        } else {
            header('Location: profile.php?error=10');
        }
    } else {
        header('Location: profile.php?error=3');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styleMain.css">
    <link rel="stylesheet" href="error.css">
    <script type="text/javascript" language="javascript">
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
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
                                Profile Settings for <strong>
                                    <?php echo $userData[0][1]; ?>
                                </strong>
                            </h1>
                            <h2>Personal information</h2>
                            <form action="profile.php" method="post">
                                <table class="table">
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Lastname</th>
                                        <th>Tel. Num.</th>
                                        <th>Mail</th>
                                    <tr>
                                        <th>Saved</th>
                                        <td>
                                            <a class="persinf">
                                                <?php echo $userData[0][3]; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="persinf">
                                                <?php echo $userData[0][4]; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="persinf">
                                                <?php echo $userData[0][6]; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="persinf">
                                                <?php echo $userData[0][5]; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Change</th>
                                        <td><input type="text" name="fname" class="form-control"
                                                placeholder="<?php echo $userData[0][3]; ?>" /></td>
                                        <td><input type="text" name="lname" class="form-control"
                                                placeholder="<?php echo $userData[0][4]; ?>" /></td>
                                        <td><input type="text" name="tel" class="form-control"
                                                placeholder="<?php echo $userData[0][6]; ?>" /></td>
                                        <td><input type="text" name="mail" class="form-control"
                                                placeholder="<?php echo $userData[0][5]; ?>" /></td>
                                    </tr>
                                    </tr>
                                </table>
                                <input type="submit" name="updateInfo" class="btn btn-info sendvalues" value="Update" />
                            </form>


                            <h2>Change your password</h2>
                            <form action="profile.php" method="post">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Your actual password</th>
                                            <?php if ($userData[0][2] == md5($_POST['actualpassword'])) { ?>
                                                <th>Your new password</th>
                                                <th>Repeat new password</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="password" name="actualpassword" class="form-control"
                                                    placeholder="****" /></td>
                                            <td><input type="password" name="newpassword" id="newpasswdinp"
                                                    class="form-control" placeholder="****" /></td>
                                            <td><input type="password" name="new2password" id="new2passwdinp"
                                                    class="form-control" placeholder="****" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input value="Change" type="submit" name="changePass"
                                    class="btn btn-info mt-3 sendvalues" />
                            </form>

                        </div> <!-- End of main card -->
                    </div> <!-- End of main content -->

                </div>
            </div>
        </div>

</body>

</html>