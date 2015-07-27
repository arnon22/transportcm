<div class="main-div-index">
    <form action="" id="export_form" class="form-horizontal export-step" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Import from CSV</legend>
            <?php
            FlashSession::showSuccess();
            FlashSession::showErrors();
            ?>
            <div class="control-group">
                <label class="control-label" for="imported_table">Select Table <i class="icon-th-large"></i></label>

                <div class="controls">
                    <select name="imported_table" id="imported_table" required="required">
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