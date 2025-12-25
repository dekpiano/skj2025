<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/popper/popper.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="<?=base_url()?>/assets/admin/assets/vendor/js/menu.js"></script>
<!-- endbuild -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Vendors JS -->
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/datatables-bootstrap5.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/datatables.responsive.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/responsive.bootstrap5.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/datatables.checkboxes.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/datatables-buttons.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/buttons.bootstrap5.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/buttons.html5.js"></script>
<script src="<?=base_url()?>/assets/admin/assets/vendor/libs/datatables/buttons.print.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<!-- Main JS -->
<script>
(function() { // เพิ่ม IIFE
    const BASE_URL = "<?= base_url() ?>";
    // Expose BASE_URL to global scope if needed by other scripts
    window.BASE_URL = BASE_URL; // ทำให้ BASE_URL เข้าถึงได้จากภายนอก IIFE
})(); // ปิด IIFE
</script>
<script src="<?=base_url()?>/assets/admin/assets/js/main.js"></script>

<!-- Page JS -->
<script src="<?=base_url()?>/assets/admin/assets/js/dashboards-analytics.js"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>