<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e($sms_plan->plan_name); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e($sms_plan->plan_name); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 60%;"></th>
                                    <th style="width: 40%;" class="text-center"><?php echo e($sms_plan->plan_name); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $plan_feature; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="feature name"><?php echo e($feature->feature_name); ?></td>
                                        <td data-label="value" class="text-center"><p><?php echo e($feature->feature_value); ?></p></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td></td>
                                    <td><button class="btn btn-success center-block" data-toggle="modal" data-target="#purchase_now"><i class="fa fa-shopping-cart"></i> <?php echo e(language_data('Purchase Now')); ?></button> </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <div class="modal fade" id="purchase_now" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo e(language_data('Purchase SMS Plan')); ?></h4>
                        </div>
                        <div class="modal-body">

                            <form class="form-some-up" role="form" action="<?php echo e(url('user/sms/post-purchase-sms-plan')); ?>" method="post">

                                <div class="form-group">
                                    <label><?php echo e(language_data('Select Payment Method')); ?></label>
                                    <select class="selectpicker form-control" name="gateway">
                                        <?php $__currentLoopData = $payment_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($pg->settings); ?>"><?php echo e($pg->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="text-right">
                                    <input type="hidden" value="<?php echo e($sms_plan->id); ?>" name="cmd">
                                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><?php echo e(language_data('Close')); ?></button>
                                    <button type="submit" class="btn btn-success btn-sm"><?php echo e(language_data('Purchase Now')); ?></button>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>