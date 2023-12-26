<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Create SMS Template')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Create SMS Template')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" action="<?php echo e(url('sms/post-sms-template')); ?>" method="post">


                                <div class="form-group">
                                    <label><?php echo e(language_data('Template Name')); ?></label>
                                    <input type="text" class="form-control" required name="template_name"/>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('From')); ?></label>
                                    <input type="text" class="form-control" name="from"/>
                                </div>
                                

                                <div class="form-group">
                                    <label><?php echo e(language_data('Insert Merge Filed')); ?></label>
                                    <select class="form-control selectpicker" id="merge_value">
                                        <option value="" disabled selected style="display:none;"><?php echo e(language_data('Select Merge Field')); ?></option>
                                        <option value="<%Phone Number%>"><?php echo e(language_data('Phone Number')); ?></option>
                                        <option value="<%Email Address%>"><?php echo e(language_data('Email')); ?> <?php echo e(language_data('Address')); ?></option>
                                        <option value="<%User Name%>"><?php echo e(language_data('User Name')); ?></option>
                                        <option value="<%Company%>"><?php echo e(language_data('Company')); ?></option>
                                        <option value="<%First Name%>"><?php echo e(language_data('First Name')); ?></option>
                                        <option value="<%Last Name%>"><?php echo e(language_data('Last Name')); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Message')); ?></label>
                                    <textarea class="form-control" id="message" name="message" rows="8"></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="coder-checkbox">
                                        <input type="checkbox" value="yes" name="set_global">
                                        <span class="co-check-ui"></span>
                                        <label>Set as Global</label>
                                    </div>
                                </div>

                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> <?php echo e(language_data('Save')); ?></button>
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
        $(document).ready(function () {

            var merge_state = $('#merge_value');

            merge_state.on('change', function () {
                var merge_value = this;

                $('#message').val(function (_, v) {
                    return v + merge_value.value;
                });
            });


        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>