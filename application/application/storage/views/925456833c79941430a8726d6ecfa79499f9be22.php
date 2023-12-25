<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>

    <title><?php echo e(language_data('Invoice')); ?> -<?php echo e($inv->id); ?></title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <style>

        * {
            margin: 0;
            padding: 0;
        }

        body {
            font: 14px/1.4 Helvetica, Arial, sans-serif;
        }

        #page-wrap {
            width: 800px;
            margin: 0 auto;
        }

        textarea {
            border: 0;
            font: 14px Helvetica, Arial, sans-serif;
            overflow: hidden;
            resize: none;
        }

        table {
            border-collapse: collapse;
        }

        table td, table th {
            border: 1px solid black;
            padding: 5px;
        }

        #header {
            height: 15px;
            width: 100%;
            margin: 20px 0;
            background: #222;
            text-align: center;
            color: white;
            font: bold 15px Helvetica, Sans-Serif;
            text-decoration: uppercase;
            letter-spacing: 20px;
            padding: 8px 0px;
        }

        #address {
            width: 250px;
            height: 150px;
            float: left;
        }

        #customer {
            overflow: hidden;
        }

        #logo {
            text-align: right;
            float: right;
            position: relative;
            margin-top: 25px;
            border: 1px solid #fff;
            max-width: 540px;
            overflow: hidden;
        }

        #customer-title {
            font-size: 20px;
            font-weight: bold;
            float: left;
        }

        #meta {
            margin-top: 1px;
            width: 100%;
            float: right;
        }

        #meta td {
            text-align: right;
        }

        #meta td.meta-head {
            text-align: left;
            background: #eee;
        }

        #meta td textarea {
            width: 100%;
            height: 20px;
            text-align: right;
        }

        #items {
            clear: both;
            width: 100%;
            margin: 30px 0 0 0;
            border: 1px solid black;
        }

        #items th {
            background: #eee;
        }

        #items textarea {
            width: 80px;
            height: 50px;
        }

        #items tr.item-row td {
            vertical-align: top;
        }

        #items td.description {
            width: 300px;
        }

        #items td.item-name {
            width: 175px;
        }

        #items td.description textarea, #items td.item-name textarea {
            width: 100%;
        }

        #items td.total-line {
            border-right: 0;
            text-align: right;
        }

        #items td.total-value {
            border-left: 0;
            padding: 10px;
        }

        #items td.total-value textarea {
            height: 20px;
            background: none;
        }

        #items td.balance {
            background: #eee;
        }

        #items td.blank {
            border: 0;
        }

        #terms {
            text-align: center;
            margin: 20px 0 0 0;
        }

        #terms h5 {
            text-transform: uppercase;
            font: 13px Helvetica, Sans-Serif;
            letter-spacing: 10px;
            border-bottom: 1px solid black;
            padding: 0 0 8px 0;
            margin: 0 0 8px 0;
        }

        #terms textarea {
            width: 100%;
            text-align: center;
        }

        .delete-wpr {
            position: relative;
        }

        .delete {
            display: block;
            color: #000;
            text-decoration: none;
            position: absolute;
            background: #EEEEEE;
            font-weight: bold;
            padding: 0px 3px;
            border: 1px solid;
            top: -6px;
            left: -22px;
            font-family: Verdana;
            font-size: 12px;
        }
        .text-center{
            text-align: center;
        }
        .text-success{
            color:#30ddbc ;
        }
    </style>

</head>

<body>

