<style>
    @import url('https://fonts.googleapis.com/css2?family=K2D:wght@400;700&display=swap');
    body {
        font-family: 'K2D', sans-serif;
    }
    .About{
        font-family: 'K2D', sans-serif;
    }
    .About p {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    .About img{
        max-width: 100%;
        height: auto;
    }
    .category-list a {
        padding: 8px 12px;
        transition: background-color 0.3s ease;
        border-radius: 5px;
        margin-bottom: 5px;
        text-decoration: none;
    }
    .category-list a:hover {
        background-color: #f0f0f0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .page-header {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
            margin-bottom: 3rem !important;
        }
        .page-header .display-4 {
            font-size: 2.5rem;
        }
        .About h1 {
            font-size: 1.8rem;
        }
        .About p {
            font-size: 1rem;
            line-height: 1.7;
        }
    }
</style>
<div class="container-fluid page-header py-4 mb-4 wow fadeIn" data-wow-delay="0.1s"
    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)),url(../uploads/background/bg-about.jpg), center no-repeat; background-size: cover;background-position: bottom;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white  slideInDown mb-3"><?=$AboutDetail->about_menu?></h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="<?=base_url('/')?>">หน้าแรก</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page"><?=$AboutDetail->about_menu?></li>
            </ol>
        </nav>
    </div>
</div>
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">

            <div class="About ql-editor col-lg-8 wow fadeInUp" data-wow-delay="0.1s"
                style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
              
                <h1 class="mb-3"><?=$AboutDetail->about_menu?></h1>
                <p>
                <?=$AboutDetail->about_detail?>
                </p>
       
           
            </div>


            <div class="col-lg-4">
                <div class="bg-light rounded p-4 mb-5 wow fadeInUp" data-wow-delay="0.1s"
                    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                    <h3 class="mb-4">เกี่ยวกับ สกจ</h3>
                    <div class="category-list d-flex flex-column">
                        <?php foreach ($AboutSchool as $key => $value) : ?>
                        <a class="text-body" href="<?=base_url('About/'.$value->about_menu)?>"><?=$value->about_menu?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>