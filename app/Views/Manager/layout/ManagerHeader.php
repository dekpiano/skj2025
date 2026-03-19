<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?=base_url('assets/admin/assets/')?>"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title><?=$title;?> | ผู้บริหาร (Executive View)</title>

    <meta name="description" content="<?=$description;?>" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=base_url('assets/admin/assets/img/favicon/favicon.ico')?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/vendor/fonts/boxicons.css')?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/vendor/css/core.css')?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/vendor/css/theme-default.css')?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/demo.css')?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')?>" />
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/vendor/libs/apex-charts/apex-charts.css')?>" />
    
    <!-- Helpers -->
    <script src="<?=base_url('assets/admin/assets/vendor/js/helpers.js')?>"></script>
    <script src="<?=base_url('assets/admin/assets/js/config.js')?>"></script>
    
    <!-- Custom Style for Manager -->
    <style>
        body { font-family: 'Sarabun', sans-serif; }
        
        /* Global Executive Theme Overrides */
        :root {
            --exec-navy: #003366;
            --exec-navy-dark: #002244;
            --exec-navy-light: #e3f2fd;
        }

        /* Sidebar/Menu Active Color */
        .bg-menu-theme .menu-inner > .menu-item.active > .menu-link {
            background-color: var(--exec-navy) !important;
            color: #fff !important;
        }
        .bg-menu-theme .menu-inner > .menu-item.active:before {
            background-color: var(--exec-navy) !important;
        }

        /* Buttons & Badges Override */
        .btn-primary { background-color: var(--exec-navy) !important; border-color: var(--exec-navy) !important; }
        .btn-primary:hover { background-color: var(--exec-navy-dark) !important; border-color: var(--exec-navy-dark) !important; }
        .bg-primary { background-color: var(--exec-navy) !important; }
        .text-primary { color: var(--exec-navy) !important; }
        .bg-label-primary { background-color: var(--exec-navy-light) !important; color: var(--exec-navy) !important; }
        
        /* Profile Card Gradient */
        .profile-card-exec {
            background: linear-gradient(135deg, #1a237e 0%, #2c3e50 100%) !important;
        }

        /* Ensure SweetAlert2 is always on top */
        .swal2-container {
            z-index: 999999 !important;
        }
    </style>
  </head>

  <body>
