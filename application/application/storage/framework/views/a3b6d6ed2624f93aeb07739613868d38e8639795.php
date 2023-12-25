<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo e(app_config('AppTitle')); ?></title>
    <link rel="icon" type="image/x-icon"  href="<?php echo asset(app_config('AppFav')); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
    <?php echo Html::style("assets/libs/bootstrap/css/bootstrap.min.css"); ?>

    <?php echo Html::style("assets/libs/bootstrap-toggle/css/bootstrap-toggle.min.css"); ?>

    <?php echo Html::style("assets/libs/font-awesome/css/font-awesome.min.css"); ?>

    <?php echo Html::style("assets/libs/alertify/css/alertify.css"); ?>

    <?php echo Html::style("assets/libs/alertify/css/alertify-bootstrap-3.css"); ?>

    <?php echo Html::style("assets/libs/bootstrap-select/css/bootstrap-select.min.css"); ?>


    

    <?php echo $__env->yieldContent('style'); ?>

    

    <?php echo Html::style("assets/css/style.css"); ?>

    <?php echo Html::style("assets/css/admin.css"); ?>

    <?php echo Html::style("assets/css/responsive.css"); ?>



</head>



<body class="has-left-bar has-top-bar <?php if(Auth::guard('client')->user()->menu_open==1): ?> left-bar-open <?php endif; ?>">

