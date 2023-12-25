<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Export and Import Clients')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-4">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Export Clients')); ?></h3>
                        </div>
                        <div class="panel-body">
                                <ul class="info-list">
                                    <li>
                                        <span class="info-list-title"><?php echo e(language_data('Export Clients')); ?></span><span class="info-list-des"><a href="<?php echo e(url('clients/export-clients')); ?>" class="btn btn-success btn-xs"><?php echo e(language_data('Export Clients as CSV')); ?></a></span>
                                    </li>
                                    <li>
                                        <span class="info-list-title"><?php echo e(language_data('Sample File')); ?></span><span class="info-list-des"><a href="<?php echo e(url('clients/download-sample-csv')); ?>" class="btn btn-complete btn-xs"><?php echo e(language_data('Download Sample File')); ?></a> </span>
                                    </li>

                                </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Import Clients')); ?></h3>
                        </div>
                        <div class="panel-body">

                            <form class="" role="form" method="post" action="<?php echo e(url('clients/post-new-client-csv')); ?>" enctype="multipart/form-data">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Client Group')); ?></label>
                                    <select class="selectpicker form-control" name="client_group"  data-live-search="true">
                                        <option value="0"><?php echo e(language_data('None')); ?></option>
                                        <?php $__currentLoopData = $client_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cg->id); ?>"><?php echo e($cg->group_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label><?php echo e(language_data('SMS Gateway')); ?></label>
                                    <select class="selectpicker form-control" name="sms_gateway"  data-live-search="true">
                                        <?php $__currentLoopData = $sms_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sg->id); ?>"><?php echo e($sg->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Import Clients')); ?></label>
                                    <div class="form-group input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="import_client">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly="">
                                    </div>
                                    <p class="text-uppercase text-complete help"><?php echo e(language_data('It will take few minutes. Please do not reload the page')); ?></p>
                                </div>

                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-download"></i> <?php echo e(language_data('Import')); ?> </button>
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