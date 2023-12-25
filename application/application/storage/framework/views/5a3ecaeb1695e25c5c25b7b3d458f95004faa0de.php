<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Localization')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"> <?php echo e(language_data('Localization')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" action="<?php echo e(url('settings/localization-post')); ?>" method="post">
                                <div class="form-group">
                                    <label for="Country"><?php echo e(language_data('Default Country')); ?></label>
                                    <select name="country" class="form-control selectpicker" data-live-search="true">
                                        <?php echo countries(app_config('Country')); ?>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Date Format')); ?></label>
                                    <select class="form-control selectpicker" data-live-search="true" name="date_format">
                                        <option value="d/m/Y" <?php if(app_config('DateFormat') == 'd/m/Y'): ?> selected="selected" <?php endif; ?>>15/05/2016</option>
                                        <option value="d.m.Y" <?php if(app_config('DateFormat') == 'd.m.Y'): ?> selected="selected" <?php endif; ?>>15.05.2016</option>
                                        <option value="d-m-Y" <?php if(app_config('DateFormat') == 'd-m-Y'): ?> selected="selected" <?php endif; ?>>15-05-2016</option>
                                        <option value="m/d/Y" <?php if(app_config('DateFormat') == 'm/d/Y'): ?> selected="selected" <?php endif; ?>>05/15/2016</option>
                                        <option value="Y/m/d" <?php if(app_config('DateFormat') == 'Y/m/d'): ?> selected="selected" <?php endif; ?>>2016/05/15</option>
                                        <option value="Y-m-d" <?php if(app_config('DateFormat') == 'Y-m-d'): ?> selected="selected" <?php endif; ?>>2016-05-15</option>
                                        <option value="M d Y" <?php if(app_config('DateFormat') == 'M d Y'): ?> selected="selected" <?php endif; ?>>May 15 2016</option>
                                        <option value="d M Y" <?php if(app_config('DateFormat') == 'd M Y'): ?> selected="selected" <?php endif; ?>>15 May 2016</option>
                                        <option value="jS M y" <?php if(app_config('DateFormat') == 'jS M y'): ?> selected="selected" <?php endif; ?>>15th May 16</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="tzone"><?php echo e(language_data('Timezone')); ?></label>
                                    <select name="timezone" class="form-control selectpicker" data-live-search="true">
                                        <?php $__currentLoopData = timezoneList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>" <?php if(app_config('Timezone')==$value): ?> selected <?php endif; ?>><?php echo e($label); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                </div>


                                <div class="form-group">
                                    <label><?php echo e(language_data('Default Language')); ?></label>
                                    <select class="form-control selectpicker" name="language">
                                        <?php $__currentLoopData = $language_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($l->id); ?>"><?php echo e($l->language); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Current Code')); ?></label>
                                    <input type="text" class="form-control" required name="currency_code" value="<?php echo e(app_config('Currency')); ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(language_data('Current Symbol')); ?></label>
                                    <input type="text" class="form-control" required name="currency_symbol" value="<?php echo e(app_config('CurrencyCode')); ?>">
                                </div>


                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> <?php echo e(language_data('Update')); ?></button>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>