<!-- This is the outer container of the modal window. It has a unique ID that is based on the ID of the issue being deleted. -->
<div class="modal fade" id="deleteIssue<?php echo $issues[$i][0]; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">

    <!-- This is the main container for the modal content. -->
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <!-- This is the header of the modal window that shows the title of the issue being deleted. -->
            <div class="modal-header">
                <h3>You're about to delete the following issue:
                    <strong>
                        <p>
                            <?php echo $issues[$i][3]; ?>
                        </p>
                    </strong>
                </h3>
            </div>

            <!-- This is the form that will be submitted when the delete button is clicked. It has a single input field for the admin password. -->
            <form action="indexIssues.php" method="post">
                <div class="modal-body">
                    <h4>Introduce the password of <strong>
                            <?php echo $userData[0][1]; ?>
                        </strong>
                        in the next field:
                    </h4>
                    <input type="password" name="adminpassword" class="form-control">
                </div>

                <!-- This is the footer of the modal window that has two buttons, one to cancel and the other to submit the form. -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="deleteIssuebutton"
                        value="<?php echo $issues[$i][0]; ?>">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
