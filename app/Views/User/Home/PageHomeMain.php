<style>
@media screen and (max-width: 453px) {
    .AdmissionFooter a {
        font-size: 1rem;
        padding: 10px;
        margin-top: -21px;
        margin-bottom: 20px;
    }
}

@media screen and (min-width: 768px) {
    .AdmissionFooter a {
        font-size: 2rem;
        padding: 10px;
        margin-top: -30px;
        margin-bottom: 30px;
    }
}

.overlay-bottom::after {
    bottom: 0;
    background: url(uploads/background/overlay-bottom.png) bottom center no-repeat;
    background-size: contain;
}

.overlay-bottom::after,
.overlay-top::before {
    position: absolute;
    content: "";
    width: 100%;
    height: 85px;
    left: 0;
    z-index: 1;
}
</style>

<!-- <img class="img-fluid" data-src="<?=base_url('uploads/banner/backtoschool.png')?>" alt="" srcset=""> -->

<!-- Carousel Start -->
<?= $this->include('User/Home/PageHomeCarousel') ?>
<!-- Carousel End -->
<!-- Facts Start -->
<?= $this->include('User/Home/PageHomeCounter')?>
<!-- Facts End -->

<!-- Facts Start -->
<?= $this->include('User/Home/PageHomeRecommend')?>
<!-- Facts End -->

<!-- News Start -->
<?= $this->include('User/Home/PageHomeNews') ?>
<!-- News End -->

<section>
<div class="container">
<div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px; visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
        <h6 class="section-title bg-white text-center text-primary px-3">SKJ Director</h6>
        <h1 class="display-6 mb-4">ผู้บริหาร</h1>
    </div>
    <div class="row justify-content-center " >
        <div class="col-md-4 col-6 wow fadeInLeft"  data-wow-delay="0.2s">
        <img src="<?=base_url();?>/uploads/director/nayk.png" class="img-fluid" alt="" loading="lazy">
        </div>
        <div class="col-md-4 col-6 wow fadeInUp" data-wow-delay="0.3s">
        <img src="<?=base_url();?>/uploads/director/pa-a.png" class="img-fluid" alt="" loading="lazy">
        </div>
        <div class="col-md-4 col-6 wow fadeInRight" data-wow-delay="0.4s">
        <img src="<?=base_url();?>/uploads/director/pa.png" class="img-fluid" alt="" loading="lazy">
        </div>
    </div>
</div>

</section>

<!-- NewsReward Start -->
<?= $this->include('User/Home/PageHomeNewsReward') ?>
<!-- NewsReward End -->





<!-- PageHomeDirector Start -->
<?= $this->include('User/Home/PageHomeRobot') ?>
<!-- PageHomeDirector End -->


<!-- PageHomeDirector Start -->
<!-- $this->include('Home/PageHomeDirector')  -->
<!-- PageHomeDirector End -->


<?= $this->include('User/Home/PageGroupSKJ') ?>

<!-- Slogan Start -->
<?= $this->include('User/Home/PageHomeSlogan') ?>
<!-- Slogan End -->


<!-- Excellence Start -->
<!-- $this->include('Home/PageHomeExcellence') -->
<!-- Excellence End -->


<!-- SKJstdio Start -->
<?= $this->include('User/Home/PageHomeSKJstdio') ?>
<!-- SKJstdio End -->

<!-- Welcome Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="<?php echo base_url('uploads/24 ตุลาคม ไว้อาลัยพระพันปีหลวง.png'); ?>" class="img-fluid" alt="ประกาศ">
            </div>
        </div>
    </div>
</div>