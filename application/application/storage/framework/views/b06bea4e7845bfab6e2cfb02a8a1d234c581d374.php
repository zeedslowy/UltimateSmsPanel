<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('SMS Price Plan')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('SMS Price Plan')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10%;"><?php echo e(language_data('SL')); ?>#</th>
                                    <th style="width: 35%;"><?php echo e(language_data('Plan Name')); ?></th>
                                    <th style="width: 15%;"><?php echo e(language_data('Price')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Popular')); ?></th>
                                    <th style="width: 30%;"><?php echo e(language_data('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $price_plan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="SL"><?php echo e($loop->iteration); ?></td>
                                        <td data-label="Plan Name"><p><?php echo e($pp->plan_name); ?></p></td>
                                        <td data-label="Price"><p><?php echo e(app_config('CurrencyCode')); ?> <?php echo e($pp->price); ?></p></td>
                                        <?php if($pp->popular=='Yes'): ?>
                                            <td data-label="Popular"><p class="label label-success label-xs"><?php echo e(language_data('Yes')); ?></p></td>
                                        <?php else: ?>
                                            <td data-label="Popular"><p class="label label-primary label-xs"><?php echo e(language_data('No')); ?></p></td>
                                        <?php endif; ?>
                                        <td data-label="Actions">
                                            <a class="btn btn-success btn-xs" href="<?php echo e(url('user/sms/sms-plan-feature/'.$pp->id)); ?>" ><i class="fa fa-eye"></i> <?php echo e(language_data('View Features')); ?></a>
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


            /*For Delete Price Plan*/
            $( "body" ).delegate( ".cdelete", "click",function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/sms/delete-price-plan/" + id;
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>