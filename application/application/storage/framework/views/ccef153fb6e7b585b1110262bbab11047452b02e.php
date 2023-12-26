<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e($admin_roles->role_name); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"> <?php echo e(language_data('Set Rules')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" action="<?php echo e(url('administrators/update-admin-set-roles')); ?>" method="post">
                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" id="select_all"/>
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Check All')); ?></label>
                                    </div>
                                </div>

                                <div class="hr-dotted"></div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,1)): ?> checked <?php endif; ?> name="perms[]" value="1">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Dashboard')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,2)): ?> checked <?php endif; ?> name="perms[]" value="2">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('All Clients')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,3)): ?> checked <?php endif; ?> name="perms[]" value="3">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Add New Client')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,4)): ?> checked <?php endif; ?> name="perms[]" value="4">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Manage')); ?> <?php echo e(language_data('Client')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,5)): ?> checked <?php endif; ?> name="perms[]" value="5">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Export and Import Clients')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,6)): ?> checked <?php endif; ?> name="perms[]" value="6">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Client Group')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,7)): ?> checked <?php endif; ?> name="perms[]" value="7">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Edit')); ?> <?php echo e(language_data('Client Group')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,8)): ?> checked <?php endif; ?> name="perms[]" value="8">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('All Invoices')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,9)): ?> checked <?php endif; ?> name="perms[]" value="9">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Recurring')); ?> <?php echo e(language_data('Invoices')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,10)): ?> checked <?php endif; ?> name="perms[]" value="10">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Manage')); ?> <?php echo e(language_data('Invoices')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,11)): ?> checked <?php endif; ?> name="perms[]" value="11">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Add New Invoice')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,12)): ?> checked <?php endif; ?> name="perms[]" value="12">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Send Bulk SMS')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,13)): ?> checked <?php endif; ?> name="perms[]" value="13">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Send SMS From File')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,14)): ?> checked <?php endif; ?> name="perms[]" value="14">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Send')); ?> <?php echo e(language_data('Schedule SMS')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,15)): ?> checked <?php endif; ?> name="perms[]" value="15">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Schedule SMS From File')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,16)): ?> checked <?php endif; ?> name="perms[]" value="16">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('SMS History')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,17)): ?> checked <?php endif; ?> name="perms[]" value="17">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('SMS Gateway')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,18)): ?> checked <?php endif; ?> name="perms[]" value="18">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Add SMS Gateway')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,19)): ?> checked <?php endif; ?> name="perms[]" value="19">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Manage')); ?> <?php echo e(language_data('SMS Gateway')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,20)): ?> checked <?php endif; ?> name="perms[]" value="20">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('SMS Price Plan')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,21)): ?> checked <?php endif; ?> name="perms[]" value="21">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Add Price Plan')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,22)): ?> checked <?php endif; ?> name="perms[]" value="22">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Coverage')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,23)): ?> checked <?php endif; ?> name="perms[]" value="23">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Sender ID Management')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,24)): ?> checked <?php endif; ?> name="perms[]" value="24">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('SMS Templates')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,25)): ?> checked <?php endif; ?> name="perms[]" value="25">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('SMS API')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,26)): ?> checked <?php endif; ?> name="perms[]" value="26">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Support Tickets')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,27)): ?> checked <?php endif; ?> name="perms[]" value="27">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Create New Ticket')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,28)): ?> checked <?php endif; ?> name="perms[]" value="28">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Manage')); ?> <?php echo e(language_data('Support Tickets')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,29)): ?> checked <?php endif; ?> name="perms[]" value="29">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Support Department')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,30)): ?> checked <?php endif; ?> name="perms[]" value="30">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Administrators')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,31)): ?> checked <?php endif; ?> name="perms[]" value="31">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Administrator Roles')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,32)): ?> checked <?php endif; ?> name="perms[]" value="32">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('System Settings')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,33)): ?> checked <?php endif; ?> name="perms[]" value="33">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Localization')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,34)): ?> checked <?php endif; ?> name="perms[]" value="34">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Email Templates')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,35)): ?> checked <?php endif; ?> name="perms[]" value="35">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Language Settings')); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,36)): ?> checked <?php endif; ?> name="perms[]" value="36">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Payment Gateways')); ?></label>
                                    </div>
                                </div>

                                
                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" <?php if(permission($admin_roles->id,37)): ?> checked <?php endif; ?> name="perms[]" value="37">
                                        <span class="co-check-ui"></span>
                                        <label><?php echo e(language_data('Send SMS')); ?></label>
                                    </div>
                                </div>


                                <input type="hidden" value="<?php echo e($admin_roles->id); ?>" name="role_id">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
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


    <script>
        $("#select_all").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>