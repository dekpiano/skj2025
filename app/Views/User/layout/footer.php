<!-- Footer Start -->

<style>
    .footer-main {
        background: linear-gradient(135deg, #177fce 0%, #249ffd 200%);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .footer-main::before {
        position: absolute;
        content: "";
        width: 100%;
        height: 85px;
        left: 0;
        top: -1px; /* Overlap slightly with previous section */
        z-index: 1;
        background: url('<?= base_url('uploads/home/overlay-bottom.png') ?>') top center no-repeat;
        background-size: 100% 100%;
        transform: scaleY(-1);
    }

    .footer-title {
        color: #fff;
        font-weight: 800;
        font-size: 1.4rem;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 12px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: #ff69b4;
        border-radius: 2px;
    }

    .footer-link {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }

    .footer-link:hover {
        color: #ff69b4;
        padding-left: 8px;
    }

    .social-btn {
        width: 45px;
        height: 45px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        margin-right: 12px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-btn:hover {
        background: linear-gradient(45deg, #ff69b4, #249ffd);
        color: #fff;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(36, 159, 253, 0.3);
    }

    .visitor-card {
        background: rgb(255 255 255 / 25%);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 12px 18px;
        margin-bottom: 12px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .visitor-card:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 105, 180, 0.3);
        transform: translateX(5px);
    }

    .visitor-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 105, 180, 0.1);
        color: #ff69b4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .visitor-info h6 {
        margin: 0;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .visitor-info span {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
    }

    .newsletter-form {
        position: relative;
        margin-top: 20px;
    }

    .newsletter-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        color: #fff;
        padding: 15px 25px;
        width: 100%;
        outline: none;
        transition: all 0.3s ease;
    }

    .newsletter-input:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: #ff69b4;
    }

    .newsletter-btn {
        position: absolute;
        right: 5px;
        top: 5px;
        bottom: 5px;
        background: linear-gradient(45deg, #ff69b4, #249ffd);
        color: #fff;
        border: none;
        border-radius: 25px;
        padding: 0 25px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .newsletter-btn:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }

    .footer-bottom {
        background: rgba(0, 0, 0, 0.4);
        padding: 25px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .messenger-fab {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 30000;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        animation: chat-pulse 2s infinite;
        border: none;
        background: linear-gradient(45deg, #ff69b4, #249ffd) !important;
    }

    .messenger-fab:hover {
        transform: translateX(-50%) translateY(-5px);
        box-shadow: 0 15px 35px rgba(255, 105, 180, 0.4);
    }

    @keyframes chat-pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 105, 180, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(255, 105, 180, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 105, 180, 0); }
    }
    .back-to-top {
        z-index: 30000 !important;
        width: 45px !important;
        height: 45px !important;
        bottom: 20px !important;
        right: 20px !important;
        border: none;
        background: #ff69b4 !important;
        box-shadow: 0 10px 20px rgba(255, 105, 180, 0.3);
    }
</style>
<a href="http://m.me/230288483730783" target="_blank" class="btn btn-primary messenger-fab px-3 py-1 rounded-pill d-flex align-items-center shadow-lg">
    <i class="fab fa-facebook-messenger me-2" style="font-size: 18px;"></i>
    <span class="fw-bold" style="font-size: 13px;">ติดต่อสอบถามที่นี่</span>
</a>

<div class="footer-main pt-5 wow fadeIn <?= (isset($festival_status) && $festival_status == 'on') ? 'snow-cap' : '' ?>" data-wow-delay="0.1s" style="padding-top: 100px !important;">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">ติดต่อเรา</h5>
                <p class="mb-3 text-white-50"><i class="bi bi-geo-alt-fill text-primary me-2"></i> 160 ม.1 ต.นครสวรรค์ออก อ.เมือง จ.นครสวรรค์ 60000</p>
                <p class="mb-3 text-white-50"><i class="bi bi-telephone-fill text-primary me-2"></i> 056-009-667</p>
                <p class="mb-4 text-white-50"><i class="bi bi-envelope-fill text-primary me-2"></i> skjns160@skj.ac.th</p>
                
                <h6 class="text-white mb-3 fw-bold">Social Media</h6>
                <div class="d-flex">
                    <a class="social-btn" href="https://www.facebook.com/SKJNS160"><i class="fab fa-facebook-f"></i></a>
                    <a class="social-btn" href="https://www.youtube.com/channel/UC7p4cQQuIFLyrF68p7JbWDw"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 border-start border-white border-opacity-10 ps-lg-5">
                <h5 class="footer-title">โรงเรียนเครือสวนกุหลาบวิทยาลัย</h5>
                <div class="row">
                    <div class="col-md-6">
                        <a class="footer-link" target="_blank" href="http://www.sk.ac.th/"><i class="bi bi-link-45deg me-1"></i> สวนกุหลาบวิทยาลัย</a>
                        <a class="footer-link" target="_blank" href="http://www.skn.ac.th/"><i class="bi bi-link-45deg me-1"></i> สวนกุหลาบวิทยาลัย นนทบุรี</a>
                        <a class="footer-link" target="_blank" href="http://www.skr.ac.th/"><i class="bi bi-link-45deg me-1"></i> สวนกุหลาบวิทยาลัย รังสิต</a>
                        <a class="footer-link" target="_blank" href="http://www.sks.ac.th/"><i class="bi bi-link-45deg me-1"></i> นวมินทราชินูทิศ สวนกุหลาบวิทยาลัย สมุทรปราการ</a>
                        <a class="footer-link" target="_blank" href="http://www.skp.ac.th/"><i class="bi bi-link-45deg me-1"></i> นวมินทราชินูทิศ สวนกุหลาบวิทยาลัย ปทุมธานี</a>
                    </div>
                    <div class="col-md-6">
                        <a class="footer-link" target="_blank" href="http://www.skpb.ac.th/"><i class="bi bi-link-45deg me-1"></i> สวนกุหลาบวิทยาลัย เพชรบูรณ์</a>
                        <a class="footer-link" target="_blank" href="https://www.sksb.ac.th/"><i class="bi bi-link-45deg me-1"></i> สวนกุหลาบวิทยาลัย สระบุรี</a>
                        <a class="footer-link" target="_blank" href="http://www.suanchon.ac.th/"><i class="bi bi-link-45deg me-1"></i> สวนกุหลาบวิทยาลัย ชลบุรี</a>
                        <a class="footer-link" target="_blank" href="http://www.skns.ac.th/"><i class="bi bi-link-45deg me-1"></i> สวนกุหลาบวิทยาลัย นครศรีธรรมราช</a>
                        <a class="footer-link" target="_blank" href="http://www.sk-thonburi.ac.th/"><i class="bi bi-link-45deg me-1"></i> สวนกุหลาบวิทยาลัย ธนบุรี</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">สถิติผู้เข้าชม</h5>
                
                <div class="visitor-card">
                    <div class="visitor-icon"><i class="bi bi-eye-fill"></i></div>
                    <div class="visitor-info">
                        <h6>ทั้งหมด</h6>
                        <span><?= number_format($v['visitAll']) ?></span>
                    </div>
                </div>
                
                <div class="visitor-card">
                    <div class="visitor-icon"><i class="bi bi-person-fill"></i></div>
                    <div class="visitor-info">
                        <h6>วันนี้</h6>
                        <span><?= number_format($v['VisitToday']) ?></span>
                    </div>
                </div>

                <div class="visitor-card">
                    <div class="visitor-icon"><i class="bi bi-calendar-event-fill"></i></div>
                    <div class="visitor-info">
                        <h6>เดือนนี้</h6>
                        <span><?= number_format($v['visitMouth']) ?></span>
                    </div>
                </div>

                <div class="visitor-card">
                    <div class="visitor-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <div class="visitor-info">
                        <h6>ปีนี้</h6>
                        <span><?= number_format($v['visitYear']) ?></span>
                    </div>
                </div>

                <div class="newsletter-form mt-4">
                    <h6 class="text-white mb-3 fw-bold">รับข่าวสารทางอีเมล</h6>
                    <div class="position-relative">
                        <input type="email" class="newsletter-input" placeholder="Your Email">
                        <button class="newsletter-btn">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0 fw-light text-white-50 small">
                    &copy; <span class="text-white fw-bold">โรงเรียนเครือสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</span>. All Rights Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end text-white-50 small">
                    Author By <a href="https://www.facebook.com/dekpiano" class="text-primary text-decoration-none fw-bold">Dekpiano</a> | 
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="text-white-50 text-decoration-none ms-2">Admin Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>/assets/lib/wow/wow.min.js"></script>
<script src="<?=base_url()?>/assets/lib/easing/easing.min.js"></script>
<script src="<?=base_url()?>/assets/lib/waypoints/waypoints.min.js"></script>
<script src="<?=base_url()?>/assets/lib/counterup/counterup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
<script src="<?=base_url()?>/assets/lib/lightbox/js/lightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<!-- Template Javascript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?=base_url()?>/assets/js/main.js?v=3"></script>
<?php if($uri->getSegment(1) === "News"):?>
<script src="<?=base_url()?>/assets/js/News/News.js?v=10.2"></script>
<?php endif; ?>

<script>
$(document).ready(function() {
    const htmlElement = $('html');
    const grayscaleToggleBtn = $('#grayscaleToggle');
    const toggleIcon = grayscaleToggleBtn.find('i');

    function applyGrayscaleState(isGrayscale) {
        if (isGrayscale) {
            htmlElement.css('filter', 'grayscale(0.7)');
            // Optionally change icon if user wants visual feedback, otherwise keep it as is.
            // For now, assume the user wants the icon to remain 'fa-solid fa-adjust' as they specified.
            // toggleIcon.removeClass('fa-adjust').addClass('fa-color-adjust'); // Example for a different icon
        } else {
            htmlElement.css('filter', 'none');
            // toggleIcon.removeClass('fa-color-adjust').addClass('fa-adjust'); // Example for a different icon
        }
        localStorage.setItem('grayscaleEnabled', isGrayscale);
    }

    // Initialize grayscale state on page load
    let savedGrayscaleState = localStorage.getItem('grayscaleEnabled');
    if (savedGrayscaleState === null) { // If no state is saved, default to grayscale
        savedGrayscaleState = 'true';
        localStorage.setItem('grayscaleEnabled', 'true');
    }
    
    if (savedGrayscaleState === 'true') {
        applyGrayscaleState(true);
    } else {
        applyGrayscaleState(false);
    }

    // Attach click handler to the button
    grayscaleToggleBtn.on('click', function(e) {
        e.preventDefault();
        const currentGrayscaleState = htmlElement.css('filter') === 'grayscale(0.7)';
        applyGrayscaleState(!currentGrayscaleState);
    });

    const observer = lozad('img[data-src]'); 
    observer.observe();


    $(".news-slider").owlCarousel({
        items : 3,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,2],
        itemsMobile : [600,1],
        pagination:true,
        autoPlay:true
    });
});

