<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Manage Payment Gateway')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Manage Payment Gateway')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('settings/post-payment-gateway-manage')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Gateway Name')); ?></label>
                                    <input type="text" class="form-control" disabled value="<?php echo e($pg->name); ?>">
                                </div>
                                <?php if($pg->settings=='paystack'): ?>
                                    <div class="form-group">
                                        <label>Merchant Email</label>
                                        <input type="text" class="form-control"  name="pg_password"  value="<?php echo e($pg->password); ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <?php if($pg->settings=='paypal'): ?>
                                        <label>Merchant Email</label>
                                    <?php elseif($pg->settings=='payu' || $pg->settings=='2checkout'): ?>
                                        <label><?php echo e(language_data('Client ID')); ?></label>
                                    <?php elseif($pg->settings=='stripe'): ?>
                                        <label><?php echo e(language_data('Publishable Key')); ?></label>
                                    <?php elseif($pg->settings=='manualpayment'): ?>
                                        <label><?php echo e(language_data('Bank Details')); ?></label>
                                    <?php elseif($pg->settings=='authorize_net'): ?>
                                        <label><?php echo e(language_data('Api Login ID')); ?></label>
                                    <?php elseif($pg->settings=='slydepay' ): ?>
                                        <label>Merchant Email</label>
                                    <?php elseif($pg->settings=='paynow' ): ?>
                                        <label>Integration ID</label>
                                    <?php elseif($pg->settings=='paystack' || $pg->settings=='pagopar'): ?>
                                        <label>Public Key</label>
                                    <?php else: ?>
                                        <label><?php echo e(language_data('Value')); ?></label>
                                    <?php endif; ?>
                                    <input type="text" class="form-control" name="pg_value" value="<?php echo e($pg->value); ?>">
                                </div>



                                <?php if($pg->settings!='paypal' && $pg->settings=='stripe' || $pg->settings=='authorize_net' ||  $pg->settings=='slydepay' || $pg->settings=='payu' || $pg->settings=='paystack' || $pg->settings=='pagopar' || $pg->settings=='paynow'): ?>
                                <div class="form-group">
                                    <?php if($pg->settings=='stripe' || $pg->settings=='paystack'): ?>
                                        <label><?php echo e(language_data('Secret_Key_Signature')); ?></label>
                                    <?php elseif($pg->settings=='authorize_net'): ?>
                                        <label><?php echo e(language_data('Transaction Key')); ?></label>
                                    <?php elseif($pg->settings=='payu'): ?>
                                        <label><?php echo e(language_data('Client Secret')); ?></label>
                                    <?php elseif($pg->settings=='slydepay'): ?>
                                        <label>Merchant Secret</label>
                                    <?php elseif($pg->settings=='paynow' ): ?>
                                        <label>Integration Key</label>
                                    <?php elseif($pg->settings=='pagopar'): ?>
                                        <label>Private Key</label>
                                    <?php else: ?>
                                        <label><?php echo e(language_data('Extra Value')); ?></label>
                                    <?php endif; ?>
                                    <input type="text" class="form-control" name="pg_extra_value" value="<?php echo e($pg->extra_value); ?>">
                                </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Status')); ?></label>
                                    <select class="selectpicker form-control" name="status">
                                        <option value="Active" <?php if($pg->status=='Active'): ?> selected <?php endif; ?>><?php echo e(language_data('Active')); ?></option>
                                        <option value="Inactive"  <?php if($pg->status=='Inactive'): ?> selected <?php endif; ?>><?php echo e(language_data('Inactive')); ?></option>
                                    </select>
                                </div>

                                <input type="hidden" value="<?php echo e($pg->id); ?>" name="cmd">
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