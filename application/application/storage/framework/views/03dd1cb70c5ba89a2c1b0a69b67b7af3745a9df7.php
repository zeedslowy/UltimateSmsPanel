<?php $__env->startSection('style'); ?>
<style>
    .radio_label{
        text-transform: lowercase !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Background Jobs')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php if(!exec_enabled()): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e($get_message); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Please specify the PHP executable path on your system')); ?></h3>
                        </div>
                        <div class="panel-body">


                            <form class="" role="form" >

                                <?php $__currentLoopData = $paths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group">
                                        <div class="coder-radiobox">
                                            <input type="radio" name="php_bin_path" value="<?php echo e($p); ?>" <?php if($p == $server_php_path): ?> checked <?php endif; ?>>
                                            <span class="co-radio-ui"></span>
                                            <label class="radio_label"><?php echo e($p); ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </form>

                            <hr>
                            <label class="text-bold">Insert the following line to your system's contab.
                                Please note, below timings for running the cron jobs are the recommended, you can change it if you want. </label>

                                <pre style="font-size: 16px;background:#f5f5f5">* * * * * <span class="current_path_value"><?php echo $server_php_path; ?></span> -d register_argc_argv=On <?php echo e(base_path()); ?>/artisan schedule:run >> /dev/null 2>&1    </pre>

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
        $(document).ready(function() {

            $('input[name="php_bin_path"]:checked').trigger('change');

            // pickadate mask
            $(document).on('keyup change', 'input[name="php_bin_path"]', function() {
                var value = $(this).val();

                if(value !== '') {
                    $('.current_path_value').html(value);
                } else {
                    $('.current_path_value').html('{PHP_BIN_PATH}');
                }
            });
            $('input[name="php_bin_path_value"]').trigger('change');

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>