<nav id="left-nav" class="left-nav-bar">
    <div class="nav-top-sec">
        <div class="app-logo">
            <img src="<?php echo asset(app_config('AppLogo')); ?>" alt="logo" class="bar-logo" width="145px" height="35px">
        </div>

        <a href="#" id="bar-setting" class="bar-setting"><i class="fa fa-bars"></i></a>
    </div>
    <div class="nav-bottom-sec">
        <ul class="left-navigation" id="left-navigation">

            
            <li <?php if(Request::path()== 'dashboard'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('dashboard')); ?>"><span class="menu-text"><?php echo e(language_data('Dashboard')); ?></span> <span class="menu-thumb"><i class="fa fa-dashboard"></i></span></a></li>


            <?php if(Auth::guard('client')->user()->reseller=='Yes'): ?>
            
            <li class="has-sub <?php if(Request::path()== 'user/all' OR Request::path()=='user/add' OR Request::path()=='user/view/'.view_id() OR Request::path()=='user/export-n-import' OR Request::path()== 'users/groups'): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Clients')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-user"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()== 'user/all' OR Request::path()=='user/view/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/all')); ?>><span class="menu-text"><?php echo e(language_data('All Clients')); ?></span> <span class="menu-thumb"><i class="fa fa-user"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/add'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/add')); ?>><span class="menu-text"><?php echo e(language_data('Add New Client')); ?></span> <span class="menu-thumb"><i class="fa fa-user-plus"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/export-n-import'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/export-n-import')); ?>><span class="menu-text"><?php echo e(language_data('Export and Import Clients')); ?></span> <span class="menu-thumb"><i class="fa fa-file-excel-o"></i></span></a></li>


                    <li <?php if(Request::path()== 'users/groups'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('users/groups')); ?>"><span class="menu-text"><?php echo e(language_data('Clients Groups')); ?></span> <span class="menu-thumb"><i class="fa fa-users"></i></span></a></li>

                </ul>
            </li>

            <?php endif; ?>

            
            <li class="has-sub <?php if(Request::path()== 'user/invoices/all' OR Request::path()=='user/invoices/recurring' OR Request::path()=='user/invoices/pay-invoice' OR Request::path()=='user/invoices/view/'.view_id() OR Request::path()=='user/invoices/edit/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Invoices')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-credit-card"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()== 'user/invoices/all' OR Request::path()=='user/invoices/pay-invoice'  OR Request::path()=='user/invoices/view/'.view_id() OR Request::path()=='user/invoices/edit/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/invoices/all')); ?>><span class="menu-text"><?php echo e(language_data('All Invoices')); ?></span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/invoices/recurring'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/invoices/recurring')); ?>><span class="menu-text"><?php echo e(language_data('Recurring')); ?> <?php echo e(language_data('Invoices')); ?></span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                </ul>
            </li>

            
            

            <li class="has-sub <?php if(Request::path()== 'user/phone-book' OR Request::path()== 'user/sms/import-contacts' OR Request::path()== 'user/add-contact/'.view_id()  OR Request::path()== 'user/view-contact/'.view_id()  OR Request::path()== 'user/sms/blacklist-contacts' OR Request::path()== 'user/edit-contact/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Contacts')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-book"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()== 'user/phone-book' OR Request::path()== 'user/add-contact/'.view_id() OR Request::path()== 'user/view-contact/'.view_id() OR Request::path()== 'user/edit-contact/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/phone-book')); ?>><span class="menu-text"><?php echo e(language_data('Phone Book')); ?></span> <span class="menu-thumb"><i class="fa fa-book"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/sms/import-contacts'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/import-contacts')); ?>><span class="menu-text"> <?php echo e(language_data('Import Contacts')); ?></span> <span class="menu-thumb"><i class="fa fa-plus"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/sms/blacklist-contacts'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/blacklist-contacts')); ?>><span class="menu-text"> <?php echo e(language_data('Blacklist Contacts')); ?></span> <span class="menu-thumb"><i class="fa fa-remove"></i></span></a></li>

                </ul>
            </li>

            

            <li class="has-sub <?php if(Request::path()== 'user/sms/post-purchase-sms-plan' OR Request::path()=='user/sms/purchase-sms-plan' OR Request::path()=='user/sms/sms-plan-feature/'.view_id() OR Request::path()== 'user/sms/buy-unit'): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Recharge')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-shopping-cart"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()== 'user/sms/purchase-sms-plan' OR Request::path()== 'user/sms/post-purchase-sms-plan' OR Request::path()=='user/sms/sms-plan-feature/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/purchase-sms-plan')); ?>><span class="menu-text"><?php echo e(language_data('Purchase SMS Plan')); ?></span> <span class="menu-thumb"><i class="fa fa-credit-card"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/sms/buy-unit'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/buy-unit')); ?>><span class="menu-text"><?php echo e(language_data('Buy Unit')); ?></span> <span class="menu-thumb"><i class="fa fa-shopping-cart"></i></span></a></li>

                </ul>
            </li>


            
            <li class="has-sub <?php if(Request::path()== 'user/sms/quick-sms' OR Request::path()== 'user/sms/send-sms' OR Request::path()=='user/sms/send-sms-file' OR Request::path()=='user/sms/send-schedule-sms' OR Request::path()=='user/sms/send-schedule-sms-file' OR Request::path()=='user/sms/sender-id-management' OR Request::path()=='user/sms/add-sender-id' OR Request::path()=='user/sms/view-sender-id/'.view_id() OR Request::path()== 'user/sms/update-schedule-sms' OR Request::path()=='user/sms/manage-update-schedule-sms/'.view_id() OR Request::path()=='user/sms/sms-templates' OR Request::path()=='user/sms/create-sms-template' OR Request::path()=='user/sms/manage-sms-template/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Bulk SMS')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-mobile"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()== 'user/sms/quick-sms'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/quick-sms')); ?>><span class="menu-text"><?php echo e(language_data('Send Quick SMS')); ?></span> <span class="menu-thumb"><i class="fa fa-space-shuttle"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/sms/send-sms'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/send-sms')); ?>><span class="menu-text"><?php echo e(language_data('Send Bulk SMS')); ?></span> <span class="menu-thumb"><i class="fa fa-send"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/sms/send-schedule-sms'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/send-schedule-sms')); ?>><span class="menu-text"><?php echo e(language_data('Send')); ?> <?php echo e(language_data('Schedule SMS')); ?></span> <span class="menu-thumb"><i class="fa fa-send-o"></i></span></a></li>


                    <li <?php if(Request::path()== 'user/sms/send-sms-file'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/send-sms-file')); ?>><span class="menu-text"><?php echo e(language_data('Send SMS From File')); ?></span> <span class="menu-thumb"><i class="fa fa-file-text"></i></span></a></li>


                    <li <?php if(Request::path()== 'user/sms/send-schedule-sms-file'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/send-schedule-sms-file')); ?>><span class="menu-text"><?php echo e(language_data('Schedule SMS From File')); ?></span> <span class="menu-thumb"><i class="fa fa-file-text-o"></i></span></a></li>

                     <li <?php if(Request::path()== 'user/sms/update-schedule-sms' OR Request::path()=='user/sms/manage-update-schedule-sms/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/update-schedule-sms')); ?>><span class="menu-text"><?php echo e(language_data('Update')); ?> <?php echo e(language_data('Schedule SMS')); ?></span> <span class="menu-thumb"><i class="fa fa-edit"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/sms/sender-id-management' OR Request::path()=='user/sms/add-sender-id' OR Request::path()=='user/sms/view-sender-id/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/sender-id-management')); ?>><span class="menu-text"><?php echo e(language_data('Sender ID Management')); ?></span> <span class="menu-thumb"><i class="fa fa-user-secret"></i></span></a></li>


                    <li <?php if(Request::path()=='user/sms/sms-templates' OR Request::path()=='user/sms/create-sms-template' OR Request::path()=='user/sms/manage-sms-template/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/sms-templates')); ?>><span class="menu-text"><?php echo e(language_data('SMS Templates')); ?></span> <span class="menu-thumb"><i class="fa fa-file-code-o"></i></span></a></li>

                </ul>
            </li>


            

            <li class="has-sub <?php if(Request::path()=='user/sms/history' OR Request::path()=='user/sms/view-inbox/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Reports')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-shopping-cart"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()=='user/sms/history' OR Request::path()=='user/sms/view-inbox/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms/history')); ?>><span class="menu-text"><?php echo e(language_data('SMS History')); ?></span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                </ul>
            </li>



            <?php if(Auth::guard('client')->user()->api_access=='Yes'): ?>

                
                <li class="has-sub <?php if(Request::path()== 'user/sms-api/info' OR Request::path()== 'user/sms-api/sdk'): ?> sub-open init-sub-open <?php endif; ?>">
                    <a href="#"><span class="menu-text"><?php echo e(language_data('SMS Api')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-plug"></i></span></a>
                    <ul class="sub">

                        <li <?php if(Request::path()== 'user/sms-api/info'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms-api/info')); ?>><span class="menu-text"><?php echo e(language_data('SMS Api')); ?></span> <span class="menu-thumb"><i class="fa fa-cog"></i></span></a></li>

                        <li <?php if(Request::path()== 'user/sms-api/sdk'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/sms-api/sdk')); ?>><span class="menu-text"><?php echo e(language_data('SMS Api')); ?> SDK</span> <span class="menu-thumb"><i class="fa fa-download"></i></span></a></li>

                    </ul>
                </li>

            <?php endif; ?>


            
            <li class="has-sub <?php if(Request::path()== 'user/tickets/all' OR Request::path()=='user/tickets/create-new' OR Request::path()=='user/tickets/view-ticket/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Support Tickets')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-envelope"></i></span></a>
                <ul class="sub">
                    <li <?php if(Request::path()== 'user/tickets/all'  OR Request::path()=='user/tickets/view-ticket/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/tickets/all')); ?>><span class="menu-text"><?php echo e(language_data('All')); ?> <?php echo e(language_data('Support Tickets')); ?></span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                    <li <?php if(Request::path()== 'user/tickets/create-new'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('user/tickets/create-new')); ?>><span class="menu-text"><?php echo e(language_data('Create New Ticket')); ?></span> <span class="menu-thumb"><i class="fa fa-plus"></i></span></a></li>

                </ul>
            </li>


            
            <li <?php if(Request::path()== 'logout'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('logout')); ?>"><span class="menu-text"><?php echo e(language_data('Logout')); ?></span> <span class="menu-thumb"><i class="fa fa-power-off"></i></span></a></li>

        </ul>
    </div>
</nav>

<main id="wrapper" class="wrapper">

    <div class="top-bar clearfix">
        <ul class="top-info-bar">
            <li class="dropdown bar-notification <?php if(count(latest_five_invoices(Auth::guard('client')->user()->id))>0): ?> active <?php endif; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-shopping-cart"></i></a>
                <ul class="dropdown-menu arrow" role="menu">
                    <li class="title"><?php echo e(language_data('Recent 5 Unpaid Invoices')); ?></li>
                    <?php $__currentLoopData = latest_five_invoices(Auth::guard('client')->user()->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(url('user/invoices/view/'.$in->id)); ?>"><?php echo e(language_data('Amount')); ?> : <?php echo e($in->total); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="footer"><a href="<?php echo e(url('user/invoices/all')); ?>"><?php echo e(language_data('See All Invoices')); ?></a></li>
                </ul>
            </li>

            <li class="dropdown bar-notification <?php if(count(latest_five_tickets(Auth::guard('client')->user()->id))>0): ?> active <?php endif; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope"></i></a>
                <ul class="dropdown-menu arrow message-dropdown" role="menu">
                    <li class="title"><?php echo e(language_data('Recent 5 Pending Tickets')); ?></li>
                    <?php $__currentLoopData = latest_five_tickets(Auth::guard('client')->user()->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(url('user/tickets/view-ticket/'.$st->id)); ?>">
                                <div class="name"><?php echo e($st->name); ?> <span><?php echo e($st->date); ?></span></div>
                                <div class="message"><?php echo e($st->subject); ?></div>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <li class="footer"><a href="<?php echo e(url('user/tickets/all')); ?>"><?php echo e(language_data('See All Tickets')); ?></a></li>
                </ul>
            </li>
        </ul>
        <div class="navbar-right">

            <div class="clearfix">
                <div class="dropdown user-profile pull-right">


                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="user-info text-complete text-uppercase m-r-30"><?php echo e(language_data('SMS Balance')); ?> : <?php echo e(Auth::guard('client')->user()->sms_limit); ?></span>


                        <span class="user-info"><?php echo e(Auth::guard('client')->user()->fname); ?> <?php echo e(Auth::guard('client')->user()->lname); ?></span>

                        <?php if(Auth::guard('client')->user()->image!=''): ?>
                            <img class="user-image" src="<?php echo asset('assets/client_pic/'.Auth::guard('client')->user()->image); ?>" alt="<?php echo e(Auth::guard('client')->user()->fname); ?> <?php echo e(Auth::guard('client')->user()->lname); ?>">
                        <?php else: ?>
                            <img class="user-image" src="<?php echo asset('assets/client_pic/profile.jpg'); ?>" alt="<?php echo e(Auth::guard('client')->user()->fname); ?> <?php echo e(Auth::guard('client')->user()->lname); ?>">
                        <?php endif; ?>

                    </a>
                    <ul class="dropdown-menu arrow right-arrow" role="menu">
                        <li><a href="<?php echo e(url('user/edit-profile')); ?>"><i class="fa fa-edit"></i> <?php echo e(language_data('Update Profile')); ?></a></li>
                        <li><a href="<?php echo e(url('user/change-password')); ?>"><i class="fa fa-lock"></i> <?php echo e(language_data('Change Password')); ?></a></li>
                        <li class="bg-dark">
                            <a href="<?php echo e(url('logout')); ?>" class="clearfix">
                                <span class="pull-left"><?php echo e(language_data('Logout')); ?></span>
                                <span class="pull-right"><i class="fa fa-power-off"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>

    

    <?php echo $__env->yieldContent('content'); ?>

    

    <input type="hidden" id="_url" value="<?php echo e(url('/')); ?>">
</main>


<?php echo Html::script("assets/libs/jquery-1.10.2.min.js"); ?>

<?php echo Html::script("assets/libs/jquery.slimscroll.min.js"); ?>

<?php echo Html::script("assets/libs/bootstrap/js/bootstrap.min.js"); ?>

<?php echo Html::script("assets/libs/bootstrap-toggle/js/bootstrap-toggle.min.js"); ?>

<?php echo Html::script("assets/libs/alertify/js/alertify.js"); ?>

<?php echo Html::script("assets/libs/bootstrap-select/js/bootstrap-select.min.js"); ?>

<?php echo Html::script("assets/js/scripts.js"); ?>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
        }
    });

    var _url=$('#_url').val();

    $('#bar-setting').click(function(e){
        e.preventDefault();
        $.post(_url+'/user/menu-open-status');
    });
</script>



<?php echo $__env->yieldContent('script'); ?>


</body>

</html>