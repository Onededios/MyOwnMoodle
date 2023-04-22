<div class="modal fade" id="surveyCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1>
                    <strong>
                        New Survey
                    </strong>
                    <button class="btn btn-danger" disabled>Please complete all fields</button>
                </h1>
            </div>
            <form action="indexSurveysAll.php" method="post">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <h2>Survey Name</h2>
                            <input type="text" class="form-control" name="surveyName" placeholder="Name">
                        </div>
                        <div class="col">
                            <h2>Question QTY</h2>
                            <input type="number" id="questionQTY" name="questionQTY" onchange="addQuestions(this)"
                                class="form-control" placeholder="5">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h2>Description</h2>
                            <textarea name="surveyDesc" rows="3" class="form-control"
                                placeholder="Description goes here... Langrán"></textarea>
                        </div>

                    </div>
                    <div id="innerQuestions"></div>
                </div>
                <div class="modal-footer">
                    <h5>Survey Active</h5>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="surveyActive" checked>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" name="sendSurveyCreate">Finish</button>
                </div>
                <script type="text/javascript">
                    function addQuestions(questionQTY) {
                        document.getElementById("innerQuestions").innerHTML = "";
                        for (let index = 0; index < questionQTY.value; index++) {
                            document.getElementById('innerQuestions').innerHTML += '<h3 class="mt-3">Question no. <strong>' + (index + 1) + '</strong></h3><input type="text" id="myInput1" class="form-control" onchange="myChangeFunction(this)" name="' + index + '" placeholder="Me cago na cona que te botou, rapaz." />';
                        }
                    }
                </script>
            </form>
        </div>
    </div>
</div>