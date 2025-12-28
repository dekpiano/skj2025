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
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
        position: relative;
    }

    .team-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .team-image-wrapper {
        position: relative;
        padding: 20px;
        background: linear-gradient(135deg, #fb7e9c 0%, #53c0f3 100%);
        overflow: hidden;
    }

    .team-image-wrapper::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, #fff, transparent);
    }

    .team-img {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
        transition: all 0.4s ease;
    }

    .team-card:hover .team-img {
        transform: scale(1.05);
        border-color: var(--primary);
    }

    .team-content {
        padding: 20px;
        text-align: center;
    }

    .team-name {
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
        font-size: 1.2rem;
    }

    .team-pos {
        color: var(--primary);
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 15px;
        display: block;
    }

    .social-links {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 15px;
    }

    .social-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .social-btn:hover {
        transform: scale(1.2) rotate(10deg);
        color: #fff;
    }

    .fb-btn { background: #3b5998; }
    .tw-btn { background: #1da1f2; }
    .ig-btn { background: #e1306c; }
    .line-btn { background: #00c300; }
    .yt-btn { background: #ff0000; }

    .director-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: gold;
        color: #000;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.7rem;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .head-of-group {
        border: 4px solid transparent;
        background-image: linear-gradient(white, white), radial-gradient(circle at top left, #fb7e9c, #53c0f3);
        background-origin: border-box;
        background-clip: content-box, border-box;
        transform: scale(1.1); /* Bigger scale */
        box-shadow: 0 20px 45px rgba(251, 126, 156, 0.3);
        z-index: 5;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .head-of-group .team-img {
        width: 220px;
        height: 220px;
    }

    .head-of-group:hover {
        transform: scale(1.15) translateY(-15px) !important;
        box-shadow: 0 30px 60px rgba(83, 192, 243, 0.4) !important;
    }

    .head-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #ff4b2b;
        color: #fff;
        padding: 4px 12px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.75rem;
        z-index: 3;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        text-transform: uppercase;
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
</style>

<div class="personnel-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center">
        <h1 class="display-4 text-white slideInDown mb-3">บุคลากร</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="<?= base_url('/') ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item text-white-50 active" aria-current="page">บุคลากร</li>
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
            <h1 class="display-6 mb-4"><?= str_replace("-", " ", urldecode($uri->getSegment(3))); ?></h1>
            <div class="section-divider"></div>
        </div>

        <div class="row g-4 justify-content-center" id="personnelContainer">
            <?php 
            // Separate Director, Heads, and Others for organized layout
            $director = null;
            $heads = [];
            $others = [];

            foreach ($Pers as $p) {
                if (urldecode($uri->getSegment(3)) === "ผู้บริหารสถานศึกษา" && $p->pers_position === "posi_001") {
                    $director = $p;
                } elseif ($p->pers_groupleade == 'หัวหน้ากลุ่มสาระ') {
                    $heads[] = $p;
                } elseif ($p->pers_status == "กำลังใช้งาน") {
                    $others[] = $p;
                }
            }
            ?>

            <!-- Render Director First -->
            <?php if ($director): ?>
                <div class="col-12 mb-5 personnel-item" data-name="<?= $director->pers_firstname . ' ' . $director->pers_lastname ?>">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-card text-center">
                                <div class="director-badge"><i class="bi bi-star-fill"></i> ผู้อำนวยการ</div>
                                <div class="team-image-wrapper">
                                    <img class="team-img" 
                                         src="<?= !empty($director->pers_img) ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $director->pers_img : base_url('uploads/presonnal/man.png') ?>" 
                                         alt="<?= $director->pers_firstname ?>"
                                         loading="lazy">
                                </div>
                                <div class="team-content">
                                    <h5 class="team-name"><?= $director->pers_prefix . $director->pers_firstname . ' ' . $director->pers_lastname ?></h5>
                                    <span class="team-pos"><?= $director->posi_name . ' ' . $director->pers_academic ?></span>
                                    <?= renderSocialLinks($director) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Render Heads -->
            <?php foreach ($heads as $head): ?>
                <div class="col-lg-4 col-md-6 personnel-item mb-5" data-name="<?= $head->pers_firstname . ' ' . $head->pers_lastname ?>">
                    <div class="team-card head-of-group wow fadeInUp" data-wow-delay="0.2s">
                        <div class="head-badge"><i class="bi bi-award-fill"></i> หัวหน้ากลุ่มสาระ</div>
                        <div class="team-image-wrapper">
                            <img class="team-img" 
                                 src="<?= !empty($head->pers_img) ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $head->pers_img : base_url('uploads/presonnal/man.png') ?>" 
                                 alt="<?= $head->pers_firstname ?>"
                                 loading="lazy">
                        </div>
                        <div class="team-content">
                            <h5 class="team-name"><?= $head->pers_prefix . $head->pers_firstname . ' ' . $head->pers_lastname ?></h5>
                            <span class="team-pos"><?= $head->posi_name . ' ' . $head->pers_academic ?></span>
                            <?= renderSocialLinks($head) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Render Others -->
            <?php foreach ($others as $p): ?>
                <div class="col-lg-3 col-md-6 personnel-item" data-name="<?= $p->pers_firstname . ' ' . $p->pers_lastname ?>">
                    <div class="team-card wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-image-wrapper">
                            <img class="team-img" 
                                 src="<?= !empty($p->pers_img) ? 'https://personnel.skj.ac.th/uploads/admin/Personnal/' . $p->pers_img : base_url('uploads/presonnal/man.png') ?>" 
                                 alt="<?= $p->pers_firstname ?>"
                                 loading="lazy">
                        </div>
                        <div class="team-content">
                            <h5 class="team-name"><?= $p->pers_prefix . $p->pers_firstname . ' ' . $p->pers_lastname ?></h5>
                            <span class="team-pos"><?= ($p->work_name == "" ? $p->posi_name : $p->work_name) . ' ' . $p->pers_academic ?></span>
                            <?= renderSocialLinks($p) ?>
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
    if (!empty($p->pers_facebook)) $html .= '<a href="' . $p->pers_facebook . '" target="_blank" class="social-btn fb-btn"><i class="fab fa-facebook-f"></i></a>';
    if (!empty($p->pers_instagram)) $html .= '<a href="' . $p->pers_instagram . '" target="_blank" class="social-btn ig-btn"><i class="fab fa-instagram"></i></a>';
    if (!empty($p->pers_twitter)) $html .= '<a href="' . $p->pers_twitter . '" target="_blank" class="social-btn tw-btn"><i class="fab fa-twitter"></i></a>';
    if (!empty($p->pers_line)) $html .= '<a href="https://line.me/ti/p/~' . $p->pers_line . '" target="_blank" class="social-btn line-btn"><i class="fab fa-line"></i></a>';
    if (!empty($p->pers_youtube)) $html .= '<a href="' . $p->pers_youtube . '" target="_blank" class="social-btn yt-btn"><i class="fab fa-youtube"></i></a>';
    
    if (empty($p->pers_facebook) && empty($p->pers_instagram) && empty($p->pers_line)) {
        $html .= '<span class="text-muted small">ไม่มีข้อมูลโซเชียล</span>';
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