<div id="page-wrap">

    <table width="100%">
        <tr>
            <td style="border: 0;  text-align: left" width="62%">
                <span style="font-size: 18px; color: #2f4f4f"><strong><?php echo e(language_data('Invoice')); ?> # <?php echo e($inv->id); ?></strong></span>
            </td>
            <td style="border: 0;  text-align: right" width="62%">
                <div id="logo">
                    <h3><?php echo e(app_config('AppName')); ?></h3><br>
                    <?php echo app_config('Address'); ?>

                </div>
            </td>
        </tr>

    </table>

    <div style="clear:both"></div>

    <div id="customer">

        <table id="meta">
            <tr>
                <td rowspan="5" style="border: 1px solid white; border-right: 1px solid black; text-align: left" width="62%"> <?php echo e($inv->cname); ?>

                    <br>
                    <?php echo e($client->address1); ?> <br>
                    <?php echo e($client->address2); ?> <br>
                    <?php echo e($client->state); ?>, <?php echo e($client->city); ?> - <?php echo e($client->postcode); ?>, <?php echo e($client->country); ?>

                    <br>
                    <?php if($client->phone!=''): ?>
                        <?php echo e($client->phone); ?>

                        <br>
                    <?php endif; ?>
                    <?php if($client->email!=''): ?>
                        <?php echo e($client->email); ?>

                    <?php endif; ?>
                </td>
                <td class="meta-head"><?php echo e(language_data('Invoice')); ?> #</td>
                <td><?php echo e($inv->id); ?></td>
            </tr>
            <tr>

                <td class="meta-head"><?php echo e(language_data('Status')); ?></td>
                <td><?php echo e(get_date_format($inv->status)); ?></td>
            </tr>
            <tr>

                <td class="meta-head"><?php echo e(language_data('Invoice Date')); ?></td>
                <td><?php echo e(get_date_format($inv->created)); ?></td>
            </tr>
            <tr>

                <td class="meta-head"><?php echo e(language_data('Due Date')); ?></td>
                <td><?php echo e(get_date_format($inv->duedate)); ?></td>
            </tr>

            <tr>

                <td class="meta-head"><?php echo e(language_data('Amount Due')); ?></td>
                <td>
                    <div class="due"><?php echo app_config('CurrencyCode'); ?> <?php echo e($inv->total); ?></div>
                </td>
            </tr>

        </table>

    </div>

    <table id="items">

        <tr>
            <th width="65%"><?php echo e(language_data('Item')); ?></th>
            <th align="right"><?php echo e(language_data('Price')); ?></th>
            <th align="right"><?php echo e(language_data('Quantity')); ?></th>
            <th align="right"><?php echo e(language_data('Total')); ?></th>

        </tr>


        <?php $__currentLoopData = $inv_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="item-row">
                <td class="description"><?php echo e($it->item); ?></td>
                <td align="right"><?php echo app_config('CurrencyCode'); ?> <?php echo e($it->price); ?></td>
                <td align="right"><?php echo e($it->qty); ?></td>
                <td align="right"><?php echo app_config('CurrencyCode'); ?> <?php echo e($it->subtotal); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($tax_sum!='0.00' OR $tax_sum!=''): ?>
            <tr>
                <td class="blank"></td>
                <td colspan="2" class="total-line"><?php echo e(language_data('Subtotal')); ?></td>
                <td class="total-value">
                    <div id="subtotal"><?php echo app_config('CurrencyCode'); ?> <?php echo e($inv->subtotal); ?></div>
                </td>
            </tr>
            <tr>

                <td class="blank text-center text-success"><?php if($inv->status=='Paid'): ?> <h1>Paid</h1> <?php endif; ?></td>
                <td colspan="2" class="total-line"><?php echo e(language_data('Tax')); ?></td>
                <td class="total-value">
                    <div id="total"><?php echo app_config('CurrencyCode'); ?> <?php echo e($tax_sum); ?></div>
                </td>
            </tr>
        <?php endif; ?>

        <?php if($dis_sum!='0.00' OR $dis_sum!=''): ?>
            <tr>
                <td class="blank"></td>
                <td colspan="2" class="total-line"><?php echo e(language_data('Discount')); ?></td>
                <td class="total-value">
                    <div id="total"><?php echo app_config('CurrencyCode'); ?> <?php echo e($dis_sum); ?></div>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td class="blank"></td>
            <td colspan="2" class="total-line balance"><?php echo e(language_data('Grand Total')); ?></td>
            <td class="total-value balance">
                <div class="due"><?php echo app_config('CurrencyCode'); ?> <?php echo e($inv->total); ?></div>
            </td>
        </tr>

    </table>

    <?php if($inv->note!=''): ?>
        <div id="terms">
            <h5><?php echo e(language_data('Invoice Note')); ?></h5>
            <?php echo e($inv->note); ?>

        </div>
    <?php endif; ?>


</div>

</body>

</html>