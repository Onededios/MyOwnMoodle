<!-- Modal to display the details of a specific issue -->

<!-- Modal with ID 'viewIssue' concatenated with the issue ID-->
<div class="modal fade" id="viewIssue<?php echo $issues[$i][0]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <!-- Modal dialog box with large size -->
    <div class="modal-dialog modal-lg" role="document">

        <!-- Modal content -->
        <div class="modal-content">

            <!-- Modal header with a dark background and white text -->
            <div class="modal-header bg-secondary text-white">

                <!-- Heading of the modal with the title 'Issue' -->
                <h2>
                    Issue
                    <br>

                    <!-- Issue name retrieved from the PHP array and displayed in bold font -->
                    <strong>
                        <?php echo $issues[$i][2]; ?>
                    </strong>
                </h2>
            </div>

            <!-- Modal body that displays the issue details retrieved from the PHP array -->
            <div class="modal-body">
                <?php echo $issues[$i][3]; ?>
            </div>

            <!-- Modal footer with a dark background -->
            <div class="modal-footer bg-secondary">

                <!-- Close button to dismiss the modal -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
