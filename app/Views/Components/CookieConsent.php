<!-- ================================================================= -->
<!-- SKJ COOKIE CONSENT SYSTEM (PDPA COMPLIANT)                        -->
<!-- สอดคล้องกับ พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562 (PDPA)       -->
<!-- ================================================================= -->

<!-- 1. Floating Cookie Consent Banner -->
<div id="skjCookieBanner" class="skj-cookie-banner shadow-lg" style="display: none;" role="dialog" aria-live="polite" aria-label="การอนุญาตใช้งาน Cookies">
    <div class="skj-cookie-card">
        <!-- Header -->
        <div class="skj-cookie-header d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <img src="<?= base_url('assets/img/logo/Logo-nav.png') ?>" alt="SKJ Logo" class="skj-cookie-logo">
                <div>
                    <h6 class="mb-0 fw-bold text-dark skj-cookie-title">การใช้งาน Cookies</h6>
                    <small class="text-muted skj-cookie-sub">รร.สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</small>
                </div>
            </div>
            <button type="button" class="btn-close skj-cookie-btn-close" id="skjBtnCookieDismiss" aria-label="ปิด"></button>
        </div>

        <!-- Body Text -->
        <div class="skj-cookie-body mb-2">
            <p class="text-secondary small mb-0 skj-cookie-desc">
                เว็บไซต์นี้ใช้คุกกี้เพื่อมอบประสบการณ์การใช้งานที่ดีที่สุด และพัฒนาประสิทธิภาพการให้บริการ ท่านสามารถศึกษารายละเอียดได้ที่ลิงก์ด้านล่าง
            </p>
        </div>

        <!-- Actions -->
        <div class="skj-cookie-actions d-flex flex-column gap-2 mb-2">
            <button type="button" class="btn btn-primary w-100 fw-bold py-1.5 shadow-sm" id="skjBtnCookieAcceptAll">
                <i class="bi bi-check-circle me-1"></i> ยอมรับทั้งหมด
            </button>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary flex-fill py-1" id="skjBtnCookieRejectAll">
                    ปฏิเสธ
                </button>
                <button type="button" class="btn btn-light border flex-fill py-1 text-dark" id="skjBtnCookieSettings">
                    <i class="bi bi-sliders me-1"></i> ดูรายละเอียด
                </button>
            </div>
        </div>

        <!-- Links to Policy -->
        <div class="skj-cookie-links text-center small pt-1 border-top">
            <a href="javascript:void(0);" class="text-decoration-underline text-primary me-2" id="skjLinkCookiePolicy">
                นโยบายคุกกี้
            </a>
            <span class="text-muted">·</span>
            <a href="javascript:void(0);" class="text-decoration-underline text-primary ms-2" id="skjLinkPrivacyPolicy">
                นโยบายความเป็นส่วนตัว
            </a>
        </div>
    </div>
</div>