$('#TBProcurements').DataTable(
    {
        order: [[0, 'desc']]
    }
);
</script>
<?php if (session()->getFlashdata('msg')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'แจ้งเตือน!',
            text: '<?= session()->getFlashdata('msg') ?>',
        })
    </script>
<?php endif; ?>
<?php if($uri->getSegment(1) == ''): // Only run on homepage ?>
<script>
$(document).ready(function() {
    // Check if the modal has been shown before
    if (localStorage.getItem('welcomeModalShown') !== 'true') {
        // The modal HTML is in PageHomeMain.php, check if it exists
        if ($('#welcomeModal').length) {
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'), {
                keyboard: false
            });
            welcomeModal.show();

            // Set a flag in localStorage so it doesn't show again
            localStorage.setItem('welcomeModalShown', 'true');
        }
    }
});
</script>
<?php endif; ?>
</body>

</html>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Login สำหรับ Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('Login/LoginAdmin')?>" method="post">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="Username" name="Username"
                            placeholder="name@example.com">
                        <label for="Username">Username</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="password" class="form-control" id="Password" name="Password"
                            placeholder="Password">
                        <label for="Password">Password</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                </form>
            </div>

        </div>
    </div>
</div>

 <!-- Modal -->
 <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
              
                <div class="modal-body">
                    <!-- ปุ่มสำหรับล็อกอินผ่าน Google -->
                    <a href="<?= base_url('SkjMain/googleLogin') ?>" class="btn btn-danger btn-block w-100">
                        <i class="fab fa-google"></i> เข้าสู่ระบบด้วย Google
                    </a>
                </div>
               
            </div>
        </div>
    </div>