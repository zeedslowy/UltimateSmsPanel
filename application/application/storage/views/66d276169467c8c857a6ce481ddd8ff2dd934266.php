<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('All Invoices')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('All Invoices')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 15%;"><?php echo e(language_data('Client Name')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Amount')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Invoice Date')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Due Date')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Status')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Type')); ?></th>
                                    <th style="width: 30%;"><?php echo e(language_data('Manage')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><a href="<?php echo e(url('clients/view/'.$in->cl_id)); ?>"><?php echo e($in->client_name); ?></a></td>
                                        <td><?php echo e($in->total); ?></td>
                                        <td><?php echo e(get_date_format($in->created)); ?></td>
                                        <td><?php echo e(get_date_format($in->duedate)); ?></td>
                                        <td>
                                            <?php if($in->status=='Unpaid'): ?>
                                                <span class="label label-warning"><?php echo e(language_data('Unpaid')); ?></span>
                                            <?php elseif($in->status=='Paid'): ?>
                                                <span class="label label-success"><?php echo e(language_data('Paid')); ?></span>
                                            <?php elseif($in->status=='Cancelled'): ?>
                                                <span class="label label-danger"><?php echo e(language_data('Cancelled')); ?></span>
                                            <?php else: ?>
                                                <span class="label label-info"><?php echo e(language_data('Partially Paid')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($in->recurring=='0'): ?>
                                                <span class="label label-success"> <?php echo e(language_data('Onetime')); ?></span>
                                            <?php else: ?>
                                                <span class="label label-info"> <?php echo e(language_data('Recurring')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($in->recurring!=0): ?>
                                                <a href="#" class="btn btn-warning btn-xs stop-recurring" id="<?php echo e($in->id); ?>"><i class="fa fa-stop"></i> <?php echo e(language_data('Stop Recurring')); ?></a>
                                            <?php endif; ?>
                                            <a href="<?php echo e(url('invoices/view/'.$in->id)); ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo e(language_data('View')); ?></a>
                                            <a href="<?php echo e(url('invoices/edit/'.$in->id)); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> <?php echo e(language_data('Edit')); ?></a>
                                            <a href="#" class="btn btn-danger btn-xs cdelete" id="<?php echo e($in->id); ?>"><i class="fa fa-trash"></i> <?php echo e(language_data('Delete')); ?></a>
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


            /*For Delete Invoice*/
            $( "body" ).delegate( ".cdelete", "click",function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/invoices/delete-invoice/" + id;
                    }
                });
            });
            /*For Delete Designation*/
            $(".stop-recurring").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/invoices/stop-recurring-invoice/" + id;
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>