<!-- 3. Modal: Cookie Settings & Preferences (ตั้งค่าคุกกี้แต่ละหมวดหมู่) -->
<div class="modal fade" id="skjCookieSettingsModal" tabindex="-1" aria-labelledby="skjCookieSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
            <div class="modal-header border-bottom py-3 px-4 bg-light">
                <div class="d-flex align-items-center gap-2">
                    <img src="<?= base_url('assets/img/logo/Logo-nav.png') ?>" alt="Logo" style="height: 32px;">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="skjCookieSettingsModalLabel">ศูนย์จัดการความยินยอมคุกกี้ (Cookie Preferences)</h5>
                        <small class="text-muted">ปรับแต่งตัวเลือกคุกกี้ที่คุณอนุญาตให้ใช้งานบนเว็บไซต์</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-secondary small mb-4">
                    เราเคารพในสิทธิความเป็นส่วนตัวของคุณ คุณสามารถเลือกอนุญาตหรือไม่อนุญาตการใช้งานคุกกี้บางประเภทได้ตามความต้องการ การปิดใช้งานคุกกี้บางประเภทอาจส่งผลต่อการทำงานและการแสดงผลบางส่วนของเว็บไซต์
                </p>

                <!-- Category 1: Necessary -->
                <div class="cookie-preference-item p-3 rounded-3 border mb-3 bg-light-subtle">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="fw-bold mb-0 text-dark">1. คุกกี้ที่จำเป็นอย่างยิ่ง (Strictly Necessary Cookies)</h6>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">เปิดตลอดเวลา (จำเป็น)</span>
                            </div>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">
                                คุกกี้ที่มีความจำเป็นสำหรับการทำงานพื้นฐานและการรักษาความปลอดภัยของเว็บไซต์ เช่น การนำทางหน้าเว็บ การตรวจสอบสิทธิ์ และการเข้าถึงระบบ โดยไม่สามารถปิดการใช้งานได้
                            </p>
                        </div>
                        <div class="form-check form-switch fs-5 ms-2">
                            <input class="form-check-input" type="checkbox" id="cookieSwitchNecessary" checked disabled>
                        </div>
                    </div>
                </div>

                <!-- Category 2: Analytics -->
                <div class="cookie-preference-item p-3 rounded-3 border mb-3">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="fw-bold mb-0 text-dark">2. คุกกี้เพื่อการวิเคราะห์และสถิติ (Analytical & Performance Cookies)</h6>
                            </div>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">
                                ช่วยให้โรงเรียนเข้าใจลักษณะการใช้งานเว็บไซต์ของผู้เข้าชม เช่น การนับจำนวนผู้เข้าชม หน้าข่าวสารหรือข้อมูลที่มีการเข้าถึงบ่อย เพื่อนำมาวิเคราะห์และปรับปรุงประสิทธิภาพการให้บริการ
                            </p>
                        </div>
                        <div class="form-check form-switch fs-5 ms-2">
                            <input class="form-check-input" type="checkbox" id="cookieSwitchAnalytics" checked>
                        </div>
                    </div>
                </div>

                <!-- Category 3: Functional -->
                <div class="cookie-preference-item p-3 rounded-3 border mb-3">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="fw-bold mb-0 text-dark">3. คุกกี้เพื่อการทำงานและปรับแต่ง (Functional Cookies)</h6>
                            </div>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">
                                ช่วยจดจำตัวเลือกและการตั้งค่าของผู้ใช้ เช่น การตั้งค่าการแสดงผล การจดจำโหมดการใช้งาน เพื่ออำนวยความสะดวกให้ผู้ใช้งานไม่ต้องตั้งค่าใหม่ทุกครั้งที่กลับมาใช้งาน
                            </p>
                        </div>
                        <div class="form-check form-switch fs-5 ms-2">
                            <input class="form-check-input" type="checkbox" id="cookieSwitchFunctional" checked>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3 d-flex flex-wrap justify-content-between gap-2">
                <button type="button" class="btn btn-outline-secondary" id="skjBtnModalRejectNonEssential">
                    ปฏิเสธทั้งหมด (ใช้เฉพาะที่จำเป็น)
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary" id="skjBtnModalSavePreferences">
                        บันทึกการตั้งค่าของฉัน
                    </button>
                    <button type="button" class="btn btn-primary fw-bold" id="skjBtnModalAcceptAll">
                        ยอมรับทั้งหมด
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. Modal: PDPA Privacy & Cookie Policy (อ่านนโยบายฉบับเต็ม) -->
<div class="modal fade" id="skjCookiePolicyModal" tabindex="-1" aria-labelledby="skjCookiePolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
            <div class="modal-header border-bottom py-3 px-4 bg-light">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-lock fs-3 text-primary"></i>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="skjCookiePolicyModalLabel">นโยบายการคุ้มครองข้อมูลส่วนบุคคลและคุกกี้</h5>
                        <small class="text-muted">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="max-height: 65vh; font-size: 0.9rem; line-height: 1.7;">
                <!-- Tabs for Policy -->
                <ul class="nav nav-pills mb-3 border-bottom pb-2" id="policyTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="tab-cookie-policy" data-bs-toggle="pill" data-bs-target="#content-cookie-policy" type="button" role="tab">
                            <i class="bi bi-cookie me-1"></i> นโยบายการใช้คุกกี้ (Cookie Policy)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="tab-privacy-policy" data-bs-toggle="pill" data-bs-target="#content-privacy-policy" type="button" role="tab">
                            <i class="bi bi-shield-check me-1"></i> นโยบายความเป็นส่วนตัว (Privacy Policy)
                        </button>
                    </li>
                </ul>

                <div class="tab-content text-secondary" id="policyTabsContent">
                    <!-- Tab 1: Cookie Policy -->
                    <div class="tab-pane fade show active" id="content-cookie-policy" role="tabpanel">
                        <h6 class="fw-bold text-dark">1. บทนำ</h6>
                        <p>โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ("โรงเรียน") จัดทำนโยบายการใช้คุกกี้นี้ขึ้น เพื่ออธิบายให้ทราบถึงความหมาย ลักษณะการทำงาน วัตถุประสงค์ และการควบคุมการใช้งานคุกกี้บนเว็บไซต์ของโรงเรียน เพื่อให้เป็นไปตาม พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562 (PDPA)</p>

                        <h6 class="fw-bold text-dark mt-3">2. คุกกี้คืออะไร?</h6>
                        <p>คุกกี้ (Cookies) คือไฟล์ข้อความขนาดเล็กที่ถูกบันทึกลงในคอมพิวเตอร์หรืออุปกรณ์สื่อสารที่ใช้งานอินเทอร์เน็ตของท่าน เมื่อท่านเข้าชมเว็บไซต์ ทำหน้าที่จดจำข้อมูลการเข้าชม การตั้งค่า และช่วยให้เว็บไซต์สามารถทำงานได้อย่างมีประสิทธิภาพและปลอดภัยยิ่งขึ้น</p>

                        <h6 class="fw-bold text-dark mt-3">3. ประเภทของคุกกี้ที่เราใช้งาน</h6>
                        <ul>
                            <li><strong>คุกกี้ที่จำเป็นอย่างยิ่ง (Strictly Necessary Cookies):</strong> จำเป็นสำหรับการทำงานของเว็บไซต์ เช่น การรักษาความปลอดภัย การตรวจสอบสิทธิ์เข้าสู่ระบบ</li>
                            <li><strong>คุกกี้เพื่อการวิเคราะห์และวัดผล (Analytics Cookies):</strong> ช่วยให้โรงเรียนทราบถึงพฤติกรรมการเข้าชมเว็บไซต์ เช่น สถิติการเข้าดูหน้าข่าวสาร เพื่อพัฒนาการให้บริการ</li>
                            <li><strong>คุกกี้เพื่อการใช้งาน (Functional Cookies):</strong> ช่วยจดจำการตั้งค่าของท่าน เช่น ภาษาหรือการกำหนดลักษณะ เพื่อความสะดวกในการใช้งานครั้งต่อไป</li>
                        </ul>

                        <h6 class="fw-bold text-dark mt-3">4. การจัดการและการถอนความยินยอมคุกกี้</h6>
                        <p>ท่านสามารถเปลี่ยนแปลงการตั้งค่าคุกกี้ หรือเพิกถอนความยินยอมได้ตลอดเวลา ผ่านปุ่ม "จัดการคุกกี้" หรือเมนู "ตั้งค่าคุกกี้" ที่ปรากฏบริเวณส่วนล่างสุดของเว็บไซต์ (Footer)</p>
                    </div>

                    <!-- Tab 2: Privacy Policy -->
                    <div class="tab-pane fade" id="content-privacy-policy" role="tabpanel">
                        <h6 class="fw-bold text-dark">1. การเก็บรวบรวมข้อมูลส่วนบุคคล</h6>
                        <p>โรงเรียนจะเก็บรวบรวมข้อมูลส่วนบุคคลอย่างจำกัดและเท่าที่จำเป็นตามวัตถุประสงค์ของการจัดการศึกษา การให้บริการข้อมูลข่าวสารทางวิชาการ และกิจกรรมของโรงเรียน โดยเป็นไปตามกรอบของ พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562</p>

                        <h6 class="fw-bold text-dark mt-3">2. วัตถุประสงค์ในการประมวลผลข้อมูล</h6>
                        <ul>
                            <li>เพื่อให้บริการด้านการศึกษา ข้อมูลข่าวสาร และกิจกรรมของโรงเรียนแก่นักเรียน ผู้ปกครอง และบุคลากร</li>
                            <li>เพื่อการติดต่อสื่อสาร การยืนยันตัวตน และการรักษาความปลอดภัยของระบบสารสนเทศ</li>
                            <li>เพื่อการพัฒนาและปรับปรุงคุณภาพการให้บริการของเว็บไซต์โรงเรียน</li>
                        </ul>

                        <h6 class="fw-bold text-dark mt-3">3. สิทธิของเจ้าของข้อมูลส่วนบุคคล</h6>
                        <p>ท่านมีสิทธิในการขอเข้าถึง ขอแก้ไข ขอโอนย้าย คัดค้าน หรือขอให้ลบข้อมูลส่วนบุคคลของท่าน รวมถึงการถอนความยินยอมที่เคยให้ไว้ ทั้งนี้ภายใต้เงื่อนไขที่กฎหมายกำหนด</p>

                        <h6 class="fw-bold text-dark mt-3">4. ช่องทางการติดต่อ</h6>
                        <p class="mb-0">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์<br>
                        160 หมู่ 1 ต.นครสวรรค์ออก อ.เมือง จ.นครสวรรค์ 60000<br>
                        โทรศัพท์: 056-200-765 | อีเมล: skjns160@skj.ac.th</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-2 justify-content-between">
                <button type="button" class="btn btn-outline-primary btn-sm" id="skjBtnOpenSettingsFromPolicy">
                    <i class="bi bi-sliders me-1"></i> ปรับแต่งการตั้งค่าคุกกี้
                </button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<!-- 5. Styling (Responsive, Compact, Modern, SKJ Palette) -->
