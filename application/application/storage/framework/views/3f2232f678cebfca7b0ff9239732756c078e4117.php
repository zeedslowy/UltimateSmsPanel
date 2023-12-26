<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('System Settings')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-7">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('System Settings')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" action="<?php echo e(url('settings/post-general-setting')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Application Name')); ?></label>
                                    <input type="text" class="form-control" required name="app_name" value="<?php echo e(app_config('AppName')); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Application Title')); ?></label>
                                    <input type="text" class="form-control" name="app_title" required="" value="<?php echo e(app_config('AppTitle')); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Address')); ?></label>
                                    <textarea class="form-control textarea-wysihtml5" name="address"><?php echo e(app_config('Address')); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('System Email')); ?></label>
                                    <span class="help"><?php echo e(language_data('Remember: All Email Going to the Receiver from this Email')); ?></span>
                                    <input type="email" class="form-control" required name="email" value="<?php echo e(app_config('Email')); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Footer Text')); ?></label>
                                    <input type="text" class="form-control" required name="footer" value="<?php echo e(app_config('FooterTxt')); ?>">
                                </div>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Application Logo')); ?></label>
                                    <div class="input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="app_logo">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Application Favicon')); ?></label>
                                    <div class="input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="app_fav">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('API Permission')); ?></label>
                                    <select class="selectpicker form-control" name="api_permission">
                                        <option value="1" <?php if(app_config('sms_api_permission')=='1'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="0" <?php if(app_config('sms_api_permission')=='0'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Sender ID Verification')); ?></label>
                                    <select class="selectpicker form-control" name="sender_id_verification">
                                        <option value="1" <?php if(app_config('sender_id_verification')=='1'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="0" <?php if(app_config('sender_id_verification')=='0'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Allow Client Registration')); ?></label>
                                    <select class="selectpicker form-control" name="client_registration">
                                        <option value="1" <?php if(app_config('client_registration')=='1'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="0" <?php if(app_config('client_registration')=='0'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Client Registration Verification')); ?></label>
                                    <select class="selectpicker form-control" name="registration_verification">
                                        <option value="1" <?php if(app_config('registration_verification')=='1'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="0" <?php if(app_config('registration_verification')=='0'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Captcha In Admin Login')); ?></label>
                                    <select class="selectpicker form-control" name="captcha_in_admin">
                                        <option value="1" <?php if(app_config('captcha_in_admin')=='1'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="0" <?php if(app_config('captcha_in_admin')=='0'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Captcha In Client Login')); ?></label>
                                    <select class="selectpicker form-control" name="captcha_in_client">
                                        <option value="1" <?php if(app_config('captcha_in_client')=='1'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="0" <?php if(app_config('captcha_in_client')=='0'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Captcha In Client Registration')); ?></label>
                                    <select class="selectpicker form-control" name="captcha_in_client_registration">
                                        <option value="1" <?php if(app_config('captcha_in_client_registration')=='1'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="0" <?php if(app_config('captcha_in_client_registration')=='0'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fname"><?php echo e(language_data('reCAPTCHA Site Key')); ?></label>
                                    <input type="text" class="form-control" required="" name="captcha_site_key" value="<?php echo e(app_config('captcha_site_key')); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="fname"><?php echo e(language_data('reCAPTCHA Secret Key')); ?></label>
                                    <input type="text" class="form-control" required="" name="captcha_secret_key" value="<?php echo e(app_config('captcha_secret_key')); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Email Gateway')); ?></label>
                                    <select class="selectpicker form-control gateway" name="email_gateway">
                                        <option value="default" <?php if(app_config('Gateway')=='default'): ?> selected <?php endif; ?>><?php echo e(language_data('Server Default')); ?></option>
                                        <option value="smtp" <?php if(app_config('Gateway')=='smtp'): ?> selected <?php endif; ?>> <?php echo e(language_data('SMTP')); ?> </option>
                                    </select>
                                </div>

                                <div class="show-smtp">

                                    <div class="form-group">
                                        <label for="fname"><?php echo e(language_data('SMTP')); ?> <?php echo e(language_data('Host Name')); ?></label>
                                        <input type="text" class="form-control" required="" name="host_name" value="<?php echo e(app_config('SMTPHostName')); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="fname"><?php echo e(language_data('SMTP')); ?> <?php echo e(language_data('User Name')); ?></label>
                                        <input type="text" class="form-control" required="" name="user_name"  value="<?php echo e(app_config('SMTPUserName')); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="fname"><?php echo e(language_data('SMTP')); ?> <?php echo e(language_data('Password')); ?></label>
                                        <input type="text" class="form-control" required="" name="password"  value="<?php echo e(app_config('SMTPPassword')); ?>">
                                    </div>


                                    <div class="form-group">
                                        <label for="fname"><?php echo e(language_data('SMTP')); ?> <?php echo e(language_data('Port')); ?></label>
                                        <input type="text" class="form-control" required="" name="port"  value="<?php echo e(app_config('SMTPPort')); ?>">
                                    </div>


                                    <div class="form-group">
                                        <label for="Default Gateway"><?php echo e(language_data('SMTP')); ?> <?php echo e(language_data('Secure')); ?></label>
                                        <select name="secure" class="selectpicker form-control">
                                            <option value="tls" <?php if(app_config('SMTPSecure')=='tls'): ?>  selected <?php endif; ?>><?php echo e(language_data('TLS')); ?></option>
                                            <option value="ssl" <?php if(app_config('SMTPSecure')=='ssl'): ?>selected <?php endif; ?>><?php echo e(language_data('SSL')); ?></option>
                                        </select>
                                    </div>


                                </div>

                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> <?php echo e(language_data('Update')); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>

    <?php echo Html::script("assets/libs/moment/moment.min.js"); ?>

    <?php echo Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js"); ?>

    <?php echo Html::script("assets/libs/handlebars/handlebars.runtime.min.js"); ?>

    <?php echo Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js"); ?>

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>

    <?php echo Html::script("assets/js/bootbox.min.js"); ?>

    <script>
        $(document).ready(function () {

            var EmailGatewaySV = $('.gateway');
            if (EmailGatewaySV.val() == 'default') {
                $('.show-smtp').hide();
            }

            EmailGatewaySV.on('change', function () {
                var value = $(this).val();
                if (value == 'smtp') {
                    $('.show-smtp').show();
                } else {
                    $('.show-smtp').hide();
                }

            });

        });

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>