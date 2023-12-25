<style type="text/css">
    .api_key_break, .api_url_break{
        word-wrap: break-word;
    }
</style>

<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('SMS API Info')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('SMS API Info')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('user/sms-api/update-info')); ?>">
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label><?php echo e(language_data('SMS Api key')); ?></label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="api-key" name="api_key" value="<?php echo e(Auth::guard('client')->user()->api_key); ?>">
                                        <span class="input-group-addon btn btn-success getNewPass"><i class="fa fa-refresh"></i> <?php echo e(language_data('Generate New')); ?></span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> <?php echo e(language_data('Update')); ?> </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('SMS API Details')); ?></h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label><?php echo e(language_data('SMS Api Key')); ?>:</label>
                                <p class="text-sm api_key_break"><?php echo e(Auth::guard('client')->user()->api_key); ?></p>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(language_data('SMS API URL')); ?>:</label>
                                <p class="text-sm api_url_break"><?php echo e(rtrim(app_config('api_url'),'/').'/sms/api?action=send-sms&api_key='.Auth::guard('client')->user()->api_key.'&to=PhoneNumber&from=SenderID&sms=YourMessage&response=json&unicode=0'); ?></p>
                            </div>

                            <div class="form-group">
                                <label>Balance Check:</label>
                                <p class="text-sm api_url_break"><?php echo e(rtrim(app_config('api_url'),'/').'/sms/api?action=check-balance&api_key='.Auth::guard('client')->user()->api_key.'&response=json'); ?></p>
                            </div>


                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <?php echo Html::script("assets/libs/handlebars/handlebars.runtime.min.js"); ?>

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>

    <script>

        // Generate a password string
        function randString(){
            var chars = "abcdefghijklmnopqrstuvwxyz=ABCDEFGHIJKLMNOP";
            var pass = "";
            for (var x = 0; x < 20; x++) {
                var i = Math.floor(Math.random() * chars.length);
                pass += chars.charAt(i);
            }
           return btoa(pass);

        }
        // Create a new password
        $(".getNewPass").click(function(){
            var field = $(this).closest('div').find('#api-key');
            field.val(randString(field));
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>