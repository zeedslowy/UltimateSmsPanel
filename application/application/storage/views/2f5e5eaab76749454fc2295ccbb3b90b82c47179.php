<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Coverage')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Coverage')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 5%;"><?php echo e(language_data('SL')); ?>#</th>
                                    <th style="width: 20%;"><?php echo e(language_data('Country')); ?></th>
                                    <th style="width: 15%;"><?php echo e(language_data('ISO Code')); ?></th>
                                    <th style="width: 15%;"><?php echo e(language_data('Country Code')); ?></th>
                                    <th style="width: 15%;"><?php echo e(language_data('Tariff')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Status')); ?></th>
                                    <th style="width: 20%;"><?php echo e(language_data('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $country_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="SL"><?php echo e($loop->iteration); ?></td>
                                        <td data-label="Country"><p><?php echo e($cc->country_name); ?></p></td>
                                        <td data-label="ISO Code"><p><?php echo e($cc->iso_code); ?></p></td>
                                        <td data-label="Country Code"><p><?php echo e($cc->country_code); ?></p></td>
                                        <td data-label="Tariff"><p><?php echo e($cc->tariff); ?></p></td>
                                        <?php if($cc->active=='1'): ?>
                                            <td data-label="Status"><p class="label label-success"><?php echo e(language_data('Live')); ?></p></td>
                                        <?php else: ?>
                                            <td data-label="Status"><p class="label label-danger"><?php echo e(language_data('Offline')); ?></p></td>
                                        <?php endif; ?>
                                        <td data-label="Actions">
                                            <a class="btn btn-success btn-xs" href="<?php echo e(url('sms/manage-coverage/'.$cc->id)); ?>" ><i class="fa fa-edit"></i> <?php echo e(language_data('Manage')); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
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

    <?php echo Html::script("assets/libs/data-table/datatables.min.js"); ?>


    <script>
        $(document).ready(function(){
            $('.data-table').DataTable();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>