<!-- Google Fonts: Sarabun & K2D -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=K2D:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Add Quill CSS for proper content rendering -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    /* ==========================================================================
       News Detail Page - Responsive & Mobile-First Readability
       ========================================================================== */
    
    :root {
        --news-primary: #1a2a4d;
        --news-accent: #0d6efd;
        --news-accent-soft: #eef4ff;
        --news-text-main: #2d3748;
        --news-text-muted: #64748b;
        --news-bg-card: #ffffff;
        --news-border-light: #edf2f7;
    }

    /* Page Header / Hero */
    .skj-news-header {
        position: relative;
        padding: 60px 0 75px;
        background: linear-gradient(135deg, rgba(26, 42, 77, 0.94) 0%, rgba(13, 30, 65, 0.9) 100%), 
                    url(<?= base_url('uploads/news/'.$news->news_img) ?>) center center no-repeat;
        background-size: cover;
        border-radius: 0 0 36px 36px;
        color: #fff;
        margin-bottom: -35px;
    }

    @media (min-width: 992px) {
        .skj-news-header {
            padding: 85px 0 100px;
            border-radius: 0 0 60px 60px;
            margin-bottom: -45px;
        }
    }

    .skj-news-header .breadcrumb {
        background: transparent;
        padding: 0;
        font-size: 0.9rem;
    }

    .skj-news-header .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.2s;
    }

    .skj-news-header .breadcrumb-item a:hover {
        color: #fff;
        text-decoration: underline;
    }

    .skj-news-header .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.95);
        font-weight: 500;
    }

    .skj-news-header .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.45);
    }

    /* Article Card Main */
    .news-article-card {
        background: var(--news-bg-card);
        border-radius: 24px;
        padding: 24px 18px;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.04);
        position: relative;
        z-index: 10;
    }

    @media (min-width: 768px) {
        .news-article-card {
            border-radius: 32px;
            padding: 38px 36px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
        }
    }

    @media (min-width: 1200px) {
        .news-article-card {
            padding: 46px 44px;
        }
    }

    /* Category Badge */
    .news-cat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--news-accent-soft);
        color: var(--news-accent);
        font-family: 'K2D', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 50px;
        border: 1px solid rgba(13, 110, 253, 0.15);
        margin-bottom: 14px;
    }

    /* Headline Title */
    .news-article-title {
        font-family: 'Sarabun', 'K2D', sans-serif;
        font-weight: 700;
        color: var(--news-primary);
        font-size: 1.35rem;
        line-height: 1.5;
        letter-spacing: -0.01em;
        margin-bottom: 16px;
        word-break: break-word;
    }

    @media (min-width: 768px) {
        .news-article-title {
            font-size: 1.7rem;
            line-height: 1.48;
            margin-bottom: 20px;
        }
    }

    @media (min-width: 1200px) {
        .news-article-title {
            font-size: 1.95rem;
            line-height: 1.45;
        }
    }

    /* Meta Info Bar */
    .news-meta-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px 18px;
        padding-bottom: 18px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--news-border-light);
        font-size: 0.88rem;
        color: var(--news-text-muted);
    }

    .news-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .news-meta-item i {
        color: var(--news-accent);
        font-size: 0.95rem;
    }

    /* Reading Controls & Share Toolbar */
    .news-toolbar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 10px 16px;
        margin-bottom: 24px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .news-font-adjuster {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.88rem;
        color: var(--news-text-muted);
    }

    .font-btn-group {
        display: inline-flex;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        overflow: hidden;
    }

    .font-btn {
        border: none;
        background: transparent;
        padding: 3px 10px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
    }

    .font-btn:hover {
        background: #f1f5f9;
        color: var(--news-accent);
    }

    .font-btn.active {
        background: var(--news-accent);
        color: #fff;
    }

    .news-share-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .news-share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        color: #fff;
        text-decoration: none;
        font-size: 0.95rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .news-share-btn:hover {
        transform: translateY(-2px);
        color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .share-fb { background: #1877f2; }
    .share-line { background: #06c755; }
    .share-copy { background: #475569; cursor: pointer; border: none; }

    /* Featured Main News Image */
    .news-feature-img-wrapper {
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 26px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        background: #f1f5f9;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .news-feature-img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        max-height: 520px;
        transition: transform 0.4s ease;
    }

    /* News Content Typography */
    .news-content-wrapper {
        font-family: 'Sarabun', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--news-text-main);
        word-break: break-word;
        overflow-wrap: break-word;
        transition: font-size 0.2s ease;
    }

    /* Dynamic font sizes controllable by toolbar */
    .news-content-wrapper.size-sm {
        font-size: 1rem;
        line-height: 1.85;
    }

    .news-content-wrapper.size-md {
        font-size: 1.125rem;
        line-height: 1.95;
    }

    .news-content-wrapper.size-lg {
        font-size: 1.25rem;
        line-height: 2.05;
    }

    /* Thai typography: left align for natural reading, no weird word-spacing */
    .news-content-wrapper .ql-editor {
        padding: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        text-align: left !important;
    }

    .news-content-wrapper .ql-editor p {
        margin-bottom: 1.35rem;
        text-align: left !important;
        letter-spacing: 0.01em;
    }

    /* Collapse excessive blank paragraphs created in rich editor */
    .news-content-wrapper .ql-editor p:empty {
        display: none;
    }

    .news-content-wrapper .ql-editor p > br:only-child {
        display: none;
    }

    .news-content-wrapper .ql-editor p.content-spacer {
        margin-bottom: 0.75rem;
    }

    /* Media inside content */
    .news-content-wrapper .ql-editor img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        margin: 18px 0;
    }

    .news-content-wrapper .ql-editor iframe {
        max-width: 100% !important;
        width: 100% !important;
        aspect-ratio: 16 / 9;
        border-radius: 14px;
        margin: 18px 0;
    }

    .news-content-wrapper .ql-editor table {
        max-width: 100% !important;
        width: 100% !important;
        border-collapse: collapse;
        margin: 20px 0;
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Smart badges in content */
    .news-hashtag {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        background: #f1f5f9;
        color: #0f172a;
        padding: 3px 12px;
        margin: 3px 4px 3px 0;
        border-radius: 20px;
        font-size: 0.9em;
        font-weight: 500;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        vertical-align: middle;
    }

    .news-hashtag i {
        color: var(--news-accent);
        font-size: 0.85em;
    }

    .news-tel-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        color: #047857 !important;
        padding: 4px 12px;
        margin: 2px 4px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.95em;
        text-decoration: none;
        border: 1px solid #a7f3d0;
        transition: all 0.2s;
        vertical-align: middle;
    }

    .news-tel-badge:hover {
        background: #d1fae5;
        color: #065f46 !important;
        transform: scale(1.02);
    }

    /* Links inside content */
    .news-content-wrapper .ql-editor a,
    .news-content-link {
        color: var(--news-accent) !important;
        font-weight: 500;
        text-decoration: underline !important;
        text-underline-offset: 3px;
        word-break: break-all !important;
        overflow-wrap: anywhere !important;
        transition: all 0.2s ease;
        display: inline;
    }

    .news-content-wrapper .ql-editor a:hover,
    .news-content-link:hover {
        color: #0b5ed7 !important;
        text-decoration: none !important;
        background-color: rgba(13, 110, 253, 0.08);
        border-radius: 4px;
        padding: 1px 4px;
    }

    .news-hashtag:hover {
        background: var(--news-accent-soft);
        border-color: rgba(13, 110, 253, 0.3);
        color: var(--news-accent);
        transform: translateY(-1px);
    }

    /* Highlight Contact & Source Box */
    .news-source-box {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-left: 4px solid var(--news-accent);
        border-radius: 16px;
        padding: 18px 20px;
        margin: 30px 0 20px;
    }

    .news-source-box .school-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .news-source-box .school-logo-mini {
        width: 38px;
        height: 38px;
        object-fit: contain;
    }

    .news-source-box h6 {
        font-family: 'K2D', sans-serif;
        font-weight: 700;
        color: var(--news-primary);
        margin: 0;
        font-size: 0.98rem;
    }

    /* Facebook Reference Card */
    .news-fb-card {
        background: #f0f6ff;
        border: 1px solid #d0e1fd;
        border-radius: 16px;
        padding: 14px 18px;
        margin: 20px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Album Gallery Grid */
    .album-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 40px 0 20px;
        padding-top: 25px;
        border-top: 1px solid var(--news-border-light);
    }

    .album-title {
        font-family: 'K2D', sans-serif;
        font-weight: 700;
        color: var(--news-primary);
        font-size: 1.25rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .album-badge {
        font-size: 0.82rem;
        background: #e2e8f0;
        color: #475569;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    .album-item {
        border-radius: 14px;
        overflow: hidden;
        position: relative;
        aspect-ratio: 4 / 3;
        background: #f1f5f9;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .album-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }

    .album-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    .album-item:hover img {
        transform: scale(1.05);
    }

    .album-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.25);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.4rem;
        transition: opacity 0.3s ease;
    }

    .album-item:hover .album-overlay {
        opacity: 1;
    }

    /* Bottom Action Bar */
    .news-bottom-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1px solid var(--news-border-light);
    }

    /* Sidebar Widgets */
    .sidebar-widget {
        background: #fff;
        border-radius: 24px;
        padding: 24px 22px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        margin-bottom: 28px;
    }

    @media (min-width: 992px) {
        .sidebar-sticky-wrap {
            position: sticky;
            top: 90px;
        }
    }

    .sidebar-title {
        font-family: 'K2D', sans-serif;
        font-weight: 700;
        color: var(--news-primary);
        font-size: 1.15rem;
        margin-bottom: 18px;
        position: relative;
        padding-bottom: 10px;
    }

    .sidebar-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 38px;
        height: 3px;
        background: var(--news-accent);
        border-radius: 2px;
    }

    .glass-search-sidebar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 18px;
        font-size: 0.92rem;
        transition: all 0.2s;
    }

    .glass-search-sidebar:focus {
        background: #fff;
        border-color: var(--news-accent);
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .sidebar-search-btn {
        background: var(--news-accent);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0 18px;
        margin-left: 8px;
        transition: background 0.2s;
    }

    .sidebar-search-btn:hover {
        background: #0b5ed7;
    }

    .recent-news-list {
        max-height: 620px;
        overflow-y: auto;
        padding-right: 6px;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    .recent-news-list::-webkit-scrollbar {
        width: 5px;
    }

    .recent-news-list::-webkit-scrollbar-track {
        background: transparent;
    }

    .recent-news-list::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 6px;
    }

    .recent-news-item {
        display: flex;
        gap: 14px;
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        transition: transform 0.2s;
    }

    .recent-news-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .recent-news-item:hover {
        transform: translateX(4px);
    }

    .recent-news-img {
        width: 80px;
        height: 75px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
        background: #f1f5f9;
    }

    .recent-news-info {
        flex: 1;
        min-width: 0;
    }

    .recent-news-info h6 {
        font-family: 'Sarabun', sans-serif;
        font-weight: 600;
        font-size: 0.92rem;
        line-height: 1.45;
        margin-bottom: 6px;
        color: var(--news-primary);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .recent-news-info a {
        text-decoration: none;
    }

    .recent-news-info a:hover h6 {
        color: var(--news-accent);
    }

    /* Toast notification */
    #newsCopyToast {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #0f172a;
        color: #fff;
        padding: 10px 22px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-family: 'K2D', sans-serif;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #newsCopyToast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
</style>

<!-- Top Breadcrumb Banner -->
<div class="skj-news-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bi bi-house-door-fill me-1"></i> หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('News') ?>">ข่าวประชาสัมพันธ์</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 250px;" aria-current="page"><?= esc($news->news_category ?? 'รายละเอียดข่าว') ?></li>
            </ol>
        </nav>
        <div class="d-none d-md-block text-white-50 small">
            <i class="bi bi-info-circle me-1"></i> โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4 g-lg-5">
        <!-- Main News Column -->
        <div class="col-lg-8">
            <article class="news-article-card wow fadeInUp" data-wow-delay="0.15s">
                
                <!-- Category Badge -->
                <div>
                    <span class="news-cat-pill">
                        <i class="bi bi-tag-fill"></i> <?= esc($news->news_category ?? 'ข่าวประชาสัมพันธ์') ?>
                    </span>
                </div>

                <!-- Main Article Headline (H1) -->
                <h1 class="news-article-title" id="articleHeadline">
                    <?= esc($news->news_topic) ?>
                </h1>

                <!-- Meta Details Bar -->
                <div class="news-meta-bar">
                    <span class="news-meta-item">
                        <i class="bi bi-calendar3"></i> <?= $dateThai->thai_date_fullmonth(strtotime($news->news_date)) ?>
                    </span>
                    <span class="news-meta-item">
                        <i class="bi bi-eye"></i> เข้าชม <?= number_format($news->news_view) ?> ครั้ง
                    </span>
                    <span class="news-meta-item">
                        <i class="bi bi-person-circle"></i> งานประชาสัมพันธ์
                    </span>
                    <span class="news-meta-item d-none d-sm-inline-flex">
                        <i class="bi bi-clock-history"></i> ใช้เวลาอ่าน ~<?= max(1, (int)ceil(mb_strlen(strip_tags($news->news_content)) / 450)) ?> นาที
                    </span>
                </div>

                <!-- Reading & Share Toolbar -->
                <div class="news-toolbar">
                    <!-- Font Size Adjuster -->
                    <div class="news-font-adjuster">
                        <span><i class="bi bi-type me-1"></i> ขนาดตัวอักษร:</span>
                        <div class="font-btn-group">
                            <button type="button" class="font-btn" data-size="sm" title="ขนาดเล็ก">A-</button>
                            <button type="button" class="font-btn active" data-size="md" title="ขนาดปกติ">A</button>
                            <button type="button" class="font-btn" data-size="lg" title="ขนาดใหญ่">A+</button>
                        </div>
                    </div>

                    <!-- Quick Share -->
                    <div class="news-share-group">
                        <span class="text-muted small me-1"><i class="bi bi-share me-1"></i> แชร์:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                           target="_blank" rel="noopener noreferrer" 
                           class="news-share-btn share-fb" title="แชร์ไปยัง Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://social-plugins.line.me/lineit/share?url=<?= urlencode(current_url()) ?>" 
                           target="_blank" rel="noopener noreferrer" 
                           class="news-share-btn share-line" title="แชร์ไปยัง LINE">
                            <i class="bi bi-line"></i>
                        </a>
                        <button type="button" class="news-share-btn share-copy" id="btnCopyLink" title="คัดลอกลิงก์ข่าว">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <?php if (!empty($news->news_img)): ?>
                    <div class="news-feature-img-wrapper">
                        <img class="news-feature-img" 
                             src="<?= base_url('uploads/news/'.$news->news_img) ?>" 
                             onerror="this.onerror=null;this.src='https://placehold.co/1200x630?text=SKJ+NEWS'; this.classList.add('d-none');" 
                             alt="<?= esc($news->news_topic) ?>">
                    </div>
                <?php endif; ?>

                <!-- Article Body Content -->
                <div class="news-content-wrapper size-md ql-snow" id="newsContentContainer">
                    <div class="ql-editor p-0">
                        <?php 
                            $content = $news->news_content;

                            // 1. Remove all redundant empty paragraphs (<p><br></p> or <p>&nbsp;</p>)
                            $content = preg_replace('/<p[^>]*>(\s*<br\s*\/?>|\s*&nbsp;|\s*)*<\/p>/i', '', $content);

                            // 2. Format tab indentation, spaces, and update old contact phone number
                            $content = str_replace(['0-5600-9667', '056-009667', '056-009-667'], '056-200-765', $content);
                            $content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
                            $content = str_replace("  ", "&nbsp;&nbsp;", $content);

                            // 3. Highlight telephone numbers with clickable tel: links
                            $content = preg_replace_callback('/(?:โทร\.?\s*|Tel\.?\s*)?((?:0\d{1,2}[- ]?\d{3,4}[- ]?\d{3,4}|0[- ]?\d{4}[- ]?\d{4}))/u', function($matches) {
                                $cleanNumber = preg_replace('/[^\d]/', '', $matches[1]);
                                if (strlen($cleanNumber) >= 9) {
                                    return '<a href="tel:'.$cleanNumber.'" class="news-tel-badge" title="แตะเพื่อโทรออก"><i class="bi bi-telephone-fill"></i> '.$matches[1].'</a>';
                                }
                                return $matches[0];
                            }, $content);

                            // 4. Auto-convert plain text URLs and emails into clickable links (without touching existing HTML tags)
                            $parts = preg_split('/(<[^>]+>)/u', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
                            $insideLink = false;
                            $parsedContent = '';

                            foreach ($parts as $part) {
                                if ($part === '') continue;

                                if ($part[0] === '<') {
                                    if (preg_match('/^<a\b/i', $part)) {
                                        $insideLink = true;
                                    } elseif (preg_match('/^<\/a>/i', $part)) {
                                        $insideLink = false;
                                    }
                                    $parsedContent .= $part;
                                } else {
                                    if (!$insideLink) {
                                        // 4.1 Convert URLs (http://, https://, or www.)
                                        $part = preg_replace_callback(
                                            '/(https?:\/\/[^\s<>&"\'\(\)\[\]]+|\bwww\.[a-zA-Z0-9\-]+(?:\.[a-zA-Z0-9\-]+)+(?:\/[^\s<>&"\'\(\)\[\]]*)?)/iu',
                                            function ($matches) {
                                                $url = $matches[1];
                                                $trailing = '';
                                                if (preg_match('/([.,;:!?)]+)$/', $url, $punct)) {
                                                    $trailing = $punct[1];
                                                    $url = substr($url, 0, -strlen($trailing));
                                                }
                                                $href = preg_match('/^https?:\/\//i', $url) ? $url : 'https://' . $url;
                                                return '<a href="' . esc($href) . '" target="_blank" rel="noopener noreferrer" class="news-content-link"><i class="bi bi-box-arrow-up-right me-1 small"></i>' . esc($url) . '</a>' . $trailing;
                                            },
                                            $part
                                        );

                                        // 4.2 Convert email addresses
                                        $part = preg_replace_callback(
                                            '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/u',
                                            function ($matches) {
                                                $email = $matches[1];
                                                return '<a href="mailto:' . esc($email) . '" class="news-content-link"><i class="bi bi-envelope me-1 small"></i>' . esc($email) . '</a>';
                                            },
                                            $part
                                        );
                                    }
                                    $parsedContent .= $part;
                                }
                            }
                            $content = $parsedContent;

                            // 5. Style hashtags (#...) into modern interactive search pills
                            $content = preg_replace_callback('/#([^\s<>&"\'\(\)\[\],.:;]+)/u', function($matches) {
                                $tag = $matches[1];
                                $searchUrl = base_url('News?search=' . urlencode($tag));
                                return '<a href="' . $searchUrl . '" class="news-hashtag" title="ค้นหาข่าว: #' . esc($tag) . '"><i class="bi bi-hash"></i>' . esc($tag) . '</a>';
                            }, $content);

                            echo $content;
                        ?>
                    </div>
                </div>

                <!-- Facebook Post Reference Card (if available) -->
                <?php 
                    $fbUrl = '';
                    if (!empty($news->news_facebook)) {
                        if (strpos($news->news_facebook, 'http') === 0) {
                            $fbUrl = $news->news_facebook;
                        } elseif (strpos($news->news_facebook, '_') !== false) {
                            $parts = explode('_', $news->news_facebook);
                            $fbUrl = 'https://www.facebook.com/' . $parts[0] . '/posts/' . $parts[1];
                        } else {
                            $fbUrl = 'https://www.facebook.com/' . $news->news_facebook;
                        }
                    }
                ?>
                <?php if ($fbUrl): ?>
                    <div class="news-fb-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" 
                                 style="width: 42px; height: 42px; background-color: #1877f2;">
                                <i class="bi bi-facebook fs-5"></i>
                            </div>
                            <div>
                                <strong class="d-block text-dark small">โพสต์ต้นฉบับบน Facebook</strong>
                                <span class="text-muted" style="font-size: 0.8rem;">ติดตามรูปภาพเพิ่มเติมและความเคลื่อนไหวทางเพจทางการ</span>
                            </div>
                        </div>
                        <a href="<?= esc($fbUrl) ?>" target="_blank" rel="noopener noreferrer" 
                           class="btn btn-sm btn-primary rounded-pill px-3 py-2 text-nowrap" style="background-color: #1877f2; border-color: #1877f2;">
                            <i class="bi bi-box-arrow-up-right me-1"></i> ดูบน Facebook
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Source & Contact Card -->
                <div class="news-source-box">
                    <div class="school-brand">
                        <img src="<?= base_url('uploads/logoSchool/LogoSKJ_4.png') ?>" alt="SKJ Logo" class="school-logo-mini">
                        <div>
                            <h6>โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</h6>
                            <small class="text-muted">งานประชาสัมพันธ์ กลุ่มบริหารงานทั่วไป</small>
                        </div>
                    </div>
                    <div class="text-muted small">
                        <i class="bi bi-telephone me-1 text-primary"></i> ติดต่อสอบถามเพิ่มเติม: <a href="tel:056200765" class="fw-bold text-decoration-none text-primary">056-200-765</a>
                    </div>
                </div>

                <!-- News Album (If any) -->
                <?php if (!empty($NewsAlbum)): ?>
                    <div class="album-section-header">
                        <h4 class="album-title">
                            <i class="bi bi-images text-primary"></i> อัลบั้มรูปภาพ
                        </h4>
                        <span class="album-badge"><?= count($NewsAlbum) ?> รูปภาพ</span>
                    </div>
                    <div class="row g-2 g-md-3">
                        <?php foreach ($NewsAlbum as $img): ?>
                            <div class="col-6 col-md-4">
                                <a href="<?= base_url('uploads/news/album/'.$img['news_img_name']) ?>" 
                                   data-lightbox="news-album" 
                                   data-title="<?= esc($news->news_topic) ?>"
                                   class="text-decoration-none">
                                    <div class="album-item">
                                        <img src="<?= base_url('uploads/news/album/'.$img['news_img_name']) ?>" 
                                             loading="lazy"
                                             alt="<?= esc($news->news_topic) ?>">
                                        <div class="album-overlay">
                                            <i class="bi bi-arrows-fullscreen"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Bottom Navigation Buttons -->
                <div class="news-bottom-actions">
                    <a href="<?= base_url('News') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                        <i class="bi bi-arrow-left me-1"></i> ย้อนกลับไปหน้าข่าวประชาสัมพันธ์
                    </a>
                    <button type="button" class="btn btn-primary rounded-pill px-4 py-2" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
                        <i class="bi bi-arrow-up me-1"></i> เลื่อนขึ้นบนสุด
                    </button>
                </div>

            </article>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <div class="sidebar-sticky-wrap">
                <!-- Search Widget -->
                <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.25s">
                    <h5 class="sidebar-title">ค้นหาข่าวสาร</h5>
                    <form method="get" action="<?= base_url('News') ?>" id="sidebarSearchForm" autocomplete="off">
                        <div class="d-flex position-relative">
                            <input type="text" class="form-control glass-search-sidebar" id="sidebarSearchInput" name="search" placeholder="พิมพ์คำค้นหาข่าว...">
                            <button type="submit" class="sidebar-search-btn" title="ค้นหา"><i class="bi bi-search"></i></button>
                            <div id="sidebar-suggestions-list" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000;"></div>
                        </div>
                    </form>
                </div>

                <!-- Recent News Widget -->
                <div class="sidebar-widget wow fadeInUp" data-wow-delay="0.35s">
                    <h5 class="sidebar-title">ข่าวประชาสัมพันธ์ล่าสุด</h5>
                    <div class="recent-news-list">
                        <?php foreach ($NewsLatest as $v_NewsLatest):?>
                            <div class="recent-news-item">
                                <img class="recent-news-img" 
                                     src="<?= base_url('uploads/news/'.$v_NewsLatest->news_img) ?>" 
                                     onerror="this.onerror=null;this.src='https://placehold.co/150x150?text=SKJ';"
                                     alt="<?= esc($v_NewsLatest->news_topic) ?>">
                                <div class="recent-news-info">
                                    <a href="<?= base_url('News/Detail/'.$v_NewsLatest->news_id);?>" 
                                       class="CountReadNews" 
                                       data_view="<?=$v_NewsLatest->news_view?>" 
                                       news_id="<?=$v_NewsLatest->news_id?>">
                                        <h6><?= mb_strimwidth(esc($v_NewsLatest->news_topic), 0, 75, "..."); ?></h6>
                                    </a>
                                    <div class="text-muted small d-flex align-items-center gap-2">
                                        <span><i class="bi bi-calendar3 me-1"></i> <?= $dateThai->thai_date_fullmonth(strtotime($v_NewsLatest->news_date)) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?= base_url('News') ?>" class="btn btn-outline-primary w-100 mt-3 py-2 rounded-pill font-weight-bold">
                        ดูข่าวทั้งหมด <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast for Copy Link -->
<div id="newsCopyToast">
    <i class="bi bi-check-circle-fill text-success fs-5"></i>
    <span>คัดลอกลิงก์เรียบร้อยแล้ว</span>
</div>

<!-- News Detail Interactive Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Font Size Adjuster Logic
    const contentContainer = document.getElementById('newsContentContainer');
    const fontButtons = document.querySelectorAll('.font-btn');

    // Retrieve user font size preference if saved
    const savedSize = localStorage.getItem('skj_news_font_size') || 'md';
    applyFontSize(savedSize);

    fontButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const size = this.getAttribute('data-size');
            applyFontSize(size);
            localStorage.setItem('skj_news_font_size', size);
        });
    });

    function applyFontSize(size) {
        if (!contentContainer) return;
        contentContainer.classList.remove('size-sm', 'size-md', 'size-lg');
        contentContainer.classList.add('size-' + size);

        fontButtons.forEach(b => {
            if (b.getAttribute('data-size') === size) {
                b.classList.add('active');
            } else {
                b.classList.remove('active');
            }
        });
    }

    // 2. Copy Link with Toast Feedback
    const btnCopyLink = document.getElementById('btnCopyLink');
    const toast = document.getElementById('newsCopyToast');

    if (btnCopyLink) {
        btnCopyLink.addEventListener('click', function () {
            const pageUrl = window.location.href;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(pageUrl).then(showCopyToast).catch(fallbackCopy);
            } else {
                fallbackCopy();
            }
        });
    }

    function fallbackCopy() {
        const dummy = document.createElement('input');
        document.body.appendChild(dummy);
        dummy.value = window.location.href;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        showCopyToast();
    }

    function showCopyToast() {
        if (!toast) return;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2600);
    }
});
</script>

