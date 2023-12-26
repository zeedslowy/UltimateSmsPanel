<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/data-table/datatables.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Buy Unit')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-5">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Recharge your account Online')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('users/post-buy-unit')); ?>">
                                <div class="form-group">
                                    <label><?php echo e(language_data('Number of Units')); ?></label>
                                    <input type="text" class="form-control" required name="number_unit"
                                           id="number_unit">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Unit Price')); ?></label>
                                    <input type="text" class="form-control" readonly name="unit_price" id="unit_price">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Amount to Pay')); ?></label>
                                    <input type="text" class="form-control" readonly name="pay_amount" id="pay_amount">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Select Payment Method')); ?></label>
                                    <select class="selectpicker form-control" name="gateway">
                                        <?php $__currentLoopData = $payment_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($pg->settings); ?>"><?php echo e($pg->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Transaction Fee')); ?></label>
                                    <input type="text" class="form-control" readonly name="trans_fee" id="trans_fee">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Total')); ?></label>
                                    <input type="text" class="form-control" readonly name="total" id="total">
                                </div>


                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <button type="submit" class="btn btn-success btn-sm pull-right purchase_button"><i
                                            class="fa fa-plus"></i> <?php echo e(language_data('Purchase Now')); ?> </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Price Bundles')); ?></h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 60%;"><?php echo e(language_data('Number of Units')); ?></th>
                                    <th style="width: 40%;"><?php echo e(language_data('Price Per Unit')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="Number of units"><?php echo e($b->unit_from); ?> - <?php echo e($b->unit_to); ?></td>
                                        <td data-label="Price"><p><?php echo e($b->price); ?> </p></td>
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

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <?php echo Html::script("assets/libs/handlebars/handlebars.runtime.min.js"); ?>

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>

    <?php echo Html::script("assets/libs/data-table/datatables.min.js"); ?>

    <?php echo Html::script("assets/js/bootbox.min.js"); ?>


    <script>
        $(document).ready(function () {
            $('.data-table').DataTable({
                "order": [[ 1, "desc" ]]
            });

            /*Transaction Loading*/

            var timer;

            $("#number_unit").on('keyup', function () {
                clearTimeout(timer);  //clear any running timeout on key up
                timer = setTimeout(function () { //then give it a second to see if the user is finished
                    var id = $("#number_unit").val();
                    var _url = $("#_url").val();
                    var dataString = 'unit_number=' + id;

                    $.ajax
                    ({
                        type: "POST",
                        url: _url + '/user/get-transaction',
                        data: dataString,
                        cache: false,
                        success: function (data) {
                            $("#unit_price").val(data.unit_price);
                            $("#pay_amount").val(data.amount_to_pay);
                            $("#trans_fee").val(data.transaction_fee);
                            $("#total").val(data.total);

                            if (data.unit_price == 'Price Bundle empty'){
                                $(".purchase_button").hide();
                            }
                        }
                    });
                }, 1000);
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>