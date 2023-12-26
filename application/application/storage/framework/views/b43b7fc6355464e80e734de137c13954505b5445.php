<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('View Invoice')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="panel">
                <div class="panel-body p-none">
                    <div class="p-20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-6 p-t-20">
                                    <div class="m-b-5">
                                        <img src="<?php echo asset(app_config('AppLogo')); ?>" alt="Logo">
                                    </div>
                                    <address>
                                        <?php echo app_config('Address'); ?>

                                    </address>

                                    <div class="m-t-20">
                                        <h3 class="panel-title"><?php echo e(language_data('Invoice To')); ?>: </h3>
                                        <h3 class="invoice-to-client-name"><?php echo e($inv->client_name); ?></h3>
                                    </div>

                                    <address>
                                        <?php echo e($client->address1); ?> <br>
                                        <?php echo e($client->address2); ?> <br>
                                        <?php echo e($client->state); ?>, <?php echo e($client->city); ?> - <?php echo e($client->postcode); ?>,  <?php echo e($client->country); ?>

                                        <br><br>
                                        <?php echo e(language_data('Phone')); ?>: <?php echo e($client->phone); ?>

                                        <br>
                                        <?php echo e(language_data('Email')); ?>: <?php echo e($client->email); ?>

                                    </address>

                                </div>

                                <div class="col-lg-6 p-t-20">


                                    <div class="btn-group pull-right" aria-label="...">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn  btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo e(language_data('Mark As')); ?> <span class="caret"></span></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <?php if($inv->status!='Paid'): ?>
                                                    <li><a href="#" id="mark_paid" data-value="<?php echo e($inv->id); ?>"><?php echo e(language_data('Paid')); ?></a></li>
                                                <?php endif; ?>
                                                <?php if($inv->status!='Unpaid'): ?>
                                                    <li><a href="#" id="mark_unpaid" data-value="<?php echo e($inv->id); ?>"><?php echo e(language_data('Unpaid')); ?></a></li>
                                                <?php endif; ?>
                                                <?php if($inv->status!='Partially Paid'): ?>
                                                    <li><a href="#" id="mark_partially_paid" data-value="<?php echo e($inv->id); ?>"><?php echo e(language_data('Partially Paid')); ?></a></li>
                                                <?php endif; ?>
                                                <?php if($inv->status!='Cancelled'): ?>
                                                    <li><a href="#" id="mark_cancelled" data-value="<?php echo e($inv->id); ?>"><?php echo e(language_data('Cancelled')); ?></a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <a href="<?php echo e(url('invoices/client-iview/'.$inv->id)); ?>" target="_blank" class="btn btn-danger  btn-sm"><i class="fa fa-paper-plane-o"></i> <?php echo e(language_data('Preview')); ?></a>
                                        <a href="<?php echo e(url('invoices/edit/'.$inv->id)); ?>" class="btn btn-warning  btn-sm"><i class="fa fa-pencil"></i> <?php echo e(language_data('Edit')); ?></a>
                                        <a href="#" data-toggle="modal" data-target="#send-email-invoice" class="btn btn-complete  btn-sm send-email"><i class="fa fa-envelope"></i> <?php echo e(language_data('Send')); ?> <?php echo e(language_data('Email')); ?></a>
                                        <a href="<?php echo e(url('invoices/download-pdf/'.$inv->id)); ?>" class="btn btn-pdf  btn-sm download-pdf"><i class="fa fa-file-pdf-o"></i> <?php echo e(language_data('PDF')); ?></a>
                                        <a href="<?php echo e(url('invoices/iprint/'.$inv->id)); ?>" target="_blank" class="btn btn-primary  btn-sm"><i class="fa fa-print"></i> <?php echo e(language_data('Print')); ?></a>
                                        <br>
                                        <br>

                                        <div class="modal fade" id="send-email-invoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel"><?php echo e(language_data('Send Invoice')); ?></h4>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form class="form-some-up" role="form" action="<?php echo e(url('invoices/send-invoice-email')); ?>" method="post">

                                                            <div class="form-group">
                                                                <label><?php echo e(language_data('Subject')); ?></label>
                                                                <input type="text" class="form-control" name="subject" required="">
                                                            </div>

                                                            <div class="form-group">
                                                                <label><?php echo e(language_data('Message')); ?></label>
                                                                <textarea class="form-control" rows="5" name="message"></textarea>
                                                            </div>

                                                            <div class="text-right">
                                                                <input type="hidden" value="<?php echo e($inv->id); ?>" name="cmd">
                                                                <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><?php echo e(language_data('Close')); ?></button>
                                                                <button type="submit" class="btn btn-success btn-sm"><?php echo e(language_data('Send')); ?></button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="m-t-20">
                                            <div class="bill-data">
                                                <p class="m-b-5">
                                                    <span class="bill-data-title"><?php echo e(language_data('Invoice No')); ?>:</span>
                                                    <span class="bill-data-value">#<?php echo e($inv->id); ?></span>
                                                </p>
                                                <p class="m-b-5">
                                                    <span class="bill-data-title"><?php echo e(language_data('Invoice Status')); ?>:</span>
                                                    <?php if($inv->status=='Unpaid'): ?>
                                                        <span class="bill-data-value"><span class="bill-data-status label-warning"><?php echo e(language_data('Unpaid')); ?></span></span>
                                                    <?php elseif($inv->status=='Paid'): ?>
                                                        <span class="bill-data-value"><span class="bill-data-status label-success"><?php echo e(language_data('Paid')); ?></span></span>
                                                    <?php elseif($inv->status=='Partially Paid'): ?>
                                                        <span class="bill-data-value"><span class="bill-data-status label-info"><?php echo e(language_data('Partially Paid')); ?></span></span>
                                                    <?php else: ?>
                                                        <span class="bill-data-value"><span class="bill-data-status label-danger"><?php echo e(language_data('Cancelled')); ?></span></span>
                                                    <?php endif; ?>
                                                </p>
                                                <p class="m-b-5">
                                                    <span class="bill-data-title"><?php echo e(language_data('Invoice Date')); ?>:</span>
                                                    <span class="bill-data-value"><?php echo e(get_date_format($inv->created)); ?></span>
                                                </p>
                                                <p class="m-b-5">
                                                    <span class="bill-data-title"><?php echo e(language_data('Due Date')); ?>:</span>
                                                    <span class="bill-data-value"><?php echo e(get_date_format($inv->duedate)); ?></span>
                                                </p>
                                                <?php if($inv->status=='Paid'): ?>
                                                    <p class="m-b-5">
                                                        <span class="bill-data-title"><?php echo e(language_data('Paid Date')); ?>:</span>
                                                        <span class="bill-data-value"><?php echo e(get_date_format($inv->datepaid)); ?></span>
                                                    </p>
                                                <?php endif; ?>

                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>

                            <div class="col-lg-12">
                                <table class="table invoice-items invoice-view">
                                    <thead>
                                    <tr class="h5 text-dark">
                                        <th id="cell-id" class="text-semibold" style="width: 5%;">#</th>
                                        <th id="cell-item" class="text-semibold" style="width: 65%;"><?php echo e(language_data('Item')); ?></th>
                                        <th id="cell-price" class="text-center text-semibold" style="width: 10%;"><?php echo e(language_data('Price')); ?></th>
                                        <th id="cell-qty" class="text-center text-semibold" style="width: 10%;"><?php echo e(language_data('Quantity')); ?></th>
                                        <th id="cell-total" class="text-semibold" style="width: 10%;"><?php echo e(language_data('Total')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i='1'; ?>
                                    <?php $__currentLoopData = $inv_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td style="width: 5%;"><?php echo $i++; ?></td>
                                            <td class="text-semibold text-dark" style="width: 65%;"><?php echo e($it->item); ?></td>
                                            <td class="text-center" style="width: 10%;"><?php echo app_config('CurrencyCode'); ?><?php echo e($it->price); ?></td>
                                            <td class="text-center" style="width: 10%;"><?php echo e($it->qty); ?></td>
                                            <td style="width: 10%;"><?php echo app_config('CurrencyCode'); ?><?php echo e($it->subtotal); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12">
                                <div class="invoice-summary">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                            <div class="inv-block">
                                                <h3 class="count-title"><?php echo e(language_data('Subtotal')); ?></h3>
                                                <p><?php echo app_config('CurrencyCode'); ?><?php echo e($inv->subtotal); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <div class="inv-block">
                                                <h3 class="count-title"><?php echo e(language_data('Tax')); ?></h3>
                                                <p><?php echo app_config('CurrencyCode'); ?><?php echo e($tax_sum); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <div class="inv-block">
                                                <h3 class="count-title"><?php echo e(language_data('Discount')); ?></h3>
                                                <p><?php echo app_config('CurrencyCode'); ?><?php echo e($dis_sum); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-lg-offset-2 col-md-offset-1 col-sm-offset-1 text-right">
                                            <div class="inv-block last">
                                                <h3 class="count-title"><?php echo e(language_data('Grand Total')); ?></h3>
                                                <p><?php echo app_config('CurrencyCode'); ?><?php echo e($inv->total); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php if($inv->note!=''): ?>
                                    <div class="well m-t-5"><b><?php echo e(language_data('Invoice Note')); ?>: </b><?php echo e($inv->note); ?></div>
                                <?php endif; ?>

                            </div>

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

    <?php echo Html::script("assets/js/bootbox.min.js"); ?>


    <script>
        $(document).ready(function(){
            /*For Invoice mark paid*/
            $("#mark_paid").click(function (e) {
                e.preventDefault();
                var id = $(this).data('value');

                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/invoices/mark-paid/" + id;
                    }
                });
            });

            /*For Invoice mark as unpaid*/
            $("#mark_unpaid").click(function (e) {
                e.preventDefault();
                var id = $(this).data('value');

                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/invoices/mark-unpaid/" + id;
                    }
                });
            });

            /*For Invoice mark as partially paid*/
            $("#mark_partially_paid").click(function (e) {
                e.preventDefault();
                var id = $(this).data('value');

                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/invoices/mark-partially-paid/" + id;
                    }
                });
            });

            /*For Invoice mark as cancelled*/
            $("#mark_cancelled").click(function (e) {
                e.preventDefault();
                var id = $(this).data('value');

                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/invoices/mark-cancelled/" + id;
                    }
                });
            });


        });
    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>