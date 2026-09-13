<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700;800&family=Sarabun:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

<style>
    /* =========================================================================
       SKJ BOARD DIRECTORY — FORMAL, BALANCED & READABLE TYPOGRAPHY
       ========================================================================= */

    :root {
        --board-navy: #132240;
        --board-primary: #0d6efd;
        --board-pink: #fb7e9c;
        --board-border: #e2e8f0;
    }

    .board-container {
        font-family: 'Sarabun', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: #f8faff;
        background-image: 
            radial-gradient(at 0% 0%, rgba(251, 126, 156, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(13, 110, 253, 0.05) 0px, transparent 50%);
        padding: 50px 0 80px;
        min-height: 100vh;
    }

    /* Breadcrumbs */
    .board-breadcrumb-nav {
        margin-bottom: 35px;
    }

    .board-breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 0.92rem;
    }

    .board-breadcrumb .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .board-breadcrumb .breadcrumb-item a:hover {
        color: var(--board-primary);
    }

    .board-breadcrumb .breadcrumb-item.active {
        color: var(--board-navy);
        font-weight: 600;
    }

    /* Board Header */
    .board-header {
        margin-bottom: 50px;
        text-align: center;
    }

    .board-pre-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid var(--board-border);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--board-navy);
        margin-bottom: 16px;
    }

    .board-header h1 {
        font-family: 'Prompt', 'Sarabun', sans-serif;
        font-weight: 800;
        color: var(--board-navy);
        font-size: 2.6rem;
        margin-bottom: 14px;
        letter-spacing: -0.3px;
    }

    .board-header .divider {
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--board-pink), var(--board-primary));
        margin: 0 auto 12px;
        border-radius: 10px;
    }

    .board-header .board-subtitle {
        color: #64748b;
        font-size: 1.05rem;
        margin: 0;
    }

    /* Section Row Titles */
    .board-row-title {
        font-family: 'Prompt', 'Sarabun', sans-serif;
        font-weight: 700;
        font-size: 1.35rem;
        color: var(--board-navy);
        text-align: center;
        margin: 45px 0 25px;
        position: relative;
        padding-bottom: 12px;
    }

    .board-row-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 45px;
        height: 3px;
        background: var(--board-primary);
        border-radius: 2px;
    }

    /* Member Card */
    .board-card {
        background: #ffffff;
        border: 1px solid var(--board-border);
        border-radius: 18px;
        padding: 20px 16px 18px;
        text-align: center;
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        width: 100%;
        height: 100%;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
        display: flex; 
        flex-direction: column;
        align-items: center;
        overflow: hidden;
        box-sizing: border-box;
    }

    .board-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
        border-color: rgba(13, 110, 253, 0.3);
    }

    /* Responsive 3:4 portrait image wrapper */
    .board-img-wrapper {
        width: 100%;
        max-width: 160px;
        aspect-ratio: 3 / 4;
        margin: 0 auto 14px;
        border-radius: 12px;
        padding: 3px;
        background: linear-gradient(135deg, rgba(251, 126, 156, 0.7) 0%, rgba(13, 110, 253, 0.7) 100%);
        position: relative;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
        flex-shrink: 0;
        overflow: hidden;
        box-sizing: border-box;
    }

    .board-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        border-radius: 9px;
        background: #f1f5f9;
        display: block;
        transition: transform 0.35s ease;
    }

    .board-card:hover .board-img-wrapper img {
        transform: scale(1.04);
    }

    .board-name {
        font-family: 'Prompt', 'Sarabun', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--board-navy);
        margin-bottom: 5px;
        line-height: 1.35;
        word-break: break-word;
        max-width: 100%;
    }

    .board-position {
        font-weight: 600;
        color: #d63384;
        font-size: 0.92rem;
        margin-bottom: 10px;
        display: block;
        line-height: 1.35;
        max-width: 100%;
    }

    .board-type {
        display: inline-block;
        padding: 3px 12px;
        background: rgba(13, 110, 253, 0.08);
        color: var(--board-primary);
        border: 1px solid rgba(13, 110, 253, 0.15);
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: auto;
        max-width: 100%;
        line-height: 1.4;
    }

    /* Single Chairman: Centered & Balanced */
    .row-chairman .col {
        max-width: 360px;
        width: 100%;
    }

    .row-chairman .board-card {
        padding: 26px 20px 22px;
    }

    .row-chairman .board-img-wrapper {
        max-width: 195px;
    }

    .row-chairman .board-name {
        font-size: 1.2rem;
    }

    .row-chairman .board-position {
        font-size: 1rem;
    }

    @media (max-width: 991px) {
        .board-header h1 { font-size: 2.1rem; }
    }

    @media (max-width: 575px) {
        .board-container { padding: 30px 0 60px; }
        .board-header h1 { font-size: 1.7rem; }
        .board-card { padding: 18px 12px; }
        .board-img-wrapper { max-width: 135px; }
        .row-chairman .board-img-wrapper { max-width: 160px; }
        .board-name { font-size: 0.98rem; }
    }

    @media print {
        header, nav, footer, .skj-chat-widget, #skjCookieBanner, .board-breadcrumb-nav {
            display: none !important;
        }
        .board-container {
            background: #ffffff !important;
            padding: 0 !important;
        }
        .board-card {
            box-shadow: none !important;
            border: 1px solid #cbd5e1 !important;
            page-break-inside: avoid;
        }
    }
