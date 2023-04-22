<!--
This is a HTML and PHP code that creates an error message block using the CSS file "error.css".
The error message is displayed if the PHP variable $_GET['error'] is set.
If $_GET['error'] is set, a switch statement is used to determine which error message to display.
The error message is displayed in a div element with the class "error" and the id "pageError".
If $_GET['error'] is not set, the div element is hidden using JavaScript.
-->
<link rel="stylesheet" href="error.css">
<div class="error mb-3" id="pageError">
    <?php
    if (isset($_GET['error'])) {
        echo '<script type="text/javascript"> document.getElementById("pageError").style.display = "block"; </script>';
        echo "⚠️ ERROR: ";
        switch ($_GET['error']) {
            case 1:
                echo "You have no rights of access to that page.";
                break;
            case 2:
                echo "Not logged. Login, please.";
                break;
            case 3:
                echo "The password is not correct.";
                break;
            case 4:
                echo "There's no user with that login.";
                break;
            case 5:
                echo "The introduced FIRST NAME must be different.";
                break;
            case 6:
                echo "The introduced LAST NAME must be different.";
                break;
            case 7:
                echo "The introduced TELEPHONE must be different.";
                break;
            case 8:
                echo "The introduced MAIL must be different.";
                break;
            case 9:
                echo "User with that USERNAME already exist.";
                break;
            case 10:
                echo "You must fill the two passwords fields.";
                break;
            case 11:
                echo "Password must be different than the previous one.";
                break;
            case 12:
                echo "Passwords don't match.";
                break;
            case 13:
                echo "You must complete all fields.";
                break;
            case 14:
                echo "User with that MAIL already exist.";
                break;
            default:
                echo "There is no good Monroe. There is no evil, there is only flesh. And the patterns to which we submit it";
        }
    } else {
        echo '<script type="text/javascript"> document.getElementById("pageError").style.display = "none"; </script>';
    }
    ?>
</div>