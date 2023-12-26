<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Message Details')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <table class="table table-ultra-responsive text-uppercase">
                                    <tr>
                                        <td class="text-right"><?php echo e(language_data('Sending User')); ?>:</td>

                                        <?php if($inbox_info->userid=='0'): ?>
                                            <td><?php echo e(language_data('Admin')); ?></td>
                                        <?php else: ?>
                                            <td><a href="<?php echo e(url('clients/view/'.$inbox_info->userid)); ?>"><?php echo e(client_info($inbox_info->userid)->fname); ?> <?php echo e(client_info($inbox_info->userid)->lname); ?></a> </td>
                                        <?php endif; ?>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><?php echo e(language_data('Created At')); ?>:</td>
                                        <td><?php echo e($inbox_info->updated_at); ?></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><?php echo e(language_data('From')); ?>:</td>
                                        <td><?php echo e($inbox_info->sender); ?></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><?php echo e(language_data('To')); ?>:</td>
                                        <td><?php echo e($inbox_info->receiver); ?></td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-ultra-responsive text-uppercase">

                                    <tr>
                                        <td class="text-right"><?php echo e(language_data('Direction')); ?>:</td>
                                        <?php if($inbox_info->send_by=='sender'): ?>
                                            <td><p><?php echo e(language_data('Outgoing')); ?></p></td>
                                        <?php else: ?>
                                            <td><p><?php echo e(language_data('Incoming')); ?></p></td>
                                        <?php endif; ?>
                                    </tr>


                                    <tr>
                                        <td class="text-right"><?php echo e(language_data('Segments')); ?>:</td>
                                        <td><?php echo e($inbox_info->amount); ?></td>
                                    </tr>


                                    <tr>
                                        <td class="text-right"><?php echo e(language_data('Status')); ?>:</td>
                                        <td><span><?php echo e($inbox_info->status); ?></span></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right"><?php echo e(language_data('Message')); ?>:</td>
                                        <td><span><?php echo e($inbox_info->message); ?></span></td>
                                    </tr>



                                </table>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>