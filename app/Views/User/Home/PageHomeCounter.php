<div class="wow fadeInUp" data-wow-delay="0.1s" >
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4 counter">
                <div class="col-lg-3 col-md-3 col-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="fact-item bg-light rounded text-center h-100 p-2">
                        <i class="fa fa-users fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">นักเรียน</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up"><?=$ConutStudent[0]->C_ALL_Stu;?></h1>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="fact-item bg-light rounded text-center h-100 p-2">
                        <i class="fa-solid fa-chalkboard-user fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">บุคลากร</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up"><?=$count_personnel?></h1>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="fact-item bg-light rounded text-center h-100 p-2">
                        <i class="fa-solid fa-building-flag fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">อาคาร</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up">15</h1>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="fact-item bg-light rounded text-center h-100 p-2">
                        <i class="fa fa-book fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">สาระการเรียนรู้</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up"><?=$count_learning?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
