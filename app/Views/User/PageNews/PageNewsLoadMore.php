<?php if($NewsAll):?>
<?php foreach ($NewsAll as $key => $v_news) : ?>
<div class="col-lg-3 col-md-4 col-6 wow fadeInUp" data-wow-delay="0.1s"
    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
    <div class="blog-item">
        <img class="img-fluid" data-src="<?=base_url('uploads/news/'.$v_news->news_img)?>" alt="">
        <div class="blog-text">
          
            <a class="h4 mb-0" href="<?=base_url('News/Detail/'.$v_news->news_id);?>"><?=$v_news->news_topic?></a>
            <div class="breadcrumb">
                <a class="breadcrumb-item small" href="#"><i class="fa fa-user me-2"></i>Admin</a>
                <a class="breadcrumb-item small" href="#"><i class="fa fa-calendar-alt me-2"></i>
                    <?=$dateThai->thai_date_fullmonth(strtotime($v_news->news_date))?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>