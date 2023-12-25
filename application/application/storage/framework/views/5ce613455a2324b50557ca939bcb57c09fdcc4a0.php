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

                                        <?php if($client->image!=''): ?>
                                            <img src="<?php echo asset('assets/client_pic/'.$client->image); ?>" alt="Profile Page" width="200px" height="200px">
                                        <?php else: ?>
                                            <img src="<?php echo asset('assets/client_pic/user.png');?>" alt="Profile Page" width="200px" height="200px">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="pull-left">
                                    <h3 class="bold font-color-1"><?php echo e($client->fname); ?> <?php echo e($client->lname); ?></h3>
                                    <ul class="info-list">
                                        <?php if($client->email!=''): ?>
                                            <li><span class="info-list-title"><?php echo e(language_data('Email')); ?></span><span class="info-list-des"><?php echo e($client->email); ?></span></li>
                                        <?php endif; ?>

                                        <?php if($client->username!=''): ?>
                                                <li><span class="info-list-title"><?php echo e(language_data('User Name')); ?></span><span class="info-list-des"><?php echo e($client->username); ?></span></li>
                                        <?php endif; ?>

                                         <li>
                                             <span class="info-list-title"><?php echo e(language_data('SMS Balance')); ?></span><span class="info-list-des">
                                                <?php echo e($client->sms_limit); ?>

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
                            <form role="form" action="<?php echo e(url('user/post-personal-info')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><?php echo e(language_data('First Name')); ?></label>
                                            <input type="text" class="form-control" required="" name="first_name" value="<?php echo e($client->fname); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Last Name')); ?></label>
                                            <input type="text" class="form-control" name="last_name"  value="<?php echo e($client->lname); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Company')); ?></label>
                                            <input type="text" class="form-control" name="company" value="<?php echo e($client->company); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Website')); ?></label>
                                            <input type="url" class="form-control" name="website" value="<?php echo e($client->website); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(language_data('Email')); ?></label>
                                            <span class="help"><?php echo e(language_data('If you leave this, then you can not reset password or can not maintain email related function')); ?></span>
                                            <input type="email" class="form-control" name="email" value="<?php echo e($client->email); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Phone')); ?></label>
                                            <input type="text" class="form-control" required name="phone" value="<?php echo e($client->phone); ?>">
                                        </div>



                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Address')); ?></label>
                                            <input type="text" class="form-control" name="address" value="<?php echo e($client->address1); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('More Address')); ?></label>
                                            <input type="text" class="form-control" name="more_address"  value="<?php echo e($client->address2); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('State')); ?></label>
                                            <input type="text" class="form-control" name="state"  value="<?php echo e($client->state); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('City')); ?></label>
                                            <input type="text" class="form-control" name="city"  value="<?php echo e($client->city); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(language_data('Postcode')); ?></label>
                                            <input type="text" class="form-control" name="postcode"  value="<?php echo e($client->postcode); ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="Country"><?php echo e(language_data('Country')); ?></label>
                                            <select name="country" class="form-control selectpicker" data-live-search="true">
                                                <?php echo countries($client->country); ?>

                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <input type="hidden" value="<?php echo e($client->id); ?>" name="cmd">
                                        <input type="submit" value="<?php echo e(language_data('Update')); ?>" class="btn btn-primary">
                                    </div>
                                </div>


                            </form>

                        </div>


                        <div role="tabpanel" class="tab-pane" id="change-picture">
                            <form role="form" action="<?php echo e(url('user/update-avatar')); ?>" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group input-group input-group-file">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        <?php echo e(language_data('Browse')); ?> <input type="file" class="form-control" name="image" accept="image/*">
                                                    </span>
                                                </span>
                                            <input type="text" class="form-control" readonly="">
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

<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>