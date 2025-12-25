<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s"
    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)),url(uploads/background/bg-news.jpg), center no-repeat; background-size: cover;background-position: bottom;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white  slideInDown mb-3">สกจ. ประชาสัมพันธ์</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">สกจ. ประชาสัมพันธ์</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">

        <form method='get' action="<?=base_url('News')?>" id="searchForm">
            <div class="input-group mb-3">
                <input type="text" class="form-control form-control-lg" type='text' name='search' value='<?= $search ?>'
                    placeholder="ค้นหาข่าวที่นี่...">
                <button type="submit" class="input-group-text btn-success"><i class="bi bi-search me-2"></i>
                    ค้นหา</button>
            </div>
        </form>

        <div class="row g-4" id="grid" data-masonry='{"percentPosition": true }'>
            <?php if($NewsAll):?>
            <?php foreach ($NewsAll as $key => $v_news) : ?>
            <div class="col-lg-4 col-md-4 col-6 grid-item wow fadeInUp" data-wow-delay="0.1s"
                style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                <div class="blog-item">
                    <?php if($v_news['news_facebook'] == ""):?>
                    <img class="img-fluid" src="<?=base_url('uploads/news/'.$v_news['news_img'])?>" alt="">
                    <?php else: ?>
                        <img class="img-fluid" src="<?=base_url('uploads/news/'.$v_news['news_img'])?>" alt="">
                    <?php endif; ?>
                    <div class="blog-text">

                        <a class="h4 mb-0 CountReadNews" data_view="<?=$v_news['news_view']?>"
                            news_id="<?=$v_news['news_id']?>"
                            href="<?=base_url('News/Detail/'.$v_news['news_id']);?>"><?=$v_news['news_topic']?></a>
                        <div class="breadcrumb">
                            <a class="breadcrumb-item small" href="#"><i class="fa fa-user me-2"></i>Admin</a>
                            <a class="breadcrumb-item small" href="#"><i class="fa fa-calendar-alt me-2"></i>
                                <?=$dateThai->thai_date_fullmonth(strtotime($v_news['news_date']))?>
                            </a>
                            <a class="breadcrumb-item small" href="#"><i
                                    class="fa fa-eye me-2"></i><?=$v_news['news_view']?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <style>
            .pagination li {
                margin-left: -1px;
            }

            .pagination li.active {
                background: deepskyblue;
                color: white;

            }

            .pagination li.active a {
                color: white;
                text-decoration: none;
                background: deepskyblue;
            }

            .pagination li a {
                padding: .375rem .75rem;
                position: relative;
                display: block;
                text-decoration: none;
                background-color: #fff;
                border: 1px solid #dee2e6;
                transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }
            </style>

            <div class="row mt-5 fadeInUp" data-wow-delay="0.3s">
                <div class="col-md-12">
                    <div class="row">
                        <div class="pagination justify-content-center mb-4">
                            <?php if ($pager) :?>
                            <?= $pager->links() ?>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <style>
        .grid {
            display: flex;
            flex-wrap: wrap;
        }
        .grid-item {
            width: 30%;
            margin: 5px;
        }
        .load-more {
            cursor: pointer;
            margin: 20px 0;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
        }
    </style>
    
            <h2>Data List</h2>
                <div class="grid" id="grid"></div>

                <div class="load-more" id="load-more">Load More</div>

            </div>
</div>