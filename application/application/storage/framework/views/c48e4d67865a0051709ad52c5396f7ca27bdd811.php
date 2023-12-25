<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('View')); ?> <?php echo e(language_data('Department')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('View')); ?> <?php echo e(language_data('Department')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="<?php echo e(url('support-tickets/update-department')); ?>">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                                <div class="form-group">
                                    <label for="dname"><?php echo e(language_data('Department Name')); ?></label>
                                    <input type="text" class="form-control" id="dname" name="dname" value="<?php echo e($d->name); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="email"><?php echo e(language_data('Department Email')); ?></label>
                                    <input type="email" class="form-control" id="email" name="email"  value="<?php echo e($d->email); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="show"><?php echo e(language_data('Show In Client')); ?></label>
                                    <select name="show" class="selectpicker form-control">
                                        <option value="Yes" <?php if($d->show=='Yes'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="No" <?php if($d->show=='No'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>


                                <div class="hr-line-dashed"></div>
                                <input type="hidden" name="cmd" value="<?php echo e($d->id); ?>">
                                <button type="submit" name="add" class="btn btn-success"><i class="fa fa-edit"></i> <?php echo e(language_data('Update')); ?></button>
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