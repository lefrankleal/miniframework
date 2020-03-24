<?php
require_once 'settings.php';
require_once 'Core/Autoload.php';

Core\Autoload::register();
$lang = new Core\Helpers\Languaje();
$lang->registerCustom('Login');

?>
    <!doctype html>

    <!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
    <!--[if gt IE 9]><!-->
    <html lang="en">
    <!--<![endif]-->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no" />

        <link rel="icon" type="image/png" href="/assets/img/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="/assets/img/favicon-32x32.png" sizes="32x32">

        <title>
            <?php echo SYSTEMNAME; ?>
        </title>

        <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
        <!-- Here goes your css login url files -->

    </head>

    <body class="login_page">

        <div class="login_page_wrapper">
            <div class="md-card" id="login_card">
                <div class="md-card-content large-padding" id="login_form">
                    <div class="login_heading">
                        <div class="user_avatar"></div>
                    </div>
                    <form id="form_login" method="post">
                        <div class="uk-form-row parsley-row">
                            <label for="login_username">
                                <?php echo LOGIN_FIELD_USER; ?>
                            </label>
                            <input class="md-input" type="text" id="login_username" name="login_username" required/>
                        </div>
                        <div class="uk-form-row parsley-row">
                            <label for="login_password">
                                <?php echo LOGIN_FIELD_PASSWORD; ?>
                            </label>
                            <input class="md-input" type="password" id="login_password" name="login_password" required/>
                        </div>
                        <div class="uk-margin-medium-top">
                            <input id="login_submit" type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large" value="<?php echo LOGIN_BUTTON_SIGNIN; ?>">
                        </div>
                        <div id="error_message" class="uk-margin-medium-top uk-text-center parsley-errors-list" hidden></div>
                        <div class="uk-margin-top">
                            <a href="#" id="login_help_show" class="uk-float-right">
                                <?php echo LOGIN_LINK_HELP; ?>
                            </a>
                        </div>
                    </form>
                </div>
                <div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: none">
                    <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                    <h2 class="heading_b uk-text-success">No puedes iniciar sesion?</h2>
                    <p>Esta informacion es para ayudarte a recuperar tu cuenta lo antes posible.</p>
                    <p>Primero, prueba con lo mas facil: si recuerdas tu contraseña pero no funciona, asegurate de que las mayusculas
                        esten desactivadas, y que tu nombre de usuario esta correcto, e intenta de nuevo.</p>
                    <p>Si tu contraseña sigue sin funcionar, es hora de
                        <a href="#" id="password_reset_show">reiniciar tu contraseña</a>.</p>
                </div>
                <div class="md-card-content large-padding" id="login_password_reset" style="display: none">
                    <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                    <h2 class="heading_a uk-margin-large-bottom">Reiniciar contraseña</h2>
                    <form id="reset_form">
                        <div class="uk-form-row">
                            <label for="login_email_reset">Correo electronico</label>
                            <input class="md-input" type="text" id="login_email_reset" name="login_email_reset" required/>
                        </div>
                        <div class="uk-margin-medium-top">
                            <a href="index.html" class="md-btn md-btn-primary md-btn-block">Reiniciar contraseña</a>
                        </div>
                    </form>
                </div>
                <div class="md-card-content large-padding" id="register_form" style="display: none">
                    <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                    <h2 class="heading_a uk-margin-medium-bottom">Crear cuenta</h2>
                    <form>
                        <div class="uk-form-row">
                            <label for="register_username">Usuario</label>
                            <input class="md-input" type="text" id="register_username" name="register_username" />
                        </div>
                        <div class="uk-form-row">
                            <label for="register_password">Contraseña</label>
                            <input class="md-input" type="password" id="register_password" name="register_password" />
                        </div>
                        <div class="uk-form-row">
                            <label for="register_password_repeat">Repetir contraseña</label>
                            <input class="md-input" type="password" id="register_password_repeat" name="register_password_repeat" />
                        </div>
                        <div class="uk-form-row">
                            <label for="register_email">E-mail</label>
                            <input class="md-input" type="text" id="register_email" name="register_email" />
                        </div>
                        <div class="uk-margin-medium-top">
                            <a href="index.html" class="md-btn md-btn-primary md-btn-block md-btn-large">Crear cuenta</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="uk-margin-top uk-text-center">
                <a href="#" id="signup_form_show">
                    <?php echo LOGIN_LINK_CREATEACC; ?>
                </a>
            </div>
        </div>

        <!-- Here goes your js login url files -->

        <script type="text/javascript">
            var LOGIN_ERROR_INVALID = '<?php echo LOGIN_ERROR_INVALID ?>';
            var LANG = '<?php echo LANG ?>';
            var URL = '<?php echo URL ?>';

            var dataC = {
                token: localStorage.getItem('active_company')
            };
            $.ajax({
                url: "/api/User/ValidateUser",
                type: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Cache-Control": "no-cache",
                    "Authorization": localStorage.getItem('token')
                },
                dataType: 'json',
                data: JSON.stringify(dataC),
                beforeSend: function () {
                }
            }).done(function (res) {
                window.location.replace(URL + '/' + LANG + '/p/main');
            }).error(function (res) {
            });
        </script>
    </body>

    </html>