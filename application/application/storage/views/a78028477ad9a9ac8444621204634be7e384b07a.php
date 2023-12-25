<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30"></div>
        <div class="p-15 p-t-none p-b-none m-l-10 m-r-10">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row text-center">

                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-success text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-user"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15"><?php echo e($total_clients); ?> <?php echo e(language_data('Client')); ?>(s)</span>
                                        <br>
                                        <a href="<?php echo e(url('clients/add')); ?>" class="btn btn-complete btn-xs text-uppercase"><?php echo e(language_data('Add New')); ?></a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-primary text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-users"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15"><?php echo e($total_groups); ?> <?php echo e(language_data('Client Group')); ?>(s)</span>
                                        <br>
                                        <a href="<?php echo e(url('clients/groups')); ?>" class="btn btn-complete btn-xs text-uppercase"><?php echo e(language_data('Add New')); ?></a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-warning text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-credit-card"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15"><?php echo e($total_invoice); ?> <?php echo e(language_data('Invoices')); ?></span>
                                        <br>
                                        <a href="<?php echo e(url('invoices/add')); ?>" class="btn btn-complete btn-xs text-uppercase"><?php echo e(language_data('Add New')); ?></a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-danger text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-ticket"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15"><?php echo e($total_tickets); ?> <?php echo e(language_data('Tickets')); ?></span>
                                        <br>
                                        <a href="<?php echo e(url('support-tickets/create-new')); ?>" class="btn btn-complete btn-xs text-uppercase"><?php echo e(language_data('Add New')); ?></a>
                                    </div>

                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>

        <div class="p-15 p-t-none p-b-none">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center"><?php echo e(language_data('Invoices History')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo $invoices_json->render(); ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center"><?php echo e(language_data('Tickets History')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo $tickets_json->render(); ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center"><?php echo e(language_data('SMS Success History')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo $sms_status_json->render(); ?>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="p-15 p-t-none p-b-none">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center"><?php echo e(language_data('SMS History By Date')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo $sms_history->render(); ?>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="p-15 p-t-none p-b-none">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel-body ">
                        <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo e(language_data('Recent 5 Invoices')); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 45px;"><?php echo e(language_data('Client')); ?></th>
                                            <th style="width: 20px;"><?php echo e(language_data('Amount')); ?></th>
                                            <th style="width: 20px;"><?php echo e(language_data('Due Date')); ?></th>
                                            <th style="width: 15px;"><?php echo e(language_data('Status')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $__currentLoopData = $recent_five_invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td data-label="client">
                                                    <p><a href="<?php echo e(url('clients/view/'.$inv->cl_id)); ?>"> <?php echo e($inv->client_name); ?> </a></p>
                                                </td>
                                                <td data-label="Amount"><p><a href="<?php echo e(url('invoices/view/'.$inv->id)); ?>"><?php echo e($inv->total); ?></a> </p>
                                                </td>
                                                <td data-label="Due Date"><p><?php echo e(get_date_format($inv->duedate)); ?></p></td>
                                                <?php if($inv->status=='Paid'): ?>
                                                    <td data-label="Status"><p class="label label-success label-xs"><?php echo e(language_data('Paid')); ?></p></td>
                                                <?php elseif($inv->status=='Unpaid'): ?>
                                                    <td data-label="Status"><p class="label label-warning label-xs"><?php echo e(language_data('Unpaid')); ?></p></td>
                                                <?php elseif($inv->status=='Partially Paid'): ?>
                                                    <td data-label="Status"><p class="label label-info label-xs"><?php echo e(language_data('Partially Paid')); ?></p></td>
                                                <?php else: ?>
                                                    <td data-label="Status"><p class="label label-danger label-xs"><?php echo e(language_data('Cancelled')); ?></p></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6 p-none">
                    <div class="panel-body ">
                        <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo e(language_data('Recent 5 Support Tickets')); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 30%;"><?php echo e(language_data('Email')); ?></th>
                                            <th style="width: 50%;"><?php echo e(language_data('Subject')); ?></th>
                                            <th style="width: 20%;"><?php echo e(language_data('Date')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $recent_five_tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rtic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td data-label="email">
                                                    <p><a href="<?php echo e(url('clients/view/'.$rtic->cl_id)); ?>"> <?php echo e($rtic->email); ?></a></p>
                                                </td>
                                                <td data-label="subject">
                                                    <p><a href="<?php echo e(url('support-tickets/view-ticket/'.$rtic->id)); ?>"><?php echo e($rtic->subject); ?></a></p>
                                                </td>
                                                <td data-label="date">
                                                    <p><?php echo e(get_date_format($rtic->date)); ?></p>
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


    </section>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('style'); ?>
    <?php echo Html::script("assets/libs/chartjs/chart.js"); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>