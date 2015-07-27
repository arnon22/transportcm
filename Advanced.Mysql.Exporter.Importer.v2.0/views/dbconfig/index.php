<div class="main-div-index">
    <form action="" id="db_config_form" class="form-horizontal" method="post">
        <fieldset>
            <legend>DataBase configuration</legend>
            <?php
            FlashSession::showErrors();
            /** @var DBAccess $dbAccess  */
            if($dbAccess = Session::get('dbAccess')){
                $dbHost = $dbAccess->getDbHost();
                $dbUser = $dbAccess->getDbUsername();
                $dbPassword = $dbAccess->getDbPassword();
                $dbName = $dbAccess->getDbName();
            }
            ?>
            <div class="control-group">
                <label class="control-label" for="db_host">Host <i class="icon-tasks"></i></label>

                <div class="controls">
                    <input type="text" name="db_host" id="db_host" value="<?php echo isset($dbHost) ? $dbHost : "";?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="db_username">Username <i class="icon-user"></i></label>

                <div class="controls">
                    <input type="text" name="db_username" id="db_username" value="<?php echo isset($dbUser) ? $dbUser : "";?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="db_password">Password <i class="icon-lock"></i></label>

                <div class="controls">
                    <input type="password" name="db_password" id="db_password" value="<?php echo isset($dbPassword) ? $dbPassword : "";?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="db_name">DB Name <i class="icon-align-justify"></i></label>

                <div class="controls">
                    <input type="text" name="db_name" id="db_name" value="<?php echo isset($dbName) ? $dbName : "";?>"/>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn" name="submitDBConfigBtn">Submit</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>