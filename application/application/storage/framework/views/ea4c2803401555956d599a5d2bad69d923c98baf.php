<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Add New Client')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Add New Client')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('clients/post-new-client')); ?>" enctype="multipart/form-data">
                                <?php echo e(csrf_field()); ?>



                                <div class="form-group">
                                    <label><?php echo e(language_data('First Name')); ?></label>
                                    <input type="text" class="form-control" required name="first_name">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Last Name')); ?></label>
                                    <input type="text" class="form-control" name="last_name">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Company')); ?></label>
                                    <input type="text" class="form-control" name="company">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Website')); ?></label>
                                    <input type="url" class="form-control" name="website">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Email')); ?></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('User name')); ?></label>
                                    <input type="text" class="form-control" required name="user_name">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Password')); ?></label>
                                    <input type="password" class="form-control" required name="password">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Confirm Password')); ?></label>
                                    <input type="password" class="form-control" required name="cpassword">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Phone')); ?></label>
                                    <input type="text" class="form-control" required name="phone">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Address')); ?></label>
                                    <input type="text" class="form-control" name="address">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('More Address')); ?></label>
                                    <input type="text" class="form-control" name="more_address">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('State')); ?></label>
                                    <input type="text" class="form-control" name="state">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('City')); ?></label>
                                    <input type="text" class="form-control" name="city">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Postcode')); ?></label>
                                    <input type="text" class="form-control" name="postcode">
                                </div>

                                <div class="form-group">
                                    <label for="Country"><?php echo e(language_data('Country')); ?></label>
                                    <select name="country" class="form-control selectpicker" data-live-search="true">
                                        <?php echo countries(app_config('Country')); ?>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Reseller Panel')); ?></label>
                                    <select class="selectpicker form-control" name="reseller_panel">
                                        <option value="Yes"><?php echo e(language_data('Yes')); ?></option>
                                        <option value="No"><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Api Access')); ?></label>
                                    <select class="selectpicker form-control" name="api_access">
                                        <option value="Yes"><?php echo e(language_data('Yes')); ?></option>
                                        <option value="No"><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Client Group')); ?></label>
                                    <select class="selectpicker form-control" name="client_group"  data-live-search="true">
                                        <option value="0"><?php echo e(language_data('None')); ?></option>
                                        <?php $__currentLoopData = $clientGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cg->id); ?>"><?php echo e($cg->group_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('SMS Gateway')); ?></label>
                                    <select class="selectpicker form-control" name="sms_gateway"  data-live-search="true">
                                        <?php $__currentLoopData = $sms_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sg->id); ?>"><?php echo e($sg->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('SMS Limit')); ?></label>
                                    <input type="text" class="form-control" name="sms_limit" required>
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

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" checked="" value="yes" name="email_notify">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Notify Client with email')); ?></label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> <?php echo e(language_data('Add')); ?> </button>
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