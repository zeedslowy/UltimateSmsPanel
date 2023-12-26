<?php $__env->startSection('style'); ?>
    <?php echo Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css"); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('Create New Ticket')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="row">

                <div class="col-lg-7">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(language_data('Create New Ticket')); ?></h3>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="<?php echo e(url('support-tickets/post-ticket')); ?>">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">


                                <div class="form-group">
                                    <label for="cid"><?php echo e(language_data('Ticket For Client')); ?></label>
                                    <select name="cid" class="selectpicker form-control" data-live-search="true">
                                        <?php $__currentLoopData = $cl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->fname); ?> <?php echo e($c->lname); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subject"><?php echo e(language_data('Subject')); ?></label>
                                    <input type="text" class="form-control" id="subject" name="subject">
                                </div>

                                <div class="form-group">
                                    <label for="message"><?php echo e(language_data('Message')); ?></label>
                                    <textarea class="textarea-wysihtml5 form-control" name="message"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="did"><?php echo e(language_data('Department')); ?></label>
                                    <select name="did" class="selectpicker form-control" data-live-search="true">
                                        <?php $__currentLoopData = $sd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($d->id); ?>"><?php echo e($d->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <button type="submit" name="add" class="btn btn-success"><i class="fa fa-plus"></i> <?php echo e(language_data('Create Ticket')); ?></button>
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

    <?php echo Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js"); ?>

    <?php echo Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>