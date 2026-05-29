<!-- Core JS -->
<script src="<?=base_url('assets/admin/assets/vendor/libs/jquery/jquery.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/vendor/libs/popper/popper.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/vendor/js/bootstrap.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/vendor/js/menu.js')?>"></script>

<!-- Vendors JS -->
<script src="<?=base_url('assets/admin/assets/vendor/libs/apex-charts/apexcharts.js')?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Main JS -->
<script>
(function() {
    const BASE_URL = "<?= base_url() ?>";
    window.BASE_URL = BASE_URL;
})();
</script>
<script src="<?=base_url('assets/admin/assets/js/main.js')?>"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
