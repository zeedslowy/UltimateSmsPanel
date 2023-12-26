<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e(app_config('AppName')); ?> - Verify Product code</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
    <?php echo Html::style("assets/libs/bootstrap/css/bootstrap.min.css"); ?>

    <?php echo Html::style("assets/libs/font-awesome/css/font-awesome.min.css"); ?>

    <?php echo Html::style("assets/css/style.css"); ?>

    <?php echo Html::style("assets/css/responsive.css"); ?>


</head>
<body>

<main id="wrapper" class="wrapper">
    <div class="container jumbo-container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="app-logo-inner text-center">
                    <img src="<?php echo asset(app_config('AppLogo')); ?>" alt="logo" class="bar-logo">
                </div>

                <div class="panel panel-30">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Verify Product code</h3>
                    </div>
                    <div class="panel-body">
                        <form class="" role="form" action="<?php echo e(url('post-verify-purchase-code')); ?>" method="post">

                            <div class="form-group form-group-default required">
                                <label for="purchase code">Purchase Code</label>
                                <input type="text" name="purchase_code" class="form-control" required autofocus>
                            </div>


                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Verify Now</button>
                        </form>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                    <div class="modal-dialog" role="document" style="margin-right: 600px;">
                        <div class="modal-content" style="width: 1000px;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Purchase Code</h4>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo e(asset('assets/img/find-item-purchase-code.png')); ?>" width="100%" height="599px">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-other-acction">
                    <div class="text-sm text-center">
                        <a href="#" data-toggle="modal" data-target="#modal-1">
                            You can find your purchase code here
                        </a>
                        <br>
                        <a href="<?php echo e(url('admin')); ?>"><?php echo e(language_data('Back To Sign in')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo Html::script("assets/libs/jquery-1.10.2.min.js"); ?>

<?php echo Html::script("assets/libs/jquery.slimscroll.min.js"); ?>

<?php echo Html::script("assets/libs/bootstrap/js/bootstrap.min.js"); ?>


</body>
</html>
