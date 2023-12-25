<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Change Password')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">

                        <div class="panel-heading">
                            <h3 class="panel-title"> <?php echo e(language_data('Change Password')); ?></h3>
                        </div>

                        <div class="panel-body">
                            <form class="" role="form" action="<?php echo e(url('admin/update-password')); ?>" method="post">


                                <div class="form-group">
                                    <label><?php echo e(language_data('Current Password')); ?></label>
                                    <input type="password" class="form-control" required name="current_password">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('New Password')); ?></label>
                                    <input type="password" class="form-control" required name="new_password">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Confirm Password')); ?></label>
                                    <input type="password" class="form-control" required name="confirm_password">
                                </div>

                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> <?php echo e(language_data('Update')); ?> </button>
                            </form>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>