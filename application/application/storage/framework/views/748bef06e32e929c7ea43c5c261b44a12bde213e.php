<?php $__env->startSection('content'); ?>

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title"><?php echo e(language_data('View Profile')); ?></h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            <?php echo $__env->make('notification.notify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body p-t-20">
                            <div class="clearfix">
                                <div class="pull-left m-r-30">
                                    <div class="thumbnail m-b-none">

                                        <?php if($admin->image!=''): ?>
                                            <img src="<?php echo asset('assets/admin_pic/'.$admin->image); ?>" alt="Profile Page" width="200px" height="200px">
                                        <?php else: ?>
                                            <img src="<?php echo asset('assets/admin_pic/user.png');?>" alt="Profile Page" width="200px" height="200px">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="pull-left">
                                    <h3 class="bold font-color-1"><?php echo e($admin->fname); ?> <?php echo e($admin->lname); ?></h3>
                                    <ul class="info-list">
                                        <?php if($admin->email!=''): ?>
                                            <li><span class="info-list-title"><?php echo e(language_data('Email')); ?></span><span class="info-list-des"><?php echo e($admin->email); ?></span></li>
                                        <?php endif; ?>

                                        <?php if($admin->username!=''): ?>
                                                <li><span class="info-list-title"><?php echo e(language_data('User Name')); ?></span><span class="info-list-des"><?php echo e($admin->username); ?></span></li>
                                        <?php endif; ?>

                                         <li>
                                             <span class="info-list-title"><?php echo e(language_data('Access Role')); ?></span><span class="info-list-des">
                                                 <?php if($admin->roleid==0): ?> <?php echo e(language_data('Super Admin')); ?> <?php else: ?> <?php echo e($admin->get_admin_role->roleid); ?> <?php endif; ?>
                                             </span>
                                         </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="p-30 p-t-none p-b-none">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#personal_details" aria-controls="home" role="tab" data-toggle="tab"><?php echo e(language_data('Personal Details')); ?></a></li>

                        <li role="presentation"><a href="#change-picture" aria-controls="settings" role="tab" data-toggle="tab"><?php echo e(language_data('Change Image')); ?></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content panel p-20">


                        

                        <div role="tabpanel" class="tab-pane active" id="personal_details">
                            <form role="form" method="post" action="<?php echo e(url('admin/post-personal-info')); ?>">

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><?php echo e(language_data('First Name')); ?></label>
                                            <input type="text" class="form-control" required="" value="<?php echo e($admin->fname); ?>" name="fname">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Last Name')); ?></label>
                                            <input type="text" class="form-control" value="<?php echo e($admin->lname); ?>" name="lname">
                                        </div>


                                        <div class="form-group">
                                            <label><?php echo e(language_data('Email')); ?></label>
                                            <span class="help">e.g. "coderpixel@gmail.com" (<?php echo e(language_data('Unique For every User')); ?>)</span>
                                            <input type="email" class="form-control" required name="email" value="<?php echo e($admin->email); ?>">
                                        </div>


                                    </div>

                                    <div class="col-md-12">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="submit" value="<?php echo e(language_data('Update')); ?>" class="btn btn-success">

                                    </div>
                                </div>


                            </form>

                        </div>


                        <div role="tabpanel" class="tab-pane" id="change-picture">
                            <form role="form" action="<?php echo e(url('admin/update-avatar')); ?>" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group input-group input-group-file">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="image" accept="image/*">
                                                    </span>
                                                </span>
                                            <input type="text" class="form-control" readonly="" >
                                        </div>

                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="submit" value="<?php echo e(language_data('Update')); ?>" class="btn btn-primary">

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

    <?php echo Html::script("assets/js/form-elements-page.js"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>