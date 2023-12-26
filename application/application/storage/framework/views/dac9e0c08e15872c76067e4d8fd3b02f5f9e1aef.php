<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Purchase Code')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">

                            <h3>Your current license</h3>

                            <hr>
                            <p>Thank you for purchasing Ultimate SMS! Below is your license key, also known as Purchase Code. Your license type is <strong class="text-primary"> <?php echo e(app_config('license_type')); ?></strong></p>
                            <h4><?php echo e(app_config('purchase_key')); ?></h4>
                            <hr>
                            <h4>License types</h4>
                            <p>When you purchase Ultimate SMS from Envato website, you are actually purchasing a license to use the product.
                                There are 2 types of license that are issued</p>

                            <h4>Regular License</h4>
                            <p>All features are available, for a single end product which end users are NOT charged for</p>

                            <h4>Extended License</h4>
                            <p>All features are available, for a single end product which end users can be charged for (software as a service)</p>

                            <hr>
                            <form class="" role="form" method="post" action="<?php echo e(url('settings/update-purchase-key')); ?>">
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label>Update your license</label>
                                    <input type="text" class="form-control" name="purchase_code" required>
                                    <span class="help-block text-success">Enter the licence key (purchase code) then hit the Update button</span>
                                </div>

                                <button type="submit" class="btn btn-success btn-sm" ><i class="fa fa-save"></i> <?php echo e(language_data('Update')); ?> </button>

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