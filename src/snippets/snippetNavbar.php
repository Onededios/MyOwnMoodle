<?php
//if logout button is pressed, destroy session and redirect to login page
if (isset($_POST["logoutbttn"])) {
    session_destroy();
    header('Location: indexLogin.php');
    die();
}
//if account profile button is pressed, redirect to user's profile page
if (isset($_POST["accprofile"])) {
    header('Location: indexProfile.php');
    die();
}

?>
<nav class="navbar navbar-expand  fixed-top" aria-label="close">
    <div class="float-right navbar-collapse" id="navbarSupportedContent">
        <!-- search form -->
        <form class="search-form d-flex ms-auto" role="search">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search"
                    viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>
        </form>
        <!-- account profile form -->
        <form action="index.php" method="post">
            <div id="profilecontainer">
                <!-- display user's name and account type -->
                <button class="btn btn-light" name="accprofile">
                    <?php echo $userData[0][1]; ?>
                    <a id="profileAccount">|
                        <?php
                        echo $type[0][0]; ?>
                    </a>
                    <!-- logout button -->
                    <button type="submit" class="btn btn-sm btn-dark" id="logoutb" name="logoutbttn"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                            <path fill-rule="evenodd"
                                d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                        </svg>
                    </button>
            </div>
        </form>
        </button>
    </div>
</nav>