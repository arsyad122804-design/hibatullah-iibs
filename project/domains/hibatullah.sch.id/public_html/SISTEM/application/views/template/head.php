<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title><?= $TitelPage ?></title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("assets/") ?>images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("assets/") ?>images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("assets/") ?>images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->

	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/styles/core.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/plugins/datatables/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/plugins/bootstrap-select/bootstrap-select.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/plugins/bootstrap-select/bootstrap-select.min.css">

	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/styles/jquery.steps.css">

	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/styles/style_v2.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/styles/theme.css">
	<script src="<?= base_url() ?>assets/src/scripts/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/styles/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/plugins/switchery/switchery.min.css">

	<script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/") ?>src/plugins/jquery-asColorPicker/dist/css/asColorPicker.css">
</head>

<body class="sidebar-dark">

	<span class="loader" style="display: none;">
		<span class="inner-spinner"></span>
	</span>