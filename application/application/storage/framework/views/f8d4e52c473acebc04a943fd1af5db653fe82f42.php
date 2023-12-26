<div class="modal fade modal_edit_client_group_<?php echo e($cg->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo e(language_data('Edit')); ?> <?php echo e(language_data('Client Group')); ?></h4>
            </div>
            <form class="form-some-up form-block" role="form" action="<?php echo e(url('clients/update-group')); ?>" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label><?php echo e(language_data('Group Name')); ?> :</label>
                        <input type="text" class="form-control" required="" name="group_name" value="<?php echo e($cg->group_name); ?>">
                    </div>
                    <br>
                    <div class="form-group">
                        <label><?php echo e(language_data('Status')); ?> :</label>
                        <select class="selectpicker form-control" name="status">
                            <option value="Yes" <?php if($cg->status=='Yes'): ?> selected <?php endif; ?>><?php echo e(language_data('Active')); ?></option>
                            <option value="No" <?php if($cg->status=='No'): ?> selected <?php endif; ?>><?php echo e(language_data('Inactive')); ?></option>
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="cmd" value="<?php echo e($cg->id); ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(language_data('Close')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(language_data('Update')); ?></button>
                </div>

            </form>
        </div>
    </div>

</div>

