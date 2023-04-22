<!-- A modal for deleting a mark -->
<div class="modal fade" id="deleteMark<?php echo $allMark[$i][0]; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal header -->
            <div class="modal-header">
                <h3>You're about to delete the following mark:
                    <p>
                        <!-- Display the mark to be deleted -->
                        <i>
                            <?php echo "User <strong>" . $userStats[0][1] . "</strong> scored <strong>" . $allMark[$i][2] . "</strong> on <strong>" . $allMark[$i][1] . "</strong>"; ?>
                        </i>
                    </p>
                </h3>
            </div>
            <!-- Form to submit deletion of mark -->
            <form action="indexMarks.php" method="post">
                <!-- Modal body -->
                <div class="modal-body">
                    <!-- Prompt for admin password -->
                    <h4>Introduce the password of <strong>
                            <?php echo $userData[0][1]; ?>
                        </strong>
                        in the next field:
                    </h4>
                    <input type="password" name="adminpassword" class="form-control">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <!-- Cancel button -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- Submit button to delete mark -->
                    <button type="submit" class="btn btn-danger" name="deleteMarkbutton"
                        value="<?php echo $allMark[$i][0]; ?>">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
