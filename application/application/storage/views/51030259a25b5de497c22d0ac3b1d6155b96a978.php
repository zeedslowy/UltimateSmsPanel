<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Price Bundles')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" action="<?php echo e(url('sms/post-sms-bundles')); ?>" method="post">
                                <div class="panel-heading">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                    <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> <?php echo e(language_data('Save')); ?></button>
                                </div>

                                <table class="table task-items">

                                    <thead>
                                    <tr>
                                        <th width="20%"><?php echo e(language_data('Unit From')); ?></th>
                                        <th width="20%"><?php echo e(language_data('Unit To')); ?></th>
                                        <th width="20%"><?php echo e(language_data('Price')); ?></th>
                                        <th width="20"><?php echo e(language_data('Transaction Fee')); ?> (%)</th>
                                        <th width="20%"></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <?php if(count($bundles)>0): ?>

                                        <?php $__currentLoopData = $bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr class="item-row">
                                                <td><input type="text" name="unit_from[]" class="form-control description salary_from" value="<?php echo e($tr->unit_from); ?>"></td>
                                                <td><input type="text" name="unit_to[]" class="form-control description" value="<?php echo e($tr->unit_to); ?>"></td>
                                                <td><input type="text" name="price[]" class="form-control description" value="<?php echo e($tr->price); ?>"></td>
                                                <td><input type="text" name="trans_fee[]" class="form-control description" value="<?php echo e($tr->trans_fee); ?>"></td>

                                                <td><button class="btn btn-danger btn-sm ExitRemoveITEM" type="button"><i class="fa fa-trash-o"></i> <?php echo e(language_data('Delete')); ?></button></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="item-row">

                                            <td><input type="text" name="unit_from[]" class="form-control description"></td>
                                            <td><input type="text" name="unit_to[]" class="form-control description"></td>
                                            <td><input type="text" name="price[]" class="form-control description"></td>
                                            <td><input type="text" name="trans_fee[]" class="form-control description"></td>
                                            <td><button class="btn btn-success btn-sm item-add"><i class="fa fa-plus"></i> <?php echo e(language_data('Add More')); ?></button></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr class="item-row">
                                            <td><input type="text" name="unit_from[]" class="form-control description"></td>
                                            <td><input type="text" name="unit_to[]" class="form-control description"></td>
                                            <td><input type="text" name="price[]" class="form-control description"></td>
                                            <td><input type="text" name="trans_fee[]" class="form-control description"></td>
                                            <td><button class="btn btn-success btn-sm item-add"><i class="fa fa-plus"></i> <?php echo e(language_data('Add More')); ?></button></td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>

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

    <?php echo Html::script("assets/js/sms-bundles.js"); ?>


    <script>
        $('.ExitRemoveITEM').on("click", function () {
            $(this).parents(".item-row").remove();
        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>