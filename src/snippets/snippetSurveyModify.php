<div class="modal fade" id="modifySurvey<?php echo $surveys[$i][0]; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>
                    Modifying the survey 
                    <p>
                        <strong>
                            <?php echo $surveys[$i][1]; ?>
                        </strong>
                    </p>
                </h3>
            </div>
            <form action="indexSurveysAll.php" method="post">
                <div class="modal-body">
                <h2>Survey Name</h2>
                <input type="text" class="form-control" name="surveyName" value="<?php echo $surveys[$i][1]; ?>">
                <h2>Description</h2>
                <textarea name="surveyDesc" rows="3" class="form-control"><?php echo $surveys[$i][2]; ?></textarea>
                <?php
                $qu = $CSurveyQuestion->getAllQuestionsBySurvey($surveys[$i][0]);
                for ($l=0; $l < count($qu); $l++) {
                    echo '<h3 class="mt-3">Question no. <strong>'.($l+1).'</strong></h3><input type="text" name="'.$l.'" class="form-control" value="'.$qu[$l][2].'" />';
                }
                ?>
                <p>
                    <h4>Introduce the password of
                        <?php echo "<strong>" . $userData[0][1] . "</strong>"; ?>
                        in the next field:
                    </h4>
                    <input type="password" name="adminpassword" class="form-control">
                </p>
                </div>
                <div class="modal-footer">
                    <h5>Survey Active</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="surveyActive" <?php if ($surveys[$i][3] == 1) {
                                                        echo "checked";
                                                    } ?>>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" name="modifySurvey"
                        value="<?php echo $surveys[$i][0]; ?>">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>