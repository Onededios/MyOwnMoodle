<?php
// This includes the contents of a PHP file named "snippetPHPh.php".
include('snippets/snippetPHPh.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <link rel="stylesheet" href="styles/styleMain.css">
</head>

<body>
    <!-- Top Nav -->
    <?php
    // This includes the contents of a PHP file named "snippetNavbar.php" which contains the code for the top navigation bar.
    include('snippets/snippetNavbar.php');
    ?>
    <!-- End Top Nav-->

    <!-- Sidebar -->
    <?php
    // This includes the contents of a PHP file named "snippetMenu.php" which contains the code for the sidebar menu.
    include("snippets/snippetMenu.php");
    ?>
    <!-- End Siderbar -->

    <div class="maincontent col-11">
        <div class="row first-row">
            <div class="col-4">
                <div class="card maincard">
                    <div class="card-body">
                        <?php
                        // This includes the contents of a PHP file named "snippetErrors.php" which contains the code for displaying error messages.
                        include('snippets/snippetErrors.php');
                        ?>
                        <h1 class="card-title">Welcome to the classroom!
                        </h1>
                    </div> <!-- End of main content -->
                </div>
            </div>
        </div>
    </div>

</body>

</html>
