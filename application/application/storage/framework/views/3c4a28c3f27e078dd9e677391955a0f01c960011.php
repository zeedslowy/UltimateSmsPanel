<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Add SMS Price Plan')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Add SMS Price Plan')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('sms/post-new-price-plan')); ?>">
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Plan Name')); ?></label>
                                    <input type="text" class="form-control" required name="plan_name">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Price')); ?></label>
                                    <input type="number" class="form-control" name="price" required>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Show in Client')); ?></label>
                                    <select class="selectpicker form-control" name="show_in_client">
                                        <option value="Active"><?php echo e(language_data('Yes')); ?></option>
                                        <option value="Inactive"><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Mark Popular')); ?></label>
                                    <select class="selectpicker form-control" name="popular">
                                        <option value="Yes"><?php echo e(language_data('Yes')); ?></option>
                                        <option value="No"><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> <?php echo e(language_data('Add Plan')); ?></button>
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