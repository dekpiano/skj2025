
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
            style="max-width: 600px; visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
            <h6 class="section-title bg-white text-center text-primary px-3">SKJ News</h6>
            <h1 class="display-6 mb-4">สกจ. ประชาสัมพันธ์</h1>
        </div>
        <div class="row g-4" data-masonry='{"percentPosition": true }'>

            <?php foreach ($news as $key => $v_news) : ?>
            <div class="col-lg-4 col-6 wow fadeInUp" data-wow-delay="0.1s"
                style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                <div class="blog-item" style="">
                    <img class="img-fluid" src="<?=base_url('uploads/news/'.$v_news->news_img)?>" alt="">
                    <div class="blog-text">
                        
                        <a class="h4 mb-0 CountReadNews" data_view="<?=$v_news->news_view?>"
                            news_id="<?=$v_news->news_id?>"
                            href="<?=base_url('News/Detail/'.$v_news->news_id);?>"><?=$v_news->news_topic?></a>
                        <!-- <?=base_url('News/Detail/'.$v_news->news_id);?> -->

                        <div class="breadcrumb">
                            <a class="breadcrumb-item small" href="#"><i class="fa fa-user me-2"></i>Admin</a>
                            <a class="breadcrumb-item small" href="#"><i class="fa fa-calendar-alt me-2"></i>
                                <?php print_r($dateThai->thai_date_fullmonth(strtotime($v_news->news_date)));?>
                            </a>
                            <a class="breadcrumb-item small" href="#"><i class="fa fa-eye me-2"></i><?=$v_news->news_view?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="text-center">
                <a class="btn btn-primary rounded-pill py-2 px-5 w-auto" href="<?=base_url('News')?>">ดูทั้งหมด</a>
            </div>


        </div>
    </div>
</div>