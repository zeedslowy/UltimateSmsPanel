<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Client Group')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-4">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Add New Group')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('clients/add-new-group')); ?>">
                                <div class="form-group">
                                    <label><?php echo e(language_data('Group Name')); ?></label>
                                    <input type="text" class="form-control" required name="group_name">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Status')); ?></label>
                                    <select class="selectpicker form-control" name="status">
                                        <option value="Yes"><?php echo e(language_data('Active')); ?></option>
                                        <option value="No"><?php echo e(language_data('Inactive')); ?></option>
                                    </select>
                                </div>

                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> <?php echo e(language_data('Add')); ?> </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Client Group')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 5%;"><?php echo e(language_data('SL')); ?>#</th>
                                    <th style="width: 20%;"><?php echo e(language_data('Group Name')); ?></th>
                                    <th style="width: 25%;"><?php echo e(language_data('Created By')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Status')); ?></th>
                                    <th style="width: 40%;"><?php echo e(language_data('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $clientGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="SL"><?php echo e($loop->iteration); ?></td>
                                        <td data-label="Name"><p><?php echo e($cg->group_name); ?> </p></td>
                                        <?php if($cg->created_by=='0'): ?>
                                            <td data-label="Created By"><p><?php echo e(language_data('Admin')); ?></p></td>
                                        <?php else: ?>
                                            <td data-label="Created By"><p><a href="<?php echo e(url('clients/view/'.$cg->created_by)); ?>"><?php echo e(client_info($cg->created_by)->fname); ?></a> </p></td>
                                        <?php endif; ?>
                                        <?php if($cg->status=='Yes'): ?>
                                            <td data-label="Status"><p class="btn btn-success btn-xs"><?php echo e(language_data('Active')); ?></p></td>
                                        <?php else: ?>
                                            <td data-label="Status"><p class="btn btn-warning btn-xs"><?php echo e(language_data('Inactive')); ?></p></td>
                                        <?php endif; ?>
                                        <td data-label="Actions">
                                            <a href="<?php echo e(url('clients/export-client-group/'.$cg->id)); ?>" class="btn btn-complete btn-xs"><i class="fa fa-upload"></i> <?php echo e(language_data('Export Clients')); ?></a>
                                            <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_client_group_<?php echo e($cg->id); ?>"><i class="fa fa-edit"></i> <?php echo e(language_data('Edit')); ?></a>
                                            <?php echo $__env->make('admin.modal-edit-client-group', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <a href="#" class="btn btn-danger btn-xs cdelete" id="<?php echo e($cg->id); ?>"><i class="fa fa-trash"></i> <?php echo e(language_data('Delete')); ?></a>
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


            /*For Delete Group*/
            $( "body" ).delegate( ".cdelete", "click",function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/clients/delete-group/" + id;
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>