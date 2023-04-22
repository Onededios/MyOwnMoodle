<?php
error_reporting(0);
session_start();
include_once("functions/functionConnection.php"); // Calls php file
$connection = new DBConnection(); // Calls the main class of the php file
$connect = $connection->connect(); // Starts the connection between

include_once("functions/functionUsers.php");
$CUsuario = new User($connect);

// If bttn is pressed
if (isset($_POST["send"])) {
    // Get the username inp and save it into a var rel with the DB
    $datosUsuario = $CUsuario->comprobarUsuario($_POST['username']);
    // If the username inp eq with the username in DB
    if ($datosUsuario[0][1] == $_POST['username']) {

        // If the pass inp eq with the pass in DB
        if ($datosUsuario[0][2] == md5($_POST['password'])) {
            $_SESSION['id'] = $datosUsuario[0][0];
            header('Location: index.php');
            die();
        } else {
            header('Location: indexLogin.php?error=3');
            die();
        }
    } else {
        header('Location: indexLogin.php?error=4');
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
    <title>Login</title>
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
                    <h1 class="card-title text-center float-left">Sign In</h1>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <?php include('snippets/snippetErrors.php'); ?>
                        <form action="indexLogin.php" method="post">
                            <!-- Username Input -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="firstnameinp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                        </svg>
                                    </label>
                                </div>
                                <input type="text" name="username" id="userinp" class="form-control"
                                    placeholder="perico" />
                            </div>


                            <!-- Password Input -->
                            <div class="input-group mt-3 mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="passwdinp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                            <path
                                                d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                        </svg>
                                    </label>
                                </div>

                                <input type="password" name="password" id="passwdinp" class="form-control"
                                    placeholder="****" />
                            </div>

                            <!-- Forgot passwd -->
                            <div class="mb-3">
                                <a href="#!">Forgot your password?</a>
                            </div>

                            <!-- Login button -->
                            <input type="submit" name="send" class="btn btn-primary btn-block mb-3" value="Enviar" />

                            <!-- Not a member -->
                        </form>
                        <div class="text-center">
                            <p>Don't have an account yet? <a href="indexRegister.php">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>