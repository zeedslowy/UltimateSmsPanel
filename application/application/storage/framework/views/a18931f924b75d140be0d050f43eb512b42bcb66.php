<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('SMS Gateway Manage')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('SMS Gateway Manage')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('sms/post-manage-sms-gateway')); ?>">
                                <?php echo e(csrf_field()); ?>


                                <?php if($gateway->custom=='Yes'): ?>
                                    <div class="form-group">
                                        <label><?php echo e(language_data('Gateway Name')); ?></label>
                                        <input type="text" class="form-control" required name="gateway_name" value="<?php echo e($gateway->name); ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="form-group">
                                        <label><?php echo e(language_data('Gateway Name')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($gateway->name); ?>" disabled>
                                    </div>
                                <?php endif; ?>

                                <?php if($gateway->name!='Twilio' && $gateway->name!='Zang' && $gateway->name!='Plivo' && $gateway->name!='AmazonSNS' && $gateway->name!='TeleSign' && $gateway->name!='BSG'): ?>
                                    <div class="form-group">
                                        <label><?php echo e(language_data('Gateway API Link')); ?></label>
                                        <input type="text" class="form-control" required name="gateway_link" value="<?php echo e($gateway->api_link); ?>">
                                    </div>
                                <?php endif; ?>


                                <div class="form-group">
                                    <label>
                                        <?php if($gateway->name=='Telenorcsms'): ?>
                                            <?php echo e(language_data('Msisdn')); ?>

                                        <?php elseif($gateway->name=='Twilio' || $gateway->name=='Zang'): ?>
                                            <?php echo e(language_data('Account Sid')); ?>

                                        <?php elseif($gateway->name=='Plivo'): ?>
                                            <?php echo e(language_data('Auth ID')); ?>

                                        <?php elseif($gateway->name=='Wavecell'): ?>
                                           Sub Account ID
                                        <?php elseif($gateway->name=='Skebby'): ?>
                                            User Key
                                        <?php elseif($gateway->name=='Ovh'): ?>
                                            APP Key
                                        <?php elseif($gateway->name=='MessageBird' || $gateway->name=='AmazonSNS'): ?>
                                            Access Key
                                        <?php elseif($gateway->name=='Clickatell' || $gateway->name=='ViralThrob' || $gateway->name=='CNIDCOM' || $gateway->name=='SmsBump' || $gateway->name=='BSG'): ?>
                                            API Key
                                        <?php elseif($gateway->name=='Semysms' || $gateway->name=='Tropo'): ?>
                                            User Token
                                        <?php elseif($gateway->name=='SendOut'): ?>
                                            Phone Number
                                        <?php elseif($gateway->name=='Dialog'): ?>
                                            API Password
                                        <?php elseif($gateway->name=='LightSMS'): ?>
                                            Login
                                        <?php elseif($gateway->name=='CheapSMS'): ?>
                                            Login ID
                                        <?php elseif($gateway->name=='TxtNation'): ?>
                                            Company
                                        <?php else: ?>
                                            <?php echo e(language_data('SMS Api User name')); ?>

                                        <?php endif; ?>
                                    </label>
                                    <input type="text" class="form-control" name="gateway_user_name" value="<?php echo e($gateway->username); ?>">
                                </div>

                                <?php if($gateway->name!='MessageBird' && $gateway->name!='Clickatell' && $gateway->name!='Dialog' && $gateway->name!='Tropo' && $gateway->name!='SmsBump' && $gateway->name!='BSG'): ?>
                                <div class="form-group">
                                    <label>
                                        <?php if($gateway->name=='Twilio' || $gateway->name=='Zang' || $gateway->name=='Plivo'): ?>
                                            <?php echo e(language_data('Auth Token')); ?>

                                        <?php elseif($gateway->name=='SMSKaufen' || $gateway->name=='NibsSMS' || $gateway->name=='LightSMS' || $gateway->name=='Wavecell'): ?>
                                            <?php echo e(language_data('SMS Api key')); ?>

                                        <?php elseif($gateway->name=='Semysms'): ?>
                                            Device ID
                                        <?php elseif($gateway->name=='SendOut'): ?>
                                            API Token
                                        <?php elseif($gateway->name=='Skebby'): ?>
                                            Access Token
                                        <?php elseif($gateway->name=='Ovh'  || $gateway->name=='CNIDCOM'): ?>
                                            APP Secret
                                        <?php elseif($gateway->name=='AmazonSNS'): ?>
                                            Secret Access Key
                                        <?php elseif($gateway->name=='ViralThrob'): ?>
                                            SaaS Account
                                        <?php elseif($gateway->name=='TxtNation'): ?>
                                            eKey
                                        <?php else: ?>
                                            <?php echo e(language_data('SMS Api Password')); ?>

                                        <?php endif; ?>
                                    </label>
                                    <input type="text" class="form-control" name="gateway_password" value="<?php echo e($gateway->password); ?>">
                                </div>
                                <?php endif; ?>

                                <?php if($gateway->custom=='Yes' || $gateway->name=='SmsGatewayMe'  || $gateway->name=='Asterisk' || $gateway->name=='GlobexCam' || $gateway->name=='Ovh' || $gateway->name=='1s2u' || $gateway->name=='SMSPRO' || $gateway->name=='DigitalReach' || $gateway->name=='AmazonSNS' || $gateway->name=='ExpertTexting' || $gateway->name=='JasminSMS' || $gateway->type=='smpp'): ?>
                                <div class="form-group">
                                    <?php if($gateway->name=='SmsGatewayMe'): ?>
                                        <label>Device ID</label>
                                    <?php elseif($gateway->name=='Asterisk' || $gateway->name=='JasminSMS' || $gateway->type=='smpp'): ?>
                                        <label>Port</label>
                                    <?php elseif($gateway->name=='GlobexCam'): ?>
                                        <label><?php echo e(language_data('SMS Api key')); ?></label>
                                    <?php elseif($gateway->name=='Ovh'): ?>
                                        <label>Consumer Key</label>
                                    <?php elseif($gateway->name=='1s2u'): ?>
                                        <label>IPCL</label>
                                    <?php elseif($gateway->name=='SMSPRO'): ?>
                                        <label>Customer ID</label>
                                    <?php elseif($gateway->name=='DigitalReach'): ?>
                                        <label>MT Port</label>
                                    <?php elseif($gateway->name=='AmazonSNS'): ?>
                                        <label>Region</label>
                                    <?php elseif($gateway->name=='ExpertTexting'): ?>
                                        <label> <?php echo e(language_data('SMS Api key')); ?></label>
                                    <?php else: ?>
                                        <label><?php echo e(language_data('Extra Value')); ?></label>
                                    <?php endif; ?>
                                    <input type="text" class="form-control" name="extra_value" value="<?php echo e($gateway->api_id); ?>">
                                </div>
                                <?php endif; ?>

                                <?php if($gateway->name=='Asterisk' ): ?>
                                <div class="form-group">
                                    <label>Device Name</label>
                                    <input type="text" class="form-control" name="device_name" value="<?php echo e(env('SC_DEVICE')); ?>">
                                </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Schedule SMS')); ?></label>
                                    <select class="selectpicker form-control" name="schedule">
                                        <option value="Yes" <?php if($gateway->schedule=='Yes'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                        <option value="No" <?php if($gateway->schedule=='No'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Status')); ?></label>
                                    <select class="selectpicker form-control" name="status">
                                        <option value="Active"  <?php if($gateway->status=='Active'): ?> selected <?php endif; ?>><?php echo e(language_data('Active')); ?></option>
                                        <option value="Inactive"  <?php if($gateway->status=='Inactive'): ?> selected <?php endif; ?>><?php echo e(language_data('Inactive')); ?></option>
                                    </select>
                                </div>

                                <input type="hidden" value="<?php echo e($gateway->id); ?>" name="cmd">
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