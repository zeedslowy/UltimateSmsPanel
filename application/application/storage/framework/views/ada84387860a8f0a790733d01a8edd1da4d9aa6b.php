<?php $__env->startSection('style'); ?>
    
    <?php echo Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Add New Invoice')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Add New Invoice')); ?></h3>
                        </div>
                        <div class="panel-body">

                            <form method="post" action="<?php echo e(url('invoices/post-new-invoice')); ?>">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label><?php echo e(language_data('Client')); ?></label>
                                        <select class="selectpicker form-control" name="client_id" data-live-search="true">
                                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($cl->id); ?>"><?php echo e($cl->fname); ?> <?php echo e($cl->lname); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo e(language_data('Invoice Type')); ?></label>
                                        <select class="selectpicker form-control invoice-type" name="invoice_type">
                                            <option value="one_time"><?php echo e(language_data('One Time')); ?></option>
                                            <option value="recurring"><?php echo e(language_data('Recurring')); ?></option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo e(language_data('Invoice Date')); ?></label>
                                        <input type="text" class="form-control datePicker" name="invoice_date">
                                    </div>

                                    <div class="show-one-time">

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Due Date')); ?></label>
                                            <input type="text" class="form-control datePicker" name="due_date">
                                        </div>


                                        <div class="form-group">
                                            <label><?php echo e(language_data('Paid Date')); ?></label>
                                            <input type="text" class="form-control datePicker" name="paid_date">
                                        </div>
                                    </div>


                                    <div class="show-recurring">
                                        <div class="form-group">
                                            <label><?php echo e(language_data('Repeat Every')); ?></label>
                                            <select class="selectpicker form-control" name="repeat_type">
                                                <option value="week1"><?php echo e(language_data('Week')); ?></option>
                                                <option value="weeks2"><?php echo e(language_data('2 Weeks')); ?></option>
                                                <option value="month1" selected><?php echo e(language_data('Month')); ?></option>
                                                <option value="months2"><?php echo e(language_data('2 Months')); ?></option>
                                                <option value="months3"><?php echo e(language_data('3 Months')); ?></option>
                                                <option value="months6"><?php echo e(language_data('6 Months')); ?></option>
                                                <option value="year1"><?php echo e(language_data('Year')); ?></option>
                                                <option value="years2"><?php echo e(language_data('2 Years')); ?></option>
                                                <option value="years3"><?php echo e(language_data('3 Years')); ?></option>
                                            </select>
                                        </div>
                                        <input type="hidden" value="0" name="paid_date_recurring">

                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <table class="table table-hover" id="invoice_items">
                                        <thead>
                                        <tr>
                                            <th width="30%"><?php echo e(language_data('Item Name')); ?></th>
                                            <th width="15%"><?php echo e(language_data('Price')); ?></th>
                                            <th width="13%"><?php echo e(language_data('Qty')); ?></th>
                                            <th width="12%"><?php echo e(language_data('Tax')); ?></th>
                                            <th width="10%"><?php echo e(language_data('Discount')); ?></th>
                                            <th width="20%"><?php echo e(language_data('Per Item Total')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="info">
                                            <td><input type="text" class="form-control item_name" name="desc[]" value=""></td>
                                            <td><input type="text" class="form-control item_price" name="amount[]" value=""></td>
                                            <td><input type="text" class="form-control qty" value="" name="qty[]"></td>
                                            <td><input type="text" class="form-control tax" name="taxed[]" value=""> </td>
                                            <td><input type="text" class="form-control discount" name="discount[]" value=""> </td>
                                            <td class="ltotal"><input type="text" class="form-control lvtotal" readonly="" name="ltotal[]"></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="row bottom-inv-con">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-success" id="blank-add"><i class="fa fa-plus"></i> <?php echo e(language_data('Add Item')); ?></button>
                                            <button type="button" class="btn btn-danger" id="item-remove"><i class="fa fa-minus-circle"></i> <?php echo e(language_data('Delete')); ?></button>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="grand-total-box"><strong><?php echo e(language_data('Total')); ?> :</strong><span id="sub_total">0.00</span></p>
                                        </div>
                                    </div>

                                    <textarea class="form-control" name="notes" rows="3" placeholder="<?php echo e(language_data('Invoice Note')); ?>"></textarea>
                                    <br>
                                    <div class="text-right">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> <?php echo e(language_data('Create Invoice')); ?></button>
                                    </div>

                                </div>
                            </div>
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

    <?php echo Html::script("assets/libs/moment/moment.min.js"); ?>

    <?php echo Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"); ?>

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>

    <?php echo Html::script("assets/js/invoice.js"); ?>

    <script>
        var $invoice_type = $('.invoice-type');
        var $show_recurring_invoice = $('.show-recurring');
        var $show_one_time_invoice = $('.show-one-time');
        function changeStateOne(val) {
            if( val =='one_time') {
                $show_recurring_invoice.hide();
                $show_one_time_invoice.show();
            } else {
                $show_one_time_invoice.hide();
                $show_recurring_invoice.show();
            }
        }
        $invoice_type.on('change', function (e) {
            changeStateOne( $(this).val() );
        });
        changeStateOne( $invoice_type.val() );

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>