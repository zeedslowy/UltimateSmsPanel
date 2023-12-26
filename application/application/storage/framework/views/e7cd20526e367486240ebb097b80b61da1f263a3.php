<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Manage Administrator')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Manage Administrator')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('administrators/post-update-admin')); ?>" enctype="multipart/form-data">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <label><?php echo e(language_data('First Name')); ?></label>
                                    <input type="text" class="form-control" required name="first_name" value="<?php echo e($admin->fname); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Last Name')); ?></label>
                                    <input type="text" class="form-control" name="last_name" value="<?php echo e($admin->lname); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('User Name')); ?></label>
                                    <input type="text" class="form-control" required name="username"  value="<?php echo e($admin->username); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Email')); ?></label>
                                    <input type="email" class="form-control" required name="email"  value="<?php echo e($admin->email); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Password')); ?></label>
                                    <input type="password" class="form-control"  name="password">
                                    <span class="help"><?php echo e(language_data('Leave blank if you do not change')); ?></span>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Confirm Password')); ?></label>
                                    <input type="text" class="form-control"  name="cpassword">
                                    <span class="help"><?php echo e(language_data('Leave blank if you do not change')); ?></span>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Role')); ?></label>
                                    <select class="selectpicker form-control" name="role" data-live-search="true">
                                        <?php $__currentLoopData = $admin_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($ar->id); ?>" <?php if($ar->id == $admin->roleid): ?> selected <?php endif; ?>><?php echo e($ar->role_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Status')); ?></label>
                                    <select class="selectpicker form-control" name="status">
                                        <option value="Active" <?php if($admin->status=='Active'): ?> selected <?php endif; ?>><?php echo e(language_data('Active')); ?></option>
                                        <option value="Inactive" <?php if($admin->status=='Inactive'): ?> selected <?php endif; ?>><?php echo e(language_data('Inactive')); ?></option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Avatar')); ?></label>
                                    <div class="form-group input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="image" accept="image/*">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly="">
                                    </div>
                                </div>

                                <input type="hidden" name="cmd" value="<?php echo e($admin->id); ?>">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> <?php echo e(language_data('Update')); ?> </button>
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