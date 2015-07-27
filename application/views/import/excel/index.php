<?php $this->load->view('common/header');?>

<div class="container-fluid">
<div class="row-fluid">
<div class="span12">
<div class="main-div-index">
    <form action="" id="export_form" class="form-horizontal export-step" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Import from Excel</legend>
            <?php
            #FlashSession::showSuccess();
           # FlashSession::showErrors();
            ?>
            <div class="control-group">
                <label class="control-label" for="imported_table_xls">Select Table <i class="icon-th-large"></i></label>

                <div class="controls">
                    <select name="imported_table_xls" id="imported_table_xls" required="required">
                       
                        <option value="transport_pricelist" selected="selected">pricelist</option>
                        
                    </select>
                </div>
            </div>
            <div id="field-list-div" class="control-group">
            
            <div class="control-group">
    <label class="control-label" for="imported_fields">Select Columns <i class="icon-th-list"></i></label>

    <div class="controls">
        <select name="imported_fields[]" id="imported_fields" required="required" multiple="">
            <?php
                       foreach ($fieldsList as $field) {
                echo '<option value="' . $field . '" selected>' . $field . '</option>';
          }
            
            ?>
        </select>
    </div>
</div>
<div class="control-group">
    <label class="control-label">First Excel Row is Column Names <i class="icon-question-sign"></i></label>

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
    <label class="control-label" for="xls_file">Excel File <i class="icon-file"></i></label>

    <div class="controls">
        <input type="file" id="xls_file" name="xls_file" class="input" required="required"/>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Update Query ? <i class="icon-question-sign"></i></label>

    <div class="form-inline">
        <div class="controls">
            <label for="update_query_1">Yes</label>
            <input type="radio" id="update_query_1" name="update_query" value="1"/>
            &nbsp;&nbsp;&nbsp;
            <label for="update_query_2">No</label>
            <input type="radio" id="update_query_2" name="update_query" value="0" checked="checked"/>
        </div>
        <div class="alert alert-info update-query-notice">
            <button type="button" class="close" data-dismiss="alert">x</button>
            The first selected Column will be considered as Primary Key when run update Query.
        </div>
    </div>
</div>
<div class="control-group">

    <input type="submit" id="submitBtn" name="submitImportTable" value="Import" class="btn"/>
</div>

</div>
</form>
</div>
</div><!--/span12-->
</div><!--/row-fluid-->
</div><!--/container-->

<!-- footer-->
<?php $this->load->view('common/footer');?>