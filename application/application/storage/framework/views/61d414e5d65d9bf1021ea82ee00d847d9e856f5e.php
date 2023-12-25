<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Add Sender ID')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Add Sender ID')); ?></h3>
                        </div>
                        <div class="panel-body">

                            <form method="post" action="<?php echo e(url('sms/post-new-sender-id')); ?>">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label><?php echo e(language_data('Client')); ?></label>
                                            <select name="client_id[]" class="selectpicker form-control" multiple data-live-search="true">
                                                <option value="0"><?php echo e(language_data('All')); ?></option>
                                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($cl->id); ?>"><?php echo e($cl->fname); ?> <?php echo e($cl->lname); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Status')); ?></label>
                                            <select class="selectpicker form-control" name="status">
                                                <option value="block"><?php echo e(language_data('Block')); ?></option>
                                                <option value="unblock"><?php echo e(language_data('Unblock')); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <table class="table table-hover" id="sender_id_items">
                                            <thead>
                                            <tr>
                                                <th width="70%"><?php echo e(language_data('Sender ID')); ?></th>
                                                <th width="30%"><?php echo e(language_data('Action')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="item-row info">
                                                <td><input type="text" autocomplete="off" required name="sender_id[]" class="form-control sender_id"></td>
                                                <td><button class="btn btn-success item-add"><i class="fa fa-plus"></i> <?php echo e(language_data('Add More')); ?></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="text-right">
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

    <?php echo Html::script("assets/js/sender-id-management.js"); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>