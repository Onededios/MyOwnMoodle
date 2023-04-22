<?php
// Including the PHP snippet file
include('snippets/snippetPHPh.php');

// Creating a new object of the UserType class
$CUserType = new UserType($connect);

// Including the function file
include_once("functions/functionFile.php");

// Creating a new object of the File class
$CFile = new File($connect);

// Getting user data based on session ID
$userData = $CUsuario->getUserData($_SESSION['id']);

// Getting the user type based on the user data retrieved
$type = $CUserType->getUserType($userData[0][7]);

// Getting all the files stored in the database
$allFilesByAll = $CFile->getAllFiles();

// Getting all the files uploaded by the current user
$allFiles = $CFile->getFilesByUser($_SESSION['id']);

// Checking if the file has been uploaded and the upload file button has been pressed
if (is_uploaded_file($_FILES['file']['tmp_name']) && isset($_POST['uploadfile'])) {
    // Generating a unique filename for the uploaded file using the current timestamp
    $fileName = time() . "_" . $_FILES['file']['name'];
    // Inserting the file details into the database
    $CFile->insertNewFile('userFiles/' . $fileName, $fileName, $_SESSION['id'], $_FILES['file']['type'], $_FILES['file']['size']);
    // Moving the uploaded file to the userFiles directory
    move_uploaded_file($_FILES['file']['tmp_name'], "userFiles/" . $fileName);
    // Redirecting the user to the indexFiles.php page
    header('Location: indexFiles.php');
    // Exiting the script
    die();
}

