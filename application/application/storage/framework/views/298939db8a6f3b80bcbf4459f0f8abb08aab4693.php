<div class="modal fade modal_edit_administrator_roles_<?php echo e($er->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo e(language_data('Edit Administrator Role')); ?></h4>
            </div>
            <form class="form-some-up form-block" role="form" action="<?php echo e(url('administrators/update-role')); ?>" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label><?php echo e(language_data('Role Name')); ?> :</label>
                        <input type="text" class="form-control" required="" name="role_name" value="<?php echo e($er->role_name); ?>">
                    </div>

                    <br>
                    <br>
                    <div class="form-group">
                        <label><?php echo e(language_data('Status')); ?> :</label>
                        <select class="selectpicker form-control" name="status">
                            <option value="Active" <?php if($er->status=='Active'): ?> selected <?php endif; ?> ><?php echo e(language_data('Active')); ?></option>
                            <option value="Inactive" <?php if($er->status=='Inactive'): ?> selected <?php endif; ?> ><?php echo e(language_data('Inactive')); ?></option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="cmd" value="<?php echo e($er->id); ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(language_data('Close')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(language_data('Update')); ?></button>
                </div>

            </form>
        </div>
    </div>

</div>

