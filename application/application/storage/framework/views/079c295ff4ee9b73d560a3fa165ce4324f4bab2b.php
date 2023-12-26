<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Manage')); ?> <?php echo e(language_data('Support Tickets')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-12">

                    <div class="panel">

                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Ticket Management')); ?></h3>
                        </div>

                        <div class="p-30 p-t-none p-b-none">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#ticket_details" aria-controls="home" role="tab" data-toggle="tab"><?php echo e(language_data('Ticket Details')); ?></a></li>
                                        <li role="presentation"><a href="#ticket_discussion" aria-controls="profile" role="tab" data-toggle="tab"><?php echo e(language_data('Ticket Discussion')); ?></a></li>
                                        <li role="presentation"><a href="#ticket_files" aria-controls="messages" role="tab" data-toggle="tab"><?php echo e(language_data('Ticket Files')); ?></a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-20">


                                        

                                        <div role="tabpanel" class="tab-pane active" id="ticket_details">

                                            <div class="clearfix ticket-de-pane">
                                                <span class="ticket-status-title"><?php echo e(language_data('Ticket For Client')); ?>:</span>
                                                <span class="ticket-status-content"><?php echo e($st->name); ?></span>
                                            </div>

                                            <div class="clearfix ticket-de-pane">
                                                <span class="ticket-status-title"><?php echo e(language_data('Email')); ?>:</span>
                                                <span class="ticket-status-content"><?php echo e($st->email); ?></span>
                                            </div>

                                            <div class="clearfix ticket-de-pane">
                                                <span class="ticket-status-title"><?php echo e(language_data('Created Date')); ?>:</span>
                                                <span class="ticket-status-content"><?php echo e(get_date_format($st->date)); ?></span>
                                            </div>

                                            <div class="clearfix ticket-de-pane">
                                                <span class="ticket-status-title"><?php echo e(language_data('Created By')); ?>:</span>
                                                <?php if($st->admin=='0'): ?>
                                                    <span class="ticket-status-content"><?php echo e($st->name); ?></span>
                                                <?php else: ?>
                                                    <span class="ticket-status-content"><?php echo e($st->admin); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="clearfix ticket-de-pane">
                                                <span class="ticket-status-title"><?php echo e(language_data('Department')); ?>:</span>
                                                <span class="ticket-status-content"><?php echo e($td->name); ?></span>
                                            </div>

                                            <div class="clearfix ticket-de-pane">
                                                <span class="ticket-status-title">Status:</span>
                                                <?php if($st->status=='Pending'): ?>
                                                    <span class="label label-danger"><?php echo e(language_data('Pending')); ?></span>
                                                <?php elseif($st->status=='Answered'): ?>
                                                    <span class="label label-success"><?php echo e(language_data('Answered')); ?></span>
                                                <?php elseif($st->status=='Customer Reply'): ?>
                                                    <span class="label label-info"><?php echo e(language_data('Customer Reply')); ?></span>
                                                <?php else: ?>
                                                    <span class="label label-primary"><?php echo e(language_data('Closed')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <?php if($st->status=='Closed'): ?>
                                                <div class="clearfix ticket-de-pane">
                                                    <span class="ticket-status-title"><?php echo e(language_data('Closed By')); ?>:</span>
                                                    <span class="ticket-status-content"><?php echo e($st->closed_by); ?></span>
                                                </div>
                                            <?php endif; ?>

                                            <div class="m-t-30"></div>

                                            <div class="clearfix">
                                                <span class="ticket-status-title"><?php echo e(language_data('Subject')); ?>:</span>
                                                <span class="ticket-status-content"><?php echo e($st->subject); ?></span>
                                            </div>
                                            <div class="clearfix">
                                                <span class="ticket-status-title"><?php echo e(language_data('Message')); ?>:</span>
                                                <div class="ticket-status-content"><?php echo $st->message; ?></div>
                                            </div>

                                        </div>


                                        <div role="tabpanel" class="tab-pane" id="ticket_discussion">
                                            <form method="POST" action="<?php echo e(url('user/tickets/replay-ticket')); ?>">
                                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                                                <div class="form-group">
                                                    <label for="message"><?php echo e(language_data('Message')); ?></label>
                                                    <textarea class="textarea-wysihtml5 form-control"  name="message"></textarea>
                                                </div>


                                                <div class="hr-line-dashed"></div>
                                                <input type="hidden" value="<?php echo e($st->id); ?>" name="cmd">
                                                <button type="submit" name="add" class="btn btn-success"> <?php echo e(language_data('Reply Ticket')); ?> <i class="fa fa-reply"></i></button>
                                            </form>
                                            <div class="m-t-30"></div>

                                            <div class="support-replies">
                                                <?php $__currentLoopData = $trply; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($tr->admin!='client'): ?>

                                                        <div class="single-support-reply clearfix admin">
                                                            <div class="reply-info">
                                                                <?php if($tr->image==''): ?>
                                                                    <img class="reply-user-thumb" src="<?php echo asset('assets/client_pic/profile.png'); ?>" height="80px" width="80px">

                                                                <?php else: ?>
                                                                    <img class="reply-user-thumb" src="<?php echo asset('assets/client_pic/'.$tr->image); ?>" height="80px" width="80px">
                                                                <?php endif; ?>

                                                                <div class="reply-info-text">
                                                                    <h4 class="reply-user-name"><?php echo e($tr->admin); ?></h4>
                                                                    <h5 class="reply-date"> - <?php echo e(get_date_format($tr->date)); ?></h5>
                                                                    <h5 class="reply-user-type"><span class="label label-success"><?php echo e(language_data('Admin')); ?></span></h5>
                                                                    <div class="reply-message"><?php echo $tr->message; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php else: ?>

                                                        <div class="single-support-reply clearfix client">
                                                            <div class="reply-info">
                                                                <?php if($tr->image==''): ?>
                                                                    <img class="reply-user-thumb" src="<?php echo asset('assets/client_pic/profile.png'); ?>" height="80px" width="80px">
                                                                <?php else: ?>
                                                                    <img class="reply-user-thumb" src="<?php echo asset('assets/client_pic/'.$tr->image); ?>" height="80px" width="80px">
                                                                <?php endif; ?>
                                                                <div class="reply-info-text">
                                                                    <h4 class="reply-user-name"><?php echo e($tr->name); ?></h4>
                                                                    <h5 class="reply-date"><?php echo e(get_date_format($tr->date)); ?></h5>
                                                                    <h5 class="reply-user-type"><span class="label label-success"><?php echo e(language_data('Client')); ?></span></h5>
                                                                    <div class="reply-message"><?php echo $tr->message; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php endif; ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="ticket_files">
                                            <form role="form" method="post" action="<?php echo e(url('user/tickets/post-ticket-files')); ?>" enctype="multipart/form-data">

                                                <div class="row">
                                                    <div class="form-group">
                                                        <label><?php echo e(language_data('File Title')); ?></label>
                                                        <input type="text" name="file_title" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(language_data('Select File')); ?></label>
                                                        <div class="input-group input-group-file">
                                                            <span class="input-group-btn">
                                                                <span class="btn btn-primary btn-file">
                                                                    <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="file" accept="image/*">
                                                                </span>
                                                            </span>
                                                            <input type="text" class="form-control" readonly="">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                        <input type="hidden" value="<?php echo e($st->id); ?>" name="cmd">
                                                        <input type="submit" value="<?php echo e(language_data('Upload')); ?>" class="btn btn-success pull-right">

                                                    </div>
                                                </div>

                                            </form>
                                            <br>
                                            <hr>

                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th style="width: 20%;"><?php echo e(language_data('Files')); ?></th>
                                                    <th style="width: 15%;"><?php echo e(language_data('Size')); ?></th>
                                                    <th style="width: 20%;"><?php echo e(language_data('Date')); ?></th>
                                                    <th style="width: 25%;"><?php echo e(language_data('Upload By')); ?></th>
                                                    <th style="width: 20%;"><?php echo e(language_data('Action')); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $ticket_file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td data-label="Files"><p><?php echo e($tf->file_title); ?></p></td>
                                                        <td data-label="Size"><p><?php echo e($tf->file_size/1000); ?> KB</p></td>
                                                        <td data-label="Date"><p><?php echo e(get_date_format($tf->updated_at)); ?></p></td>
                                                        <?php if($tf->admin!='client'): ?>
                                                            <td data-label="Upload by"><p><?php echo e(admin_info($tf->admin_id)->fname); ?></p></td>
                                                        <?php else: ?>
                                                            <td data-label="Upload by"><p><?php echo e(client_info($tf->cl_id)->fname); ?></p></td>
                                                        <?php endif; ?>
                                                        <td data-label="actions" class="text-right">
                                                            <a href="<?php echo e(url('user/tickets/download-file/'.$tf->id)); ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> </a>
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
                    </div>


                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <?php echo Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js"); ?>

    <?php echo Html::script("assets/libs/handlebars/handlebars.runtime.min.js"); ?>

    <?php echo Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js"); ?>

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>