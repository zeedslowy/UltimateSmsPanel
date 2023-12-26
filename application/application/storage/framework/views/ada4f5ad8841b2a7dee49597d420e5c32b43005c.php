<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('send')); ?> <?php echo e(language_data('single')); ?> <?php echo e(language_data('SMS')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('send')); ?> <?php echo e(language_data('single')); ?> <?php echo e(language_data('SMS')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="<?php echo e(url('sms/post-single-sms')); ?>">
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Phone Number')); ?></label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('SMS Gateway')); ?></label>
                                    <select class="selectpicker form-control" name="sms_gateway"  data-live-search="true">
                                        <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sg->id); ?>"><?php echo e($sg->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Sender ID')); ?></label>
                                    <input type="text" class="form-control" name="sender_id" id="sender_id">
                                </div>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Message')); ?></label>
                                    <textarea class="form-control" name="message" rows="5" id="message"></textarea>
                                    <span class="help text-uppercase" id="remaining">160 <?php echo e(language_data('characters remaining')); ?></span>
                                    <span class="help text-success" id="messages">1 <?php echo e(language_data('message')); ?>(s)</span>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-send"></i> <?php echo e(language_data('Send')); ?> </button>
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
        $(document).ready(function(){

            var $get_msg=$("#message");
            var $remaining = $('#remaining'),
                $messages = $remaining.next();

            $get_msg.keyup(function(){
                var chars = this.value.length,
                    messages = Math.ceil(chars / 160),
                    remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

                $remaining.text(remaining + ' characters remaining');
                $messages.text(messages + ' message(s)');
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>