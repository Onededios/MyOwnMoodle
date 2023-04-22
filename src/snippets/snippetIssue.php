<!-- Start of Button -->
<!-- This comment indicates the beginning of the button code block -->
<button class="btn btn-light mt-auto" name="reportIssue" data-toggle="modal" data-target="#reportIssue">
    Report an issue
    <svg xmlns=" http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bug-fill"
        viewBox="0 0 16 16">
        <!-- This SVG is a bug icon -->
    </svg>
</button>
<!-- This is the end of the button code block -->
<!-- Start of modal -->
<!-- This comment indicates the beginning of the modal code block -->
<div class="modal fade" id="reportIssue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <!-- This div creates the modal window that opens when the button is clicked -->
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- This div contains the contents of the modal -->
            <div class="modal-header">
                <h3>Reporting an issue...</h3>
            </div>
            <!-- This is the form for submitting an issue -->
            <form action="indexIssues.php" method="post">
                <div class="modal-body">
                    <!-- These are the input fields for the issue title, content, and priority -->
                    <h4>Issue title: <input type="text" name="issueTitle" class="form-control" /></h4>
                    <h4>
                        Issue content:
                        <textarea name="issueContent" class="md-textarea form-control" rows="3"></textarea>
                    </h4>
                    <h4>
                        Issue priority:
                        <select class="btn btn-sm" name="issuePrior">
                            <!-- These options are for the issue priority -->
                            <option value="1" class="bg-secondary" selected>normal</option>
                            <option value="2" class="bg-warning">important</option>
                            <option value="3" class="bg-danger">urgent</option>
                        </select>
                    </h4>
                </div>
                <div class="modal-footer">
                    <!-- These buttons close the modal or submit the form -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" name="issueSend" value="report">Send Issue</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- This is the end of the modal code block -->