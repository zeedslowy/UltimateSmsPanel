<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30 clearfix">
            <h2 class="page-title inline-block"><?php echo e(language_data('All')); ?> <?php echo e(language_data('Sender ID')); ?></h2>
            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#request-new-sender"><i class="fa fa-plus"></i> <?php echo e(language_data('Request New Sender ID')); ?></button>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('All')); ?> <?php echo e(language_data('Sender ID')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 20%;"><?php echo e(language_data('SL')); ?>#</th>
                                    <th style="width: 60%;"><?php echo e(language_data('Sender ID')); ?></th>
                                    <th style="width: 20%;"><?php echo e(language_data('Status')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $sender_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="SL"><?php echo e($loop->iteration); ?></td>
                                        <td data-label="Sender ID"><p><?php echo e($si->sender_id); ?></p></td>

                                        <?php if($si->status=='unblock'): ?>
                                            <td data-label="Status"><p class="label label-success"><?php echo e(language_data('Unblock')); ?></p></td>
                                        <?php elseif($si->status=='block'): ?>
                                            <td data-label="Status"><p class="label label-danger"><?php echo e(language_data('Block')); ?></p></td>
                                        <?php else: ?>
                                            <td data-label="Status"><p class="label label-warning"><?php echo e(language_data('Pending')); ?></p></td>
                                        <?php endif; ?>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="request-new-sender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo e(language_data('Request New Sender ID')); ?></h4>
                        </div>
                        <form class="form-some-up" role="form" method="post" action="<?php echo e(url('user/sms/post-sender-id')); ?>">

                            <div class="modal-body">
                                <div class="form-group">
                                    <label><?php echo e(language_data('Sender ID')); ?></label>
                                    <input type="text" class="form-control" required="" name="sender_id">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> <?php echo e(language_data('Close')); ?> </button>
                                <button type="submit" class="btn btn-primary"> <?php echo e(language_data('Send')); ?> </button>
                            </div>
                        </form>
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
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>