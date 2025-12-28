<style>
    #header-carousel {
        position: relative;
    }

    #header-carousel::after {
        position: absolute;
        content: "";
        width: 100%;
        height: 85px;
        left: 0;
        bottom: -1px; /* Overlap slightly with next section */
        z-index: 10;
        background: url('<?= base_url('uploads/home/overlay-bottom.png') ?>') bottom center no-repeat;
        background-size: 100% 100%;
        pointer-events: none;
    }

    /* Prevent indicators from being covered */
    #header-carousel .carousel-indicators {
        margin-bottom: 90px;
        z-index: 11;
    }

    @media screen and (max-width: 768px) {
        #header-carousel .carousel-item {
            position: relative;
            min-height: 200px;
        }
        #header-carousel::after {
            height: 40px; /* Adjust height for mobile */
        }
    }
</style>

<div class="wow fadeIn" data-wow-delay="0.1s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <!-- <div class="carousel-indicators">
            <?php foreach ($banner as $key => $v_banner): ?>
            <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="<?=$key?>"
                <?=$key==0?'class="active"':''?> aria-current="true" aria-label="Slide 1">
                <img class="img-fluid" data-src="<?=base_url()?>/uploads/banner/all/<?php echo $v_banner['banner_img'];?>"
                    alt="Image">
            </button>
            <?php endforeach; ?>
        </div> -->
        <div class="carousel-inner">
            <?php foreach ($banner as $key => $v_banner): 
                    if($v_banner['banner_linkweb'] == ""):
            ?>
            <div class="carousel-item <?=$key==0?'active':''?>">
                <img class="w-100" src="<?=base_url()?>/uploads/banner/all/<?php echo $v_banner['banner_img'];?>"
                    alt="Image" loading="lazy">
            </div>
            <?php else: ?>
            <a href="<?=$v_banner['banner_linkweb']?>" target="_blank">
                <div class="carousel-item <?=$key==0?'active':''?>">
                    <img class="w-100" src="<?=base_url()?>/uploads/banner/all/<?php echo $v_banner['banner_img'];?>"
                        alt="Image" loading="lazy">
            </a>
        </div>
        <?php 
            endif;
            endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
</div>
