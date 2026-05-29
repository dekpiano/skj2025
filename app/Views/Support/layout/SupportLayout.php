<?= $this->include('Support/layout/SupportHeader') ?>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <?= $this->include('Support/layout/SupportMenu', ['uri' => $uri]) ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?= $this->include('Support/layout/SupportNavbar') ?>
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

<?= $this->include('Support/layout/SupportFooter') ?>
