<div class="main-div-index">
    <div id="logo-span">
        <img src="<?php Tools::img("logo.png"); ?>" alt="MySql - CSV Manager" title="MySql - CSV Manager"/>
    </div>
    <hr class="index"/>
    <fieldset>
        <legend>CSV</legend>
        <a class="csv-link" href="<?php Tools::url("export"); ?>">
            <span>Export CSV</span><i class="icon-indent-left"></i>
        </a>
        <a class="csv-link" href="<?php Tools::url("import"); ?>">
            <span>Import CSV</span><i class="icon-indent-right"></i>
        </a>
        <a class="csv-link" href="<?php Tools::url("export/custom"); ?>">
            <span>Custom Export</span><i class="icon-list-alt"></i>
        </a>
    </fieldset>
    <hr class="index"/>
    <fieldset>
        <legend>Excel</legend>
        <a class="csv-link" href="<?php Tools::url("export/excel"); ?>">
            <span>Export Excel</span><i class="icon-indent-left"></i>
        </a>
        <a class="csv-link" href="<?php Tools::url("import/excel"); ?>">
            <span>Import Excel</span><i class="icon-indent-right"></i>
        </a>
        <a class="csv-link" href="<?php Tools::url("export/custom/excel"); ?>">
            <span>Custom Export</span><i class="icon-list-alt"></i>
        </a>
        <hr class="index"/>
    <fieldset>
        <legend>PDF</legend>
        <a class="csv-link" href="<?php Tools::url("export/pdf"); ?>">
            <span>Export PDF</span><i class="icon-indent-left"></i>
        </a>
        <a class="csv-link" href="<?php Tools::url("export/custom/pdf"); ?>">
            <span>Custom Export</span><i class="icon-list-alt"></i>
        </a>
    </fieldset>
    <hr class="index"/>
    <fieldset>
        <legend>Configuration</legend>
        <a class="csv-link" href="<?php Tools::url("dbconfig"); ?>">
        <span>Database Configuration</span> <i class="icon-wrench"></i>
    </a>
    </fieldset>

</div>