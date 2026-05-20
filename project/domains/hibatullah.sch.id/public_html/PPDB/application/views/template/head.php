<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="author" content="siata">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/logo.ico" type="image/x-icon" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href=<?= base_url('assets/img/logo.png') ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url() ?>assets/logo.ico">
    <link rel="apple-touch-icon-precomposed" href="<?= base_url() ?>assets/logo.ico">

    <!-- Favicon -->
    <link href="<?= base_url('assets/') ?>img/favicon.ico" rel="icon">


    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url('assets/') ?>lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/') ?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url('assets/') ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <!-- Template Stylesheet -->
    <link href="<?= base_url('assets/') ?>css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-2">
            <a href="<?= base_url() ?>">
            </a>
            <a href="<?= base_url() ?>" class="navbar-brand" style="position:absolute;">
                <img src=" <?= base_url('assets/img/logo.png') ?>" style="width:80px">
            </a>
            <a href="<?= base_url('formulir') ?>" class="navbar-toggler  btn btn-primary bg-primary rounded-pill px-3 py-2">DAFTAR <i class="fa fa-arrow-right ms-3"></i>
            </a>

            <!-- 
            <a href="" class="navbar-toggler btn btn-primary rounded-pill px-3 d-none d-lg-block">DAFTAR <i class="fa fa-arrow-right ms-3"></i></a> -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <!-- <a href="index.html" class="nav-item nav-link active">Home</a>
                    <a href="about.html" class="nav-item nav-link">About Us</a>
                    <a href="classes.html" class="nav-item nav-link">Classes</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu rounded-0 rounded-bottom border-0 shadow-sm m-0">
                            <a href="facility.html" class="dropdown-item">School Facilities</a>
                            <a href="team.html" class="dropdown-item">Popular Teachers</a>
                            <a href="call-to-action.html" class="dropdown-item">Become A Teachers</a>
                            <a href="appointment.html" class="dropdown-item">Make Appointment</a>
                            <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            <a href="404.html" class="dropdown-item">404 Error</a>
                        </div>
                    </div>
                    <a href="contact.html" class="nav-item nav-link">Contact Us</a> -->
                </div>
                <a href="<?= base_url('formulir') ?>" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">DAFTAR <i class="fa fa-arrow-right ms-3"></i></a>
            </div>
        </nav>
        <!-- Navbar End -->