<style>
/* Cookie Consent Banner Styling (Compact & Responsive) */
.skj-cookie-banner {
    position: fixed;
    bottom: 20px;
    left: 20px;
    max-width: 360px;
    width: calc(100% - 40px);
    z-index: 10500;
    animation: skjCookieSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes skjCookieSlideUp {
    from {
        opacity: 0;
        transform: translateY(25px) scale(0.98);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.skj-cookie-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 15px 16px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 12px 30px -4px rgba(10, 37, 64, 0.18), 0 0 0 1px rgba(0, 0, 0, 0.03);
}

.skj-cookie-logo {
    height: 30px;
    width: auto;
    object-fit: contain;
}

.skj-cookie-title {
    font-size: 0.92rem;
    line-height: 1.2;
}

.skj-cookie-sub {
    font-size: 0.72rem;
    display: block;
}

.skj-cookie-desc {
    font-size: 0.8rem !important;
    line-height: 1.55 !important;
}

.skj-cookie-actions .btn {
    border-radius: 8px;
    font-size: 0.82rem;
    transition: all 0.2s ease;
}

.skj-cookie-actions .btn-primary {
    background: linear-gradient(135deg, #1b68b3 0%, #15518c 100%);
    border: none;
}

.skj-cookie-actions .btn-primary:hover {
    background: linear-gradient(135deg, #15518c 0%, #0d3b66 100%);
    transform: translateY(-1px);
}

.skj-cookie-links a {
    font-size: 0.75rem;
}


.cookie-preference-item {
    transition: background-color 0.2s ease;
}

.cookie-preference-item:hover {
    background-color: #f8f9fa;
}

/* Mobile / Tablet Optimization (Elevate above Mobile Bottom Navigation Bar) */
@media (max-width: 991.98px) {
    .skj-cookie-banner {
        /* ยกแบนเนอร์ให้ลอยพ้น Mobile Bottom Navbar (สูง ~60px + safe area) */
        bottom: calc(70px + env(safe-area-inset-bottom, 0px));
        right: 12px;
        left: 12px;
        width: auto;
        max-width: none;
    }
    
    .skj-cookie-card {
        padding: 13px 14px;
        border-radius: 12px;
    }

    .skj-cookie-logo {
        height: 26px;
    }

    .skj-cookie-title {
        font-size: 0.88rem;
    }

    .skj-cookie-desc {
        font-size: 0.78rem !important;
        line-height: 1.5 !important;
    }

    .skj-cookie-actions .btn {
        font-size: 0.8rem;
        padding-top: 6px;
        padding-bottom: 6px;
    }


}
</style>

<!-- 6. JavaScript Logic (PDPA Compliant Consent Engine) -->
<script>
(function () {
    'use strict';

    const STORAGE_KEY = 'skj_cookie_consent_v1';

    // State helper
    function getConsent() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            return raw ? JSON.parse(raw) : null;
        } catch (e) {
            return null;
        }
    }

    function saveConsent(settings) {
        const payload = {
            necessary: true,
            analytics: !!settings.analytics,
            functional: !!settings.functional,
            status: settings.status || 'custom',
            updatedAt: new Date().toISOString()
        };
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
        } catch (e) {
            console.error('Could not save cookie consent', e);
        }
        applyConsent(payload);
    }

    // Apply or suppress cookies/scripts according to user choice
    function applyConsent(consent) {
        // Dispatch custom event for any analytics or integration script
        window.dispatchEvent(new CustomEvent('skjCookieConsentUpdated', { detail: consent }));

        if (consent.analytics) {
            window['ga-disable-default'] = false;
        } else {
            window['ga-disable-default'] = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const banner = document.getElementById('skjCookieBanner');
        const btnAcceptAll = document.getElementById('skjBtnCookieAcceptAll');
        const btnRejectAll = document.getElementById('skjBtnCookieRejectAll');
        const btnDismiss = document.getElementById('skjBtnCookieDismiss');
        const btnSettings = document.getElementById('skjBtnCookieSettings');
        const linkCookiePolicy = document.getElementById('skjLinkCookiePolicy');
        const linkPrivacyPolicy = document.getElementById('skjLinkPrivacyPolicy');

        // Modal buttons
        const modalEl = document.getElementById('skjCookieSettingsModal');
        const policyModalEl = document.getElementById('skjCookiePolicyModal');
        const switchAnalytics = document.getElementById('cookieSwitchAnalytics');
        const switchFunctional = document.getElementById('cookieSwitchFunctional');
        const btnModalSave = document.getElementById('skjBtnModalSavePreferences');
        const btnModalAcceptAll = document.getElementById('skjBtnModalAcceptAll');
        const btnModalReject = document.getElementById('skjBtnModalRejectNonEssential');
        const btnOpenSettingsFromPolicy = document.getElementById('skjBtnOpenSettingsFromPolicy');

        let settingsModal = null;
        let policyModal = null;

        function getBootstrapModal(el) {
            if (window.bootstrap && window.bootstrap.Modal) {
                return bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
            }
            return null;
        }

        const existingConsent = getConsent();

        if (!existingConsent) {
            // ยังไม่เคยตอบรับ ให้แสดงแบนเนอร์หลังจากหน้าเว็บโหลดเรียบร้อย (delay 600ms)
            setTimeout(function () {
                if (banner) banner.style.display = 'block';
            }, 600);
        } else {
            // เคยตอบรับแล้ว ซ่อนแบนเนอร์
            if (banner) banner.style.display = 'none';
            applyConsent(existingConsent);
        }

        // Action: Accept All
        function handleAcceptAll() {
            saveConsent({ analytics: true, functional: true, status: 'accepted' });
            if (banner) banner.style.display = 'none';
            if (settingsModal) settingsModal.hide();
        }

        // Action: Reject Non-essential
        function handleRejectAll() {
            saveConsent({ analytics: false, functional: false, status: 'rejected' });
            if (banner) banner.style.display = 'none';
            if (settingsModal) settingsModal.hide();
        }

        if (btnAcceptAll) btnAcceptAll.addEventListener('click', handleAcceptAll);
        if (btnModalAcceptAll) btnModalAcceptAll.addEventListener('click', handleAcceptAll);

        if (btnRejectAll) btnRejectAll.addEventListener('click', handleRejectAll);
        if (btnModalReject) btnModalReject.addEventListener('click', handleRejectAll);

        // Action: Dismiss (Close button) -> treat as reject non-essential for safety
        if (btnDismiss) {
            btnDismiss.addEventListener('click', function () {
                handleRejectAll();
            });
        }

        // Open Preferences Modal
        function openSettingsModal() {
            const current = getConsent();
            if (current) {
                if (switchAnalytics) switchAnalytics.checked = !!current.analytics;
                if (switchFunctional) switchFunctional.checked = !!current.functional;
            } else {
                if (switchAnalytics) switchAnalytics.checked = true;
                if (switchFunctional) switchFunctional.checked = true;
            }
            settingsModal = getBootstrapModal(modalEl);
            if (settingsModal) settingsModal.show();
        }

        if (btnSettings) btnSettings.addEventListener('click', openSettingsModal);

        // Save Custom Preferences
        if (btnModalSave) {
            btnModalSave.addEventListener('click', function () {
                const analytics = switchAnalytics ? switchAnalytics.checked : false;
                const functional = switchFunctional ? switchFunctional.checked : false;
                saveConsent({ analytics: analytics, functional: functional, status: 'custom' });
                if (banner) banner.style.display = 'none';
                if (settingsModal) settingsModal.hide();
            });
        }

        // Open Policy Modals
        function openPolicyModal(tabName) {
            policyModal = getBootstrapModal(policyModalEl);
            if (policyModal) {
                if (tabName === 'privacy') {
                    const privacyTab = document.getElementById('tab-privacy-policy');
                    if (privacyTab && window.bootstrap && bootstrap.Tab) {
                        new bootstrap.Tab(privacyTab).show();
                    }
                } else {
                    const cookieTab = document.getElementById('tab-cookie-policy');
                    if (cookieTab && window.bootstrap && bootstrap.Tab) {
                        new bootstrap.Tab(cookieTab).show();
                    }
                }
                policyModal.show();
            }
        }

        if (linkCookiePolicy) {
            linkCookiePolicy.addEventListener('click', function (e) {
                e.preventDefault();
                openPolicyModal('cookie');
            });
        }

        if (linkPrivacyPolicy) {
            linkPrivacyPolicy.addEventListener('click', function (e) {
                e.preventDefault();
                openPolicyModal('privacy');
            });
        }

        if (btnOpenSettingsFromPolicy) {
            btnOpenSettingsFromPolicy.addEventListener('click', function () {
                if (policyModal) policyModal.hide();
                setTimeout(openSettingsModal, 300);
            });
        }

        // Expose global API for external triggers (e.g. Footer Link)
        window.SKJCookieConsent = {
            openSettings: openSettingsModal,
            openPolicy: openPolicyModal,
            reset: function () {
                localStorage.removeItem(STORAGE_KEY);
                if (banner) banner.style.display = 'block';
            }
        };
    });
})();
</script>
