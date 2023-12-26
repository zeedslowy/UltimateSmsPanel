<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Send Bulk SMS')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Send Bulk SMS')); ?></h3>
                        </div>
                        <div class="panel-body">

                            <form class="" role="form" method="post" action="<?php echo e(url('user/sms/post-bulk-sms')); ?>">
                                <?php echo e(csrf_field()); ?>



                                <div class="form-group">
                                    <label><?php echo e(language_data('SMS Templates')); ?></label>
                                    <select class="selectpicker form-control" name="sms_template"  data-live-search="true" id="sms_template">
                                        <option><?php echo e(language_data('Select Template')); ?></option>
                                        <?php $__currentLoopData = $sms_templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($st->id); ?>"><?php echo e($st->template_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>


                                <?php if(app_config('sender_id_verification') == 1): ?>
                                    <?php if($sender_ids): ?>
                                        <div class="form-group">
                                            <label><?php echo e(language_data('Sender ID')); ?></label>
                                            <select class="selectpicker form-control sender_id" name="sender_id" data-live-search="true">
                                                <?php $__currentLoopData = $sender_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($si); ?>"><?php echo e($si); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group">
                                            <label><?php echo e(language_data('Sender ID')); ?></label>
                                            <p><a href="<?php echo e(url('user/sms/sender-id-management')); ?>" class="text-uppercase"><?php echo e(language_data('Request New Sender ID')); ?></a> </p>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="form-group">
                                        <label><?php echo e(language_data('Sender ID')); ?></label>
                                        <input type="text" class="form-control sender_id" name="sender_id">
                                    </div>
                                <?php endif; ?>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Select Contact Type')); ?></label>
                                    <select class="selectpicker form-control" name="contact_type"  id="contact_type">
                                        <option value="phone_book"><?php echo e(language_data('Phone Book')); ?></option>
                                        <?php if(Auth::guard('client')->user()->reseller=='Yes'): ?>
                                            <option value="client_group"><?php echo e(language_data('Client Group')); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <?php if(Auth::guard('client')->user()->reseller=='Yes'): ?>
                                    <div class="form-group client-group-area">
                                        <label><?php echo e(language_data('Client Group')); ?></label>
                                        <select class="selectpicker form-control select_client_group" name="client_group_id[]" multiple data-live-search="true">
                                            <?php $__currentLoopData = $client_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($cg->id); ?>"><?php echo e($cg->group_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group contact-list-area">
                                    <label><?php echo e(language_data('Contact List')); ?></label>
                                    <select class="form-control selectpicker select_contact_group" name="contact_list_id[]" data-live-search="true" multiple>
                                        <?php $__currentLoopData = $phone_book; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($pb->id); ?>"><?php echo e($pb->group_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Recipients')); ?></label>
                                    <textarea class="form-control" rows="4" name="recipients" id="recipients"></textarea>
                                    <span class="help text-uppercase"><?php echo e(language_data('Insert number with comma')); ?> (,) Ex. 8801721900000,8801721900001</span>
                                    <span class="help text-uppercase pull-right"><?php echo e(language_data('Total Number Of Recipients')); ?>: <span class="number_of_recipients bold text-success m-r-5">0</span></span>
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
                                    <textarea class="form-control" name="message" rows="5" id="message"></textarea>
                                    <span class="help text-uppercase" id="remaining">160 <?php echo e(language_data('characters remaining')); ?></span>
                                    <span class="help text-success" id="messages">1 <?php echo e(language_data('message')); ?>(s)</span>
                                </div>




                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" name="send_later" <?php if($schedule_sms): ?> checked <?php endif; ?> class="send_later" value="on">
                                        <span class="co-check-ui"></span>
                                        <label>Send Later</label>
                                    </div>
                                </div>


                                <div class="schedule_time">
                                    <div class="form-group">
                                        <label><?php echo e(language_data('Schedule Time')); ?></label>
                                        <input type="text" class="form-control dateTimePicker" name="schedule_time">
                                    </div>
                                </div>

                                <input type="hidden" value="<?php echo e($schedule_sms); ?>" id="schedule_sms_status" name="schedule_sms_status">
                                <button type="submit" class="btn btn-success btn-sm" name="action" value="send_now"><i class="fa fa-send"></i> <?php echo e(language_data('Send')); ?> </button>
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

    <?php echo Html::script("assets/js/dom-rules.js"); ?>

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>


    <script>
        $(document).ready(function(){


            var number_of_recipients_ajax = 0,
                number_of_recipients_manual = 0,
                $get_msg = $("#message"),
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


            $('#recipients').on('keyup', function() {

                if ( $(this).val().trim() ) {
                    number_of_recipients_manual = $(this).val().split(',').length;
                } else {
                    number_of_recipients_manual = 0;
                }


                var total = number_of_recipients_manual + Number(number_of_recipients_ajax);

                $('.number_of_recipients').text( total );

            });


            var domRules = $.createDomRules({

                parentSelector: 'body',
                scopeSelector: 'form',
                showTargets:    function( rule, $controller, condition, $targets, $scope ) {
                    $targets.fadeIn();
                    $('.number_of_recipients').text(0);
                },
                hideTargets:    function( rule, $controller, condition, $targets, $scope ) {
                    $targets.fadeOut();
                    $('.number_of_recipients').text(0);
                },

                rules: [
                    {
                        controller:     '#contact_type',
                        value:          'phone_book',
                        condition:      '==',
                        targets:        '.contact-list-area',
                    },
                    {
                        controller:     '#contact_type',
                        value:          'client_group',
                        condition:      '==',
                        targets:        '.client-group-area',
                    }
                ]
            });


            $('.select_client_group').on('hide.bs.select', function (e) {

                var vals = [];

                $(this).find(':selected').each(function(){
                    vals.push( $(this).val() );
                });

                if ( vals.length ) {

                    vals = vals.map(function(val){
                        return Number( val );
                    });

                    $.ajax({
                        url: _url + '/user/sms/get-contact-list-ids',
                        type: 'GET',
                        data: {
                            'client_group_ids': vals
                        }
                    })
                        .done(function(data,response) {

                            number_of_recipients_manual = Number(number_of_recipients_manual);

                            if ( response == 'success' && data.status == 'success' ) {

                                number_of_recipients_ajax   = Number(data.data);

                                var total = number_of_recipients_manual + number_of_recipients_ajax;

                                $('.number_of_recipients').text( total );

                                return;
                            }

                            $('.number_of_recipients').text(number_of_recipients_manual);

                        })
                        .fail(function() {

                            number_of_recipients_manual = Number(number_of_recipients_manual);

                            $('.number_of_recipients').text(number_of_recipients_manual);

                        })

                } else {

                    number_of_recipients_ajax = 0;

                    var total = Number(number_of_recipients_manual) + number_of_recipients_ajax;

                    $('.number_of_recipients').text( total );
                }

            });


            $('.select_contact_group').on('hide.bs.select', function (e) {

                var vals = [];

                $(this).find(':selected').each(function(){
                    vals.push( $(this).val() );
                });

                if ( vals.length ) {

                    vals = vals.map(function(val){
                        return Number( val );
                    });

                    $.ajax({
                        url: _url + '/user/sms/get-contact-list-ids',
                        type: 'GET',
                        data: {
                            'contact_list_ids': vals
                        }
                    })
                        .done(function(data,response) {

                            number_of_recipients_manual = Number(number_of_recipients_manual);

                            if ( response == 'success' && data.status == 'success' ) {

                                number_of_recipients_ajax   = Number(data.data);

                                var total = number_of_recipients_manual + number_of_recipients_ajax;

                                $('.number_of_recipients').text( total );

                                return;
                            }

                            $('.number_of_recipients').text(number_of_recipients_manual);

                        })
                        .fail(function() {

                            number_of_recipients_manual = Number(number_of_recipients_manual);

                            $('.number_of_recipients').text(number_of_recipients_manual);

                        });

                } else {

                    number_of_recipients_ajax = 0;

                    var total = Number(number_of_recipients_manual) + number_of_recipients_ajax;

                    $('.number_of_recipients').text( total );
                }

            });







        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>