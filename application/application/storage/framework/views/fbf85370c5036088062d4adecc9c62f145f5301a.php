<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Add Plan Feature')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Add Plan Feature')); ?></h3>
                        </div>
                        <div class="panel-body">

                            <form method="post" action="<?php echo e(url('sms/post-new-plan-feature')); ?>">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label><?php echo e(language_data('Client')); ?></label>
                                            <input type="text" disabled class="form-control" value="<?php echo e($price_plan->plan_name); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Show In Client')); ?></label>
                                            <select class="selectpicker form-control" name="show_in_client">
                                                <option value="Active"><?php echo e(language_data('Yes')); ?></option>
                                                <option value="Inactive"><?php echo e(language_data('No')); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <table class="table table-hover" id="plan-feature-items">
                                            <thead>
                                            <tr>
                                                <th width="40%"><?php echo e(language_data('Feature Name')); ?></th>
                                                <th width="30%"><?php echo e(language_data('Feature Value')); ?></th>
                                                <th width="30%"><?php echo e(language_data('Action')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="item-row info">
                                                <td><input type="text" autocomplete="off" required name="feature_name[]" class="form-control feature_name"></td>
                                                <td><input type="text" autocomplete="off" required name="feature_value[]" class="form-control feature_value"></td>
                                                <td><button class="btn btn-success item-add"><i class="fa fa-plus"></i><?php echo e(language_data('Add More')); ?></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="text-right">
                                            <input type="hidden" value="<?php echo e($price_plan->id); ?>" name="cmd">
                                            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> <?php echo e(language_data('Save')); ?></button>
                                        </div>

                                    </div>
                                </div>
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

    <?php echo Html::script("assets/js/plan-feature.js"); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>