<div class="modal fade" id="deleteAnswers<?php echo $answer[$k][0]; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>
                    Deleting <a class="text-danger">all</a> answers by
                    <strong>
                        <?php $username = $CUsuario->getUsername($answer[$k][4]);
                        echo $username[0][0]; ?>
                    </strong>
                    on
                    <hr>
                    <strong>
                        <?php echo $surveys[$i][1]; ?>
                    </strong>
                </h3>
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
                    <button type="submit" class="btn btn-danger" name="deleteSurveyAnswer"
                        value="<?php echo $answer[$k][1]; ?>">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>