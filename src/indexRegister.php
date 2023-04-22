<?php
session_start();

include_once("functions/functionConnection.php"); // Calls php file
$connection = new DBConnection(); // Calls the main class of the php file
$connect = $connection->connect(); // Starts the connection between

include_once("functions/functionUsers.php");
$CUsuario = new User($connect);

if (isset($_POST['submitbutton'])) {
    if ($_POST['user'] !== "" && $_POST['repassd'] !== "" && $_POST['firstname'] !== "" && $_POST['lastname'] !== "" && $_POST['mail'] !== "" && $_POST['tel'] !== "") {
        $userCorrecto = false;
        $mailCorrecto = false;
        $passwdCorrecto = false;
        if (!$CUsuario->usernameExists($_POST['user'])) {
            $userCorrecto = true;
        } else {
            header('Location: indexRegister.php?error=9');
            die();
        }

        if (!$CUsuario->mailExists($_POST['mail'])) {
            $mailCorrecto = true;
        } else {
            header('Location: indexRegister.php?error=14');
            die();
        }

        if ($_POST['passwd'] !== "" && $_POST['repasswd'] !== "") {
            if ($_POST['passwd'] === $_POST['repasswd']) {
                $passwdCorrecto = true;
            } else {
                header('Location: indexRegister.php?error=12');
                die();
            }
        } else {
            header('Location: indexRegister.php?error=10');
            die();
        }

        if ($userCorrecto && $mailCorrecto && $passwdCorrecto) {
            $CUsuario->insertNewUser($_POST['user'], md5($_POST['repasswd']), $_POST['firstname'], $_POST['lastname'], $_POST['mail'], $_POST['tel']);
            $datosUsuario = $CUsuario->comprobarUsuario($_POST['user']);
            $_SESSION['id'] = $datosUsuario[0][0];
            header('Location: index.php');
            die();
        }
    } else {
        header('Location: indexRegister.php?error=13');
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleForm.css">
    <link rel="stylesheet" href="styles/styleError.css">
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&display=swap" rel="stylesheet">
    <script type="text/javascript" language="javascript">
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <div class="pt-5">
        <div class="global-container">
            <div class="card login-form border-dark">
                <div class="card-header bg-dark text-white">
                    <a href="index.php" class="navbar-brand text-white float-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="60" fill="white"
                            class="logo bi bi-alipay" viewBox="0 0 16 16">
                            <path
                                d="M2.541 0H13.5a2.551 2.551 0 0 1 2.54 2.563v8.297c-.006 0-.531-.046-2.978-.813-.412-.14-.916-.327-1.479-.536-.303-.113-.624-.232-.957-.353a12.98 12.98 0 0 0 1.325-3.373H8.822V4.649h3.831v-.634h-3.83V2.121H7.26c-.274 0-.274.273-.274.273v1.621H3.11v.634h3.875v1.136h-3.2v.634H9.99c-.227.789-.532 1.53-.894 2.202-2.013-.67-4.161-1.212-5.51-.878-.864.214-1.42.597-1.746.998-1.499 1.84-.424 4.633 2.741 4.633 1.872 0 3.675-1.053 5.072-2.787 2.08 1.008 6.37 2.738 6.387 2.745v.105A2.551 2.551 0 0 1 13.5 16H2.541A2.552 2.552 0 0 1 0 13.437V2.563A2.552 2.552 0 0 1 2.541 0Z" />
                            <path
                                d="M2.309 9.27c-1.22 1.073-.49 3.034 1.978 3.034 1.434 0 2.868-.925 3.994-2.406-1.602-.789-2.959-1.353-4.425-1.207-.397.04-1.14.217-1.547.58Z" />
                        </svg>
                        Classroom
                    </a>
                    <div class="vl"></div>
                    <h1 class="card-title text-center float-left">Sign Up</h1>
                </div>
                <div class="card-body">
                    <?php include("snippets/snippetErrors.php"); ?>
                    <div class="card-text">
                        <form action="indexRegister.php" method="post">
                            <!-- Name and lastname -->
                            <div class="row align-items-start">
                                <!-- First Name Input-->
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="firstnameinp">Name</label>
                                    </div>
                                    <input type="text" name="firstname" id="firstnameinp" class="form-control"
                                        placeholder="Juan Miguel" />
                                </div>

                                <!-- Last Name Input -->
                                <div class="input-group col mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="lastnameinp">Last Name</label>
                                    </div>
                                    <input type="text" name="lastname" id="lastnameinp" class="form-control"
                                        placeholder="Segura" />
                                </div>
                            </div>

                            <div class="row align-items-start">
                                <!-- Tel Input -->
                                <div class="input-group col mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="telinp">Telephone</label>
                                    </div>
                                    <input type="tel" name="tel" id="telinp" class="form-control"
                                        placeholder="65979965" />
                                </div>
                                <!-- Username Input -->
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="userinp">Username</label>
                                    </div>
                                    <input type="text" name="user" id="userinp" class="form-control"
                                        placeholder="jmega" />
                                </div>
                            </div>

                            <!-- Mail Input -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="mailinp">Mail</label>
                                </div>
                                <input type="text" name="mail" id="mailinp" class="form-control"
                                    placeholder="jmega@miramihuevo.com" />
                            </div>

                            <!-- Password Input -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="passwdinp">Password</label>
                                </div>
                                <input type="password" name="passwd" id="passwdinp" class="form-control"
                                    placeholder="****" />
                            </div>

                            <!-- Re-Password Input -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="repasswdinp">Repeat the password</label>
                                </div>
                                <input type="password" name="repasswd" id="repasswdinp" class="form-control"
                                    placeholder="****" />
                            </div>

                            <!-- Signup button -->
                            <input type="submit" class="btn btn-primary btn-block mb-4" id="submitbutton"
                                name="submitbutton" value="Submit"></input>
                        </form>
                        <div class="text-center">
                            <p>Already have an account? <a href="indexLogin.php">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>