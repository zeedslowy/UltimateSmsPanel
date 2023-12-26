<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"); ?>


    <style>
        .progress-bar-indeterminate {
            background: url('../../assets/img/progress-bar-complete.svg') no-repeat top left;
            width: 100%;
            height: 100%;
            background-size: cover;
        }
    </style>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Send Bulk SMS')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <div class="show_notification"></div>
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Send Bulk SMS')); ?></h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <div class="form-group">
                                    <a href="<?php echo e(url('sms/download-sample-sms-file')); ?>" class="btn btn-complete"><i
                                                class="fa fa-download"></i> <?php echo e(language_data('Download Sample File')); ?>

                                    </a>
                                </div>
                            </div>

                            <div id="send-sms-file-wrapper">
                                <form id="send-sms-file-form" class="" role="form" method="post"
                                      action="<?php echo e(url('sms/post-sms-from-file')); ?>" enctype="multipart/form-data">
                                    <?php echo e(csrf_field()); ?>


                                    <div class="form-group">
                                        <label><?php echo e(language_data('Import Numbers')); ?></label>
                                        <div class="form-group input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="import_numbers"
                                                                                   @change="handleImportNumbers">
                                            </span>
                                        </span>
                                            <input type="text" class="form-control" readonly="">
                                        </div>


                                        <div id='loadingmessage' style='display:none' class="form-group">
                                            <label><?php echo e(language_data('File Uploading.. Please wait')); ?></label>
                                            <div class="progress">
                                                <div class="progress-bar-indeterminate"></div>
                                            </div>
                                        </div>


                                        <div class="coder-checkbox">
                                            <input type="checkbox" name="header_exist" :checked="form.header_exist"
                                                   v-model="form.header_exist">
                                            <span class="co-check-ui"></span>
                                            <label><?php echo e(language_data('First Row As Header')); ?></label>
                                        </div>
                                    </div>


                                    <div class="form-group" v-show="number_columns.length > 0">
                                        <label><?php echo e(language_data('Phone Number')); ?> <?php echo e(language_data('Column')); ?></label>
                                        <select class="selectpicker form-control" ref="number_column"
                                                name="number_column" data-live-search="true" v-model="number_column">
                                            <option v-for="column in number_columns" :value="column.key"
                                                    v-text="column.value"></option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label><?php echo e(language_data('SMS Gateway')); ?></label>
                                        <select class="selectpicker form-control" name="sms_gateway"
                                                data-live-search="true">
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
                                        <label><?php echo e(language_data('Remove Duplicate')); ?></label>
                                        <select class="selectpicker form-control" name="remove_duplicate">
                                            <option value="yes"><?php echo e(language_data('Yes')); ?></option>
                                            <option value="no"><?php echo e(language_data('No')); ?></option>
                                        </select>
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
                                        <textarea class="form-control" name="message" rows="5" id="message"
                                                  ref="message"></textarea>
                                        <span class="help text-uppercase"
                                              id="remaining">160 <?php echo e(language_data('characters remaining')); ?></span>
                                        <span class="help text-success" id="messages">1 <?php echo e(language_data('message')); ?>

                                            (s)</span>
                                    </div>

                                    <div class="row">

                                        <div class="col-sm-6" v-show="number_columns.length > 0">
                                            <div class="form-group">
                                                <label><?php echo e(language_data('Select Merge Field')); ?></label>
                                                <select class="selectpicker form-control" ref="merge_field"
                                                        data-live-search="true" v-model="number_column">
                                                    <option v-for="column in number_columns" :value="column.key"
                                                            v-text="column.value"></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo e(language_data('SMS Templates')); ?></label>
                                                <select class="selectpicker form-control" name="sms_template"
                                                        data-live-search="true" id="sms_template">
                                                    <option><?php echo e(language_data('Select Template')); ?></option>
                                                    <?php $__currentLoopData = $sms_templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($st->id); ?>"><?php echo e($st->template_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="coder-checkbox">
                                            <input type="checkbox" name="send_later" <?php if($schedule_sms): ?> checked
                                                   <?php endif; ?> class="send_later" value="on">
                                            <span class="co-check-ui"></span>
                                            <label><?php echo e(language_data('Send Later')); ?></label>
                                        </div>
                                    </div>


                                    <div class="schedule_time">
                                        <div class="form-group">
                                            <label><?php echo e(language_data('Schedule Time')); ?></label>
                                            <input type="text" class="form-control dateTimePicker" name="schedule_time">
                                        </div>
                                    </div>


                                    <div id='uploadContact' style='display:none' class="form-group">
                                        <label><?php echo e(language_data('Message adding in Queue.. Please wait')); ?></label>
                                        <div class="progress">
                                            <div class="progress-bar-indeterminate"></div>
                                        </div>
                                    </div>

                                    <input type="hidden" value="<?php echo e($schedule_sms); ?>" id="schedule_sms_status" name="schedule_sms_status">
                                    <span class="text-uppercase text-complete help"><?php echo e(language_data('After click on Send button, do not refresh your browser')); ?></span>

                                    <button type="submit" id="submitContact" class="btn btn-success btn-sm pull-right"><i class="fa fa-send"></i> <?php echo e(language_data('Send')); ?> </button>

                                </form>
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

    <?php echo Html::script("assets/libs/moment/moment.min.js"); ?>

    <?php echo Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"); ?>

    <?php echo Html::script("assets/js/vue.js"); ?>

    <?php echo Html::script("assets/js/file_upload.js"); ?>

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>


    <script>
        $(document).ready(function () {


            $('#submitContact').click(function(){
                $(this).hide();
                $('#uploadContact').show();
            });


            var $get_msg = $("#message"),
                $remaining = $('#remaining'),
                $messages = $remaining.next(),
                message_type = 'plain',
                maxCharInitial = 160,
                maxChar = 157,
                messages = 1,
                schedule_sms_status = $('#schedule_sms_status').val();

            if (schedule_sms_status) {
                $('.schedule_time').show();
            } else {
                $('.schedule_time').hide();
            }

            $('.send_later').change(function () {
                $('.schedule_time').fadeToggle();
            });


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


            $("#sms_template").change(function () {
                var id = $(this).val();
                var _url = $("#_url").val();
                var dataString = 'st_id=' + id;
                $.ajax
                ({
                    type: "POST",
                    url: _url + '/sms/get-template-info',
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        $("#sender_id").val(data.from);

                        var totalChar = $get_msg.val(data.message).val().length;
                        var remainingChar = maxCharInitial;

                        if (totalChar <= maxCharInitial) {
                            remainingChar = maxCharInitial - totalChar;
                            messages = 1;
                        } else {
                            totalChar = totalChar - maxCharInitial;
                            messages = Math.ceil(totalChar / maxChar);
                            remainingChar = messages * maxChar - totalChar;
                            messages = messages + 1;
                        }

                        $remaining.text(remainingChar + ' characters remaining');
                        $messages.text(messages + ' Message(s)');
                    }
                });
            });

            $get_msg.keyup(get_character);

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>