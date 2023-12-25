<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Update')); ?> <?php echo e(language_data('Schedule SMS')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Update')); ?> <?php echo e(language_data('Schedule SMS')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-some-up form-block" role="form" action="<?php echo e(url('sms/post-update-schedule-sms')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Phone Number')); ?></label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" value="<?php echo e($sh->receiver); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Schedule Time')); ?></label>
                                    <input type="text" class="form-control dateTimePicker" name="schedule_time" value="<?php echo e(get_date_format($sh->submit_time)); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('SMS Gateway')); ?></label>
                                    <select class="selectpicker form-control" name="sms_gateway"  data-live-search="true">
                                        <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if($sg->id == $sh->use_gateway): ?> selected <?php endif; ?> value="<?php echo e($sg->id); ?>"><?php echo e($sg->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Sender ID')); ?></label>
                                    <input type="text" class="form-control" name="sender_id" id="sender_id" value="<?php echo e($sh->sender); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Message Type')); ?></label>
                                    <select class="selectpicker form-control message_type" name="message_type">
                                        <option value="plain" <?php if($sh->type == 'plain'): ?> selected <?php endif; ?>><?php echo e(language_data('Plain')); ?></option>
                                        <option value="unicode" <?php if($sh->type == 'unicode'): ?> selected <?php endif; ?>><?php echo e(language_data('Unicode')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Message')); ?></label>
                                    <textarea class="form-control" name="message" rows="5" id="message"> <?php echo e($sh->message); ?></textarea>
                                    <span class="help text-uppercase" id="remaining">160 <?php echo e(language_data('characters remaining')); ?></span>
                                    <span class="help text-success" id="messages">1 <?php echo e(language_data('message')); ?>(s)</span>
                                </div>
                                <input type="hidden" value="<?php echo e($sh->id); ?>" name="cmd">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> <?php echo e(language_data('update')); ?> </button>
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


    <script>
        $(document).ready(function () {

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
                    maxChar = 160;
                    messages = 1;
                }

                get_character();
            });

            $get_msg.keyup(get_character);

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>