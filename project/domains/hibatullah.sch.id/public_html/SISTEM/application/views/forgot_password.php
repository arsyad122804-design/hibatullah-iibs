<!DOCTYPE html>

<html>



<head>

    <!-- Basic Page Info -->

    <meta charset="utf-8">

    <title>SIATA - Halaman Login </title>



    <!-- Site favicon -->

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("assets/") ?>images/apple-touch-icon.png">

    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("assets/") ?>images/favicon-32x32.png">

    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("assets/") ?>images/favicon-16x16.png">



    <!-- Mobile Specific Metas -->

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">



    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/src/styles/core.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendors/styles/icon-font.min.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/src/styles/style.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/src/styles/theme.css">


    <style>
        .login-box-forgot {
            max-width: 480px;
            width: 100%;
            padding: 40px 20px;
            margin: 5px auto
        }
    </style>
</head>



<body class="login-page">

    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-2 img-login">
                </div>

                <div class="col-md-8">

                    <div class="login-box-forgot bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Forgot Password</h2>
                        </div>
                        <p class="mb-20">Untuk melakukan reset password, silahkan masukkan username dan alamat email anda.</p>

                        <?= form_open("forgot_password/email_reset", array('id' => 'reset')); ?>
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" autocomplete="off" name="usn" id="usn" placeholder="Username" required />
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="email" class="form-control form-control-lg" placeholder="Email" name="eml" required />
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-5">
                                <div class="input-group mb-0">
                                    <!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
										-->
                                    <!-- <button  class="btn btn-primary btn-lg btn-block">Submit</button> -->
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="font-16 weight-600 text-center" data-color="#707373">OR</div>
                            </div>
                            <div class="col-5">
                                <div class="input-group mb-0">
                                    <a class="btn btn-outline-primary btn-lg btn-block" href="<?= base_url() ?>">Login</a>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>

                </div>

                <div class="col-lg-2 img-login">
                </div>

            </div>

        </div>

    </div>

    <!-- js -->

    <script src="<?= base_url() ?>assets/vendors/scripts/core.js"></script>

    <script src="<?= base_url() ?>assets/vendors/scripts/script.min.js"></script>

    <script src="<?= base_url() ?>assets/vendors/scripts/process.js"></script>

    <script src="<?= base_url() ?>assets/vendors/scripts/layout-settings.js"></script>

    <script>
        var urls = '<?= base_url() ?>';
    </script>

    <script src="<?= base_url() ?>assets/src/api-js/login.js"></script>

</body>



</html>