// Checking if the delete file button has been pressed
if (isset($_POST['deletefilebutton'])) {
    // Checking if the entered password matches the admin password
    if (md5($_POST['adminpassword']) === $userData[0][2]) {
        // Retrieving the file name based on the file ID
        $fileName = $CFile->getFileByID($_POST['deletefilebutton']);
        // Deleting the file from the database
        $CFile->deleteFile($_POST['deletefilebutton']);
        // Deleting the file from the userFiles directory
        unlink("userFiles/" . $fileName[0][1]);
        // Redirecting the user to the indexFiles.php page
        header('Location: indexFiles.php');
        // Exiting the script
        die();
    } else {
        // Redirecting the user to the indexFiles.php page with an error message
        header("Location: indexFiles.php?error=1");
        // Exiting the script
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload</title>
    <link rel="stylesheet" href="styles/styleMain.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
</head>

<body>
    <!-- Include the navigation bar snippet -->
    <?php include('snippets/snippetNavbar.php'); ?>

    <div class="row">
        <!-- Include the sidebar snippet -->
        <?php include('snippets/snippetMenu.php'); ?>

        <!-- Main content area -->
        <div class="maincontent col-11">
            <div class="row first-row">
                <div class="col-4">
                    <!-- Main card -->
                    <div class="card maincard">
                        <div class="card-body">
                            <h1 class="card-title">
                                File List
                            </h1>
                            <!-- Show whether all files or just user's files are being displayed -->
                            <h2>
                                <?php
                                if ($userData[0][7] == 1) {
                                    echo "All User Uploaded Files";
                                } else {
                                    echo "Your Uploaded Files";
                                }
                                ?>
                            </h2>

                            <!-- Table to display the list of files -->
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <!-- <th>File Type</th> -->
                                        <th>File Size</th>
                                        <?php if ($userData[0][7] == 1) { ?>
                                            <th>F ID</th>
                                            <th>File Path</th>
                                            <th></th>
                                            <th>U ID</th>
                                            <th>Username</th>
                                            <th></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($userData[0][7] == 1) {
                                        // If displaying all files, loop through the array of all files
                                        for ($i = 0; $i < count($allFilesByAll); $i++) {
                                            ?>
                                            <tr>
                                                <!-- File name -->
                                                <td>
                                                    <small>
                                                        <!-- Link to the file -->
                                                        <a href="<?php echo $allFilesByAll[$i][3]; ?>" target="_blank">
                                                            <?php
                                                            // Display the file name without the timestamp (first 11 characters)
                                                            echo substr($allFilesByAll[$i][1], 11, strlen($allFilesByAll[$i][1])) . str_replace("", "", "");
                                                            ?>
                                                        </a>
                                                    </small>
                                                </td>
                                                <!-- <td> -->
                                                <!-- <?php echo $allFilesByAll[$i][2]; ?> -->
                                                <!-- </td> File Type -->
                                                <!-- File Size -->
                                                <td>
                                                    <?php echo number_format((float) ($allFilesByAll[$i][4] * 0.000001), 2, '.', '') . " MB"; ?>
                                                </td>
                                                <!-- File ID -->
                                                <th>
                                                    <?php echo $allFilesByAll[$i][0]; ?>
                                                </th>
                                                <!-- File Path -->
                                                <td>
                                                    <small class="text-muted">
                                                        <?php
                                                        // Display the first 20 characters of the file path
                                                        echo substr($allFilesByAll[$i][3], 0, 20) . str_replace("", "", "...");
                                                        ?>
                                                    </small>
                                                </td>
                                                <!-- Copy file path button -->
                                                <td>
                                                    <!-- A button to copy the text of the file name to the clipboard -->
                                                    <button class="btn btn-sm bg-info"
                                                        data-clipboard-text=" <?php echo $allFilesByAll[$i][3]; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-clipboard-check"
                                                            viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                                <th>
                                                    <!-- The file name -->
                                                    <?php echo $allFilesByAll[$i][5]; ?>
                                                </th>
                                                <td>
                                                    <!-- The user ID associated with the file -->
                                                    <?php $username = $CUsuario->getUsername($allFilesByAll[$i][5]);
                                                    echo $username[0][0]; ?>
                                                </td>
                                                <td>
                                                    <!-- A button to delete the file -->
                                                    <button type="submit" class="btn btn-sm btn-danger" name="deleteFile"
                                                        data-toggle="modal"
                                                        data-target="#deleteFile<?php echo $allFilesByAll[$i][0]; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                            <path
                                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                        </svg></button>
                                                </td>
                                                <!-- Start of modal -->
                                                <?php include('snippets/snippetFileDelete.php'); ?> <!-- Includes snippet file that contains code to delete files -->
                                                <!-- End of modal -->

                                                <!-- For each file in the list -->
                                                <?php
                                                    if (count($allFiles) > 0) { // If there are files in the list
                                                        foreach ($allFiles as $file) { // For each file in the list
                                                ?>
                                                            <tr>
                                                                <th>
                                                                    <a href="<?php echo $file[3]; ?>" target="_blank"> <!-- Link to download file -->
                                                                        <?php echo substr($file[1], 11, strlen($file[1])) . str_replace("", "", ""); ?> <!-- File name without timestamp -->
                                                                    </a>
                                                                </th>
                                                                <!-- <td> -->
                                                                <!-- <?php echo $file[2]; ?> -->
                                                                <!-- </td> -->
                                                                <td>
                                                                    <?php echo number_format((float) ($file[4] * 0.000001), 2, '.', '') . " MB"; ?> <!-- File size in MB -->
                                                                </td>
                                                            </tr>
                                                <?php
                                                        }
                                                    } else { // If there are no files in the list
                                                ?>
                                                        <tr>
                                                            <td colspan="2">No files found.</td> <!-- Display message that no files were found -->
                                                        </tr>
                                                <?php
                                                    }
                                                ?>

                                                <!-- Form to upload files -->
                                                <h1 class="card-title">
                                                    Upload File
                                                </h1>
                                                <form action="indexFiles.php" method='post' enctype="multipart/form-data">
                                                    <div class="btn btn-secondary">
                                                        <input type="file" accept=".pdf" name="file"> <!-- File upload input -->
                                                        <button type="submit" class="btn btn-info" name="uploadfile">Upload</button> <!-- Upload button -->
                                                    </div>
                                                </form>

                                                <!-- JavaScript code to copy file link to clipboard -->
                                                <script type="text/javascript">
                                                    var Clipboard = new ClipboardJS('.btn');
                                                </script>

</body>
</html>