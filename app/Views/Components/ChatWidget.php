<!-- ==================== SKJ LIVE CHAT FLOATING MESSENGER PRO (FOR skj2025) ==================== -->
<!-- Explicitly include Boxicons & Google Fonts to guarantee 100% icon & font rendering anywhere -->
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --skj-chat-pink: #ff6b8b;
        --skj-chat-pink-dark: #e04869;
        --skj-chat-blue: #56ccf2;
        --skj-chat-blue-dark: #2f80ed;
        --skj-chat-gradient: linear-gradient(135deg, #ff6b8b 0%, #e04869 50%, #56ccf2 100%);
        --skj-chat-user-bubble: linear-gradient(135deg, #ff6b8b 0%, #ff8ea7 100%);
        --skj-chat-shadow: 0 16px 40px -10px rgba(255, 107, 139, 0.4), 0 8px 24px -6px rgba(15, 23, 42, 0.18);
    }

    #skjChatContainerWrap {
        font-family: 'Prompt', 'K2D', 'Sarabun', sans-serif !important;
    }

    /* Floating Launcher Button */
    .skj-chat-launcher {
        position: fixed;
        bottom: 30px;
        right: 22px;
        z-index: 99999;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--skj-chat-gradient);
        color: #ffffff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        box-shadow: 0 6px 20px rgba(255, 107, 139, 0.4), 0 3px 10px rgba(86, 204, 242, 0.25);
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 2.5px solid #ffffff;
        outline: none;
    }

    .skj-chat-launcher:hover {
        transform: scale(1.08) translateY(-3px);
        box-shadow: 0 10px 28px rgba(255, 107, 139, 0.55), 0 5px 14px rgba(86, 204, 242, 0.35);
        color: #ffffff;
    }

    .skj-chat-launcher-pill {
        position: absolute;
        right: 60px;
        top: 50%;
        transform: translateY(-50%);
        background: #ffffff;
        color: #0f172a;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 30px;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.12);
        border: 1px solid rgba(255, 107, 139, 0.25);
        white-space: nowrap;
        pointer-events: none;
        display: flex;
        align-items: center;
        gap: 5px;
        animation: floatPill 3.5s ease-in-out infinite;
    }
    .skj-chat-launcher-pill::after {
        content: '';
        position: absolute;
        right: -6px;
        top: 50%;
        transform: translateY(-50%);
        border-width: 5px 0 5px 6px;
        border-style: solid;
        border-color: transparent transparent transparent #ffffff;
    }

    @keyframes floatPill {
        0%, 100% { transform: translateY(-50%) translateX(0); }
        50% { transform: translateY(-50%) translateX(-4px); }
    }

    .skj-chat-launcher .badge-unread {
        position: absolute;
        top: -3px;
        right: -3px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        min-width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ffffff;
        box-shadow: 0 3px 8px rgba(239, 68, 68, 0.5);
    }

    /* Floating Chat Window Box */
    .skj-chat-window {
        position: fixed;
        bottom: 90px;
        right: 22px;
        width: 400px;
        max-width: calc(100vw - 32px);
        height: 590px;
        max-height: calc(100dvh - 120px);
        background: #ffffff;
        border-radius: 24px;
        box-shadow: var(--skj-chat-shadow);
        border: 1px solid rgba(226, 232, 240, 0.95);
        z-index: 999999;
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: chatSlideUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Mobile Chat Widget Responsive Rules (< 992px) */
    @media (max-width: 991px) {
        /* Hide floating launcher on mobile because it's directly integrated into the Bottom Navigation Bar */
        .skj-chat-launcher {
            display: none !important;
        }

        .skj-chat-launcher-pill {
            display: none !important;
        }

        .skj-chat-window {
            bottom: calc(75px + env(safe-area-inset-bottom, 0px));
            right: 10px;
            left: 10px;
            width: auto;
            max-width: calc(100vw - 20px);
            height: calc(100dvh - 150px);
            border-radius: 20px;
        }
    }


    @keyframes chatSlideUp {
        from { opacity: 0; transform: translateY(30px) scale(0.92); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .skj-chat-header {
        background: var(--skj-chat-gradient);
        color: #ffffff;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(255, 107, 139, 0.25);
    }

    .skj-chat-header .header-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    }
    .skj-chat-header .header-avatar img {
        width: 30px;
        height: 30px;
        object-fit: contain;
    }

    .skj-chat-header .header-avatar .online-radar {
        position: absolute;
        bottom: -1px;
        right: -1px;
        width: 13px;
        height: 13px;
        background-color: #22c55e;
        border: 2.5px solid #ffffff;
        border-radius: 50%;
    }

    .skj-chat-header-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .skj-chat-header-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.22);
        color: #ffffff !important;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1.15rem;
    }
    .skj-chat-header-btn:hover {
        background: rgba(255, 255, 255, 0.4);
        color: #ffffff;
    }

    .skj-chat-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background-color: #f8fafc;
        background-image: radial-gradient(#e2e8f0 1.2px, transparent 1.2px);
        background-size: 18px 18px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .skj-msg-row {
        display: flex;
        flex-direction: column;
        max-width: 84%;
    }

    .skj-msg-row.user { align-self: flex-end; }
    .skj-msg-row.admin { align-self: flex-start; }
    .skj-msg-row.system { align-self: center; max-width: 94%; }

    .skj-msg-bubble {
        padding: 11px 16px;
        border-radius: 20px;
        font-size: 0.90rem;
        line-height: 1.55;
        word-break: break-word;
    }
    .skj-msg-bubble.user {
        background: var(--skj-chat-user-bubble);
        color: #ffffff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 14px rgba(255, 107, 139, 0.28);
    }
    .skj-msg-bubble.admin {
        background: #ffffff;
        color: #0f172a;
        border: 1.5px solid #edf2f7;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
    }
    .skj-msg-bubble.system {
        background: #ffffff;
        color: #1e293b;
        font-size: 0.84rem;
        border-radius: 16px;
        border: 1.5px solid #fed7aa;
        border-left: 4px solid #f97316;
        box-shadow: 0 3px 12px rgba(249, 115, 22, 0.08);
    }

    /* Links inside client chat bubbles */
    .skj-msg-bubble a {
        word-break: break-all;
        text-decoration: underline;
        transition: opacity 0.2s ease;
    }
    .skj-msg-bubble.user a {
        color: #ffffff !important;
        font-weight: 600;
        text-decoration-color: rgba(255, 255, 255, 0.85);
    }
    .skj-msg-bubble.user a:hover {
        opacity: 0.9;
    }
    .skj-msg-bubble.admin a {
        color: #2563eb !important;
        font-weight: 600;
    }
    .skj-msg-bubble.admin a:hover {
        color: #1d4ed8 !important;
    }
    .skj-msg-bubble.system a {
        color: #ea580c !important;
        font-weight: 600;
    }
    .skj-msg-bubble.system a:hover {
        color: #c2410c !important;
    }

    .skj-chat-img-thumb {
        max-width: 220px;
        max-height: 180px;
        border-radius: 14px;
        cursor: pointer;
        transition: transform 0.2s ease;
        margin-top: 6px;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .skj-chat-img-thumb:hover {
        transform: scale(1.03);
    }

    .skj-chat-quick-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 8px 12px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
    }

    .skj-quick-chip {
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 4px 10px;
        cursor: pointer;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }
    .skj-quick-chip:hover {
        background: #fff0f3;
        border-color: #ff8ea7;
        color: #e04869;
        transform: translateY(-1px);
    }

    .skj-chat-footer {
        padding: 10px 14px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
    }

    /* Attachment Preview in Footer */
    .skj-attach-preview-bar {
        display: none;
        align-items: center;
        justify-content: space-between;
        background: #f1f5f9;
        padding: 6px 12px;
        border-radius: 12px;
        margin-bottom: 8px;
        font-size: 0.8rem;
    }

    .skj-chat-input-box {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border-radius: 30px;
        padding: 4px 6px 4px 14px;
        border: 1.5px solid #e2e8f0;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .skj-chat-input-box:focus-within {
        background: #ffffff;
        border-color: var(--skj-chat-pink);
        box-shadow: 0 0 0 3px rgba(255, 107, 139, 0.2);
    }
    .skj-chat-input-box input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 0.90rem;
        outline: none;
        color: #0f172a;
        padding: 4px 0;
    }
    .skj-chat-attach-btn {
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 1.3rem;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: color 0.2s;
    }
    .skj-chat-attach-btn:hover { color: var(--skj-chat-pink); }

    .skj-chat-send-btn {
        background: var(--skj-chat-user-bubble);
        border: none;
        color: #ffffff !important;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: transform 0.2s;
        box-shadow: 0 3px 10px rgba(255, 107, 139, 0.35);
        flex-shrink: 0;
    }
    .skj-chat-send-btn:hover { transform: scale(1.06); }

    /* Typing Indicator */
    .skj-typing-indicator {
        display: none;
        align-items: center;
        gap: 4px;
        padding: 8px 12px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        width: fit-content;
        margin-bottom: 6px;
    }
    .skj-typing-dot {
        width: 6px;
        height: 6px;
        background: #94a3b8;
        border-radius: 50%;
        animation: typingDot 1.4s infinite ease-in-out;
    }
    .skj-typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .skj-typing-dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typingDot {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
        30% { transform: translateY(-4px); opacity: 1; }
    }

    /* Lightbox Modal */
    .skj-chat-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.85);
        z-index: 9999999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        backdrop-filter: blur(4px);
    }
    .skj-chat-lightbox img {
        max-width: 90vw;
        max-height: 85vh;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    .skj-chat-lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #ffffff;
        font-size: 34px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .skj-chat-lightbox-close:hover { transform: scale(1.1); }

</style>

<div id="skjChatContainerWrap">
    <!-- Floating Launcher Icon -->
    <div class="skj-chat-launcher" id="skjChatLauncher" onclick="toggleChatWindow()" title="สอบถามข้อมูล">
        <i class="bx bxs-chat" id="chatLauncherIcon"></i>
        <span class="badge-unread" id="chatUnreadBadge" style="display: none;">0</span>
        <div class="skj-chat-launcher-pill" id="skjChatLauncherPill">
            <span>💬 สอบถามข้อมูล</span>
        </div>
    </div>

    <!-- Floating Chat Window -->
    <div class="skj-chat-window" id="skjChatWindow">
        <div class="skj-chat-header">
            <div class="d-flex align-items-center gap-2">
                <div class="header-avatar">
                    <img src="<?= base_url('uploads/logoSchool/LogoSKJ_4.png'); ?>" alt="SKJ Logo">
                    <span class="online-radar"></span>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-white" style="font-size: 0.98rem; line-height: 1.2;">ศูนย์บริการข้อมูล SKJ Live</h6>
                    <div style="font-size: 0.74rem; opacity: 0.95;">🟢 เจ้าหน้าที่และบอทพร้อมบริการ</div>
                </div>
            </div>
            <div class="skj-chat-header-actions">
                <button type="button" class="skj-chat-header-btn" id="btnToggleChatSound" onclick="toggleChatSound()" title="เปิด/ปิดเสียงแจ้งเตือน">
                    <i class="bx bx-volume-full" id="soundIcon"></i>
                </button>
                <button type="button" class="skj-chat-header-btn" onclick="toggleChatWindow()" title="ย่อหน้าต่าง">
                    <i class="bx bx-x" style="font-size: 1.5rem;"></i>
                </button>
            </div>
        </div>

        <!-- Contact Info Bar -->
        <div style="background: #f8fafc; padding: 10px 14px; border-bottom: 1px solid #e2e8f0;">
            <div class="row g-2">
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm rounded-pill" id="chatInputName" placeholder="👤 ชื่อ-นามสกุล..." maxlength="100" onchange="saveChatProfile()" style="font-size: 0.82rem; background: #ffffff;">
                </div>
                <div class="col-5">
                    <input type="tel" class="form-control form-control-sm rounded-pill" id="chatInputTel" placeholder="📞 เบอร์โทร..." maxlength="20" onchange="saveChatProfile()" style="font-size: 0.82rem; background: #ffffff;">
                </div>
            </div>
        </div>

        <!-- Chat Messages Body -->
        <div class="skj-chat-body" id="skjChatBody"></div>

        <!-- Typing Indicator -->
        <div class="px-3" id="typingWrap" style="display: none; background: #f8fafc;">
            <div class="skj-typing-indicator" id="skjTypingIndicator" style="display: flex;">
                <span class="small text-muted me-1" style="font-size: 0.72rem;">กำลังพิมพ์</span>
                <div class="skj-typing-dot"></div>
                <div class="skj-typing-dot"></div>
                <div class="skj-typing-dot"></div>
            </div>
        </div>

        <!-- Interactive FAQ Chips -->
        <div class="skj-chat-quick-chips">
            <span class="skj-quick-chip" onclick="quickSendQuestion('ขอสอบถามข้อมูลการรับสมัครนักเรียนครับ')">📝 สมัครเรียน</span>
            <span class="skj-quick-chip" onclick="quickSendQuestion('ขอทราบแผนการเรียนและหลักสูตรครับ')">📚 แผนการเรียน</span>
            <span class="skj-quick-chip" onclick="quickSendQuestion('ขอทราบข้อมูลการติดต่อโรงเรียนครับ')">📞 ติดต่อเรา</span>
            <span class="skj-quick-chip" onclick="quickSendQuestion('ขอทราบเวลาทำการของโรงเรียนครับ')">⏰ เวลาทำการ</span>
            <span class="skj-quick-chip" onclick="quickSendQuestion('ขอสอบถามเรื่องค่าธรรมเนียมการศึกษา/ส่งสลิปครับ')">💳 ค่าเทอม</span>
            <span class="skj-quick-chip" onclick="quickSendQuestion('ขอทราบแผนที่และเส้นทางมาโรงเรียนครับ')">📍 แผนที่</span>
        </div>

        <!-- Footer Input Bar -->
        <div class="skj-chat-footer">
            <!-- Image Attachment Preview Bar -->
            <div class="skj-attach-preview-bar" id="attachPreviewBar">
                <div class="d-flex align-items-center gap-2 overflow-hidden">
                    <i class="bx bx-image text-primary fs-5"></i>
                    <span class="text-truncate" id="attachFileName" style="max-width: 240px;">รูปภาพที่เลือก</span>
                </div>
                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="clearSelectedAttachment()">
                    <i class="bx bx-x fs-5"></i>
                </button>
            </div>

            <form id="skjUserChatForm" onsubmit="sendUserMessage(event)">
                <input type="file" id="chatFileInput" accept="image/*,.pdf" style="display: none;" onchange="handleFileSelect(event)">
                <div class="skj-chat-input-box">
                    <button type="button" class="skj-chat-attach-btn" onclick="document.getElementById('chatFileInput').click()" title="แนบรูปภาพหรือสลิป">
                        <i class="bx bx-image-add"></i>
                    </button>
                    <input type="text" id="chatInputMessage" placeholder="พิมพ์ข้อความที่นี่..." autocomplete="off">
                    <button type="submit" class="skj-chat-send-btn" id="btnChatSend" title="ส่งข้อความ">
                        <i class="bx bxs-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Lightbox Modal -->
    <div class="skj-chat-lightbox" id="skjChatLightbox" onclick="closeChatLightbox()">
        <i class="bx bx-x skj-chat-lightbox-close" onclick="closeChatLightbox()"></i>
        <img id="skjLightboxImg" src="" alt="ขยายรูปภาพ">
    </div>
</div>

<script>
    let chatSessionToken = localStorage.getItem('skj_chat_token') || '';
    let chatLastMessageId = 0;
    let chatPollTimer = null;
    let isChatOpen = false;
    let chatUnreadCount = 0;
    let isChatSoundMuted = localStorage.getItem('skj_chat_muted') === '1';
    let currentAttachment = null; // { file_url, file_name, attachment_type }

    // Web Audio Sound FX Synthesizer
    let audioCtx = null;
    function playChatChime() {
        if (isChatSoundMuted) return;
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            if (!audioCtx) audioCtx = new AudioContext();
            if (audioCtx.state === 'suspended') audioCtx.resume();

            const now = audioCtx.currentTime;
            
            // Oscillator 1 (Sweet high ping)
            const osc1 = audioCtx.createOscillator();
            const gain1 = audioCtx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(659.25, now); // E5
            osc1.frequency.exponentialRampToValueAtTime(880, now + 0.12); // A5
            gain1.gain.setValueAtTime(0.2, now);
            gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.35);

            osc1.connect(gain1);
            gain1.connect(audioCtx.destination);
            osc1.start(now);
            osc1.stop(now + 0.35);
        } catch (e) {
            console.log('Audio playback error', e);
        }
    }

    function updateSoundIcon() {
        const icon = document.getElementById('soundIcon');
        if (icon) {
            icon.className = isChatSoundMuted ? 'bx bx-volume-mute text-warning' : 'bx bx-volume-full';
        }
    }

    function toggleChatSound() {
        isChatSoundMuted = !isChatSoundMuted;
        localStorage.setItem('skj_chat_muted', isChatSoundMuted ? '1' : '0');
        updateSoundIcon();
        if (!isChatSoundMuted) playChatChime();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const savedName = localStorage.getItem('skj_chat_user_name') || '';
        const savedTel = localStorage.getItem('skj_chat_user_tel') || '';
        if (savedName) document.getElementById('chatInputName').value = savedName;
        if (savedTel) document.getElementById('chatInputTel').value = savedTel;
        updateSoundIcon();
    });

    function saveChatProfile() {
        const name = document.getElementById('chatInputName').value.trim();
        const tel = document.getElementById('chatInputTel').value.trim();
        if (name) localStorage.setItem('skj_chat_user_name', name);
        if (tel) localStorage.setItem('skj_chat_user_tel', tel);
    }

    function toggleChatWindow() {
        isChatOpen = !isChatOpen;
        const win = document.getElementById('skjChatWindow');
        const pill = document.getElementById('skjChatLauncherPill');
        
        if (isChatOpen) {
            win.style.display = 'flex';
            if (pill) pill.style.display = 'none';
            chatUnreadCount = 0;
            document.getElementById('chatUnreadBadge').style.display = 'none';
            initChatSession();
            setTimeout(() => document.getElementById('chatInputMessage').focus(), 300);
        } else {
            win.style.display = 'none';
            if (pill) pill.style.display = 'flex';
        }
    }

    function initChatSession() {
        const formData = new FormData();
        formData.append('session_token', chatSessionToken);
        formData.append('user_name', document.getElementById('chatInputName').value.trim());
        formData.append('user_tel', document.getElementById('chatInputTel').value.trim());

        fetch('<?= site_url('api/chat/init') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                chatSessionToken = data.session.session_token;
                localStorage.setItem('skj_chat_token', chatSessionToken);
                renderUserMessages(data.messages || []);
                startUserPolling();
            }
        });
    }

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);

        document.getElementById('attachFileName').innerText = 'กำลังอัปโหลด ' + file.name + '...';
        document.getElementById('attachPreviewBar').style.display = 'flex';

        fetch('<?= site_url('api/chat/upload') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                currentAttachment = data;
                document.getElementById('attachFileName').innerText = data.file_name;
            } else {
                alert(data.message || 'อัปโหลดไฟล์ล้มเหลว');
                clearSelectedAttachment();
            }
        })
        .catch(err => {
            alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
            clearSelectedAttachment();
        });
    }

    function clearSelectedAttachment() {
        currentAttachment = null;
        document.getElementById('chatFileInput').value = '';
        document.getElementById('attachPreviewBar').style.display = 'none';
    }

    function sendUserMessage(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('chatInputMessage');
        const text = input.value.trim();
        const attachment = currentAttachment;

        if (!text && !attachment) return;

        saveChatProfile();
        
        // Optimistic append
        const nowStr = formatChatTime(new Date());
        appendUserMessageRow('user', 'คุณ', text, nowStr, attachment ? attachment.file_url : null, attachment ? attachment.attachment_type : null);
        
        input.value = '';
        clearSelectedAttachment();

        // Show typing indicator
        showTypingIndicator(true);

        const formData = new FormData();
        formData.append('session_token', chatSessionToken);
        formData.append('message', text);
        if (attachment) {
            formData.append('attachment_url', attachment.file_url);
            formData.append('attachment_type', attachment.attachment_type);
        }
        formData.append('user_name', document.getElementById('chatInputName').value.trim());
        formData.append('user_tel', document.getElementById('chatInputTel').value.trim());

        fetch('<?= site_url('api/chat/send') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            showTypingIndicator(false);
            if (data.status === 'success' && data.message) {
                chatLastMessageId = Math.max(chatLastMessageId, parseInt(data.message.message_id));
                if (data.bot_reply) {
                    setTimeout(() => {
                        chatLastMessageId = Math.max(chatLastMessageId, parseInt(data.bot_reply.message_id));
                        appendUserMessageRow(data.bot_reply.sender_type, data.bot_reply.sender_name, data.bot_reply.message, formatChatTime(data.bot_reply.created_at));
                        playChatChime();
                    }, 500);
                }
            }
        })
        .catch(() => {
            showTypingIndicator(false);
        });
    }

    function showTypingIndicator(show) {
        const wrap = document.getElementById('typingWrap');
        if (wrap) wrap.style.display = show ? 'block' : 'none';
        const body = document.getElementById('skjChatBody');
        if (body) body.scrollTop = body.scrollHeight;
    }

    function quickSendQuestion(text) {
        document.getElementById('chatInputMessage').value = text;
        sendUserMessage();
    }

    function startUserPolling() {
        if (chatPollTimer) clearInterval(chatPollTimer);
        chatPollTimer = setInterval(pollUserMessages, 3500);
    }

    function pollUserMessages() {
        if (!chatSessionToken) return;

        fetch(`<?= site_url('api/chat/messages') ?>?session_token=${encodeURIComponent(chatSessionToken)}&last_message_id=${chatLastMessageId}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.messages && data.messages.length > 0) {
                let hasAdminMsg = false;
                data.messages.forEach(m => {
                    const mId = parseInt(m.message_id);
                    if (mId > chatLastMessageId) {
                        chatLastMessageId = mId;
                        appendUserMessageRow(m.sender_type, m.sender_name, m.message, formatChatTime(m.created_at), m.attachment_url, m.attachment_type);
                        if (m.sender_type === 'admin' || m.sender_type === 'system') {
                            hasAdminMsg = true;
                        }
                    }
                });

                if (hasAdminMsg) {
                    playChatChime();
                    if (!isChatOpen) {
                        chatUnreadCount += data.messages.length;
                        const badge = document.getElementById('chatUnreadBadge');
                        badge.innerText = chatUnreadCount;
                        badge.style.display = 'flex';
                    }
                }
            }
        });
    }

    function renderUserMessages(messages) {
        const body = document.getElementById('skjChatBody');
        body.innerHTML = '';
        messages.forEach(m => {
            const mId = parseInt(m.message_id);
            if (mId > chatLastMessageId) chatLastMessageId = mId;
            appendUserMessageRow(m.sender_type, m.sender_name, m.message, formatChatTime(m.created_at), m.attachment_url, m.attachment_type);
        });
    }

    function appendUserMessageRow(type, name, text, timeStr, attachmentUrl = null, attachmentType = null) {
        const body = document.getElementById('skjChatBody');
        const row = document.createElement('div');
        row.className = 'skj-msg-row ' + type;

        const isUser = type === 'user';
        const isSystem = type === 'system';
        const displayName = isUser ? 'คุณ' : (type === 'admin' ? (name || 'Admin ระบบ') : (name || 'ระบบตอบรับอัตโนมัติ'));

        let html = '';
        if (isSystem) {
            html += `<div class="d-flex align-items-center gap-1 mb-1">
                <span class="badge bg-primary text-white rounded-pill px-2 py-0" style="font-size: 0.68rem; font-weight: 600;">
                    ${(name && name.includes('AI')) ? '🤖 AI ประชาสัมพันธ์' : '✨ ระบบตอบกลับ'}
                </span>
                <small class="text-muted fw-bold" style="font-size: 0.70rem;">${displayName}</small>
            </div>`;
        } else {
            html += `<small class="text-muted fw-bold mb-1" style="font-size: 0.72rem; ${isUser ? 'text-align: right;' : ''}">${displayName}</small>`;
        }
        
        let bubbleContent = '';
        if (text) {
            bubbleContent += `<div>${formatChatMessage(text, isUser)}</div>`;
        }

        if (attachmentUrl) {
            const fullUrl = '<?= base_url() ?>/' + attachmentUrl;
            if (attachmentType === 'image' || attachmentUrl.match(/\.(jpeg|jpg|png|gif|webp)$/i)) {
                bubbleContent += `<img src="${fullUrl}" class="skj-chat-img-thumb" onclick="openChatLightbox('${fullUrl}')" alt="รูปภาพแนบ">`;
            } else {
                bubbleContent += `<div class="mt-2"><a href="${fullUrl}" target="_blank" class="btn btn-sm btn-light border rounded-pill"><i class="bx bx-file me-1"></i> ดาวน์โหลดเอกสาร</a></div>`;
            }
        }

        html += `<div class="skj-msg-bubble ${type}">${bubbleContent}</div>`;
        html += `<small class="text-muted mt-1" style="font-size: 0.68rem; ${isUser ? 'text-align: right;' : ''}">${timeStr}</small>`;

        row.innerHTML = html;
        body.appendChild(row);
        body.scrollTop = body.scrollHeight;
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

    function openChatLightbox(url) {
        document.getElementById('skjLightboxImg').src = url;
        document.getElementById('skjChatLightbox').style.display = 'flex';
    }

    function closeChatLightbox() {
        document.getElementById('skjChatLightbox').style.display = 'none';
    }

    const THAI_MONTHS_SHORT = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

    function parseSafeChatDate(input) {
        if (!input) return null;
        if (input instanceof Date) return input;
        if (typeof input !== 'string') return null;

        // Try direct parse (works for ISO strings like 2026-09-03T10:33:33.799Z)
        let d = new Date(input);
        if (!isNaN(d.getTime())) return d;

        // Try MySQL "YYYY-MM-DD HH:mm:ss" -> replace space with 'T'
        d = new Date(input.replace(' ', 'T'));
        if (!isNaN(d.getTime())) return d;

        // Fallback: replace dashes with slashes only if no 'T'
        if (!input.includes('T')) {
            d = new Date(input.replace(/-/g, '/'));
            if (!isNaN(d.getTime())) return d;
        }

        return null;
    }

    function formatChatTime(dateInput) {
        if (!dateInput) return '';
        const d = parseSafeChatDate(dateInput);
        if (!d) return dateInput;

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
        const timePartShort = `${hours}:${minutes}`;

        if (isToday) {
            return `${timePart}`;
        } else if (isYesterday) {
            return `เมื่อวาน ${timePartShort}`;
        } else if (isThisYear) {
            return `${day} ${month} ${timePartShort}`;
        } else {
            return `${day} ${month} ${thaiYearShort} ${timePartShort}`;
        }
    }
</script>
