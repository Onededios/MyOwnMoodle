<div class="modal fade" id="surveyAnswer<?php echo $surveys[$i][0]; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1>
                    <strong>
                        Answer
                    </strong>
                </h1>
            </div>
            <div class="modal-header">
                <h5>
                    <p>
                        <strong>
                            <?php echo $surveys[$i][1]; ?>
                        </strong>
                    </p>
                    <a class="text-muted">
                        <h6>
                            <?php echo $surveys[$i][2]; ?>
                        </h6>
                    </a>
                </h5>
            </div>
            <form action="indexSurvey.php" method="post">
                <div class="modal-body">
                    <?php $questions = $CSurveyQuestion->getAllQuestionsBySurvey($surveys[$i][0]);
                    for ($l = 0; $l < count($questions); $l++) { ?>
                        <p>
                            <strong>
                                <?php echo $questions[$l][2]; ?>
                            </strong>
                            <input type="text" name="<?php echo $questions[$l][0]; ?>" class="form-control">
                        </p>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" name="sendSurveyAnswer"
                        value="<?php echo $surveys[$i][0]; ?>">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>