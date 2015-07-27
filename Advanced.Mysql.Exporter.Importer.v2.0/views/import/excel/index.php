<div class="main-div-index">
    <form action="" id="export_form" class="form-horizontal export-step" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Import from Excel</legend>
            <?php
            FlashSession::showSuccess();
            FlashSession::showErrors();
            ?>
            <div class="control-group">
                <label class="control-label" for="imported_table_xls">Select Table <i class="icon-th-large"></i></label>

                <div class="controls">
                    <select name="imported_table_xls" id="imported_table_xls" required="required">
                        <option value="">&nbsp;</option>
                        <?php
                        foreach ($this->tableList as $table) :
                            echo '<option value="' . $table . '">' . $table . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div id="field-list-div" class="control-group">

            </div>
</div>