<!-- This is a modal that will allow the user to delete a file from a list of files.
     The modal will show the name of the file that is about to be deleted and ask for the password of the user.
     The password will be verified in the back-end.
     The file to be deleted will be sent to the back-end when the delete button is clicked. -->
<div class="modal fade" id="deleteFile<?php echo $allFilesByAll[$i][0]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- This is the header of the modal that shows the name of the file that is about to be deleted. -->
            <div class="modal-header">
                <h3>You're about to delete the file <strong><?php echo $allFilesByAll[$i][1]; ?></strong></h3>
            </div>
            <!-- This is the form that will ask for the user's password. -->
            <form action="indexFiles.php" method="post">
                <div class="modal-body">
                    <!-- This is the message that will ask for the user's password. -->
                    <h4>Introduce the password of <strong><?php echo $userData[0][1]; ?></strong> in the next field:</h4>
                    <input type="password" name="adminpassword" class="form-control">
                </div>
                <div class="modal-footer">
                    <!-- This button will close the modal without deleting the file. -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- This button will submit the form and delete the file. -->
                    <button type="submit" class="btn btn-danger" name="deletefilebutton" value="<?php echo $allFilesByAll[$i][0]; ?>">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>