<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('View Profile')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body p-t-20">
                            <div class="clearfix">
                                <div class="pull-left m-r-30">
                                    <div class="thumbnail m-b-none">
                                        <?php if($client->image!=''): ?>
                                            <img src="<?php echo asset('assets/client_pic/' . $client->image); ?>" alt="<?php echo e($client->fname); ?> <?php echo e($client->lname); ?>" height="150px" width="150px">
                                        <?php else: ?>
                                            <img src="<?php echo asset('assets/client_pic/profile.jpg'); ?>" alt="<?php echo e($client->fname); ?> <?php echo e($client->lname); ?>" height="150px" width="150px">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="pull-left">
                                    <h3 class="bold font-color-1"><?php echo e($client->fname); ?> <?php echo e($client->lname); ?></h3>
                                    <ul class="info-list">
                                        <?php if($client->email!=''): ?>
                                            <li>
                                                <span class="info-list-title"><?php echo e(language_data('Email')); ?></span><span class="info-list-des"><?php echo e($client->email); ?></span>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <span class="info-list-title"><?php echo e(language_data('Phone')); ?></span><span class="info-list-des"><?php echo e($client->phone); ?></span>
                                        </li>
                                        <li>
                                            <span class="info-list-title"><?php echo e(language_data('Location')); ?></span><span class="info-list-des"><?php echo e($client->address1); ?> <?php echo e($client->address2); ?> <?php echo e($client->state); ?> <?php echo e($client->city); ?> - <?php echo e($client->postcode); ?> <?php echo e($client->country); ?></span>
                                        </li>
                                        <li>
                                            <span class="info-list-title"><?php echo e(language_data('SMS Balance')); ?></span><span class="info-list-des"><?php echo e($client->sms_limit); ?></span>
                                        </li>
                                        <li>
                                            <span class="info-list-title"><?php echo e(language_data('SMS Gateway')); ?></span><span class="info-list-des"><?php echo e($client->get_sms_gateway->name); ?></span>
                                        </li>
                                    </ul>

                                    <a href="#" data-toggle="modal" data-target=".modal_send_sms_<?php echo e($client->id); ?>" class="btn btn-success btn-sm"><i class="fa fa-mobile-phone"></i> <?php echo e(language_data('Send SMS')); ?></a>
                                    <a href="#" data-toggle="modal" data-target=".modal_update_limit_<?php echo e($client->id); ?>" class="btn btn-primary btn-sm"><i class="fa fa-exchange"></i> <?php echo e(language_data('Update Limit')); ?></a>
                                    <a href="#" data-toggle="modal" data-target=".modal_change_image_<?php echo e($client->id); ?>" class="btn btn-complete btn-sm change-image"><i class="fa fa-image"></i> <?php echo e(language_data('Change Image')); ?></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="p-30 p-t-none p-b-none">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#edit-profile" aria-controls="home" role="tab" data-toggle="tab"><?php echo e(language_data('Edit Profile')); ?></a></li>
                        <li role="presentation"><a href="#tickets" aria-controls="tickets" role="tab" data-toggle="tab"><?php echo e(language_data('Support Tickets')); ?></a></li>
                        <li role="presentation"><a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab"><?php echo e(language_data('Invoices')); ?></a></li>
                        <li role="presentation"><a href="#sms-transaction" aria-controls="sms-transaction" role="tab" data-toggle="tab"><?php echo e(language_data('SMS Transaction')); ?></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content panel p-20">
                        <div role="tabpanel" class="tab-pane active" id="edit-profile">
                            <form role="form" action="<?php echo e(url('clients/update-client-post')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label><?php echo e(language_data('First Name')); ?></label>
                                            <input type="text" class="form-control" required="" name="first_name" value="<?php echo e($client->fname); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Last Name')); ?></label>
                                            <input type="text" class="form-control" name="last_name"  value="<?php echo e($client->lname); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Company')); ?></label>
                                            <input type="text" class="form-control" name="company" value="<?php echo e($client->company); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Website')); ?></label>
                                            <input type="url" class="form-control" name="website" value="<?php echo e($client->website); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Client Group')); ?></label>
                                            <select class="selectpicker form-control" name="client_group"  data-live-search="true">
                                                <option value="0" <?php if($client->groupid==0): ?> selected <?php endif; ?>><?php echo e(language_data('None')); ?></option>
                                                <?php $__currentLoopData = $clientGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($cg->id); ?>"  <?php if($client->groupid==$cg->id): ?> selected <?php endif; ?>><?php echo e($cg->group_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('SMS Gateway')); ?></label>
                                            <select class="selectpicker form-control" name="sms_gateway"  data-live-search="true">
                                                <?php $__currentLoopData = $sms_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($sg->id); ?>" <?php if($client->sms_gateway==$sg->id): ?> selected <?php endif; ?>><?php echo e($sg->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Reseller Panel')); ?></label>
                                            <select class="selectpicker form-control" name="reseller_panel">
                                                <option value="Yes" <?php if($client->reseller=='Yes'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                                <option value="No" <?php if($client->reseller=='No'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                            </select>
                                        </div>


                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Address')); ?></label>
                                            <input type="text" class="form-control" name="address" value="<?php echo e($client->address1); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('More Address')); ?></label>
                                            <input type="text" class="form-control" name="more_address"  value="<?php echo e($client->address2); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('State')); ?></label>
                                            <input type="text" class="form-control" name="state"  value="<?php echo e($client->state); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('City')); ?></label>
                                            <input type="text" class="form-control" name="city"  value="<?php echo e($client->city); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Postcode')); ?></label>
                                            <input type="text" class="form-control" name="postcode"  value="<?php echo e($client->postcode); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="Country"><?php echo e(language_data('Country')); ?></label>
                                            <select name="country" class="form-control selectpicker" data-live-search="true">
                                                <?php echo countries($client->country); ?>

                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo e(language_data('Email')); ?></label>
                                            <input type="email" class="form-control" required name="email" value="<?php echo e($client->email); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('User Name')); ?></label>
                                            <input type="text" class="form-control" required name="user_name" value="<?php echo e($client->username); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Password')); ?></label> <span class="help"><?php echo e(language_data('Leave blank if you do not change')); ?></span>
                                            <input type="password" class="form-control" name="password">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Phone')); ?></label>
                                            <input type="text" class="form-control" required name="phone" value="<?php echo e($client->phone); ?>">
                                        </div>


                                        <div class="form-group">
                                            <label><?php echo e(language_data('Api Access')); ?></label>
                                            <select class="selectpicker form-control" name="api_access">
                                                <option value="Yes" <?php if($client->api_access=='Yes'): ?> selected <?php endif; ?>><?php echo e(language_data('Yes')); ?></option>
                                                <option value="No" <?php if($client->api_access=='No'): ?> selected <?php endif; ?>><?php echo e(language_data('No')); ?></option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Status')); ?></label>
                                            <select class="selectpicker form-control" name="status">
                                                <option value="Active" <?php if($client->status=='Active'): ?> selected <?php endif; ?>><?php echo e(language_data('Active')); ?></option>
                                                <option value="Inactive" <?php if($client->status=='Inactive'): ?> selected <?php endif; ?>><?php echo e(language_data('Inactive')); ?></option>
                                                <option value="Closed" <?php if($client->status=='Closed'): ?> selected <?php endif; ?>><?php echo e(language_data('Closed')); ?></option>
                                            </select>
                                        </div>


                                    </div>

                                    <div class="col-md-12">
                                        <input type="hidden" value="<?php echo e($client->id); ?>" name="cmd">
                                        <input type="submit" value="<?php echo e(language_data('Update')); ?>" class="btn btn-primary">
                                    </div>
                                </div>


                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="tickets">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(language_data('Subject')); ?></th>
                                    <th><?php echo e(language_data('Date')); ?></th>
                                    <th><?php echo e(language_data('Status')); ?></th>
                                    <th class="text-right"><?php echo e(language_data('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?> </td>
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
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="invoices">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 10%;"><?php echo e(language_data('Amount')); ?></th>
                                    <th style="width: 15%;"><?php echo e(language_data('Invoice Date')); ?></th>
                                    <th style="width: 15%;"><?php echo e(language_data('Due Date')); ?></th>
                                    <th style="width: 10%;"><?php echo e(language_data('Status')); ?></th>
                                    <th style="width: 15%;"><?php echo e(language_data('Type')); ?></th>
                                    <th style="width: 30%;"><?php echo e(language_data('Manage')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($in->total); ?></td>
                                        <td><?php echo e(get_date_format($in->created)); ?></td>
                                        <td><?php echo e(get_date_format($in->duedate)); ?></td>
                                        <td>
                                            <?php if($in->status=='Unpaid'): ?>
                                                <span class="label label-warning"><?php echo e(language_data('Unpaid')); ?></span>
                                            <?php elseif($in->status=='Paid'): ?>
                                                <span class="label label-success"><?php echo e(language_data('Paid')); ?></span>
                                            <?php elseif($in->status=='Cancelled'): ?>
                                                <span class="label label-danger"><?php echo e(language_data('Cancelled')); ?></span>
                                            <?php else: ?>
                                                <span class="label label-info"><?php echo e(language_data('Partially Paid')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($in->recurring=='0'): ?>
                                                <span class="label label-success"> <?php echo e(language_data('Onetime')); ?></span>
                                            <?php else: ?>
                                                <span class="label label-info"> <?php echo e(language_data('Recurring')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(url('invoices/view/'.$in->id)); ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo e(language_data('View')); ?></a>
                                            <a href="<?php echo e(url('invoices/edit/'.$in->id)); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> <?php echo e(language_data('Edit')); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="sms-transaction">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">#</th>
                                    <th style="width: 30%;"><?php echo e(language_data('Amount')); ?></th>
                                    <th style="width: 50%;"><?php echo e(language_data('Date')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $sms_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($st->amount); ?></td>
                                        <td><?php echo e(get_date_format($st->updated_at)); ?></td>
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

    <div class="modal fade modal_send_sms_<?php echo e($client->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(language_data('Send SMS')); ?></h4>
                </div>
                <form class="form-some-up form-block" role="form" action="<?php echo e(url('clients/send-sms')); ?>" method="post">

                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo e(language_data('Sender ID')); ?> :</label>
                            <input type="text" class="form-control" name="sender_id">
                        </div>

                        <div class="form-group">
                            <label><?php echo e(language_data('Message Type')); ?></label>
                            <select class="selectpicker form-control message_type" name="message_type">
                                <option value="plain"><?php echo e(language_data('Plain')); ?></option>
                                <option value="unicode"><?php echo e(language_data('Unicode')); ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo e(language_data('Message')); ?></label>
                            <textarea class="form-control" name="message" rows="5" id="message"></textarea>
                            <span class="help text-uppercase" id="remaining">160 <?php echo e(language_data('characters remaining')); ?></span>
                            <span class="help text-success" id="messages">1 <?php echo e(language_data('message')); ?>(s)</span>
                        </div>

                        <div class="form-group">
                            <select class="selectpicker form-control" name="sms_gateway" data-live-search="true">
                                <?php $__currentLoopData = $sms_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($gateway->id); ?>"><?php echo e($gateway->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <input type="hidden" name="cmd" value="<?php echo e($client->id); ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(language_data('Close')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(language_data('Send')); ?></button>
                    </div>

                </form>
            </div>
        </div>

    </div>
    <div class="modal fade modal_update_limit_<?php echo e($client->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(language_data('Update Limit')); ?></h4>
                </div>
                <form class="form-some-up form-block" role="form" action="<?php echo e(url('clients/update-limit')); ?>" method="post">

                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo e(language_data('SMS Balance')); ?> :</label>
                            <input type="number" class="form-control" required="" name="sms_amount">
                            <span class="help"><?php echo e(language_data('Update with previous balance. Enter (-) amount for decrease limit')); ?></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <input type="hidden" name="cmd" value="<?php echo e($client->id); ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(language_data('Close')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(language_data('Add')); ?></button>
                    </div>

                </form>
            </div>
        </div>

    </div>
    <div class="modal fade modal_change_image_<?php echo e($client->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(language_data('Update Image')); ?></h4>
                </div>
                <form class="form-some-up form-block" role="form" action="<?php echo e(url('clients/update-image')); ?>" method="post" enctype="multipart/form-data">

                    <div class="modal-body">

                        <div class="form-group">
                            <label><?php echo e(language_data('Avatar')); ?></label>
                            <div class="input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="client_image">
                                            </span>
                                        </span>
                                <input type="text" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <input type="hidden" name="cmd" value="<?php echo e($client->id); ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(language_data('Close')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(language_data('Update')); ?></button>
                    </div>

                </form>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <?php echo Html::script("assets/libs/handlebars/handlebars.runtime.min.js"); ?>

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>

    <?php echo Html::script("assets/libs/data-table/datatables.min.js"); ?>


    <script>
        $(document).ready(function(){
            $('.data-table').DataTable();

            var $get_msg = $("#message"),
                $remaining = $('#remaining'),
                $messages = $remaining.next(),
                message_type = 'plain',
                maxCharInitial = 160,
                maxChar = 157,
                messages = 1;


          function get_character() {
            var totalChar = $get_msg[0].value.length;
            var remainingChar = maxCharInitial;

            if ( totalChar <= maxCharInitial ) {
              remainingChar = maxCharInitial - totalChar;
              messages = 1;
            } else {
              totalChar = totalChar - maxCharInitial;
              messages = Math.ceil( totalChar / maxChar );
              remainingChar = messages * maxChar - totalChar;
              messages = messages + 1;
            }

            $remaining.text(remainingChar + ' characters remaining');
            $messages.text(messages + ' Message(s)');
          }

            $('.message_type').on('change', function () {
                message_type = $(this).val();

                if (message_type == 'unicode') {
                    maxCharInitial = 70;
                    maxChar = 67;
                    messages = 1;
                }

                if (message_type == 'plain') {
                    maxCharInitial = 160;
                    maxChar = 157;
                    messages = 1;
                }

              get_character();
            });

            $get_msg.keyup(get_character);

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>