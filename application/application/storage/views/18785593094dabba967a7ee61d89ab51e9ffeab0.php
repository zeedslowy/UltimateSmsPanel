<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Edit Contact')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Edit Contact')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-some-up form-block" role="form" action="<?php echo e(url('user/update-single-contact')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Phone Number')); ?></label>
                                    <input type="text" class="form-control" required name="number" value="<?php echo e($cl->phone_number); ?>">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label><?php echo e(language_data('First Name')); ?></label>
                                    <input type="text" class="form-control" name="first_name" value="<?php echo e($cl->first_name); ?>">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label><?php echo e(language_data('Last Name')); ?></label>
                                    <input type="text" class="form-control" name="last_name" value="<?php echo e($cl->last_name); ?>">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label><?php echo e(language_data('Email')); ?></label>
                                    <input type="email" class="form-control" name="email"  value="<?php echo e($cl->email_address); ?>">
                                </div>

                                <br>
                                <div class="form-group">
                                    <label><?php echo e(language_data('Company')); ?></label>
                                    <input type="text" class="form-control" name="company"  value="<?php echo e($cl->company); ?>">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label><?php echo e(language_data('User name')); ?></label>
                                    <input type="text" class="form-control" name="username"  value="<?php echo e($cl->user_name); ?>">
                                </div>

                                <input type="hidden" name="cmd" value="<?php echo e($cl->id); ?>">
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
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>