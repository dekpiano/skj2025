<?= $this->include('Manager/layout/ManagerHeader') ?>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <?= $this->include('Manager/layout/ManagerMenu', ['uri' => $uri]) ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?= $this->include('Manager/layout/ManagerNavbar') ?>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <?= $this->renderSection('content') ?>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<?= $this->renderSection('modals') ?>

<?= $this->include('Manager/layout/ManagerFooter') ?>
