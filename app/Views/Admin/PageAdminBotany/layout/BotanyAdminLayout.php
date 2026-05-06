<?= $this->include('Admin/layout/AdminHeader') ?>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <?= $this->include('Admin/PageAdminBotany/layout/BotanyMenu') ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?= $this->include('Admin/PageAdminBotany/layout/BotanyNavbar') ?>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <?= $this->renderSection('content') ?>
                <!-- / Content -->

                <!-- Footer -->
                <!-- No local footer needed if AdminFooter is used at the end -->
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>

<?= $this->renderSection('modals') ?>
<?= $this->include('Admin/layout/AdminFooter') ?>
