<style>
    .personnel-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(<?= base_url('uploads/background/bg-personnal.jpg') ?>) center no-repeat;
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        border-radius: 0 0 50px 50px;
        margin-bottom: -50px;
    }

    .search-container {
        max-width: 600px;
        margin: -40px auto 40px;
        position: relative;
        z-index: 10;
    }

    .search-box {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 2px solid var(--primary);
        border-radius: 30px;
        padding: 15px 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .search-box:focus-within {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .search-box input {
        border: none;
        background: transparent;
        width: 100%;
        outline: none;
        font-size: 1.1rem;
    }

    .team-card {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        height: 420px;
        background: linear-gradient(150deg, #fb7e9c 0%, #9b8ef4 48%, #53c0f3 100%);
        border: 1px solid rgba(255, 255, 255, 0.45);
        box-shadow: 0 12px 36px rgba(15, 23, 42, 0.08);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .team-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 48px rgba(15, 23, 42, 0.14), 0 8px 24px rgba(83, 192, 243, 0.25);
        border-color: rgba(255, 255, 255, 0.8);
    }

    .director-card {
        height: 470px;
        background: linear-gradient(150deg, #fb7e9c 0%, #8978f0 45%, #4bb7ed 100%);
        box-shadow: 0 16px 44px rgba(251, 126, 156, 0.2), 0 8px 24px rgba(83, 192, 243, 0.2);
    }

    .head-of-group {
        height: 440px;
        border: 2px solid rgba(255, 255, 255, 0.75);
    }

    .team-image-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: flex-end;
        padding-top: 4px;
        padding-bottom: 0;
        overflow: hidden;
        z-index: 1;
        pointer-events: none;
    }

    .team-img {
        height: calc(100% - 4px);
        width: auto;
        min-width: 80%;
        max-width: 165%;
        transform: scale(1.08);
        transform-origin: bottom center;
        object-fit: contain;
        object-position: bottom center;
        border: none !important;
        background: transparent !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        filter: drop-shadow(0 10px 22px rgba(0, 0, 0, 0.16));
        -webkit-mask-image: linear-gradient(to bottom, #000 78%, rgba(0, 0, 0, 0.85) 88%, rgba(0, 0, 0, 0.25) 97%, transparent 100%);
        mask-image: linear-gradient(to bottom, #000 78%, rgba(0, 0, 0, 0.85) 88%, rgba(0, 0, 0, 0.25) 97%, transparent 100%);
        transition: transform 0.45s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: block;
    }

    .director-card .team-img,
    .head-of-group .team-img {
        height: calc(100% - 4px);
        transform: scale(1.10);
        transform-origin: bottom center;
    }

    .team-card:hover .team-img {
        transform: scale(1.14) translateY(-3px);
    }

    .team-mist-layer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 48%;
        background: 
            radial-gradient(ellipse 120% 85% at 50% 100%, 
                rgba(255, 255, 255, 0.75) 0%, 
                rgba(255, 255, 255, 0.55) 30%, 
                rgba(255, 255, 255, 0.25) 65%, 
                rgba(255, 255, 255, 0) 100%
            ),
            linear-gradient(
                to top,
                rgba(255, 255, 255, 0.82) 0%,
                rgba(255, 255, 255, 0.70) 22%,
                rgba(255, 255, 255, 0.48) 46%,
                rgba(255, 255, 255, 0.22) 70%,
                rgba(255, 255, 255, 0.05) 88%,
                rgba(255, 255, 255, 0) 100%
            );
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
        -webkit-mask-image: linear-gradient(to top, black 55%, transparent 100%);
        mask-image: linear-gradient(to top, black 55%, transparent 100%);
        pointer-events: none;
        z-index: 2;
    }

    .team-content {
        position: relative;
        z-index: 3;
        padding: 22px 20px 20px;
        text-align: left;
        width: 100%;
    }

    .team-name {
        font-family: 'Prompt', sans-serif;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
        font-size: 1.15rem;
        line-height: 1.3;
        letter-spacing: -0.2px;
        text-shadow: 0 1px 4px rgba(255, 255, 255, 0.7);
    }

    .team-pos {
        color: #475569;
        font-weight: 500;
        font-size: 0.84rem;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }

    .team-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .social-links {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0;
    }

    .social-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        transition: all 0.25s ease;
        font-size: 0.78rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .social-btn:hover {
        transform: translateY(-2px) scale(1.12);
        color: #fff;
    }

    .fb-btn { background: #3b5998; }
    .tw-btn { background: #1da1f2; }
    .ig-btn { background: #e1306c; }
    .line-btn { background: #00c300; }
    .yt-btn { background: #ff0000; }

    .team-pill-badge {
        background: #ffffff;
        color: #0d6efd;
        font-size: 0.76rem;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 999px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        text-decoration: none;
    }

    .director-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: linear-gradient(135deg, #ffd700 0%, #ffae00 100%);
        color: #000;
        padding: 6px 16px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.72rem;
        z-index: 4;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        letter-spacing: 0.3px;
    }

    .head-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: linear-gradient(135deg, #ff4b2b 0%, #ff416c 100%);
        color: #fff;
        padding: 5px 14px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.72rem;
        z-index: 4;
        box-shadow: 0 4px 14px rgba(255, 65, 108, 0.3);
    }

    .subhead-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: linear-gradient(135deg, #0d6efd 0%, #00b4d8 100%);
        color: #fff;
        padding: 5px 14px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.72rem;
        z-index: 4;
        box-shadow: 0 4px 14px rgba(13, 110, 253, 0.3);
    }

    .subhead-of-group {
        height: 430px;
        border: 2px solid rgba(13, 110, 253, 0.45);
    }

    .subhead-of-group .team-img {
        height: calc(100% - 4px);
        transform: scale(1.09);
        transform-origin: bottom center;
    }

    .section-divider {
        height: 4px;
        width: 100px;
        background: var(--primary);
        margin: 20px auto;
        border-radius: 2px;
    }

    /* Animation */
    .wow-container {
        opacity: 0;
        transform: translateY(20px);
    }
    
    .fade-up {
        animation: fadeUp 0.6s ease forwards;
    }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments across devices */
    @media (max-width: 991.98px) {
        .team-card {
            height: 410px;
        }
        .director-card {
            height: 450px;
        }
        .head-of-group {
            height: 430px;
        }
    }

    @media (max-width: 575.98px) {
        .team-card {
            height: 400px;
            max-width: 320px;
            margin: 0 auto;
        }
        .director-card {
            height: 430px;
            max-width: 330px;
        }
        .head-of-group {
            height: 410px;
            max-width: 320px;
        }
        .team-content {
            padding: 18px 16px 16px;
        }
        .team-name {
            font-size: 1.05rem;
        }
        .team-pos {
            font-size: 0.8rem;
            margin-bottom: 10px;
        }
        .team-pill-badge {
            font-size: 0.72rem;
            padding: 4px 10px;
        }
        .social-btn {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 350px) {
        .team-card {
            height: 380px;
        }
        .director-card {
            height: 400px;
        }
        .team-name {
            font-size: 0.96rem;
        }
    }
</style>

<div class="skj-page-header header-personnel wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <h1 class="slideInDown mb-3">บุคลากร</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active" aria-current="page">บุคลากร</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <!-- Search Bar -->
        <div class="search-container wow fadeInUp" data-wow-delay="0.2s">
            <div class="search-box d-flex align-items-center">
                <i class="bi bi-search text-primary me-3 fs-5"></i>
                <input type="text" id="personnelSearch" placeholder="ค้นหาชื่อ หรือตำแหน่ง..." onkeyup="filterPersonnel()">
            </div>
        </div>

        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h6 class="section-title bg-white text-center text-primary px-3">แผนกงาน / กลุ่มสาระ</h6>
            <h1 class="display-6 mb-4"><?php 
                $title = str_replace("-", " ", urldecode($uri->getSegment(3)));
                if(empty($title) && urldecode($uri->getSegment(2)) === "Executive") $title = "ผู้บริหารสถานศึกษา";
                echo $title;
            ?></h1>
            <div class="section-divider"></div>
        </div>

        <div class="row g-4 justify-content-center" id="personnelContainer">
            <?php 
            $director = null;
            $deputies = [];
            $heads = [];
            $subheads = [];
            $others = [];

            foreach ($Pers as $p) {
                if ($p->pers_position === "posi_001") {
                    $director = $p;
                } elseif ($p->pers_position === "posi_002") {
                    $deputies[] = $p;
                } elseif (
                    (!empty($p->pers_groupleade) && strpos($p->pers_groupleade, 'หัวหน้า') !== false && strpos($p->pers_groupleade, 'รอง') === false) ||
                    (!empty($p->work_name) && strpos($p->work_name, 'หัวหน้ากลุ่ม') !== false && strpos($p->work_name, 'รอง') === false)
                ) {
                    $heads[] = $p;
                } elseif (
                    (!empty($p->pers_groupleade) && strpos($p->pers_groupleade, 'รอง') !== false) ||
                    (!empty($p->work_name) && strpos($p->work_name, 'รองหัวหน้า') !== false)
                ) {
                    $subheads[] = $p;
                } elseif ($p->pers_status == "กำลังใช้งาน") {
                    $others[] = $p;
                }
            }
            ?>

            <!-- Render Director First -->
            <?php if ($director): ?>
                <div class="col-12 mb-5 personnel-item" data-name="<?= $director->pers_firstname . ' ' . $director->pers_lastname . ' ' . ($director->work_name ?: $director->posi_name) . ' ' . ($director->pers_academic ?? '') . ' ผู้อำนวยการ' ?>">
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-card director-card">
                                <div class="director-badge"><i class="bi bi-star-fill me-1"></i> ผู้อำนวยการ</div>
                                <div class="team-image-wrapper">
                                    <img class="team-img" 
                                         src="<?= !empty($director->pers_img) ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $director->pers_img : base_url('uploads/presonnal/man.png') ?>" 
                                         alt="<?= $director->pers_firstname ?>"
                                         loading="lazy">
                                </div>
                                <div class="team-mist-layer"></div>
                                <div class="team-content">
                                    <h5 class="team-name"><?= $director->pers_prefix . $director->pers_firstname . ' ' . $director->pers_lastname ?></h5>
                                    <div class="team-pos"><?= ($director->work_name == "" ? $director->posi_name : $director->work_name) . (!empty($director->pers_academic) ? ' ' . $director->pers_academic : '') ?></div>
                                    <div class="team-footer">
                                        <?= renderSocialLinks($director) ?>
                                        <span class="team-pill-badge"><i class="bi bi-shield-check"></i> <?= !empty($director->posi_name) ? $director->posi_name : 'ผู้อำนวยการ' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Render Deputies -->
            <?php if (!empty($deputies)): ?>
                <div class="col-12 mb-5">
                    <div class="row g-4 justify-content-center">
                        <?php foreach ($deputies as $deputy): ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 personnel-item" data-name="<?= $deputy->pers_firstname . ' ' . $deputy->pers_lastname . ' ' . ($deputy->work_name ?: $deputy->posi_name) . ' ' . ($deputy->pers_academic ?? '') . ' รองผู้อำนวยการ' ?>">
                                <div class="team-card wow fadeInUp" data-wow-delay="0.2s">
                                    <div class="team-image-wrapper">
                                        <img class="team-img" 
                                             src="<?= !empty($deputy->pers_img) ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $deputy->pers_img : base_url('uploads/presonnal/man.png') ?>" 
                                             alt="<?= $deputy->pers_firstname ?>"
                                             loading="lazy">
                                    </div>
                                    <div class="team-mist-layer"></div>
                                    <div class="team-content">
                                        <h5 class="team-name"><?= $deputy->pers_prefix . $deputy->pers_firstname . ' ' . $deputy->pers_lastname ?></h5>
                                        <div class="team-pos"><?= ($deputy->work_name == "" ? $deputy->posi_name : $deputy->work_name) . (!empty($deputy->pers_academic) ? ' ' . $deputy->pers_academic : '') ?></div>
                                        <div class="team-footer">
                                            <?= renderSocialLinks($deputy) ?>
                                            <span class="team-pill-badge"><?= !empty($deputy->posi_name) ? $deputy->posi_name : 'รองผู้อำนวยการ' ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Render Heads (Alone on own row) -->
            <?php foreach ($heads as $head): ?>
                <div class="col-12 mb-5 personnel-item" data-name="<?= $head->pers_firstname . ' ' . $head->pers_lastname . ' ' . ($head->work_name ?: $head->posi_name) . ' ' . ($head->pers_academic ?? '') . ' หัวหน้ากลุ่มสาระ ' . ($head->pers_groupleade ?? '') ?>">
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="team-card head-of-group">
                                <div class="head-badge"><i class="bi bi-award-fill me-1"></i> หัวหน้ากลุ่มสาระ</div>
                                <div class="team-image-wrapper">
                                    <img class="team-img" 
                                         src="<?= !empty($head->pers_img) ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $head->pers_img : base_url('uploads/presonnal/man.png') ?>" 
                                         alt="<?= $head->pers_firstname ?>"
                                         loading="lazy">
                                </div>
                                <div class="team-mist-layer"></div>
                                <div class="team-content">
                                    <h5 class="team-name"><?= $head->pers_prefix . $head->pers_firstname . ' ' . $head->pers_lastname ?></h5>
                                    <div class="team-pos"><?= ($head->work_name == "" ? $head->posi_name : $head->work_name) . (!empty($head->pers_academic) ? ' ' . $head->pers_academic : '') ?></div>
                                    <div class="team-footer">
                                        <?= renderSocialLinks($head) ?>
                                        <span class="team-pill-badge"><?= !empty($head->pers_groupleade) ? $head->pers_groupleade : (!empty($head->posi_name) ? $head->posi_name : 'หัวหน้ากลุ่มสาระ') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Render Deputy Heads (Below Head of Group) -->
            <?php if (!empty($subheads)): ?>
                <div class="col-12 mb-5">
                    <div class="row g-4 justify-content-center">
                        <?php foreach ($subheads as $subhead): ?>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 personnel-item" data-name="<?= $subhead->pers_firstname . ' ' . $subhead->pers_lastname . ' ' . ($subhead->work_name ?: $subhead->posi_name) . ' ' . ($subhead->pers_academic ?? '') . ' รองหัวหน้ากลุ่มสาระ ' . ($subhead->pers_groupleade ?? '') ?>">
                                <div class="team-card subhead-of-group wow fadeInUp" data-wow-delay="0.25s">
                                    <div class="subhead-badge"><i class="bi bi-award me-1"></i> รองหัวหน้ากลุ่มสาระ</div>
                                    <div class="team-image-wrapper">
                                        <img class="team-img" 
                                             src="<?= !empty($subhead->pers_img) ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $subhead->pers_img : base_url('uploads/presonnal/man.png') ?>" 
                                             alt="<?= $subhead->pers_firstname ?>"
                                             loading="lazy">
                                    </div>
                                    <div class="team-mist-layer"></div>
                                    <div class="team-content">
                                        <h5 class="team-name"><?= $subhead->pers_prefix . $subhead->pers_firstname . ' ' . $subhead->pers_lastname ?></h5>
                                        <div class="team-pos"><?= ($subhead->work_name == "" ? $subhead->posi_name : $subhead->work_name) . (!empty($subhead->pers_academic) ? ' ' . $subhead->pers_academic : '') ?></div>
                                        <div class="team-footer">
                                            <?= renderSocialLinks($subhead) ?>
                                            <span class="team-pill-badge"><?= !empty($subhead->pers_groupleade) ? $subhead->pers_groupleade : (!empty($subhead->posi_name) ? $subhead->posi_name : 'รองหัวหน้ากลุ่มสาระ') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Render Others -->
            <?php foreach ($others as $p): ?>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 personnel-item" data-name="<?= $p->pers_firstname . ' ' . $p->pers_lastname . ' ' . ($p->work_name ?: $p->posi_name) . ' ' . ($p->pers_academic ?? '') ?>">
                    <div class="team-card wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-image-wrapper">
                            <img class="team-img" 
                                 src="<?= !empty($p->pers_img) ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $p->pers_img : base_url('uploads/presonnal/man.png') ?>" 
                                 alt="<?= $p->pers_firstname ?>"
                                 loading="lazy">
                        </div>
                        <div class="team-mist-layer"></div>
                        <div class="team-content">
                            <h5 class="team-name"><?= $p->pers_prefix . $p->pers_firstname . ' ' . $p->pers_lastname ?></h5>
                            <div class="team-pos"><?= ($p->work_name == "" ? $p->posi_name : $p->work_name) . (!empty($p->pers_academic) ? ' ' . $p->pers_academic : '') ?></div>
                            <div class="team-footer">
                                <?= renderSocialLinks($p) ?>
                                <span class="team-pill-badge"><?= !empty($p->work_name) ? $p->work_name : (!empty($p->posi_name) ? $p->posi_name : 'บุคลากร') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        
        <div id="noResults" class="text-center py-5 d-none">
            <i class="bi bi-people text-muted mb-3" style="font-size: 5rem; opacity: 0.3;"></i>
            <p class="mt-3 text-muted">ไม่พบข้อมูลตามที่ระบุ...</p>
        </div>
    </div>
</div>

<?php
function renderSocialLinks($p) {
    $html = '<div class="social-links">';
    $hasSocial = false;
    if (!empty($p->pers_facebook)) { $html .= '<a href="' . $p->pers_facebook . '" target="_blank" class="social-btn fb-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>'; $hasSocial = true; }
    if (!empty($p->pers_instagram)) { $html .= '<a href="' . $p->pers_instagram . '" target="_blank" class="social-btn ig-btn" title="Instagram"><i class="fab fa-instagram"></i></a>'; $hasSocial = true; }
    if (!empty($p->pers_twitter)) { $html .= '<a href="' . $p->pers_twitter . '" target="_blank" class="social-btn tw-btn" title="Twitter"><i class="fab fa-twitter"></i></a>'; $hasSocial = true; }
    if (!empty($p->pers_line)) { $html .= '<a href="https://line.me/ti/p/~' . $p->pers_line . '" target="_blank" class="social-btn line-btn" title="Line"><i class="fab fa-line"></i></a>'; $hasSocial = true; }
    if (!empty($p->pers_youtube)) { $html .= '<a href="' . $p->pers_youtube . '" target="_blank" class="social-btn yt-btn" title="YouTube"><i class="fab fa-youtube"></i></a>'; $hasSocial = true; }
    
    if (!$hasSocial) {
        $html .= '<span class="text-muted" style="font-size: 0.72rem; opacity: 0.75;"><i class="bi bi-person-circle me-1"></i>สกจ.</span>';
    }
    $html .= '</div>';
    return $html;
}
?>

<script>
    function filterPersonnel() {
        const input = document.getElementById('personnelSearch');
        const filter = input.value.toLowerCase();
        const container = document.getElementById('personnelContainer');
        const items = container.getElementsByClassName('personnel-item');
        const noResults = document.getElementById('noResults');
        let hasResults = false;

        for (let i = 0; i < items.length; i++) {
            const name = items[i].getAttribute('data-name').toLowerCase();
            if (name.indexOf(filter) > -1) {
                items[i].classList.remove('d-none');
                hasResults = true;
            } else {
                items[i].classList.add('d-none');
            }
        }

        if (hasResults) {
            noResults.classList.add('d-none');
        } else {
            noResults.classList.remove('d-none');
        }
    }
</script>