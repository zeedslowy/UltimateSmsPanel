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



<body class="has-left-bar has-top-bar <?php if(Auth::user()->menu_open==1): ?> left-bar-open <?php endif; ?>">

<nav id="left-nav" class="left-nav-bar">
    <div class="nav-top-sec">
        <div class="app-logo">
            <img src="<?php echo asset(app_config('AppLogo')); ?>" alt="logo" class="bar-logo" width="145px" height="35px">
        </div>

        <a href="#" id="bar-setting" class="bar-setting"><i class="fa fa-bars"></i></a>
    </div>
    <div class="nav-bottom-sec">
        <ul class="left-navigation" id="left-navigation">

            
            <li <?php if(Request::path()== 'admin/dashboard'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('admin/dashboard')); ?>"><span class="menu-text"><?php echo e(language_data('Dashboard')); ?></span> <span class="menu-thumb"><i class="fa fa-dashboard"></i></span></a></li>

                
                <li class="has-sub <?php if(Request::path()== 'clients/all' OR Request::path()=='clients/add' OR Request::path()=='clients/view/'.view_id() OR Request::path()=='clients/export-n-import' OR Request::path()== 'clients/groups'): ?> sub-open init-sub-open <?php endif; ?>">
                    <a href="#"><span class="menu-text"><?php echo e(language_data('Clients')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-user"></i></span></a>
                    <ul class="sub">

                        <li <?php if(Request::path()== 'clients/all' OR Request::path()=='clients/view/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('clients/all')); ?>><span class="menu-text"><?php echo e(language_data('All Clients')); ?></span> <span class="menu-thumb"><i class="fa fa-user"></i></span></a></li>

                        <li <?php if(Request::path()== 'clients/add'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('clients/add')); ?>><span class="menu-text"><?php echo e(language_data('Add New Client')); ?></span> <span class="menu-thumb"><i class="fa fa-user-plus"></i></span></a></li>

                        <li <?php if(Request::path()== 'clients/groups'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('clients/groups')); ?>"><span class="menu-text"><?php echo e(language_data('Clients Groups')); ?></span> <span class="menu-thumb"><i class="fa fa-users"></i></span></a></li>

                        <li <?php if(Request::path()== 'clients/export-n-import'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('clients/export-n-import')); ?>><span class="menu-text"><?php echo e(language_data('Export and Import Clients')); ?></span> <span class="menu-thumb"><i class="fa fa-file-excel-o"></i></span></a></li>

                    </ul>
                </li>


                
                <li class="has-sub <?php if(Request::path()== 'invoices/all' OR Request::path()=='invoices/add' OR Request::path()=='invoices/recurring' OR Request::path()=='invoices/view/'.view_id() OR Request::path()=='invoices/edit/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                    <a href="#"><span class="menu-text"><?php echo e(language_data('Invoices')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-credit-card"></i></span></a>
                    <ul class="sub">

                        <li <?php if(Request::path()== 'invoices/all'  OR Request::path()=='invoices/view/'.view_id() OR Request::path()=='invoices/edit/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('invoices/all')); ?>><span class="menu-text"><?php echo e(language_data('All Invoices')); ?></span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                        <li <?php if(Request::path()== 'invoices/recurring'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('invoices/recurring')); ?>><span class="menu-text"><?php echo e(language_data('Recurring')); ?> <?php echo e(language_data('Invoices')); ?></span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                        <li <?php if(Request::path()== 'invoices/add'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('invoices/add')); ?>><span class="menu-text"><?php echo e(language_data('Add New Invoice')); ?></span> <span class="menu-thumb"><i class="fa fa-plus"></i></span></a></li>

                    </ul>
                </li>



            
            <li class="has-sub <?php if(Request::path()== 'sms/phone-book' OR Request::path()== 'sms/import-contacts' OR Request::path()== 'sms/view-contact/'.view_id() OR Request::path()== 'sms/blacklist-contacts' OR Request::path()== 'sms/add-contact/'.view_id() OR Request::path()== 'sms/edit-contact/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Contacts')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-book"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()== 'sms/phone-book' OR Request::path()== 'sms/view-contact/'.view_id()  OR Request::path()== 'sms/add-contact/'.view_id() OR Request::path()== 'sms/edit-contact/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/phone-book')); ?>><span class="menu-text"> <?php echo e(language_data('Phone Book')); ?></span> <span class="menu-thumb"><i class="fa fa-book"></i></span></a></li>

                    <li <?php if(Request::path()== 'sms/import-contacts'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/import-contacts')); ?>><span class="menu-text"> <?php echo e(language_data('Import Contacts')); ?></span> <span class="menu-thumb"><i class="fa fa-plus"></i></span></a></li>

                    <li <?php if(Request::path()== 'sms/blacklist-contacts'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/blacklist-contacts')); ?>><span class="menu-text"> <?php echo e(language_data('Blacklist Contacts')); ?></span> <span class="menu-thumb"><i class="fa fa-remove"></i></span></a></li>

                </ul>
            </li>


            
            <li class="has-sub <?php if(Request::path()=='sms/price-plan' OR Request::path()=='sms/add-price-plan' OR Request::path()=='sms/coverage' OR Request::path()=='sms/manage-coverage/'.view_id() OR Request::path()== 'sms/add-plan-feature/'.view_id() OR Request::path()== 'sms/manage-price-plan/'.view_id()  OR Request::path()== 'sms/view-plan-feature/'.view_id() OR Request::path()== 'sms/manage-plan-feature/'.view_id() OR Request::path()=='sms/price-bundles'): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Recharge')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-shopping-cart"></i></span></a>
                <ul class="sub">


                    <li <?php if(Request::path()=='sms/price-bundles'  OR Request::path()=='sms/manage-price-bundles/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/price-bundles')); ?>><span class="menu-text"><?php echo e(language_data('Price Bundles')); ?></span> <span class="menu-thumb"><i class="fa fa-shopping-cart"></i></span></a></li>

                    <li <?php if(Request::path()== 'sms/price-plan' OR Request::path()== 'sms/add-plan-feature/'.view_id() OR Request::path()== 'sms/manage-price-plan/'.view_id() OR Request::path()== 'sms/view-plan-feature/'.view_id()  OR Request::path()== 'sms/manage-plan-feature/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/price-plan')); ?>><span class="menu-text"><?php echo e(language_data('SMS Price Plan')); ?></span> <span class="menu-thumb"><i class="fa fa-money"></i></span></a></li>

                    <li <?php if(Request::path()== 'sms/add-price-plan'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/add-price-plan')); ?>><span class="menu-text"><?php echo e(language_data('Add Price Plan')); ?></span> <span class="menu-thumb"><i class="fa fa-plus"></i></span></a></li>

                    <li <?php if(Request::path()=='sms/coverage' OR Request::path()=='sms/manage-coverage/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/coverage')); ?>><span class="menu-text"><?php echo e(language_data('Coverage')); ?></span> <span class="menu-thumb"><i class="fa fa-wifi"></i></span></a></li>

                </ul>
            </li>


                
                <li class="has-sub <?php if(Request::path()== 'sms/quick-sms'OR Request::path()== 'sms/send-sms' OR Request::path()=='sms/send-sms-file' OR Request::path()=='sms/send-schedule-sms' OR Request::path()=='sms/send-schedule-sms-file' OR Request::path()=='sms/sms-templates' OR Request::path()=='sms/manage-sms-template/'.view_id() OR Request::path()=='sms/create-sms-template' OR Request::path()== 'sms/update-schedule-sms' OR Request::path()=='sms/manage-update-schedule-sms/'.view_id() OR Request::path()== 'sms/sender-id-management' OR Request::path()=='sms/add-sender-id' OR Request::path()=='sms/view-sender-id/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                    <a href="#"><span class="menu-text"><?php echo e(language_data('Bulk SMS')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-mobile"></i></span></a>
                    <ul class="sub">


                        <li <?php if(Request::path()== 'sms/quick-sms'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/quick-sms')); ?>><span class="menu-text"><?php echo e(language_data('Send Quick SMS')); ?></span> <span class="menu-thumb"><i class="fa fa-space-shuttle"></i></span></a></li>

                        <li <?php if(Request::path()== 'sms/send-sms'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/send-sms')); ?>><span class="menu-text"><?php echo e(language_data('Send Bulk SMS')); ?></span> <span class="menu-thumb"><i class="fa fa-send"></i></span></a></li>

                        <li <?php if(Request::path()== 'sms/send-schedule-sms'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/send-schedule-sms')); ?>><span class="menu-text"><?php echo e(language_data('Send')); ?> <?php echo e(language_data('Schedule SMS')); ?></span> <span class="menu-thumb"><i class="fa fa-send-o"></i></span></a></li>

                        <li <?php if(Request::path()== 'sms/send-sms-file'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/send-sms-file')); ?>><span class="menu-text"><?php echo e(language_data('Send SMS From File')); ?></span> <span class="menu-thumb"><i class="fa fa-file-text"></i></span></a></li>

                        <li <?php if(Request::path()== 'sms/send-schedule-sms-file'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/send-schedule-sms-file')); ?>><span class="menu-text"><?php echo e(language_data('Schedule SMS From File')); ?></span> <span class="menu-thumb"><i class="fa fa-file-text-o"></i></span></a></li>

                        <li <?php if(Request::path()== 'sms/update-schedule-sms' OR Request::path()=='sms/manage-update-schedule-sms/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/update-schedule-sms')); ?>><span class="menu-text"><?php echo e(language_data('Update')); ?> <?php echo e(language_data('Schedule SMS')); ?></span> <span class="menu-thumb"><i class="fa fa-edit"></i></span></a></li>

                        <li <?php if(Request::path()== 'sms/sender-id-management' OR Request::path()=='sms/add-sender-id' OR Request::path()=='sms/view-sender-id/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/sender-id-management')); ?>><span class="menu-text"><?php echo e(language_data('Sender ID Management')); ?></span> <span class="menu-thumb"><i class="fa fa-user-secret"></i></span></a></li>

                        <li <?php if(Request::path()=='sms/sms-templates' OR Request::path()=='sms/create-sms-template' OR Request::path()=='sms/manage-sms-template/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/sms-templates')); ?>><span class="menu-text"><?php echo e(language_data('SMS Templates')); ?></span> <span class="menu-thumb"><i class="fa fa-file-code-o"></i></span></a></li>

                    </ul>
                </li>



            
            <li class="has-sub <?php if(Request::path()== 'sms/http-sms-gateway' OR Request::path()=='sms/smpp-sms-gateway' OR Request::path()=='sms/add-sms-gateways' OR Request::path()=='sms/gateway-manage/'.view_id() OR Request::path()=='sms/custom-gateway-manage/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('SMS Gateway')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-server"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()=='sms/http-sms-gateway'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/http-sms-gateway')); ?>><span class="menu-text"> HTTP <?php echo e(language_data('SMS Gateway')); ?></span> <span class="menu-thumb"><i class="fa fa-code"></i></span></a></li>

                    <li <?php if(Request::path()=='sms/smpp-sms-gateway'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/smpp-sms-gateway')); ?>><span class="menu-text"> SMPP <?php echo e(language_data('SMS Gateway')); ?></span> <span class="menu-thumb"><i class="fa fa-server"></i></span></a></li>

                </ul>
            </li>



            
            <li class="has-sub <?php if(Request::path()=='sms/history' OR Request::path()=='sms/view-inbox/'.view_id() OR Request::path()=='sms/reports/download' OR Request::path()=='sms/reports/delete'): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('Reports')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-list"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()=='sms/history' OR Request::path()=='sms/view-inbox/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms/history')); ?>><span class="menu-text"><?php echo e(language_data('SMS History')); ?></span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                </ul>
            </li>

            
            <li class="has-sub <?php if(Request::path()== 'sms-api/info' OR Request::path()== 'sms-api/sdk'): ?> sub-open init-sub-open <?php endif; ?>">
                <a href="#"><span class="menu-text"><?php echo e(language_data('SMS Api')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-plug"></i></span></a>
                <ul class="sub">

                    <li <?php if(Request::path()== 'sms-api/info'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms-api/info')); ?>><span class="menu-text"><?php echo e(language_data('SMS Api')); ?></span> <span class="menu-thumb"><i class="fa fa-cog"></i></span></a></li>

                    <li <?php if(Request::path()== 'sms-api/sdk'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('sms-api/sdk')); ?>><span class="menu-text"><?php echo e(language_data('SMS Api')); ?> SDK</span> <span class="menu-thumb"><i class="fa fa-download"></i></span></a></li>

                </ul>
            </li>



            
                <li class="has-sub <?php if(Request::path()== 'support-tickets/all' OR Request::path()=='support-tickets/create-new' OR Request::path()=='support-tickets/department' OR Request::path()=='support-tickets/view-department/'.view_id() OR Request::path()=='support-tickets/view-ticket/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                    <a href="#"><span class="menu-text"><?php echo e(language_data('Support Tickets')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-envelope"></i></span></a>
                    <ul class="sub">
                        <li <?php if(Request::path()== 'support-tickets/all'  OR Request::path()=='support-tickets/view-ticket/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('support-tickets/all')); ?>><span class="menu-text"><?php echo e(language_data('All')); ?> <?php echo e(language_data('Support Tickets')); ?></span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                        <li <?php if(Request::path()== 'support-tickets/create-new'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('support-tickets/create-new')); ?>><span class="menu-text"><?php echo e(language_data('Create New Ticket')); ?></span> <span class="menu-thumb"><i class="fa fa-plus"></i></span></a></li>

                        <li <?php if(Request::path()== 'support-tickets/department'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('support-tickets/department')); ?>><span class="menu-text"><?php echo e(language_data('Support Department')); ?></span> <span class="menu-thumb"><i class="fa fa-support"></i></span></a></li>

                    </ul>
                </li>




                
                <li class="has-sub <?php if(Request::path()== 'administrators/all' OR Request::path()=='administrators/manage/'.view_id() OR Request::path()=='administrators/role' OR Request::path()=='administrators/set-role/'.view_id()): ?> sub-open init-sub-open <?php endif; ?>">
                    <a href="#"><span class="menu-text"><?php echo e(language_data('Administrators')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-user"></i></span></a>
                    <ul class="sub">
                        <li <?php if(Request::path()== 'administrators/all'  OR Request::path()=='administrators/manage/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('administrators/all')); ?>><span class="menu-text"><?php echo e(language_data('Administrators')); ?></span> <span class="menu-thumb"><i class="fa fa-user"></i></span></a></li>

                        <li <?php if(Request::path()=='administrators/role' OR Request::path()=='administrators/set-role/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('administrators/role')); ?>><span class="menu-text"><?php echo e(language_data('Administrator Roles')); ?></span> <span class="menu-thumb"><i class="fa fa-user-secret"></i></span></a></li>

                    </ul>
                </li>



                
                <li class="has-sub <?php if(Request::path()== 'settings/general' OR Request::path()=='settings/localization'  OR Request::path()=='settings/email-templates'  OR Request::path()=='settings/email-template-manage/'.view_id() OR Request::path()=='settings/language-settings' OR Request::path()=='settings/language-settings-translate/'.view_id() OR Request::path()=='settings/language-settings-manage/'.view_id()  OR Request::path()=='settings/payment-gateways' OR Request::path()=='settings/payment-gateway-manage/'.view_id() OR Request::path()=='settings/background-jobs' OR Request::path()=='settings/purchase-code'): ?> sub-open init-sub-open <?php endif; ?>">
                    <a href="#"><span class="menu-text"><?php echo e(language_data('Settings')); ?></span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-cogs"></i></span></a>
                    <ul class="sub">

                        <li <?php if(Request::path()== 'settings/general'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('settings/general')); ?>><span class="menu-text"><?php echo e(language_data('System Settings')); ?></span> <span class="menu-thumb"><i class="fa fa-cog"></i></span></a></li>

                        <li <?php if(Request::path()== 'settings/localization'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('settings/localization')); ?>><span class="menu-text"><?php echo e(language_data('Localization')); ?></span> <span class="menu-thumb"><i class="fa fa-globe"></i></span></a></li>

                        <li <?php if(Request::path()== 'settings/email-templates' OR Request::path()=='settings/email-template-manage/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('settings/email-templates')); ?>><span class="menu-text"><?php echo e(language_data('Email Templates')); ?></span> <span class="menu-thumb"><i class="fa fa-envelope"></i></span></a></li>

                        <li <?php if(Request::path()== 'settings/language-settings' OR Request::path()=='settings/language-settings-manage/'.view_id() OR Request::path()=='settings/language-settings-translate/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('settings/language-settings')); ?>><span class="menu-text"><?php echo e(language_data('Language Settings')); ?></span> <span class="menu-thumb"><i class="fa fa-language"></i></span></a></li>

                        <li <?php if(Request::path()=='settings/payment-gateways' OR Request::path()=='settings/payment-gateway-manage/'.view_id()): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('settings/payment-gateways')); ?>><span class="menu-text"><?php echo e(language_data('Payment Gateways')); ?></span> <span class="menu-thumb"><i class="fa fa-paypal"></i></span></a></li>

                        <li <?php if(Request::path()=='settings/background-jobs'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('settings/background-jobs')); ?>><span class="menu-text">Background Jobs</span> <span class="menu-thumb"><i class="fa fa-clock-o"></i></span></a></li>

                        <li <?php if(Request::path()=='settings/purchase-code'): ?> class="active" <?php endif; ?>><a href=<?php echo e(url('settings/purchase-code')); ?>><span class="menu-text"><?php echo e(language_data('Purchase Code')); ?></span> <span class="menu-thumb"><i class="fa fa-key"></i></span></a></li>

                    </ul>
                </li>

            
            <li <?php if(Request::path()== 'admin/logout'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('admin/logout')); ?>"><span class="menu-text"><?php echo e(language_data('Logout')); ?></span> <span class="menu-thumb"><i class="fa fa-power-off"></i></span></a></li>

        </ul>
    </div>
</nav>

<main id="wrapper" class="wrapper">

    <div class="top-bar clearfix">
        <ul class="top-info-bar">

            <li class="dropdown bar-notification <?php if(count(latest_five_invoices(0))>0): ?> active <?php endif; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-shopping-cart"></i></a>
                <ul class="dropdown-menu arrow" role="menu">
                    <li class="title"><?php echo e(language_data('Recent 5 Unpaid Invoices')); ?></li>
                    <?php $__currentLoopData = latest_five_invoices(0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(url('invoices/view/'.$in->id)); ?>"><?php echo e(language_data('Amount')); ?> : <?php echo e($in->total); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="footer"><a href="<?php echo e(url('invoices/all')); ?>"><?php echo e(language_data('See All Invoices')); ?></a></li>
                </ul>
            </li>

            <li class="dropdown bar-notification <?php if(count(latest_five_tickets(0))>0): ?> active <?php endif; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope"></i></a>
                <ul class="dropdown-menu arrow message-dropdown" role="menu">
                    <li class="title"><?php echo e(language_data('Recent 5 Pending Tickets')); ?></li>
                    <?php $__currentLoopData = latest_five_tickets(0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(url('support-tickets/view-ticket/'.$st->id)); ?>">
                                <div class="name"><?php echo e($st->name); ?> <span><?php echo e($st->date); ?></span></div>
                                <div class="message"><?php echo e($st->subject); ?></div>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <li class="footer"><a href="<?php echo e(url('support-tickets/all')); ?>"><?php echo e(language_data('See All Tickets')); ?></a></li>
                </ul>
            </li>
        </ul>


        <div class="navbar-right">

            <div class="clearfix">
                <div class="dropdown user-profile pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="user-info"><?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?></span>

                        <?php if(Auth::user()->image!=''): ?>
                            <img class="user-image" src="<?php echo asset('assets/admin_pic/'.Auth::user()->image); ?>" alt="<?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?>">
                        <?php else: ?>
                            <img class="user-image" src="<?php echo asset('assets/admin_pic/profile.jpg'); ?>" alt="<?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?>">
                        <?php endif; ?>

                    </a>
                    <ul class="dropdown-menu arrow right-arrow" role="menu">
                        <li><a href="<?php echo e(url('admin/edit-profile')); ?>"><i class="fa fa-edit"></i> <?php echo e(language_data('Update Profile')); ?></a></li>
                        <li><a href="<?php echo e(url('admin/change-password')); ?>"><i class="fa fa-lock"></i> <?php echo e(language_data('Change Password')); ?></a></li>
                        <li class="bg-dark">
                            <a href="<?php echo e(url('admin/logout')); ?>" class="clearfix">
                                <span class="pull-left"><?php echo e(language_data('Logout')); ?></span>
                                <span class="pull-right"><i class="fa fa-power-off"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="top-info-bar m-r-10">

                    <div class="dropdown pull-right bar-notification">
                        <a href="#" class="dropdown-toggle text-success" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img src="<?php echo asset('assets/country_flag/'.\App\Language::find(app_config('Language'))->icon); ?>" alt="Language">
                        </a>
                        <ul class="dropdown-menu lang-dropdown arrow right-arrow" role="menu">
                            <?php $__currentLoopData = get_language(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(url('language/change/'.$lan->id)); ?>" <?php if($lan->id==app_config('Language')): ?> class="text-complete" <?php endif; ?>>
                                        <img class="user-thumb" src="<?php echo asset('assets/country_flag/'.$lan->icon); ?>" alt="user thumb">
                                        <div class="user-name"><?php echo e($lan->language); ?></div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>

    

    <?php echo $__env->yieldContent('content'); ?>

    

    <input type="hidden" id="_url" value="<?php echo e(url('/')); ?>">
    <input type="hidden" id="_sms_gateway_count" value="<?php echo e(active_sms_gateway()); ?>">
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
        $.post(_url+'/admin/menu-open-status');
    });

    var _active_gateway = $('#_sms_gateway_count').val();

    if (_active_gateway == 0){
        alertify.log("<i class='fa fa-times-circle'></i> <span>There is no active sms gateway yet. <a href="+_url+'/sms/http-sms-gateway'+"> Click </a>  to configure one.</span>", "warning", 0);
    }

</script>



<?php echo $__env->yieldContent('script'); ?>


</body>

</html>