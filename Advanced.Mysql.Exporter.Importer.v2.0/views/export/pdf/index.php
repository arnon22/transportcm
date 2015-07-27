<div class="main-div-index">
    <form action="" id="export_form" class="form-horizontal export-step" method="post">
        <fieldset>
            <legend>Export to PDF</legend>
            <?php
            FlashSession::showSuccess();
            FlashSession::showErrors();
            ?>
            <div class="control-group">
                <label class="control-label" for="exported_table_pdf">Select Table <i class="icon-th-large"></i></label>

                <div class="controls">
                    <select name="exported_table_pdf" id="exported_table_pdf" required="required">
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