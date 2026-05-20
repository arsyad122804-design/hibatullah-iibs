<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>SISTEM PPDB PONPES HIBATULLAH</title>
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
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/src/styles/style_v2.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/src/styles/theme.css">
</head>

<body class="login-page">
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-8 ">
                </div>
                <!-- <div class="col-md-12 col-lg-4 img-login "  >
                    <img src="<?= base_url() ?>assets/images/login-page-21.png" alt="siata" width="100%">
                </div> -->
                <div class="col-md-4 col-lg-4">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <img src="<?= base_url() ?>assets/images/logo-light@2x.png" alt="">
                            <div class="text-center  TextLogin"><span class="btn-block p-3" style="font-weight: 900;"><?= $message ?></span></div>
                        </div>
                        <?= form_open("auth/chekingdata", array('id' => 'login')); ?>
                        <div class="input-group custom">
                            <input type="text" class="form-control form-control-lg" autocomplete="off" name="usn" id="usn" placeholder="Username" required />
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input type="password" class="form-control form-control-lg" autocomplete="off" name="pss" id="pass" placeholder="**********" required />
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                            </div>
                        </div>
                        <div class="row pb-30">
                            <!-- <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="forgot-password"><a href="<?= base_url("forgot_password") ?>">Forgot Password</a></div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <button class="btn btn-primary btn-lg btn-block" id="Login_system">Sign In</button>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                        <div class="col-md-12 align-item-center pt-2" style="text-align: center;"><a style="text-align: center;" href="<?= base_url('privacy_policy') ?>"> Privacy & Kebijakan</a></div>
                    </div>

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