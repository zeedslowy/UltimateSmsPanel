<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Support Tickets')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Support Tickets')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(language_data('Client Name')); ?></th>
                                    <th><?php echo e(language_data('Email')); ?></th>
                                    <th><?php echo e(language_data('Subject')); ?></th>
                                    <th><?php echo e(language_data('Date')); ?></th>
                                    <th><?php echo e(language_data('Status')); ?></th>
                                    <th class="text-right" width="20%"><?php echo e(language_data('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $__currentLoopData = $st; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?> </td>
                                        <td><?php echo e($in->name); ?></td>
                                        <td><?php echo e($in->email); ?></td>
                                        <td><?php echo e($in->subject); ?></td>
                                        <td><?php echo e(get_date_format($in->date)); ?></td>
                                        <td>
                                            <?php if($in->status=='Pending'): ?>
                                                <span class="label label-danger"><?php echo e(language_data('Pending')); ?></span>
                                            <?php elseif($in->status=='Answered'): ?>
                                                <span class="label label-success"><?php echo e(language_data('Answered')); ?></span>
                                            <?php elseif($in->status=='Customer Reply'): ?>
                                                <span class="label label-info"><?php echo e(language_data('Customer Reply')); ?></span>
                                            <?php else: ?>
                                                <span class="label label-primary"><?php echo e(language_data('Closed')); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-right">
                                            <a href="<?php echo e(url('support-tickets/view-ticket/'.$in->id)); ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo e(language_data('View')); ?></a>
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
        $(document).ready(function () {

            /*For DataTable*/
            $('.data-table').DataTable();

            /*For Delete Support Tickets*/

            $( "body" ).delegate( ".cdelete", "click",function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function(result) {
                    if(result){
                        var _url = $("#_url").val();
                        window.location.href = _url + "/support-tickets/delete-ticket/" + id;
                    }
                });
            });

        });
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>