<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<meta charset="utf-8">
<title><?php echo html_escape($page_title); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Checklist dashboard">

<link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">
<script src="<?php echo base_url('assets/js/config.js'); ?>"></script>
<link href="<?php echo base_url('assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css" id="app-style">
<link href="<?php echo base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css">

<style>
    .leftside-menu .side-nav-link.active {
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
    }

    .topbar-page-copy h4 {
        line-height: 1.2;
    }

    .topbar-page-copy p {
        max-width: 520px;
    }

    .summary-card {
        border: 0;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
    }

    .hero-card {
        background: linear-gradient(135deg, #0d6efd, #1f8bff);
        color: #fff;
        border: 0;
        overflow: hidden;
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 1.2rem;
    }
</style>
