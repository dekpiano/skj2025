<?= $this->extend('Admin/layout/AdminLayout') ?>

<?= $this->section('content') ?>

<!-- Include Styles directly inside content to guarantee 100% rendering -->
<style>
    /* ==========================================================
       SKJ LIVE CHAT DASHBOARD - MODERN ULTRA PRO UI (FOR skj2025)
       ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

    :root {
        --skj-pink: #ff6b8b;
        --skj-pink-dark: #e04869;
        --skj-pink-light: #fff0f3;
        --skj-blue: #56ccf2;
        --skj-blue-dark: #2f80ed;
        --chat-pink-gradient: linear-gradient(135deg, #ff6b8b 0%, #e04869 100%);
        --chat-blue-gradient: linear-gradient(135deg, #56ccf2 0%, #2f80ed 100%);
        --chat-card-shadow: 0 12px 35px -5px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
        --chat-border: #e2e8f0;
        --chat-bg-sidebar: #ffffff;
        --chat-bg-canvas: #f8fafc;
    }

    .chat-layout-card {
        height: calc(100vh - 125px);
        min-height: 600px;
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid var(--chat-border);
        box-shadow: var(--chat-card-shadow);
        display: flex;
        overflow: hidden;
        position: relative;
        margin-top: 6px;
        font-family: 'Prompt', 'Sarabun', sans-serif;
    }

    /* Left Sidebar */
    .chat-sidebar {
        width: 380px;
        border-right: 1px solid var(--chat-border);
        display: flex;
        flex-direction: column;
        background: var(--chat-bg-sidebar);
        flex-shrink: 0;
        z-index: 10;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-header {
        padding: 16px 18px;
        background: #ffffff;
        border-bottom: 1px solid var(--chat-border);
    }

    .chat-brand-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: var(--chat-pink-gradient);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 4px 10px rgba(255, 107, 139, 0.35);
        color: #ffffff;
    }

    .search-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
        margin-top: 12px;
    }

    .search-input-wrap .search-icon {
        position: absolute;
        left: 12px;
        color: #94a3b8;
        font-size: 1.15rem;
        pointer-events: none;
    }

    .search-input-wrap input {
        width: 100%;
        padding: 9px 12px 9px 38px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.86rem;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }

    .search-input-wrap input:focus {
        background: #ffffff;
        border-color: var(--skj-pink);
        box-shadow: 0 0 0 3px rgba(255, 107, 139, 0.15);
    }

    .chat-filter-tabs {
        display: flex;
        gap: 5px;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 14px;
        margin-top: 12px;
    }

    .chat-filter-btn {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 0.76rem;
        font-weight: 600;
        padding: 7px 4px;
        border-radius: 10px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        white-space: nowrap;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .chat-filter-btn .badge-count {
        background: rgba(100, 116, 139, 0.12);
        padding: 1px 7px;
        border-radius: 12px;
        font-size: 0.7rem;
    }

    .chat-filter-btn.active {
        background: #ffffff;
        color: #0f172a;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
    }

    .chat-filter-btn.active .badge-count {
        background: rgba(255, 107, 139, 0.15);
        color: var(--skj-pink-dark);
    }

    .chat-list-scroll {
        flex: 1;
        overflow-y: auto;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: #f8fafc;
    }

    .session-card {
        padding: 12px 14px;
        border-radius: 16px;
        background: #ffffff;
        border: 1.5px solid #edf2f7;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .session-card:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
    }

    .session-card.active {
        background: #fff8f9;
        border-color: #fecdd3;
        box-shadow: 0 6px 18px rgba(255, 107, 139, 0.15);
    }
    
    .session-card.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 12%;
        bottom: 12%;
        width: 4px;
        background: var(--skj-pink);
        border-radius: 0 4px 4px 0;
    }

    .session-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.05rem;
        color: #ffffff;
        flex-shrink: 0;
        position: relative;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        border: 2px solid #ffffff;
    }

    .online-pulse {
        position: absolute;
        bottom: 0px;
        right: 0px;
        width: 12px;
        height: 12px;
        background-color: #22c55e;
        border: 2px solid #ffffff;
        border-radius: 50%;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
    }

    .session-name {
        font-size: 0.92rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
    }

    .session-snippet {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.4;
    }

    .session-card.active .session-name {
        color: var(--skj-pink-dark);
    }

    .unread-pill-badge {
        background: linear-gradient(135deg, #ff6b8b, #e04869);
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 20px;
        box-shadow: 0 3px 8px rgba(255, 107, 139, 0.4);
    }

    /* Right Canvas */
    .chat-canvas {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #ffffff;
        position: relative;
        min-width: 0;
    }

    .room-header {
        padding: 14px 20px;
        background: #ffffff;
        border-bottom: 1px solid var(--chat-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 5;
        gap: 12px;
    }

    .room-header-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .room-messages-container {
        flex: 1;
        overflow-y: auto;
        padding: 20px 24px;
        background-color: #f8fafc;
        background-image: radial-gradient(#e2e8f0 1.2px, transparent 1.2px);
        background-size: 20px 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .msg-group {
        display: flex;
        flex-direction: column;
        max-width: 75%;
        position: relative;
    }

    .msg-group.user { align-self: flex-start; }
    .msg-group.admin { align-self: flex-end; }
    .msg-group.system { align-self: center; max-width: 90%; text-align: center; }

    .msg-bubble {
        padding: 11px 16px;
        border-radius: 20px;
        font-size: 0.92rem;
        line-height: 1.55;
        word-break: break-word;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .msg-group.user .msg-bubble {
        background: #ffffff;
        border: 1.5px solid #edf2f7;
        color: #0f172a;
        border-bottom-left-radius: 4px;
    }

    .msg-group.admin .msg-bubble {
        background: var(--chat-pink-gradient);
        color: #ffffff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 15px rgba(255, 107, 139, 0.28);
    }

    .msg-group.system .msg-bubble {
        background: #ffffff;
        color: #1e293b;
        border: 1.5px solid #fed7aa;
        border-left: 4px solid #f97316;
        border-radius: 16px;
        font-size: 0.84rem;
        padding: 10px 16px;
        text-align: left;
        box-shadow: 0 3px 12px rgba(249, 115, 22, 0.08);
    }

    /* Links inside chat bubbles */
    .msg-bubble a {
        word-break: break-all;
        text-decoration: underline;
        transition: opacity 0.2s ease;
    }
    .msg-group.user .msg-bubble a {
        color: #2563eb;
        font-weight: 600;
    }
    .msg-group.user .msg-bubble a:hover {
        color: #1d4ed8;
    }
    .msg-group.admin .msg-bubble a {
        color: #ffffff;
        font-weight: 600;
        text-decoration-color: rgba(255, 255, 255, 0.85);
    }
    .msg-group.admin .msg-bubble a:hover {
        opacity: 0.9;
    }
    .msg-group.system .msg-bubble a {
        color: #ea580c;
        font-weight: 600;
    }
    .msg-group.system .msg-bubble a:hover {
        color: #c2410c;
    }

    .admin-chat-img-thumb {
        max-width: 260px;
        max-height: 200px;
        border-radius: 14px;
        cursor: pointer;
        transition: transform 0.2s ease;
        margin-top: 6px;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .admin-chat-img-thumb:hover { transform: scale(1.02); }

    .msg-meta-row {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.72rem;
        color: #94a3b8;
        margin-top: 4px;
    }
    .msg-group.admin .msg-meta-row { justify-content: flex-end; }

    .room-footer {
        padding: 12px 18px;
        background: #ffffff;
        border-top: 1px solid var(--chat-border);
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quick-pill-container {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        padding-bottom: 2px;
        scrollbar-width: none;
    }
    .quick-pill-container::-webkit-scrollbar { display: none; }

    .quick-pill {
        font-size: 0.76rem;
        font-weight: 600;
        white-space: nowrap;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 5px 12px;
        cursor: pointer;
        color: #334155;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        flex-shrink: 0;
    }
    .quick-pill:hover {
        background: #fff0f3;
        border-color: #ff8ea7;
        color: var(--skj-pink-dark);
        transform: translateY(-1px);
    }

    /* Attachment Preview in Admin Footer */
    .admin-attach-preview-bar {
        display: none;
        align-items: center;
        justify-content: space-between;
        background: #f1f5f9;
        padding: 8px 14px;
        border-radius: 14px;
        font-size: 0.8rem;
    }

    .input-capsule {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 30px;
        padding: 4px 6px 4px 14px;
        transition: all 0.2s ease;
        gap: 8px;
    }
    .input-capsule:focus-within {
        background: #ffffff;
        border-color: var(--skj-pink);
        box-shadow: 0 0 0 3px rgba(255, 107, 139, 0.18);
    }

    .input-capsule input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 0.92rem;
        color: #0f172a;
        outline: none;
        padding: 6px 0;
        min-width: 0;
    }

    .btn-send-gradient {
        background: var(--chat-pink-gradient);
        color: #ffffff;
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 700;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255, 107, 139, 0.35);
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .btn-send-gradient:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(255, 107, 139, 0.45);
    }

    .btn-chat-back {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--chat-border);
        background: #f8fafc;
        color: #334155;
        cursor: pointer;
        padding: 0;
        flex-shrink: 0;
    }

    .empty-chat-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #64748b;
        padding: 30px 20px;
        text-align: center;
    }

    .empty-chat-icon {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(255, 107, 139, 0.15), rgba(86, 204, 242, 0.15));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--skj-pink);
        margin-bottom: 16px;
        box-shadow: 0 8px 20px rgba(255, 107, 139, 0.15);
    }

    /* Admin Lightbox */
    .admin-chat-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.85);
        z-index: 3000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        backdrop-filter: blur(5px);
    }
    .admin-chat-lightbox img {
        max-width: 90vw;
        max-height: 85vh;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    .admin-chat-lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #ffffff;
        font-size: 36px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .admin-chat-lightbox-close:hover { transform: scale(1.1); }

    @media (max-width: 767.98px) {
        .chat-layout-card {
            height: calc(100dvh - 100px);
            min-height: calc(100vh - 100px);
            border-radius: 16px;
            margin-top: 0;
        }
        .chat-sidebar { width: 100%; border-right: none; }
        .chat-canvas { display: none; width: 100%; }
        .chat-layout-card.chat-room-active .chat-sidebar { display: none !important; }
        .chat-layout-card.chat-room-active .chat-canvas { display: flex !important; }
        .btn-chat-back { display: inline-flex; }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y px-2 px-sm-3 pt-1">

    <!-- Main Chat Frame Card -->
    <div class="chat-layout-card" id="chatLayoutCard">
        
        <!-- ==================== LEFT SIDEBAR ==================== -->
        <div class="chat-sidebar">
            <div class="sidebar-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="chat-brand-icon">
                            <i class="bx bxs-chat"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 1.0rem; line-height: 1.2;">Live Chat (SKJ Main)</h6>
                            <small class="text-muted" style="font-size: 0.74rem;" id="statSummaryText">กำลังโหลด...</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-circle p-0 position-relative" onclick="openAiModal()" title="ตั้งค่า AI Smart Chatbot (Google Gemini ฟรี)" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bx bx-bot fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle" id="aiStatusDot" title="สถานะ AI" style="width: 10px; height: 10px;"></span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info rounded-circle p-0" onclick="openTelegramModal()" title="ตั้งค่า Telegram Bot แจ้งเตือน" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bx bxl-telegram fs-5"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-0" id="btnToggleAdminSound" onclick="toggleAdminSound()" title="เปิด/ปิดเสียงแจ้งเตือน" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bx bx-volume-full fs-5" id="adminSoundIcon"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-0" onclick="loadSessions(true)" title="รีเฟรชข้อความ" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bx bx-refresh fs-5"></i>
                        </button>
                    </div>
                </div>

                <div class="search-input-wrap">
                    <i class="bx bx-search search-icon"></i>
                    <input type="text" id="searchChatInput" placeholder="ค้นหาชื่อ, เบอร์โทร, ข้อความ..." onkeyup="filterSessions()">
                </div>

                <div class="chat-filter-tabs">
                    <button class="chat-filter-btn active" onclick="setChatFilter('all', this)">
                        ทั้งหมด <span class="badge-count" id="filterCountAll">0</span>
                    </button>
                    <button class="chat-filter-btn" onclick="setChatFilter('unread', this)">
                        🔔 รอตอบ <span class="badge-count text-danger fw-bold" id="filterCountUnread" style="display: none;">0</span>
                    </button>
                    <button class="chat-filter-btn" onclick="setChatFilter('active', this)">
                        🟢 คุยอยู่ <span class="badge-count" id="filterCountActive">0</span>
                    </button>
                    <button class="chat-filter-btn" onclick="setChatFilter('closed', this)">
                        📁 ปิดแล้ว
                    </button>
                </div>
            </div>

            <div class="chat-list-scroll" id="chatListContainer">
                <div class="text-center p-4 text-muted">
                    <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                    <div class="small">กำลังโหลดห้องสนทนา...</div>
                </div>
            </div>
        </div>

        <!-- ==================== RIGHT CANVAS (CHAT ROOM) ==================== -->
        <div class="chat-canvas" id="chatMainArea">
            
            <div class="empty-chat-placeholder" id="emptyStateBox">
                <div class="empty-chat-icon">
                    <i class="bx bx-chat"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">เลือกห้องสนทนาเพื่อเริ่มบริการ</h5>
                <p class="text-muted small mb-0" style="max-width: 380px; line-height: 1.6;">
                    คลิกเลือกผู้ติดต่อจากรายการด้านซ้ายเพื่อดูประวัติการสนทนา หรือพิมพ์ตอบคำถามนักเรียนและผู้ปกครอง
                </p>
            </div>

            <div id="activeRoomContent" style="display: none; height: 100%; flex-direction: column; width: 100%;">
                
                <div class="room-header">
                    <div class="room-header-profile">
                        <button type="button" class="btn-chat-back" onclick="backToSessionList()" title="ย้อนกลับรายการ">
                            <i class="bx bx-chevron-left fs-3"></i>
                        </button>

                        <div class="session-avatar" id="currentAvatar" style="background: var(--chat-pink-gradient);">
                            U
                        </div>
                        <div class="overflow-hidden">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h6 class="mb-0 fw-bold text-dark text-truncate" id="currentUserName" style="font-size: 1.0rem;">ผู้ติดต่อ</h6>
                                <span class="badge bg-label-success rounded-pill px-2 py-0 small font-monospace flex-shrink-0" id="currentStatusBadge">Active</span>
                                <span class="badge bg-label-info rounded-pill px-2 py-0 small flex-shrink-0" id="sessionBotBadge" style="cursor: pointer;" onclick="toggleSessionBotForCurrent()" title="คลิกเพื่อ สลับเปิด/พักการตอบของ AI ในห้องนี้">
                                    <i class="bx bx-user-check me-1"></i> เจ้าหน้าที่กำลังดูห้องนี้ (AI หยุดตอบชั่วคราว)
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <small class="text-muted text-truncate" id="currentUserTel">
                                    <i class="bx bx-phone text-primary me-1"></i> -
                                </small>
                                <span class="text-muted opacity-50 d-none d-sm-inline">|</span>
                                <small class="text-muted text-truncate" id="currentSessionTime">
                                    <i class="bx bx-time-five text-secondary me-1"></i> เริ่ม: -
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-1 room-header-actions flex-shrink-0">
                        <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-2 px-sm-3" id="btnToggleSessionBot" onclick="toggleSessionBotForCurrent()" title="สลับเปิด/พักการทำงานของ AI ในห้องนี้">
                            <i class="bx bx-pause-circle me-1"></i> <span class="d-none d-sm-inline" id="btnToggleSessionBotText">พัก AI</span>
                        </button>
                        <a href="javascript:void(0);" class="btn btn-outline-success btn-sm rounded-pill px-2 px-sm-3" id="btnCallUser" target="_blank" style="display: none;">
                            <i class="bx bx-phone me-1"></i> <span class="d-none d-sm-inline">โทรหา</span>
                        </a>
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-2 px-sm-3" id="btnToggleStatus" onclick="toggleCurrentSessionStatus()">
                            <i class="bx bx-check-circle me-1"></i> <span class="d-none d-sm-inline">จบการสนทนา</span>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle p-0" onclick="confirmDeleteCurrentSession()" title="ลบห้องสนทนานี้" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bx bx-trash fs-6"></i>
                        </button>
                    </div>
                </div>

                <div class="room-messages-container" id="chatMessagesBox"></div>

                <div class="room-footer">
                    <!-- Categorized Canned Quick Replies -->
                    <div class="quick-pill-container">
                        <span class="quick-pill" onclick="insertQuickReply('สวัสดีครับ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ยินดีต้อนรับครับ มีข้อสงสัยสอบถามได้เลยครับ ✨')">👋 ทักทาย</span>
                        <span class="quick-pill" onclick="insertQuickReply('สามารถดูข้อมูลระเบียบการรับสมัครนักเรียน ม.1 และ ม.4 ได้ทางเว็บไซต์โรงเรียน หรือติดต่อห้องอำนวยการครับ 📋')">📝 รับสมัคร</span>
                        <span class="quick-pill" onclick="insertQuickReply('สามารถติดต่อสอบถามเพิ่มเติมได้ที่เบอร์โทรศัพท์ 056-009-667 ในวันและเวลาราชการ (จันทร์-ศุกร์ 08:00 - 16:30 น.) ครับ 📞')">📞 ติดต่อ</span>
                        <span class="quick-pill" onclick="insertQuickReply('หากโอนชำระเงินค่าบำรุงการศึกษาแล้ว สามารถแนบรูปสลิปหลักฐานในช่องแชทนี้ได้เลยครับ 💳')">💳 แจ้งสลิป</span>
                        <span class="quick-pill" onclick="insertQuickReply('ยินดีให้บริการครับ หากมีข้อสงสัยเพิ่มเติมสอบถามได้ตลอดเวลานะครับ ขอบคุณครับ 🙏🌸')">🙏 ขอบคุณ</span>
                    </div>

                    <!-- Admin Attachment Preview Bar -->
                    <div class="admin-attach-preview-bar" id="adminAttachPreviewBar">
                        <div class="d-flex align-items-center gap-2 overflow-hidden">
                            <i class="bx bx-image text-primary fs-5"></i>
                            <span class="text-truncate" id="adminAttachFileName">รูปภาพที่เลือก</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="clearAdminAttachment()">
                            <i class="bx bx-x fs-5"></i>
                        </button>
                    </div>

                    <form id="adminReplyForm" onsubmit="sendAdminReply(event)">
                        <input type="file" id="adminFileInput" accept="image/*,.pdf" style="display: none;" onchange="handleAdminFileSelect(event)">
                        <div class="input-capsule">
                            <button type="button" class="btn btn-sm btn-link text-secondary p-0" onclick="document.getElementById('adminFileInput').click()" title="แนบรูปภาพส่งให้ผู้ติดต่อ">
                                <i class="bx bx-image-add fs-4"></i>
                            </button>
                            <input type="text" id="adminReplyInput" placeholder="พิมพ์ข้อความตอบกลับที่นี่..." autocomplete="off">
                            <button class="btn-send-gradient" type="submit" id="btnAdminSend">
                                <span>ส่ง</span>
                                <i class="bx bx-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- Telegram Settings Modal -->
<div class="modal fade" id="telegramSettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom px-4 py-3" style="background: linear-gradient(135deg, #229ED9 0%, #0088cc 100%); color: #ffffff;">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bxl-telegram fs-3"></i>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0" style="font-size: 1.1rem;">ตั้งค่าการแจ้งเตือน Telegram</h5>
                        <small class="text-white opacity-75" style="font-size: 0.75rem;">รับข้อความแจ้งเตือนทันทีเมื่อมีคนทักแชทเข้ามา</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="telegramConfigForm" onsubmit="saveTelegramSettings(event)">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.88rem;">Telegram Bot Token <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bx bx-key"></i></span>
                            <input type="text" class="form-control" id="tgBotToken" placeholder="เช่น 7123456789:AAHk..." autocomplete="off">
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.74rem;">
                            สร้างบอทได้ที่ <a href="https://t.me/BotFather" target="_blank" class="fw-bold text-primary">@BotFather</a> แล้วคัดลอก HTTP API Token มาวาง
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.88rem;">Telegram Chat ID / Group ID <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bx bx-group"></i></span>
                            <input type="text" class="form-control" id="tgChatId" placeholder="เช่น -1001234567890 หรือ 123456789" autocomplete="off">
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.74rem;">
                            ดึง Chat ID ได้จากบอท <a href="https://t.me/userinfobot" target="_blank" class="text-primary">@userinfobot</a> หรือ <a href="https://t.me/RawDataBot" target="_blank" class="text-primary">@RawDataBot</a> (อย่าลืมดึงบอทเข้ากลุ่มก่อน)
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.88rem;">ชื่อกลุ่ม / หมายเหตุ</label>
                        <input type="text" class="form-control" id="tgChatTitle" placeholder="เช่น กลุ่มงานสารสนเทศ SKJ">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="tgStatus" checked>
                        <label class="form-check-label fw-bold" for="tgStatus">เปิดใช้งานการแจ้งเตือน Telegram (ON/OFF)</label>
                    </div>

                    <div id="tgAlertBox" style="display: none;" class="alert alert-sm mb-3"></div>

                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                        <button type="button" class="btn btn-outline-info rounded-pill px-3" id="btnTestTelegram" onclick="testTelegramNotification()">
                            <i class="bx bx-send me-1"></i> ทดสอบส่งข้อความ
                        </button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSaveTelegram">
                                <i class="bx bx-save me-1"></i> บันทึก
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- AI Smart Chatbot Settings Modal (Google Gemini Free) -->
<div class="modal fade" id="aiSettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom px-4 py-3" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%); color: #ffffff;">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-white text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bx bx-bot fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0" style="font-size: 1.15rem;">ตั้งค่า AI Smart Chatbot (Google Gemini - ฟรี 100%)</h5>
                        <small class="text-white opacity-75" style="font-size: 0.78rem;">ระบบตอบกลับอัตโนมัติอัจฉริยะสำหรับงานประชาสัมพันธ์และแชทสดโรงเรียน</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background: #f8fafc;">
                <!-- Free API Key Guide Banner -->
                <div class="card border-0 shadow-sm rounded-4 mb-3 p-3" style="background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%); border-left: 4px solid #6366f1 !important;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bx bx-bulb text-primary fs-3 mt-1"></i>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.92rem;">วิธีขอรับ Google Gemini API Key ฟรี (ไม่เสียค่าใช้จ่าย & ไม่ต้องผูกบัตร)</h6>
                            <p class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.4;">
                                1. เข้าไปที่ <a href="https://aistudio.google.com/" target="_blank" class="fw-bold text-primary text-decoration-underline">Google AI Studio <i class="bx bx-link-external"></i></a> แล้วล็อกอินด้วยบัญชี Gmail ใดก็ได้<br>
                                2. กดปุ่ม <b>"Get API key"</b> แล้วกด <b>"Create API key"</b><br>
                                3. คัดลอก Key มาวางในช่องด้านล่าง แล้วกดสวิตช์เปิดใช้งานได้ทันที (ฟรีวันละ 1,500 ข้อความ)
                            </p>
                            <a href="https://aistudio.google.com/" target="_blank" class="btn btn-sm btn-primary rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                                <i class="bx bx-key me-1"></i> รับ Gemini API Key ฟรีที่ Google AI Studio
                            </a>
                        </div>
                    </div>
                </div>

                <form id="aiConfigForm" onsubmit="saveAiSettings(event)">
                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div>
                                <h6 class="fw-bold text-dark mb-0">สถานะการทำงานของ AI</h6>
                                <small class="text-muted" style="font-size: 0.76rem;">หากปิด AI ระบบจะสลับไปใช้ระบบคำตอบด่วน (Smart FAQ) อัตโนมัติ</small>
                            </div>
                            <div class="form-check form-switch fs-4 mb-0">
                                <input class="form-check-input" type="checkbox" id="aiStatus" onchange="updateAiStatusUI()">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label fw-bold text-dark" style="font-size: 0.86rem;">Google Gemini API Key <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bx bx-key text-muted"></i></span>
                                    <input type="password" class="form-control border-start-0 border-end-0" id="aiApiKey" placeholder="AIzaSy..." autocomplete="off">
                                    <button class="btn btn-light border border-start-0" type="button" onclick="toggleApiKeyVisibility()" title="แสดง/ซ่อนคีย์">
                                        <i class="bx bx-show" id="aiKeyEyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-dark" style="font-size: 0.86rem;">โมเดล AI (Model)</label>
                                <select class="form-select" id="aiModel">
                                    <option value="gemini-3.5-flash" selected>gemini-3.5-flash (แนะนำ ฉลาด ตอบเร็ว ฟรี)</option>
                                    <option value="gemini-3.5-flash-lite">gemini-3.5-flash-lite (รุ่นประหยัด ตอบเร็วมาก)</option>
                                    <option value="gemini-flash-latest">gemini-flash-latest (รุ่น Flash ล่าสุดอัตโนมัติ)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.86rem;">
                                ข้อมูลโรงเรียน & บุคลิก AI (System Prompt) <span class="text-danger">*</span>
                            </label>
                            <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none p-0" onclick="resetDefaultAiPrompt()" style="font-size: 0.78rem;">
                                <i class="bx bx-reset me-1"></i> โหลดข้อความแนะนำ
                            </button>
                        </div>
                        <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">
                            ป้อนข้อมูลโรงเรียน ประวัติ หลักสูตร เวลาทำการ เบอร์โทรศัพท์ และกฎการตอบเพื่อให้ AI ตอบได้แม่นยำ
                        </small>
                        <textarea class="form-control" id="aiSystemPrompt" rows="8" style="font-size: 0.84rem; line-height: 1.5; font-family: 'Prompt', 'Sarabun', sans-serif;" placeholder="กำหนดบริบทและข้อมูลโรงเรียนที่นี่..."></textarea>
                    </div>

                    <!-- Live AI Test Sandbox -->
                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-3" style="background: #ffffff; border: 1.5px dashed #cbd5e1 !important;">
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.88rem;">
                            <i class="bx bx-test-tube text-primary me-1"></i> ทดสอบถาม-ตอบ AI (Live Test Sandbox)
                        </h6>
                        <small class="text-muted mb-2 d-block" style="font-size: 0.76rem;">พิมพ์คำถามทดสอบเพื่อลองดูว่า AI จะตอบกลับผู้ใช้อย่างไร</small>
                        
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="aiTestInput" placeholder="เช่น โรงเรียนเปิดรับสมัคร ม.1 วันไหนบ้าง หรือ มีสายการเรียนอะไรบ้าง" style="font-size: 0.85rem;">
                            <button class="btn btn-primary px-3" type="button" id="btnTestAi" onclick="testAiSandbox()">
                                <i class="bx bx-paper-plane me-1"></i> ทดสอบถาม AI
                            </button>
                        </div>

                        <div id="aiTestResultWrap" style="display: none;" class="p-3 rounded-3 bg-light border">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-bold text-primary small" id="aiTestResultHeader">🤖 คำตอบจาก AI:</span>
                                <span class="badge bg-light text-muted border small" id="aiTestLatency">0 ms</span>
                            </div>
                            <div class="text-dark small" id="aiTestReplyBody" style="white-space: pre-line; line-height: 1.6;"></div>
                        </div>
                    </div>

                    <div id="aiAlertBox" style="display: none;" class="alert alert-sm mb-3"></div>

                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                        <span class="text-muted small" id="aiLastUpdatedInfo" style="font-size: 0.75rem;"></span>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSaveAi">
                                <i class="bx bx-save me-1"></i> บันทึกการตั้งค่า
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let allSessions = [];
    let currentSessionId = null;
    let currentFilter = 'all';
    let pollInterval = null;
    const initialSessionToken = '<?= esc($activeToken ?? '') ?>';
    let initialTokenHandled = false;
    let isAdminSoundMuted = localStorage.getItem('skj_admin_chat_muted') === '1';
    let prevUnreadTotal = 0;
    let currentAdminAttachment = null;

    const avatarGradients = [
        'linear-gradient(135deg, #ff6b8b, #ff8ea7)',
        'linear-gradient(135deg, #56ccf2, #2f80ed)',
        'linear-gradient(135deg, #8b5cf6, #a78bfa)',
        'linear-gradient(135deg, #10b981, #34d399)'
    ];

    // Web Audio Sound FX for Admin
    let adminAudioCtx = null;
    function playAdminChime() {
        if (isAdminSoundMuted) return;
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            if (!adminAudioCtx) adminAudioCtx = new AudioContext();
            if (adminAudioCtx.state === 'suspended') adminAudioCtx.resume();

            const now = adminAudioCtx.currentTime;
            const osc = adminAudioCtx.createOscillator();
            const gain = adminAudioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, now); // D5
            osc.frequency.exponentialRampToValueAtTime(880, now + 0.15); // A5
            gain.gain.setValueAtTime(0.3, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.4);

            osc.connect(gain);
            gain.connect(adminAudioCtx.destination);
            osc.start(now);
            osc.stop(now + 0.4);
        } catch (e) {
            console.log('Audio error', e);
        }
    }

    function updateAdminSoundIcon() {
        const icon = document.getElementById('adminSoundIcon');
        if (icon) {
            icon.className = isAdminSoundMuted ? 'bx bx-volume-mute text-warning fs-5' : 'bx bx-volume-full fs-5';
        }
    }

    function toggleAdminSound() {
        isAdminSoundMuted = !isAdminSoundMuted;
        localStorage.setItem('skj_admin_chat_muted', isAdminSoundMuted ? '1' : '0');
        updateAdminSoundIcon();
        if (!isAdminSoundMuted) playAdminChime();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateAdminSoundIcon();
        checkAiStatusOnLoad();
        loadSessions(false);
        pollInterval = setInterval(function() {
            loadSessions(false, true);
            if (currentSessionId) {
                loadSessionMessages(currentSessionId, true);
            }
        }, 3500);
    });

    let lastSessionsHash = '';
    let lastMessagesHash = '';

    function backToSessionList() {
        const layoutCard = document.getElementById('chatLayoutCard');
        if (layoutCard) layoutCard.classList.remove('chat-room-active');
        currentSessionId = null;
        initialTokenHandled = true;
        document.getElementById('activeRoomContent').style.display = 'none';
        document.getElementById('emptyStateBox').style.display = 'flex';
        filterSessions();
    }

    function updateStatsOverview(sessions) {
        const total = sessions.length;
        const active = sessions.filter(s => s.status === 'active').length;
        const unread = sessions.reduce((acc, s) => acc + (parseInt(s.unread_admin_count) || 0), 0);

        // Sound alert if new unread messages arrive
        if (unread > prevUnreadTotal && prevUnreadTotal > 0) {
            playAdminChime();
        }
        prevUnreadTotal = unread;

        document.getElementById('statSummaryText').innerText = `${total} ห้องสนทนา • กำลังคุย ${active}`;
        document.getElementById('filterCountAll').innerText = total;
        document.getElementById('filterCountActive').innerText = active;

        const unreadBadge = document.getElementById('filterCountUnread');
        if (unread > 0) {
            unreadBadge.innerText = unread;
            unreadBadge.style.display = 'inline-block';
        } else {
            unreadBadge.style.display = 'none';
        }
    }

    function setChatFilter(filterType, btnEl) {
        currentFilter = filterType;
        document.querySelectorAll('.chat-filter-btn').forEach(b => b.classList.remove('active'));
        if (btnEl) btnEl.classList.add('active');
        filterSessions();
    }

    function filterSessions() {
        const q = (document.getElementById('searchChatInput').value || '').toLowerCase().trim();
        let filtered = allSessions;

        if (currentFilter === 'unread') filtered = filtered.filter(s => (parseInt(s.unread_admin_count) || 0) > 0);
        else if (currentFilter === 'active') filtered = filtered.filter(s => s.status === 'active');
        else if (currentFilter === 'closed') filtered = filtered.filter(s => s.status === 'closed');

        if (q) {
            filtered = filtered.filter(s => 
                (s.user_name && s.user_name.toLowerCase().includes(q)) ||
                (s.user_tel && s.user_tel.toLowerCase().includes(q)) ||
                (s.last_message && s.last_message.toLowerCase().includes(q))
            );
        }

        renderSessionsList(filtered);
    }

    function renderSessionsList(sessions) {
        const container = document.getElementById('chatListContainer');
        if (!sessions || sessions.length === 0) {
            container.innerHTML = `
                <div class="text-center p-4 text-muted">
                    <i class="bx bx-conversation fs-2 opacity-50 mb-1"></i>
                    <div class="small fw-bold">ไม่พบห้องสนทนา</div>
                </div>`;
            return;
        }

        let html = '';
        sessions.forEach((s) => {
            const isActive = currentSessionId === s.session_id ? 'active' : '';
            const unreadCount = parseInt(s.unread_admin_count) || 0;
            const unreadBadge = unreadCount > 0 ? `<span class="unread-pill-badge">${unreadCount}</span>` : '';
            const initial = (s.user_name || 'U').charAt(0).toUpperCase();
            const timeStr = formatSessionCardTime(s.last_message_time || s.updated_at);
            const gradient = avatarGradients[s.session_id % avatarGradients.length];
            const isOnline = s.status === 'active';

            let snippet = escapeHtml(s.last_message || '');
            if (s.last_attachment && !snippet) {
                snippet = '📷 [รูปภาพ/ไฟล์แนบ]';
            } else if (!snippet) {
                snippet = 'เริ่มการสนทนา';
            }

            html += `
            <div class="session-card ${isActive}" onclick="selectSession(${s.session_id})">
                <div class="d-flex align-items-center gap-2">
                    <div class="session-avatar" style="background: ${gradient};">
                        ${initial}
                        ${isOnline ? '<span class="online-pulse"></span>' : ''}
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <h6 class="mb-0 session-name text-truncate">${escapeHtml(s.user_name)}</h6>
                            <small class="text-muted" style="font-size: 0.68rem;">${timeStr}</small>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="session-snippet mb-0 text-truncate" style="max-width: 200px;">
                                ${s.last_sender === 'admin' ? '<span class="text-primary fw-bold">คุณ: </span>' : ''}${snippet}
                            </p>
                            ${unreadBadge}
                        </div>
                    </div>
                </div>
            </div>`;
        });

        container.innerHTML = html;
    }

    function selectSession(sessionId) {
        if (currentSessionId !== sessionId) {
            lastMessagesHash = '';
        }
        currentSessionId = sessionId;
        document.getElementById('emptyStateBox').style.display = 'none';
        document.getElementById('activeRoomContent').style.display = 'flex';

        const layoutCard = document.getElementById('chatLayoutCard');
        if (layoutCard) layoutCard.classList.add('chat-room-active');

        filterSessions();
        loadSessionMessages(sessionId, false);
    }

    function loadSessions(showSpinner = false, silent = false) {
        if (showSpinner && !silent) {
            document.getElementById('chatListContainer').innerHTML = `
                <div class="text-center p-4 text-muted">
                    <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                    <div class="small">กำลังโหลดข้อมูล...</div>
                </div>`;
        }

        fetch('<?= site_url('admin/live-chat/sessions') ?>', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const sessions = data.sessions || [];
                const newHash = JSON.stringify(sessions);
                if (newHash !== lastSessionsHash || !silent) {
                    lastSessionsHash = newHash;
                    allSessions = sessions;
                    updateStatsOverview(allSessions);
                    filterSessions();
                }

                if (initialSessionToken && !initialTokenHandled && !currentSessionId) {
                    initialTokenHandled = true;
                    const match = allSessions.find(s => s.session_token === initialSessionToken);
                    if (match) selectSession(match.session_id);
                }
            }
        })
        .catch(err => console.error(err));
    }

    function loadSessionMessages(sessionId, silent = false) {
        fetch(`<?= site_url('admin/live-chat/messages') ?>/${sessionId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const s = data.session;
                const msgs = data.messages || [];
                const newMsgHash = JSON.stringify(msgs) + '_' + s.status;

                // Update room meta only if changed
                document.getElementById('currentUserName').innerText = s.user_name;
                document.getElementById('currentAvatar').innerText = (s.user_name || 'U').charAt(0).toUpperCase();
                
                const telEl = document.getElementById('currentUserTel');
                const callBtn = document.getElementById('btnCallUser');
                if (s.user_tel && s.user_tel !== '-') {
                    telEl.innerHTML = `<i class="bx bx-phone text-primary me-1"></i> <a href="tel:${s.user_tel}" class="text-dark fw-bold">${s.user_tel}</a>`;
                    callBtn.href = `tel:${s.user_tel}`;
                    callBtn.style.display = 'inline-flex';
                } else {
                    telEl.innerHTML = `<i class="bx bx-phone text-muted me-1"></i> ไม่ได้ระบุเบอร์`;
                    callBtn.style.display = 'none';
                }

                const sessionTimeEl = document.getElementById('currentSessionTime');
                if (sessionTimeEl && s.created_at) {
                    sessionTimeEl.innerHTML = `<i class="bx bx-time-five text-secondary me-1"></i> เริ่ม: ${formatShortDateTime(s.created_at)}`;
                }

                const statusBadge = document.getElementById('currentStatusBadge');
                const btnToggle = document.getElementById('btnToggleStatus');
                if (s.status === 'active') {
                    statusBadge.className = 'badge bg-label-success rounded-pill px-2 py-0 small font-monospace';
                    statusBadge.innerText = 'Active';
                    btnToggle.innerHTML = '<i class="bx bx-check-circle me-1"></i> จบการสนทนา';
                } else {
                    statusBadge.className = 'badge bg-label-secondary rounded-pill px-2 py-0 small font-monospace';
                    statusBadge.innerText = 'Closed';
                    btnToggle.innerHTML = '<i class="bx bx-refresh me-1"></i> เปิดการสนทนาใหม่';
                }

                // Update session bot paused / active badge
                const botBadge = document.getElementById('sessionBotBadge');
                const btnToggleBot = document.getElementById('btnToggleSessionBot');
                const btnToggleBotText = document.getElementById('btnToggleSessionBotText');
                if (botBadge && btnToggleBot) {
                    const isPaused = (parseInt(s.is_bot_paused) === 1);
                    if (isPaused) {
                        botBadge.className = 'badge bg-label-secondary rounded-pill px-2 py-0 small flex-shrink-0';
                        botBadge.innerHTML = '<i class="bx bx-pause-circle me-1"></i> AI พักการตอบ (แมนนวล)';
                        btnToggleBot.className = 'btn btn-outline-success btn-sm rounded-pill px-2 px-sm-3';
                        btnToggleBotText.innerText = 'เปิด AI';
                        btnToggleBot.title = 'คลิกเพื่อเปิดให้ AI ช่วยตอบ';
                    } else {
                        // Admin is actively viewing this room, so AI is paused automatically
                        botBadge.className = 'badge bg-label-info rounded-pill px-2 py-0 small flex-shrink-0';
                        botBadge.innerHTML = '<i class="bx bx-user-check me-1"></i> เจ้าหน้าที่กำลังดูห้องนี้ (AI หยุดตอบชั่วคราว)';
                        btnToggleBot.className = 'btn btn-outline-warning btn-sm rounded-pill px-2 px-sm-3';
                        btnToggleBotText.innerText = 'พัก AI';
                        btnToggleBot.title = 'คลิกเพื่อพักการตอบของ AI ในห้องนี้';
                    }
                }

                if (newMsgHash !== lastMessagesHash || !silent) {
                    lastMessagesHash = newMsgHash;
                    renderMessagesStream(msgs, silent);
                }
            }
        })
        .catch(err => console.error(err));
    }

    function renderMessagesStream(messages, silent = false) {
        const box = document.getElementById('chatMessagesBox');
        let html = '';

        messages.forEach(m => {
            const isUser = m.sender_type === 'user';
            const isAdmin = m.sender_type === 'admin';
            const isSystem = m.sender_type === 'system';

            let typeClass = isUser ? 'user' : (isAdmin ? 'admin' : 'system');
            const senderLabel = isAdmin ? (m.sender_name || 'Admin ระบบ') : (isUser ? (m.sender_name || 'ผู้ติดต่อ') : (m.sender_name || 'ระบบอัตโนมัติ'));
            const timeStr = formatTime(m.created_at);

            let bubbleContent = '';
            if (m.message) {
                bubbleContent += `<div>${formatChatMessage(m.message, isAdmin)}</div>`;
            }

            if (m.attachment_url) {
                const fullUrl = '<?= base_url() ?>/' + m.attachment_url;
                if (m.attachment_type === 'image' || m.attachment_url.match(/\.(jpeg|jpg|png|gif|webp)$/i)) {
                    bubbleContent += `<img src="${fullUrl}" class="admin-chat-img-thumb" onclick="openAdminLightbox('${fullUrl}')" alt="รูปภาพแนบ">`;
                } else {
                    bubbleContent += `<div class="mt-2"><a href="${fullUrl}" target="_blank" class="btn btn-sm btn-light border rounded-pill"><i class="bx bx-file me-1"></i> ดาวน์โหลดเอกสาร</a></div>`;
                }
            }

            html += `
            <div class="msg-group ${typeClass}">
                ${!isSystem ? `
                    <div class="msg-meta-row mb-1">
                        <span class="fw-bold text-dark" style="font-size: 0.75rem;">${escapeHtml(senderLabel)}</span>
                    </div>` : ''}
                <div class="msg-bubble">${bubbleContent}</div>
                ${!isSystem ? `<div class="msg-meta-row"><span>${timeStr}</span></div>` : ''}
            </div>`;
        });

        box.innerHTML = html;
        if (!silent) box.scrollTop = box.scrollHeight;
    }

    function handleAdminFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        document.getElementById('adminAttachFileName').innerText = 'กำลังอัปโหลด ' + file.name + '...';
        document.getElementById('adminAttachPreviewBar').style.display = 'flex';

        fetch('<?= site_url('admin/live-chat/upload') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                currentAdminAttachment = data;
                document.getElementById('adminAttachFileName').innerText = data.file_name;
            } else {
                alert(data.message || 'อัปโหลดไฟล์ล้มเหลว');
                clearAdminAttachment();
            }
        })
        .catch(() => {
            alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
            clearAdminAttachment();
        });
    }

    function clearAdminAttachment() {
        currentAdminAttachment = null;
        document.getElementById('adminFileInput').value = '';
        document.getElementById('adminAttachPreviewBar').style.display = 'none';
    }

    function sendAdminReply(e) {
        e.preventDefault();
        const input = document.getElementById('adminReplyInput');
        const text = input.value.trim();
        const attachment = currentAdminAttachment;

        if ((!text && !attachment) || !currentSessionId) return;

        input.value = '';
        clearAdminAttachment();

        const formData = new FormData();
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        formData.append('session_id', currentSessionId);
        formData.append('message', text);
        if (attachment) {
            formData.append('attachment_url', attachment.file_url);
            formData.append('attachment_type', attachment.attachment_type);
        }

        fetch('<?= site_url('admin/live-chat/reply') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                loadSessionMessages(currentSessionId, true);
                loadSessions(false, true);
            }
        });
    }

    function toggleCurrentSessionStatus() {
        if (!currentSessionId) return;
        fetch(`<?= site_url('admin/live-chat/toggle-status') ?>/${currentSessionId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                loadSessionMessages(currentSessionId, false);
                loadSessions(false, true);
            }
        });
    }

    function confirmDeleteCurrentSession() {
        if (!currentSessionId) return;
        if (!confirm('คุณต้องการลบประวัติการสนทนาของห้องนี้ทั้งหมดใช่หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้')) return;

        fetch(`<?= site_url('admin/live-chat/delete') ?>/${currentSessionId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                backToSessionList();
                loadSessions(true);
            } else {
                alert(data.message || 'ลบไม่สำเร็จ');
            }
        });
    }

    function toggleSessionBotForCurrent() {
        if (!currentSessionId) return;
        fetch(`<?= site_url('admin/live-chat/toggle-bot') ?>/${currentSessionId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                loadSessionMessages(currentSessionId, false);
            } else {
                alert(data.message || 'เกิดข้อผิดพลาด');
            }
        })
        .catch(err => console.error(err));
    }

    function insertQuickReply(text) {
        const input = document.getElementById('adminReplyInput');
        input.value = text;
        input.focus();
    }

    function openTelegramModal() {
        fetch('<?= site_url('admin/live-chat/telegram-config') ?>', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.config) {
                document.getElementById('tgBotToken').value = data.config.telegram_bot_token || '';
                document.getElementById('tgChatId').value = data.config.telegram_chat_id || '';
                document.getElementById('tgChatTitle').value = data.config.telegram_chat_title || '';
                document.getElementById('tgStatus').checked = (data.config.telegram_status === 'on');
            }
            document.getElementById('tgAlertBox').style.display = 'none';
            const modal = new bootstrap.Modal(document.getElementById('telegramSettingsModal'));
            modal.show();
        })
        .catch(() => {
            const modal = new bootstrap.Modal(document.getElementById('telegramSettingsModal'));
            modal.show();
        });
    }

    function saveTelegramSettings(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSaveTelegram');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...';

        const formData = new FormData();
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        formData.append('telegram_bot_token', document.getElementById('tgBotToken').value.trim());
        formData.append('telegram_chat_id', document.getElementById('tgChatId').value.trim());
        formData.append('telegram_chat_title', document.getElementById('tgChatTitle').value.trim());
        formData.append('telegram_status', document.getElementById('tgStatus').checked ? 'on' : 'off');

        fetch('<?= site_url('admin/live-chat/telegram-config') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-save me-1"></i> บันทึก';
            const alertBox = document.getElementById('tgAlertBox');
            if (data.status === 'success') {
                alertBox.className = 'alert alert-success alert-sm mb-3';
                alertBox.innerText = data.message || 'บันทึกสำเร็จ!';
                alertBox.style.display = 'block';
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('telegramSettingsModal'))?.hide();
                }, 1200);
            } else {
                alertBox.className = 'alert alert-danger alert-sm mb-3';
                alertBox.innerText = data.message || 'เกิดข้อผิดพลาด';
                alertBox.style.display = 'block';
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-save me-1"></i> บันทึก';
        });
    }

    function testTelegramNotification() {
        const btn = document.getElementById('btnTestTelegram');
        const token = document.getElementById('tgBotToken').value.trim();
        const chatId = document.getElementById('tgChatId').value.trim();
        const alertBox = document.getElementById('tgAlertBox');

        if (!token || !chatId) {
            alertBox.className = 'alert alert-warning alert-sm mb-3';
            alertBox.innerText = 'กรุณากรอก Bot Token และ Chat ID ก่อนทดสอบครับ';
            alertBox.style.display = 'block';
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> กำลังทดสอบ...';

        const formData = new FormData();
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        formData.append('telegram_bot_token', token);
        formData.append('telegram_chat_id', chatId);

        fetch('<?= site_url('admin/live-chat/telegram-test') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-send me-1"></i> ทดสอบส่งข้อความ';
            if (data.status === 'success') {
                alertBox.className = 'alert alert-success alert-sm mb-3';
                alertBox.innerText = data.message;
            } else {
                alertBox.className = 'alert alert-danger alert-sm mb-3';
                alertBox.innerText = data.message;
            }
            alertBox.style.display = 'block';
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-send me-1"></i> ทดสอบส่งข้อความ';
            alertBox.className = 'alert alert-danger alert-sm mb-3';
            alertBox.innerText = 'เชื่อมต่อล้มเหลว ตรวจสอบอินเทอร์เน็ต';
            alertBox.style.display = 'block';
        });
    }

    function openAdminLightbox(url) {
        document.getElementById('adminLightboxImg').src = url;
        document.getElementById('adminChatLightbox').style.display = 'flex';
    }

    function closeAdminLightbox() {
        document.getElementById('adminChatLightbox').style.display = 'none';
    }

    const THAI_MONTHS_SHORT = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

    function formatShortDateTime(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr.replace(/-/g, '/'));
        if (isNaN(d.getTime())) return dateStr;

        const now = new Date();
        const isToday = (d.toDateString() === now.toDateString());

        const yesterday = new Date(now);
        yesterday.setDate(now.getDate() - 1);
        const isYesterday = (d.toDateString() === yesterday.toDateString());

        const isThisYear = (d.getFullYear() === now.getFullYear());

        const day = d.getDate();
        const month = THAI_MONTHS_SHORT[d.getMonth()];
        const thaiYearShort = String((d.getFullYear() + 543) % 100).padStart(2, '0');
        const hours = String(d.getHours()).padStart(2, '0');
        const minutes = String(d.getMinutes()).padStart(2, '0');
        const timePart = `${hours}:${minutes} น.`;

        if (isToday) {
            return `วันนี้ ${timePart}`;
        } else if (isYesterday) {
            return `เมื่อวาน ${timePart}`;
        } else if (isThisYear) {
            return `${day} ${month} ${timePart}`;
        } else {
            return `${day} ${month} ${thaiYearShort} ${timePart}`;
        }
    }

    function formatSessionCardTime(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr.replace(/-/g, '/'));
        if (isNaN(d.getTime())) return dateStr;

        const now = new Date();
        const isToday = (d.toDateString() === now.toDateString());

        const yesterday = new Date(now);
        yesterday.setDate(now.getDate() - 1);
        const isYesterday = (d.toDateString() === yesterday.toDateString());

        const isThisYear = (d.getFullYear() === now.getFullYear());

        const day = d.getDate();
        const month = THAI_MONTHS_SHORT[d.getMonth()];
        const thaiYearShort = String((d.getFullYear() + 543) % 100).padStart(2, '0');
        const hours = String(d.getHours()).padStart(2, '0');
        const minutes = String(d.getMinutes()).padStart(2, '0');

        if (isToday) {
            return `${hours}:${minutes} น.`;
        } else if (isYesterday) {
            return `เมื่อวาน`;
        } else if (isThisYear) {
            return `${day} ${month}`;
        } else {
            return `${day} ${month} ${thaiYearShort}`;
        }
    }

    function formatTime(dateStr) {
        return formatShortDateTime(dateStr);
    }

    function escapeHtml(str) {
        if (!str) return '';
        const p = document.createElement('p');
        p.textContent = str;
        return p.innerHTML;
    }

    function decodeHtmlEntities(str) {
        if (!str) return '';
        const txt = document.createElement('textarea');
        txt.innerHTML = str;
        return txt.value;
    }

    function formatChatMessage(rawText, isDarkBubble = false) {
        if (!rawText) return '';

        // Decode existing HTML entities if previously encoded in backend
        const decoded = decodeHtmlEntities(rawText);

        // Sanitize raw text to prevent XSS attacks
        const div = document.createElement('div');
        div.textContent = decoded;
        let safe = div.innerHTML;

        const tokens = [];

        // 1. Markdown link pattern: [label](url)
        safe = safe.replace(/\[([^\]]+)\]\((https?:\/\/[^\s<)]+)\)/g, function(match, label, url) {
            const token = `__CHAT_LINK_TOKEN_${tokens.length}__`;
            tokens.push(`<a href="${url}" target="_blank" rel="noopener noreferrer" class="chat-text-link">${label} <i class="bx bx-link-external" style="font-size: 0.82em; vertical-align: middle;"></i></a>`);
            return token;
        });

        // 2. Full URL pattern: https://... or http://...
        safe = safe.replace(/(https?:\/\/[^\s<]+)/gi, function(match, url) {
            let cleanUrl = url;
            let trailing = '';
            const matchTrailing = cleanUrl.match(/[.,;:!?)\]"']+$/);
            if (matchTrailing) {
                trailing = matchTrailing[0];
                cleanUrl = cleanUrl.slice(0, -trailing.length);
            }
            const token = `__CHAT_LINK_TOKEN_${tokens.length}__`;
            tokens.push(`<a href="${cleanUrl}" target="_blank" rel="noopener noreferrer" class="chat-text-link">${cleanUrl}</a>${trailing}`);
            return token;
        });

        // 3. WWW URL pattern: www.example.com...
        safe = safe.replace(/(^|[\s\n>])(www\.[a-zA-Z0-9\-]+(\.[a-zA-Z0-9\-]+)+[^\s<]*)/gi, function(match, prefix, url) {
            let cleanUrl = url;
            let trailing = '';
            const matchTrailing = cleanUrl.match(/[.,;:!?)\]"']+$/);
            if (matchTrailing) {
                trailing = matchTrailing[0];
                cleanUrl = cleanUrl.slice(0, -trailing.length);
            }
            const token = `__CHAT_LINK_TOKEN_${tokens.length}__`;
            tokens.push(`<a href="https://${cleanUrl}" target="_blank" rel="noopener noreferrer" class="chat-text-link">${cleanUrl}</a>${trailing}`);
            return prefix + token;
        });

        // 4. Restore tokens
        tokens.forEach((html, i) => {
            safe = safe.split(`__CHAT_LINK_TOKEN_${i}__`).join(html);
        });

        // 5. Formatting (bold, bullets, line breaks)
        safe = safe.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        safe = safe.replace(/•/g, '&bull;');
        safe = safe.replace(/\n/g, '<br>');

        return safe;
    }

    // ==========================================
    // AI SMART CHATBOT (GOOGLE GEMINI) LOGIC
    // ==========================================
    const DEFAULT_SKJ_AI_PROMPT = `คุณคือ "น้องกุหลาบ (SKJ AI Assistant)" ผู้ช่วยประชาสัมพันธ์อัจฉริยะของโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ สังกัดองค์การบริหารส่วนจังหวัดนครสวรรค์
หน้าที่ของคุณคือตอบคำถามของผู้ปกครอง นักเรียน ศิษย์เก่า และประชาชนทั่วไปอย่างสุภาพ อบอุ่น มีไมตรีจิต และถูกต้องกระชับ (ลงท้ายด้วย ครับ/ค่ะ อย่างเหมาะสม)

ข้อมูลพื้นฐานของโรงเรียน:
- ชื่อสถานศึกษา: โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
- ที่ตั้ง: 160 หมู่ 1 ตำบลนครสวรรค์ออก อำเภอเมือง จังหวัดนครสวรรค์ 60000
- โทรศัพท์สำนักงาน: 056-009-667
- เวลาทำการ: วันจันทร์ - ศุกร์ เวลา 08:00 - 16:30 น. (ปิดทำการวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์)
- สีประจำโรงเรียน: ชมพู - ฟ้า (ดอกกุหลาบสีชมพู)
- คำขวัญ/อัตลักษณ์: สุภาพชน คนสวนฯ เป็นผู้นำ รักเพื่อน นับถือพี่ เคารพครู กตัญญูพ่อแม่ ดูแลน้อง สนองคุณแผ่นดิน

ข้อมูลด้านวิชาการและการรับสมัคร:
- ระดับชั้นที่เปิดสอน: มัธยมศึกษาปีที่ 1 ถึง 6
- การรับสมัคร: รับสมัครช่วงกุมภาพันธ์ - มีนาคม ของทุกปี (ระดับ ม.1 และ ม.4) ทั้งระบบออนไลน์ผ่านเว็บไซต์ https://skj.ac.th และที่อาคารอำนวยการ
- แผนการเรียน ม.ปลาย: วิทยาศาสตร์-คณิตศาสตร์, ศิลป์-ภาษา, ศิลป์-สังคม และเทคโนโลยีสารสนเทศ
- การชำระเงิน/ค่าเทอม: ชำระผ่านระบบออนไลน์หรือที่ห้องการเงิน หากโอนแล้วสามารถแนบรูปถ่ายสลิปเข้ามาในช่องแชทนี้ได้ทันที

กฎการตอบคำถาม:
1. ตอบเป็นภาษาไทยที่สุภาพ กระชับ อ่านเข้าใจง่าย ใช้ emoji หรือ bullet point ประกอบให้อ่านสบายตา
2. หากเป็นเรื่องนอกเหนือข้อมูลโรงเรียน หรือเรื่องที่ต้องให้ครู/เจ้าหน้าที่ตรวจสอบเฉพาะบุคคล (เช่น ผลการเรียนรายบุคคล, แก้เกรด, การขอใบ ปพ.) ให้แนะนำให้ติดต่อเบอร์โทร 056-009-667 ในวันและเวลาทำการ หรือพิมพ์ฝากชื่อและเบอร์โทรศัพท์ไว้ในแชทเพื่อให้เจ้าหน้าที่ติดต่อกลับ`;

    function updateAiStatusBadge(isOn) {
        const dot = document.getElementById('aiStatusDot');
        if (!dot) return;
        if (isOn) {
            dot.className = 'position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle';
            dot.title = 'สถานะ AI: เปิดใช้งาน (ON)';
        } else {
            dot.className = 'position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle';
            dot.title = 'สถานะ AI: ปิดการทำงาน (OFF)';
        }
    }

    function checkAiStatusOnLoad() {
        fetch('<?= site_url('admin/live-chat/ai-config') ?>', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.config) {
                updateAiStatusBadge(data.config.ai_status === 'on');
            }
        })
        .catch(() => {});
    }

    function openAiModal() {
        fetch('<?= site_url('admin/live-chat/ai-config') ?>', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.config) {
                const c = data.config;
                document.getElementById('aiApiKey').value = c.ai_api_key || '';
                document.getElementById('aiModel').value = c.ai_model || 'gemini-3.5-flash';
                document.getElementById('aiStatus').checked = (c.ai_status === 'on');
                document.getElementById('aiSystemPrompt').value = c.ai_system_prompt || DEFAULT_SKJ_AI_PROMPT;
                
                if (c.updated_at) {
                    document.getElementById('aiLastUpdatedInfo').innerText = 'อัปเดตล่าสุด: ' + formatShortDateTime(c.updated_at);
                }
                updateAiStatusBadge(c.ai_status === 'on');
            } else {
                document.getElementById('aiSystemPrompt').value = DEFAULT_SKJ_AI_PROMPT;
            }
            document.getElementById('aiAlertBox').style.display = 'none';
            document.getElementById('aiTestResultWrap').style.display = 'none';
            const modal = new bootstrap.Modal(document.getElementById('aiSettingsModal'));
            modal.show();
        })
        .catch(() => {
            document.getElementById('aiSystemPrompt').value = DEFAULT_SKJ_AI_PROMPT;
            const modal = new bootstrap.Modal(document.getElementById('aiSettingsModal'));
            modal.show();
        });
    }

    function updateAiStatusUI() {
        const isChecked = document.getElementById('aiStatus').checked;
        updateAiStatusBadge(isChecked);
    }

    function toggleApiKeyVisibility() {
        const input = document.getElementById('aiApiKey');
        const icon = document.getElementById('aiKeyEyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bx bx-hide';
        } else {
            input.type = 'password';
            icon.className = 'bx bx-show';
        }
    }

    function resetDefaultAiPrompt() {
        if (confirm('คุณต้องการโหลดข้อความแนะนำข้อมูลโรงเรียนและบุคลิกภาพ AI กลับมาเป็นค่าเริ่มต้นใช่หรือไม่?')) {
            document.getElementById('aiSystemPrompt').value = DEFAULT_SKJ_AI_PROMPT;
        }
    }

    function saveAiSettings(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSaveAi');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...';

        const formData = new FormData();
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        formData.append('ai_api_key', document.getElementById('aiApiKey').value.trim());
        formData.append('ai_model', document.getElementById('aiModel').value);
        formData.append('ai_system_prompt', document.getElementById('aiSystemPrompt').value.trim());
        formData.append('ai_status', document.getElementById('aiStatus').checked ? 'on' : 'off');

        fetch('<?= site_url('admin/live-chat/ai-config') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-save me-1"></i> บันทึกการตั้งค่า';
            const alertBox = document.getElementById('aiAlertBox');
            if (data.status === 'success') {
                updateAiStatusBadge(document.getElementById('aiStatus').checked);
                alertBox.className = 'alert alert-success alert-sm mb-3';
                alertBox.innerText = data.message || 'บันทึกสำเร็จ!';
                alertBox.style.display = 'block';
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('aiSettingsModal'))?.hide();
                }, 1200);
            } else {
                alertBox.className = 'alert alert-danger alert-sm mb-3';
                alertBox.innerText = data.message || 'เกิดข้อผิดพลาดในการบันทึก';
                alertBox.style.display = 'block';
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-save me-1"></i> บันทึกการตั้งค่า';
        });
    }

    function testAiSandbox() {
        const btn = document.getElementById('btnTestAi');
        const testInput = document.getElementById('aiTestInput');
        const userMsg = testInput.value.trim() || 'โรงเรียนเปิดรับสมัคร ม.1 วันไหนบ้าง และมีสายการเรียนอะไรบ้าง';
        const apiKey = document.getElementById('aiApiKey').value.trim();
        const model = document.getElementById('aiModel').value;
        const prompt = document.getElementById('aiSystemPrompt').value.trim();
        const alertBox = document.getElementById('aiAlertBox');
        const resultWrap = document.getElementById('aiTestResultWrap');
        const replyBody = document.getElementById('aiTestReplyBody');
        const latencyBadge = document.getElementById('aiTestLatency');

        if (!apiKey) {
            alertBox.className = 'alert alert-warning alert-sm mb-3';
            alertBox.innerText = 'กรุณากรอก Google Gemini API Key ก่อนทำการทดสอบครับ';
            alertBox.style.display = 'block';
            document.getElementById('aiApiKey').focus();
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> กำลังถาม AI...';
        alertBox.style.display = 'none';

        const formData = new FormData();
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        formData.append('test_message', userMsg);
        formData.append('ai_api_key', apiKey);
        formData.append('ai_model', model);
        formData.append('ai_system_prompt', prompt);

        fetch('<?= site_url('admin/live-chat/ai-test') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-paper-plane me-1"></i> ทดสอบถาม AI';
            if (data.status === 'success') {
                resultWrap.style.display = 'block';
                replyBody.innerText = data.reply;
                latencyBadge.innerText = (data.latency_ms || 0) + ' ms (' + (data.model || model) + ')';
            } else {
                alertBox.className = 'alert alert-danger alert-sm mb-3';
                alertBox.innerText = data.message || 'เกิดข้อผิดพลาดในการเรียกใช้ AI';
                alertBox.style.display = 'block';
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-paper-plane me-1"></i> ทดสอบถาม AI';
            alertBox.className = 'alert alert-danger alert-sm mb-3';
            alertBox.innerText = 'เกิดข้อผิดพลาดในการเชื่อมต่อเครือข่าย';
            alertBox.style.display = 'block';
        });
    }
</script>
<?= $this->endSection() ?>