</style>

<div class="board-container">
    <div class="container">

        <!-- Breadcrumbs Navigation -->
        <nav class="board-breadcrumb-nav" aria-label="breadcrumb">
            <ol class="breadcrumb board-breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bi bi-house-door-fill me-1"></i>หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('About') ?>">เกี่ยวกับ สกจ</a></li>
                <li class="breadcrumb-item active" aria-current="page">คณะกรรมการสถานศึกษา</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="board-header animate__animated animate__fadeIn">
            <div class="board-pre-badge">
                <img src="<?= base_url('uploads/logoSchool/LogoSKJ_4.png') ?>" alt="SKJ" width="22" height="22" style="object-fit: contain;">
                <span>ข้อมูลสารสนเทศทางการ · คณะกรรมการสถานศึกษา</span>
            </div>
            <h1>ทำเนียบคณะกรรมการสถานศึกษาขั้นพื้นฐาน</h1>
            <div class="divider"></div>
            <p class="board-subtitle">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
        </div>

        <!-- Board Rows -->
        <?php foreach ($board_rows as $row) : ?>
            <?php if (!empty($row->members)) : ?>
                <?php 
                    $is_chairman = ($row->row_cols == 1);
                    $grid_class = $is_chairman 
                        ? 'row-chairman row-cols-1' 
                        : 'row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-' . $row->row_cols;
                ?>
                <div class="board-section mb-4">
                    <div class="row g-3 g-lg-4 justify-content-center <?= $grid_class ?>">
                        <?php foreach ($row->members as $member) : ?>
                            <div class="col d-flex justify-content-center">
                                <div class="board-card animate__animated animate__zoomIn">
                                    <div class="board-img-wrapper">
                                        <?php 
                                            $img_path = "https://personnel.skj.ac.th/uploads/admin/Board/" . ($member->board_img ?: 'default.png');
                                        ?>
                                        <img src="<?= $img_path ?>" alt="<?= esc($member->board_firstname) ?>" onerror="this.src='<?= base_url('uploads/logoSchool/LogoSKJ_4.png') ?>'; this.style.objectFit='contain'; this.style.padding='16px';">
                                    </div>
                                    <h2 class="board-name"><?= esc($member->board_prefix . $member->board_firstname . ' ' . $member->board_lastname) ?></h2>
                                    <span class="board-position"><?= esc($member->board_position) ?></span>
                                    <?php if ($member->board_type) : ?>
                                        <span class="board-type"><?= esc($member->board_type) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if (empty($board_rows)) : ?>
            <div class="text-center py-5">
                <i class="bi bi-people-fill display-1 text-muted opacity-25"></i>
                <p class="mt-3 text-muted">ไม่พบข้อมูลคณะกรรมการสถานศึกษาในขณะนี้</p>
            </div>
        <?php endif; ?>

    </div>
</div>
