<div id="login">
    <h1><?php _ewh( 'Welcome Back' ); ?></h1>
    <p class="tagline"><?php _ewh( 'Take control of your financial future, today.' ); ?></p>
    <form name="loginform" id="loginform" action="https://dev.thinkcraft.co.za/wp-login.php" method="post" class="shake">
        <p>
            <label for="user_login">Username or Email Address</label>
            <input type="text" name="log" id="user_login" aria-describedby="login_error" class="input" value="" size="20" autocapitalize="off" autocomplete="username">
        </p>

        <div class="user-pass-wrap">
            <label for="user_pass">Password</label>
            <div class="wp-pwd">
                <input type="password" name="pwd" id="user_pass" aria-describedby="login_error" class="input password-input" value="" size="20" autocomplete="current-password">
                <button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Show password">
                    <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                </button>
            </div>
        </div>
        <p class="forgetmenot"><input name="rememberme" type="checkbox" id="rememberme" value="forever" checked="checked"> <label for="rememberme">Remember Me</label></p>
        <p class="submit">
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In">
            <input type="hidden" name="redirect_to" value="https://dev.thinkcraft.co.za/wp-admin/">
            <input type="hidden" name="testcookie" value="1">
        </p>
    </form></div>