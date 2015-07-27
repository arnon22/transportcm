<div class="main-div-index">
    <form action="" id="export_form" class="form-horizontal export-step" method="post">
        <fieldset>
            <legend>Export Custom Query to CSV</legend>
            <?php
            FlashSession::showSuccess();
            FlashSession::showErrors();
            ?>
            <div class="control-group" id="field-list-div">
                <div class="control-group">
                    <label for="custom_query" class="control-label">Custom Sql Query <i
                            class="icon-th-list"></i></label>

                    <div class="controls">
                      <textarea name="custom_query" id="custom_query"></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label for="csv_separator" class="control-label">CSV Separator <i class="icon-filter"></i></label>

                    <div class="controls">
                        <input type="text" required="required" class="input-mini" value=";" name="csv_separator"
                               id="csv_separator">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Export Column names <i class="icon-question-sign"></i></label>

                    <div class="form-inline">
                        <div class="controls">
                            <label for="with_header_row_1">Yes</label>
                            <input type="radio" checked="checked" value="1" name="with_header_row"
                                   id="with_header_row_1">
                            &nbsp;&nbsp;&nbsp;
                            <label for="with_header_row_2">No</label>
                            <input type="radio" value="0" name="with_header_row" id="with_header_row_2">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label for="csv_file_name" class="control-label">Output File Name <i class="icon-file"></i></label>

                    <div class="controls">
                        <input type="text" required="required" class="input" value="custom_csv" name="csv_file_name"
                               id="csv_file_name">
                    </div>
                </div>
                <div class="control-group">

                    <input type="submit" class="btn" value="Export" name="submitExportCustomCSV" id="submitBtn">
                </div>
            </div>
</div>