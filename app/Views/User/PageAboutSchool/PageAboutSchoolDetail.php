<!-- Add Quill CSS for proper content rendering -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<!-- Google Fonts: Sarabun (Formal Thai Standard) & Prompt (Headings) -->
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700;800&family=Sarabun:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

<style>
    /* =========================================================================
       SKJ ABOUT PAGE — FORMAL, PROPORTIONAL & HIGHLY READABLE TYPOGRAPHY
       สอดคล้องกับระเบียบงานสารบรรณและการจัดรูปแบบเว็บไซต์ทางการของสถานศึกษา
       ========================================================================= */

    :root {
        --about-navy: #132240;
        --about-primary: #0d6efd;
        --about-blue-light: #f0f7ff;
        --about-pink: #fb7e9c;
        --about-text: #2d3748;
        --about-text-muted: #64748b;
        --about-border: #e2e8f0;
        --about-card-bg: #ffffff;
        --about-radius: 20px;
    }

    body {
        background-color: #f8fafc;
    }

    /* Page Header */
    .about-page-hero {
        background: linear-gradient(135deg, rgba(19, 34, 64, 0.95) 0%, rgba(13, 110, 253, 0.88) 100%),
                    url('<?= base_url('uploads/background/bg-about.jpg') ?>') center center / cover no-repeat;
        padding: 60px 0 50px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        border-bottom: 3px solid var(--about-pink);
    }

    .about-page-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(251, 126, 156, 0.18) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-pre-title {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 14px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 30px;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        color: #ffffff;
        margin-bottom: 14px;
        backdrop-filter: blur(8px);
    }

    .hero-main-title {
        font-family: 'Prompt', 'Sarabun', sans-serif;
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 12px;
        letter-spacing: -0.3px;
        color: #ffffff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
    }

    .about-breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        font-size: 0.92rem;
    }

    .about-breadcrumb .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .about-breadcrumb .breadcrumb-item a:hover {
        color: #ffffff;
        text-decoration: underline;
    }

    .about-breadcrumb .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.65);
    }

    .about-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.45);
    }

    /* Main Article Container */
    .about-main-card {
        background: var(--about-card-bg);
        border-radius: var(--about-radius);
        border: 1px solid var(--about-border);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        padding: 48px 52px;
        position: relative;
        margin-bottom: 40px;
    }

    /* Official Document Header Badge inside Card */
    .doc-official-header {
        border-bottom: 1.5px solid #edf2f7;
        padding-bottom: 22px;
        margin-bottom: 32px;
    }

    .doc-school-emblem {
        width: 56px;
        height: 56px;
        object-fit: contain;
        flex-shrink: 0;
        filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.12));
    }

    .doc-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--about-primary);
        background: var(--about-blue-light);
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 4px;
        letter-spacing: 0.3px;
    }

    .doc-school-title {
        font-family: 'Prompt', 'Sarabun', sans-serif;
        font-weight: 700;
        font-size: 1.12rem;
        color: var(--about-navy);
        line-height: 1.35;
        margin: 0;
    }

    .doc-school-subtitle {
        font-size: 0.84rem;
        color: var(--about-text-muted);
        line-height: 1.3;
        margin: 0;
    }

    /* Action Toolbar (Font Resizer, Print, Copy) */
    .doc-toolbar {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        padding: 5px 8px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .btn-toolbar-action {
        background: transparent;
        border: none;
        color: #475569;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        line-height: 1;
    }

    .btn-toolbar-action:hover {
        background: #ffffff;
        color: var(--about-primary);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }

    .btn-toolbar-action.active {
        background: var(--about-primary);
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(13, 110, 253, 0.3);
    }

    .btn-toolbar-action.btn-print {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
    }

    .btn-toolbar-action.btn-print:hover {
        background: var(--about-navy);
        color: #ffffff;
        border-color: var(--about-navy);
    }

    /* Article Heading & Metadata */
    .about-article-headline {
        font-family: 'Prompt', 'Sarabun', sans-serif;
        font-weight: 800;
        font-size: 2.1rem;
        color: var(--about-navy);
        margin-bottom: 12px;
        line-height: 1.3;
        position: relative;
    }

    .about-accent-line {
        width: 64px;
        height: 4px;
        background: linear-gradient(90deg, var(--about-pink) 0%, var(--about-primary) 100%);
        border-radius: 4px;
        margin-bottom: 22px;
    }

    .doc-meta-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px;
        color: var(--about-text-muted);
        font-size: 0.88rem;
        margin-bottom: 30px;
        padding: 10px 16px;
        background: #f8fafc;
        border-radius: 10px;
        border-left: 3px solid var(--about-primary);
    }

    .doc-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* =========================================================================
       OFFICIAL CONTENT TYPOGRAPHY — READABILITY SYSTEM
       ========================================================================= */

    .about-body-text {
        font-family: 'Sarabun', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--about-text);
        word-break: break-word;
        overflow-wrap: break-word;
        transition: font-size 0.2s ease, line-height 0.2s ease;
    }

    /* Typography font sizes (controlled by toolbar) */
    .about-body-text.size-sm {
        font-size: 1.05rem;
        line-height: 1.85;
    }

    .about-body-text.size-md {
        font-size: 1.15rem;
        line-height: 1.95;
    }

    .about-body-text.size-lg {
        font-size: 1.28rem;
        line-height: 2.05;
    }

    /* Quill Overrides & Formal Typography */
    .about-body-text .ql-editor {
        padding: 0 !important;
        font-family: inherit !important;
        font-size: inherit !important;
        line-height: inherit !important;
        color: inherit !important;
        overflow-y: visible !important;
    }

    /* Paragraphs */
    .about-body-text p {
        margin-bottom: 1.5rem;
        text-align: left;
        letter-spacing: 0.1px;
    }

    /* Headings inside content */
    .about-body-text h1,
    .about-body-text h2,
    .about-body-text h3,
    .about-body-text h4,
    .about-body-text h5,
    .about-body-text h6 {
        font-family: 'Prompt', 'Sarabun', sans-serif !important;
        font-weight: 700 !important;
        color: var(--about-navy) !important;
        margin-top: 2.2rem;
        margin-bottom: 1.1rem;
        line-height: 1.4;
    }

    .about-body-text h1 { font-size: 1.85em; border-bottom: 2px solid var(--about-border); padding-bottom: 8px; }
    .about-body-text h2 { font-size: 1.6em; border-bottom: 1.5px solid var(--about-border); padding-bottom: 6px; }
    .about-body-text h3 { font-size: 1.35em; color: #1e3a8a !important; }
    .about-body-text h4 { font-size: 1.18em; }

    /* Lists */
    .about-body-text ul,
    .about-body-text ol {
        padding-left: 2rem;
        margin-bottom: 1.6rem;
    }

    .about-body-text li {
        margin-bottom: 0.65rem;
        line-height: 1.85;
    }

    .about-body-text ul > li {
        list-style-type: disc;
    }

    /* Blockquotes / Callout Boxes */
    .about-body-text blockquote,
    .about-body-text .ql-editor blockquote {
        background: #f8fafc;
        border-left: 4px solid var(--about-primary) !important;
        border-radius: 0 14px 14px 0;
        padding: 18px 24px !important;
        margin: 1.8rem 0;
        color: #1e293b;
        font-style: normal;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.04);
        position: relative;
    }

    .about-body-text blockquote::before {
        content: '“';
        font-family: 'Prompt', serif;
        font-size: 2.8rem;
        line-height: 1;
        color: rgba(13, 110, 253, 0.25);
        position: absolute;
        top: 6px;
        left: 10px;
    }

    /* Tables */
    .about-body-text table {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        overflow: hidden;
        margin: 2rem 0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .about-body-text th {
        background: #f1f5f9 !important;
        color: var(--about-navy) !important;
        font-weight: 700 !important;
        padding: 14px 18px !important;
        border-bottom: 2px solid #cbd5e1 !important;
        border-right: 1px solid #e2e8f0;
        text-align: left;
    }

    .about-body-text td {
        padding: 12px 18px !important;
        border-bottom: 1px solid #e2e8f0 !important;
        border-right: 1px solid #e2e8f0;
        color: var(--about-text) !important;
        vertical-align: top;
    }

    .about-body-text tr:last-child td {
        border-bottom: none !important;
    }

    .about-body-text tr:nth-child(even) td {
        background: #f8fafc;
    }

    .about-body-text tr:hover td {
        background: #f0f7ff;
    }

    /* Images */
    .about-body-text img,
    .about-body-text .ql-editor img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        margin: 22px auto;
        display: block;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Links */
    .about-body-text a {
        color: var(--about-primary) !important;
        text-decoration: underline !important;
        text-underline-offset: 3px;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .about-body-text a:hover {
        color: #0b5ed7 !important;
        background: rgba(13, 110, 253, 0.08);
        border-radius: 4px;
        padding: 1px 4px;
        text-decoration: none !important;
    }

    .about-body-text strong,
    .about-body-text b {
        font-weight: 700;
        color: #0f172a;
    }

    /* =========================================================================
       SIDEBAR NAVIGATION — STRUCTURED & BALANCED
       ========================================================================= */

    .about-sidebar-widget {
        background: var(--about-card-bg);
        border-radius: var(--about-radius);
        border: 1px solid var(--about-border);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        padding: 30px 24px;
        position: sticky;
        top: 95px;
        margin-bottom: 30px;
    }

    .sidebar-heading {
        font-family: 'Prompt', 'Sarabun', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--about-navy);
        padding-bottom: 14px;
        margin-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-heading-icon {
        width: 32px;
        height: 32px;
        background: rgba(13, 110, 253, 0.1);
        color: var(--about-primary);
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .about-menu-nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .about-menu-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 18px;
        border-radius: 12px;
        color: #334155;
        font-weight: 500;
        font-size: 0.98rem;
        text-decoration: none;
        background: #f8fafc;
        border: 1px solid transparent;
        transition: all 0.25s ease;
    }

    .about-menu-link:hover {
        background: #ffffff;
        color: var(--about-primary);
        border-color: #cbd5e1;
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .about-menu-link.active {
        background: linear-gradient(135deg, var(--about-navy) 0%, var(--about-primary) 100%);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 6px 18px rgba(13, 110, 253, 0.25);
        border-color: transparent;
        transform: translateX(6px);
    }

    .about-menu-link i {
        font-size: 0.85rem;
        opacity: 0.5;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    .about-menu-link:hover i,
    .about-menu-link.active i {
        opacity: 1;
        transform: translateX(3px);
    }

    .about-menu-link.active i {
        color: var(--about-pink);
    }

    /* Sidebar Divider & Extra Links */
    .sidebar-section-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 18px 0;
    }

    .sidebar-contact-card {
        background: linear-gradient(145deg, #132240 0%, #1e3a8a 100%);
        border-radius: 16px;
        padding: 22px 20px;
        color: #ffffff;
        margin-top: 24px;
        box-shadow: 0 8px 20px rgba(19, 34, 64, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .contact-card-title {
        font-family: 'Prompt', 'Sarabun', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-card-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.88rem;
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.4;
    }

    .contact-card-item i {
        color: var(--about-pink);
        margin-top: 2px;
    }

    /* =========================================================================
       RESPONSIVE DESIGN (Tablets & Smartphones)
       ========================================================================= */

    @media (max-width: 991px) {
        .about-main-card {
            padding: 36px 28px;
            border-radius: 18px;
        }

        .about-article-headline {
            font-size: 1.75rem;
        }

        .hero-main-title {
            font-size: 2rem;
        }

        .about-sidebar-widget {
            position: static;
            margin-top: 20px;
        }
    }

    @media (max-width: 576px) {
        .about-page-hero {
            padding: 40px 0 35px;
        }

        .about-main-card {
            padding: 26px 18px;
            border-radius: 16px;
        }

        .about-article-headline {
            font-size: 1.45rem;
        }

        .doc-school-emblem {
            width: 44px;
            height: 44px;
        }

        .doc-school-title {
            font-size: 1rem;
        }

        .about-body-text.size-md {
            font-size: 1.05rem;
            line-height: 1.85;
        }

        .doc-official-header {
            padding-bottom: 16px;
            margin-bottom: 22px;
        }
    }

    /* =========================================================================
       PRINT STYLESHEET (พิมพ์เอกสารทางการ / บันทึก PDF)
       ========================================================================= */

    @media print {
        /* Hide web UI chrome elements */
        header,
        nav,
        .about-page-hero,
        .about-sidebar-col,
        .doc-toolbar,
        footer,
        .skj-chat-widget,
        #skjCookieBanner,
        .btn,
        .breadcrumb {
            display: none !important;
        }

        body,
        .container-xxl,
        .container {
            background: #ffffff !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .about-main-card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .about-article-headline {
            color: #000000 !important;
            font-size: 22pt !important;
        }

        .about-body-text {
            font-size: 14pt !important;
            line-height: 1.8 !important;
            color: #000000 !important;
        }

        .doc-official-header {
            border-bottom: 2pt solid #000000 !important;
            display: flex !important;
        }

        .doc-school-emblem {
            width: 70px !important;
            height: 70px !important;
        }

        .col-lg-8 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }
    }
</style>

<!-- Hero Banner -->
<section class="about-page-hero wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-10 mx-auto text-center">
                <div class="hero-pre-title">
                    <img src="<?= base_url('uploads/logoSchool/LogoSKJ_4.png') ?>" alt="SKJ" width="20" height="20" style="object-fit: contain;">
                    <span>ข้อมูลสถานศึกษา · ข้อมูลทั่วไป</span>
                </div>
                <h1 class="hero-main-title"><?= esc($AboutDetail->about_menu) ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb about-breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bi bi-house-door-fill me-1"></i>หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('About') ?>">เกี่ยวกับ สกจ</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($AboutDetail->about_menu) ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Content Body & Sidebar Section -->
<main class="container-xxl py-5">
    <div class="container">
        <div class="row g-4 g-lg-5">

            <!-- MAIN CONTENT COLUMN (8 cols) -->
            <div class="col-lg-8">
                <article class="about-main-card wow fadeInUp" data-wow-delay="0.2s">

                    <!-- Official Document Header (ตราสัญลักษณ์ & แถบเครื่องมือช่วยอ่าน) -->
                    <div class="doc-official-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= base_url('uploads/logoSchool/LogoSKJ_4.png') ?>" alt="ตราประจำโรงเรียน" class="doc-school-emblem">
                            <div>
                                <span class="doc-badge-pill">
                                    <i class="bi bi-patch-check-fill me-1"></i> ข้อมูลสารสนเทศทางการ
                                </span>
                                <h2 class="doc-school-title">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</h2>
                                <p class="doc-school-subtitle">สังกัดองค์การบริหารส่วนจังหวัดนครสวรรค์</p>
                            </div>
                        </div>

                        <!-- Readability Controls (ปรับขนาดตัวหนังสือ / พิมพ์ / คัดลอก) -->
                        <div class="doc-toolbar" role="toolbar" aria-label="เครื่องมือสำหรับผู้อ่าน">
                            <span class="small text-muted me-1 d-none d-sm-inline" style="font-size: 11px;">ขนาดตัวอักษร:</span>
                            <button type="button" class="btn-toolbar-action" id="btnFontSm" title="ตัวหนังสือขนาดเล็ก">ก-</button>
                            <button type="button" class="btn-toolbar-action active" id="btnFontMd" title="ตัวหนังสือขนาดปกติ">ก</button>
                            <button type="button" class="btn-toolbar-action" id="btnFontLg" title="ตัวหนังสือขนาดใหญ่">ก+</button>
                            <span class="text-muted opacity-50 mx-1">|</span>
                            <button type="button" class="btn-toolbar-action btn-print" onclick="window.print();" title="พิมพ์หน้านี้ / พิมพ์เป็น PDF">
                                <i class="bi bi-printer-fill"></i>
                                <span class="d-none d-md-inline">พิมพ์</span>
                            </button>
                            <button type="button" class="btn-toolbar-action" id="btnCopyLink" title="คัดลอกลิงก์หน้านี้">
                                <i class="bi bi-share-fill"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Article Title -->
                    <header>
                        <h1 class="about-article-headline"><?= esc($AboutDetail->about_menu) ?></h1>
                        <div class="about-accent-line"></div>

                        <!-- Meta Info -->
                        <div class="doc-meta-bar">
                            <div class="doc-meta-item">
                                <i class="bi bi-folder2-open text-primary"></i>
                                <span>หมวดหมู่: ข้อมูลเกี่ยวกับ สกจ</span>
                            </div>
                            <?php if (!empty($AboutDetail->about_date)): ?>
                                <div class="doc-meta-item">
                                    <i class="bi bi-calendar3 text-primary"></i>
                                    <span>ปรับปรุงข้อมูลล่าสุด: <?= date('d/m/Y', strtotime($AboutDetail->about_date)) ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="doc-meta-item ms-auto d-none d-sm-flex">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>ฉบับทางการ</span>
                            </div>
                        </div>
                    </header>

                    <!-- Main Text Content (Quill Rendered with Formal Typography) -->
                    <div class="about-body-text size-md ql-snow" id="aboutBodyContent">
                        <div class="ql-editor">
                            <?= $AboutDetail->about_detail ?>
                        </div>
                    </div>

                    <!-- Official Document Footer Note -->
                    <div class="mt-5 pt-4 border-top text-muted small d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <span>
                            <i class="bi bi-shield-check text-primary me-1"></i> กลุ่มงานบริหารทั่วไปและเทคโนโลยีสารสนเทศ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
                        </span>
                        <a href="javascript:void(0);" onclick="window.scrollTo({top: 0, behavior: 'smooth'});" class="text-primary text-decoration-none">
                            <i class="bi bi-arrow-up-circle-fill me-1"></i> กลับสู่ด้านบน
                        </a>
                    </div>

                </article>
            </div>

            <!-- SIDEBAR NAVIGATION COLUMN (4 cols) -->
            <div class="col-lg-4 about-sidebar-col">
                <aside class="about-sidebar-widget wow fadeInRight" data-wow-delay="0.3s">

                    <h3 class="sidebar-heading">
                        <span class="sidebar-heading-icon"><i class="bi bi-bank"></i></span>
                        <span>เกี่ยวกับ สกจ</span>
                    </h3>

                    <!-- Dynamic Navigation of all About items -->
                    <nav class="about-menu-nav" aria-label="เมนูเกี่ยวกับ สกจ">
                        <?php foreach ($AboutSchool as $key => $value) : ?>
                            <?php $isActive = ($AboutDetail->about_menu == $value->about_menu) ? 'active' : ''; ?>
                            <a class="about-menu-link <?= $isActive ?>" href="<?= base_url('About/' . urlencode($value->about_menu)) ?>" <?= $isActive ? 'aria-current="page"' : '' ?>>
                                <span><i class="bi bi-bookmark-fill me-2 <?= $isActive ? 'text-white' : 'text-primary' ?>" style="font-size: 0.8rem;"></i><?= esc($value->about_menu) ?></span>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        <?php endforeach; ?>

                        <!-- Board Link (คณะกรรมการสถานศึกษา) -->
                        <div class="sidebar-section-divider"></div>
                        <a class="about-menu-link" href="<?= base_url('Board') ?>">
                            <span><i class="bi bi-person-lines-fill me-2 text-primary" style="font-size: 0.85rem;"></i>คณะกรรมการสถานศึกษา</span>
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                        <a class="about-menu-link" href="https://botany.skj.ac.th/" target="_blank" rel="noopener">
                            <span><i class="bi bi-flower1 me-2 text-success" style="font-size: 0.85rem;"></i>งานสวนพฤกษศาสตร์</span>
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </nav>

                    <!-- School Quick Contact Card -->
                    <div class="sidebar-contact-card">
                        <h4 class="contact-card-title">
                            <i class="bi bi-building"></i> ติดต่อประสานงาน
                        </h4>
                        <div class="contact-card-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>160 หมู่ 1 ต.นครสวรรค์ออก อ.เมือง จ.นครสวรรค์ 60000</span>
                        </div>
                        <div class="contact-card-item">
                            <i class="bi bi-telephone-fill"></i>
                            <span>โทร: 056-200-765</span>
                        </div>
                        <div class="contact-card-item">
                            <i class="bi bi-envelope-fill"></i>
                            <span>อีเมล: skjns160@skj.ac.th</span>
                        </div>
                        <div class="contact-card-item">
                            <i class="bi bi-clock-fill"></i>
                            <span>วันจันทร์ - ศุกร์ | 08.00 - 16.30 น.</span>
                        </div>
                    </div>

                </aside>
            </div>

        </div>
    </div>
</main>

<!-- Readability Script (Font Size Switcher & Copy Link) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bodyContent = document.getElementById('aboutBodyContent');
        const btnSm = document.getElementById('btnFontSm');
        const btnMd = document.getElementById('btnFontMd');
        const btnLg = document.getElementById('btnFontLg');
        const btnCopy = document.getElementById('btnCopyLink');

        // Font size preference handling
        function setFontSize(size) {
            if (!bodyContent) return;
            bodyContent.classList.remove('size-sm', 'size-md', 'size-lg');
            bodyContent.classList.add('size-' + size);

            [btnSm, btnMd, btnLg].forEach(btn => btn && btn.classList.remove('active'));
            if (size === 'sm' && btnSm) btnSm.classList.add('active');
            if (size === 'md' && btnMd) btnMd.classList.add('active');
            if (size === 'lg' && btnLg) btnLg.classList.add('active');

            try {
                localStorage.setItem('skj_about_font_size', size);
            } catch (e) {}
        }

        // Restore user preference if saved
        try {
            const savedSize = localStorage.getItem('skj_about_font_size');
            if (savedSize && ['sm', 'md', 'lg'].includes(savedSize)) {
                setFontSize(savedSize);
            }
        } catch (e) {}

        if (btnSm) btnSm.addEventListener('click', () => setFontSize('sm'));
        if (btnMd) btnMd.addEventListener('click', () => setFontSize('md'));
        if (btnLg) btnLg.addEventListener('click', () => setFontSize('lg'));

        // Copy link handler
        if (btnCopy) {
            btnCopy.addEventListener('click', function () {
                const url = window.location.href;
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(() => {
                        showCopySuccess();
                    }).catch(() => fallbackCopy(url));
                } else {
                    fallbackCopy(url);
                }
            });
        }

        function fallbackCopy(text) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            showCopySuccess();
        }

        function showCopySuccess() {
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'คัดลอกลิงก์สำเร็จ!',
                    text: 'คัดลอกที่อยู่หน้านี้ไปยังคลิปบอร์ดแล้ว',
                    timer: 1800,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            } else {
                alert('คัดลอกลิงก์เรียบร้อยแล้ว');
            }
        }
    });
</script>