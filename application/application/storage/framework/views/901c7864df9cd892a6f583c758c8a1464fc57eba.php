<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Manage')); ?> <?php echo e(language_data('Sender ID')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Manage')); ?> <?php echo e(language_data('Sender ID')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('sms/post-update-sender-id')); ?>">
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Sender ID')); ?></label>
                                    <input type="text" class="form-control" required name="sender_id" value="<?php echo e($senderId->sender_id); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Client')); ?></label>
                                    <select class="form-control selectpicker" multiple data-live-search="true" name="client_id[]">
                                        <option value="0" <?php if($selected_all==true): ?> selected <?php endif; ?>><?php echo e(language_data('All')); ?></option>
                                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($e->id); ?>" <?php if(in_array_r($e->id,$sender_id_clients)): ?> selected <?php endif; ?>><?php echo e($e->fname); ?> <?php echo e($e->lname); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Status')); ?></label>
                                    <select class="selectpicker form-control" name="status">
                                        <option value="block" <?php if($senderId->status=='block'): ?> selected <?php endif; ?>><?php echo e(language_data('Block')); ?></option>
                                        <option value="unblock"  <?php if($senderId->status=='unblock'): ?> selected <?php endif; ?>><?php echo e(language_data('Unblock')); ?></option>
                                    </select>
                                </div>

                                <input value="<?php echo e($senderId->id); ?>" name="cmd" type="hidden">
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