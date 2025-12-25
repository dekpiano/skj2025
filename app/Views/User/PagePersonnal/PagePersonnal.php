<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s"
    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn; background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)),url(../../uploads/background/bg-personnal.jpg), center no-repeat; background-size: cover;background-position: center;">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white  slideInDown mb-3">บุคลากร</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="<?=base_url('/')?>">หน้าแรก</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">บุคลากร</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
            style="max-width: 600px; visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
            <h6 class="section-title bg-white text-center text-primary px-3">กลุ่มสาระการเรียนรู้</h6>
            <h1 class="display-6 mb-4"><?=str_replace("-", " ", urldecode($uri->getSegment(3)));?></h1>
        </div>
        <div class="row g-4">          
            <?php foreach ($Pers as $key => $v_Pers) :?>
            <?php if(urldecode($uri->getSegment(3)) === "ผู้บริหารสถานศึกษา" && $v_Pers->pers_position === "posi_001"): ?>
                <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s"
                    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                    <div class="team-item rounded text-center p-4" style="background: linear-gradient(to top, #fb7e9c 0%, #53c0f3 100%);">
                        <?php if(empty($v_Pers->pers_img)):?>
                        <img class="img-fluid rounded-circle  p-2" style="height: 250px;"
                            src="<?=base_url('uploads/presonnal/man.png')?>" alt="">
                        <?php else: ?>
                        <img class="img-fluid rounded-circle  p-2" style="height: 250px;"
                            src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=$v_Pers->pers_img;?>" alt="">
                        <?php endif; ?>
                        <div class="team-text">
                            <div class="team-title" style="color: #000;">
                                <h5><?=$v_Pers->pers_prefix.$v_Pers->pers_firstname.' '.$v_Pers->pers_lastname?></h5>
                                <span><?=$v_Pers->posi_name.' '.$v_Pers->pers_academic?></span>
                                <p><?=$v_Pers->pers_groupleade == 'หัวหน้ากลุ่มสาระ' ?"($v_Pers->pers_groupleade)":""?>
                                </p>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-primary" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($v_Pers->pers_groupleade == 'หัวหน้ากลุ่มสาระ') : ?>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s"
                    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                    <div class="team-item rounded text-center" style="background: linear-gradient(to top, #fb7e9c 0%, #53c0f3 100%);">
                        <?php if(empty($v_Pers->pers_img)):?>
                        <img class="img-fluid rounded-circle  p-2" style="height: 250px;"
                            src="<?=base_url('uploads/presonnal/man.png')?>" alt="">
                        <?php else: ?>
                        <img class="img-fluid rounded-circle p-2" style="height: 250px;"
                            src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=$v_Pers->pers_img;?>" alt="">
                        <?php endif; ?>
                        <div class="team-text">
                            <div class="team-title" style="color: #000;">
                                <h5><?=$v_Pers->pers_prefix.$v_Pers->pers_firstname.' '.$v_Pers->pers_lastname?></h5>
                                <span><?=$v_Pers->posi_name.' '.$v_Pers->pers_academic?></span>
                                <p><?=$v_Pers->pers_groupleade == 'หัวหน้ากลุ่มสาระ' ?"($v_Pers->pers_groupleade)":""?>
                                </p>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-primary" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php else :?>
            <?php if($v_Pers->pers_status == "กำลังใช้งาน" && $v_Pers->pers_position !== "posi_001"): ?>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s"
                style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                <div class="team-item rounded text-center" style="background: linear-gradient(to top, #fb7e9c 0%, #53c0f3 100%);">
                <?php if(empty($v_Pers->pers_img)):?>
                        <img class="img-fluid rounded-circle p-2" style="width: 250px;"
                            src="<?=base_url('uploads/presonnal/man.png')?>" alt="">
                        <?php else: ?>
                        <img class="img-fluid rounded-circle p-2" style="height: 250px;"
                            src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=$v_Pers->pers_img;?>" alt="">
                        <?php endif; ?>
                    <div class="team-text">
                        <div class="team-title" style="color: #000;">
                            <h5><?=$v_Pers->pers_prefix.$v_Pers->pers_firstname.' '.$v_Pers->pers_lastname?></h5>
                            <span><?=($v_Pers->work_name == "" ? $v_Pers->posi_name : $v_Pers->work_name).' '.$v_Pers->pers_academic?></span>
                            <p><?=$v_Pers->pers_groupleade == 'หัวหน้ากลุ่มสาระ' ?"($v_Pers->pers_groupleade)":""?></p>
                        </div>
                        <div class="team-social">
                            <a class="btn btn-square btn-primary" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary" href=""><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php endif; ?>
            <?php endforeach; ?>

        </div>
    </div>
</div>