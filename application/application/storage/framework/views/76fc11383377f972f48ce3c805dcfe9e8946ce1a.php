<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Support Department')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-4">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Support Department')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="<?php echo e(url('support-tickets/post-department')); ?>">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <div class="form-group">
                                    <label for="dname"><?php echo e(language_data('Department Name')); ?></label>
                                    <input type="text" class="form-control" id="dname" name="dname">
                                </div>

                                <div class="form-group">
                                    <label for="email"><?php echo e(language_data('Department Email')); ?></label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>

                                <div class="form-group">
                                    <label for="show"><?php echo e(language_data('Show In Client')); ?></label>
                                    <select name="show" class="selectpicker form-control">
                                        <option value="Yes"><?php echo e(language_data('Yes')); ?></option>
                                        <option value="No"><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <button type="submit" name="add" class="btn btn-success"><i class="fa fa-plus"></i> <?php echo e(language_data('Add New')); ?></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Support Department')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(language_data('Department Name')); ?></th>
                                    <th><?php echo e(language_data('Email')); ?></th>
                                    <th><?php echo e(language_data('Show In Client')); ?></th>
                                    <th class="text-right" width="25%"><?php echo e(language_data('Manage')); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $__currentLoopData = $sd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?> </td>
                                        <td><a href="<?php echo e(url('support-tickets/view-department/'.$in->id)); ?>"><?php echo e($in->name); ?></a> </td>
                                        <td><?php echo e($in->email); ?></td>
                                        <td>
                                            <?php if($in->show=='No'): ?>
                                                <span class="label label-danger"><?php echo e(language_data('No')); ?></span>
                                            <?php else: ?>
                                                <span class="label label-success"><?php echo e(language_data('Yes')); ?></span>
                                            <?php endif; ?>

                                        </td>

                                        <td class="text-right">
                                            <a href="<?php echo e(url('support-tickets/view-department/'.$in->id)); ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo e(language_data('View')); ?></a>
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
        });

        $( "body" ).delegate( ".cdelete", "click",function (e) {
            e.preventDefault();
            var id = this.id;
            bootbox.confirm("Are you sure?", function(result) {
                if(result){
                    var _url = $("#_url").val();
                    window.location.href = _url + "/support-tickets/delete-department/" + id;
                }
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>