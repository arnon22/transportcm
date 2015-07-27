<div class="control-group">
    <label class="control-label" for="exported_fields">Select Columns <i class="icon-th-list"></i></label>

    <div class="controls">
        <select name="exported_fields[]" id="exported_fields" required="required" multiple="">
            <?php
            foreach ($this->fieldsList as $field) :
                echo '<option value="' . $field . '" selected>' . $field . '</option>';
            endforeach;
            ?>
        </select>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="csv_separator">CSV Separator <i class="icon-filter"></i></label>

    <div class="controls">
        <input type="text" id="csv_separator" name="csv_separator" value=";" class="input-mini" required="required" />
    </div>
</div>
<div class="control-group">
    <label class="control-label">Export Column names <i class="icon-question-sign"></i></label>

    <div class="form-inline">
        <div class="controls">
            <label for="with_header_row_1">Yes</label>
            <input type="radio" id="with_header_row_1" name="with_header_row" value="1" checked="checked"/>
            &nbsp;&nbsp;&nbsp;
            <label for="with_header_row_2">No</label>
            <input type="radio" id="with_header_row_2" name="with_header_row" value="0"/>
        </div>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="csv_file_name">Output File Name <i class="icon-file"></i></label>

    <div class="controls">
        <input type="text" id="csv_file_name" name="csv_file_name" value="<?php echo $this->tableName;?>_csv"
               class="input" required="required" />
    </div>
</div>
<div class="control-group">

    <input type="submit" id="submitBtn" name="submitExportCSV" value="Export" class="btn"/>
</div>
