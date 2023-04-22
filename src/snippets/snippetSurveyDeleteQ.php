<div class="modal fade" id="deleteQuestion<?php echo $allQuestions[$j][0]; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>
                    Deleting the question
                    <br>
                    <strong>
                        <?php echo $allQuestions[$j][2]; ?>
                    </strong>
                    <br>
                    from the survey
                    <br>
                    <strong>
                        <?php echo $surveys[$i][1]; ?>
                    </strong>
                </h4>
            </div>
            <form action="indexSurveysAll.php" method="post">
                <div class="modal-body">
                    <h4>Introduce the password of
                        <?php echo "<strong>" . $userData[0][1] . "</strong>"; ?>
                        in the next field:
                    </h4>
                    <input type="password" name="adminpassword" class="form-control">
                    <input type="hidden" name="userID" value="<?php echo $answer[$k][4]; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="deleteSurveyQuestion"
                        value="<?php echo $allQuestions[$j][0]; ?>">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>