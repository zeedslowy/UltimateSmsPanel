<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30 clearfix">
            <h2 class="page-title inline-block"><?php echo e(language_data('SMS Gateway')); ?></h2>

            <a href="<?php echo e(url('sms/add-sms-gateways')); ?>" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> <?php echo e(language_data('Add Gateway')); ?></a>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('SMS Gateway')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10%;"><?php echo e(language_data('SL')); ?>#</th>
                                    <th style="width: 25%;"><?php echo e(language_data('Gateway Name')); ?></th>
                                    <th style="width: 20%;"><?php echo e(language_data('Schedule SMS')); ?></th>
                                    <th style="width: 15%;"><?php echo e(language_data('Two Way')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Status')); ?></th>
                                    <th style="width: 20%;"><?php echo e(language_data('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="SL"><?php echo e($loop->iteration); ?></td>
                                        <td data-label="Gateway Name"><p><?php echo e($g->name); ?></p></td>

                                        <?php if($g->schedule=='Yes'): ?>
                                            <td data-label="Schedule SMS"><p class="label label-success"><?php echo e(language_data('Yes')); ?></p></td>
                                        <?php else: ?>
                                            <td data-label="Schedule SMS"><p class="label label-danger"><?php echo e(language_data('No')); ?></p></td>
                                        <?php endif; ?>

                                        <?php if($g->two_way=='Yes'): ?>
                                            <td data-label="Two Way"><p class="label label-success"><?php echo e(language_data('Yes')); ?></p></td>
                                        <?php else: ?>
                                            <td data-label="Two Way"><p class="label label-danger"><?php echo e(language_data('No')); ?></p></td>
                                        <?php endif; ?>

                                        <?php if($g->status=='Active'): ?>
                                            <td data-label="Status"><p class="label label-success"><?php echo e(language_data('Active')); ?></p></td>
                                        <?php else: ?>
                                            <td data-label="Status"><p class="label label-danger"><?php echo e(language_data('Inactive')); ?></p></td>
                                        <?php endif; ?>
                                        <td data-label="Actions">
                                            <?php if($g->custom=='Yes'): ?>
                                                <a class="btn btn-success btn-xs" href="<?php echo e(url('sms/custom-gateway-manage/'.$g->id)); ?>"><i class="fa fa-edit"></i> <?php echo e(language_data('Manage')); ?></a>
                                                <a href="#" class="btn btn-danger btn-xs cdelete" id="<?php echo e($g->id); ?>"><i class="fa fa-trash"></i> <?php echo e(language_data('Delete')); ?></a>
                                            <?php else: ?>
                                                <a class="btn btn-success btn-xs" href="<?php echo e(url('sms/gateway-manage/'.$g->id)); ?>"><i class="fa fa-edit"></i> <?php echo e(language_data('Manage')); ?></a>
                                            <?php endif; ?>

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

    <?php echo Html::script("assets/js/bootbox.min.js"); ?>


    <script>
        $(document).ready(function(){
            $('.data-table').DataTable();

            /*For Delete Gateway*/
            $( "body" ).delegate( ".cdelete", "click",function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/sms/delete-sms-gateway/" + id;
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>