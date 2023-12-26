<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(app_config('AppName')); ?> <?php echo e(language_data('User Registration')); ?></title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
    <?php echo Html::style("assets/libs/bootstrap/css/bootstrap.min.css"); ?>

    <?php echo Html::style("assets/libs/font-awesome/css/font-awesome.min.css"); ?>

    <?php echo Html::style("assets/css/style.css"); ?>

    <?php echo Html::style("assets/css/responsive.css"); ?>

    <?php echo Html::style("assets/libs/bootstrap-select/css/bootstrap-select.min.css"); ?>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<main id="wrapper" class="wrapper">
    <div class="container jumbo-container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="app-logo-inner text-center">
                    <img src="<?php echo asset(app_config('AppLogo')); ?>" alt="logo" class="bar-logo">
                </div>
                <div class="panel panel-30">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><?php echo e(language_data('User Registration')); ?></h3>
                    </div>
                    <div class="panel-body">

                        <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <form class="" role="form" method="post" action="<?php echo e(url('user/post-registration')); ?>">



                            <div class="form-group">
                                <label><?php echo e(language_data('First Name')); ?></label>
                                <input type="text" class="form-control" required name="first_name" id="first_name">
                            </div>

                            <div class="form-group">
                                <label><?php echo e(language_data('Last Name')); ?></label>
                                <input type="text" class="form-control" name="last_name" placeholder="Optional">
                            </div>

                            <div class="form-group">
                                <label><?php echo e(language_data('Email')); ?></label>
                                <input type="email" class="form-control" name="email" placeholder="email address" required>
                            </div>

                            <div class="form-group">
                                <label for="user name"><?php echo e(language_data('User Name')); ?></label>
                                <input type="text" class="form-control" required name="user_name">
                            </div>

                            <div class="form-group">
                                <label><?php echo e(language_data('Password')); ?></label>
                                <input type="password" class="form-control" required name="password">
                            </div>

                            <div class="form-group">
                                <label><?php echo e(language_data('Confirm Password')); ?></label>
                                <input type="password" class="form-control" required name="cpassword">
                            </div>

                            <div class="form-group">
                                <label><?php echo e(language_data('Phone')); ?></label>
                                <input type="text" class="form-control" required name="phone">
                            </div>

                            <div class="form-group">
                                <label for="Country"><?php echo e(language_data('Country')); ?></label>
                                <select name="country" class="form-control selectpicker" data-live-search="true">
                                    <?php echo countries(app_config('Country')); ?>

                                </select>
                            </div>


                        <?php if(app_config('captcha_in_client_registration')=='1'): ?>
                                <div id="g-recaptcha" class="g-recaptcha" data-sitekey="<?php echo e(app_config('captcha_site_key')); ?>" data-expired-callback="recaptchaCallback"></div>

                                <noscript>
                                    <div style="width: 302px; height: 352px;margin-bottom:20px;margin-left:100px;">
                                        <div style="width: 302px; height: 352px; position: relative;">
                                            <div style="width: 302px; height: 352px; position: absolute;">
                                                <!-- change YOUR_SITE_KEY with your google recaptcha key -->
                                                <iframe src="https://www.google.com/recaptcha/api/fallback?k=<?php echo e(app_config('captcha_site_key')); ?>" style="width: 302px; height:352px; border-style: none;">
                                                </iframe>
                                            </div>
                                            <div style="width: 250px; height: 80px; position: absolute; border-style: none; bottom: 21px; left: 25px; margin: 0px; padding: 0px; right: 25px;">
                                                <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 80px; border: 1px solid #c1c1c1; margin: 0px; padding: 0px; resize: none;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </noscript>
                            <?php endif; ?>


                            <div class="form-group m-t-20 m-b-20">
                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" checked="" value="yes" name="email_notify">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Notify Client with email')); ?></label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <input type="submit" class="btn btn-primary btn-block btn-lg" value="<?php echo e(language_data('Sign up')); ?>">
                        </form>
                        <br>

                    </div>
                </div>
                <div class="panel-other-acction">
                    <div class="text-sm text-center">

                        <a href="<?php echo e(url('forgot-password')); ?>"><?php echo e(language_data('Forget Password')); ?>?</a><br>
                        <?php echo e(language_data('Already have an Account')); ?> ? <?php echo e(language_data('Login')); ?> <a href="<?php echo e(url('/')); ?>"><?php echo e(language_data('here')); ?></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo Html::script("assets/libs/jquery-1.10.2.min.js"); ?>

<?php echo Html::script("assets/libs/jquery.slimscroll.min.js"); ?>

<?php echo Html::script("assets/libs/bootstrap/js/bootstrap.min.js"); ?>

<?php echo Html::script("assets/libs/bootstrap-select/js/bootstrap-select.min.js"); ?>

<?php echo Html::script("assets/js/scripts.js"); ?>

<script>
    $("#first_name").focus();
</script>
</body>
</html>