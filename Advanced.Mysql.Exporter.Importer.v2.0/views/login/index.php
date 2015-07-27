<div class="container-login">
    <form class="form-signin" method="post" action="" id="login-form">
        <h2 class="form-signin-heading">Administration</h2>
        <?php
        FlashSession::showErrors();
        ?>
        <input type="text" class="input-block-level" placeholder="Username" name="username">
        <input type="password" class="input-block-level" placeholder="Password" name="password">

        <button class="btn btn-primary" type="submit" name="submitLoginBtn">Sign in</button>
    </form>

</div>