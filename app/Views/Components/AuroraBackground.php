<!-- ================================================================= -->
<!-- SKJ AURORA ANIMATED BACKGROUND COMPONENT                          -->
<!-- พื้นหลังออโรร่า เคลื่อนไหวลื่นไหล 60 FPS ผสานละอองดาวประกายแสง     -->
<!-- ================================================================= -->

<div id="skjAuroraContainer" class="skj-aurora-wrapper" aria-hidden="true">
    <!-- 1. Ambient Pulsing Radial Gradient Overlay -->
    <div class="aurora-radial-pulse"></div>

    <!-- 2. Colorful Glowing Blobs (Pink, Blue, Purple, Teal) -->
    <div class="aurora-blob-layer">
        <!-- Pink Blob (สวนกุหลาบ ชมพู) -->
        <div class="aurora-blob blob-pink"></div>
        <!-- Blue Blob (สวนกุหลาบ ฟ้า) -->
        <div class="aurora-blob blob-blue"></div>
        <!-- Purple Blob (ออโรร่า ม่วง) -->
        <div class="aurora-blob blob-purple"></div>
        <!-- Cyan/Teal Blob (ประกายฟ้าน้ำทะเล) -->
        <div class="aurora-blob blob-teal"></div>
    </div>

    <!-- 3. Twinkling Stars & Particles Canvas (Lightweight, 60fps) -->
    <canvas id="auroraStarCanvas" class="aurora-canvas-stars"></canvas>
</div>

<style>
/* ==========================================================================
   AURORA BACKGROUND STYLES
   ========================================================================== */
:root {
    --aurora-pink: rgba(251, 126, 156, 0.28);
    --aurora-blue: rgba(36, 159, 253, 0.28);
    --aurora-purple: rgba(168, 85, 247, 0.22);
    --aurora-teal: rgba(45, 212, 191, 0.20);
}

.skj-aurora-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    max-width: 100%;
    z-index: -1;
    pointer-events: none;
    overflow: hidden;
    background: #ffffff; /* ฐานสีขาวสะอาดตา สำหรับเว็บไซต์โรงเรียน */
}

/* 1. Pulsing Ambient Layer */
.aurora-radial-pulse {
    position: absolute;
    inset: 0;
    background-image: 
        radial-gradient(ellipse 60% 50% at 20% 20%, var(--aurora-pink) 0%, transparent 70%),
        radial-gradient(ellipse 55% 45% at 80% 80%, var(--aurora-blue) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 50% 50%, var(--aurora-purple) 0%, transparent 75%);
    opacity: 0.65;
    animation: auroraPulse 12s ease-in-out infinite alternate;
    will-change: opacity, transform;
}

@keyframes auroraPulse {
    0% {
        opacity: 0.5;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.04);
    }
    100% {
        opacity: 0.55;
        transform: scale(1);
    }
}

/* 2. Floating Aurora Blobs */
.aurora-blob-layer {
    position: absolute;
    inset: 0;
    mix-blend-mode: multiply;
    filter: blur(80px);
    opacity: 0.75;
}

.aurora-blob {
    position: absolute;
    border-radius: 50%;
    will-change: transform;
    pointer-events: none;
}

/* Blob 1: Pink (Top-Left to Center) */
.blob-pink {
    top: -15%;
    left: -15%;
    width: 55vw;
    height: 55vw;
    max-width: 680px;
    max-height: 680px;
    background: radial-gradient(circle, rgba(251, 126, 156, 0.45) 0%, rgba(251, 126, 156, 0.05) 70%, transparent 100%);
    animation: floatPink 24s ease-in-out infinite alternate;
}

@keyframes floatPink {
    0% {
        transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
    }
    50% {
        transform: translate3d(80px, 60px, 0) scale(1.2) rotate(45deg);
    }
    100% {
        transform: translate3d(-40px, 90px, 0) scale(0.95) rotate(-30deg);
    }
}

/* Blob 2: Blue (Bottom-Right to Center) */
.blob-blue {
    bottom: -15%;
    right: -15%;
    width: 60vw;
    height: 60vw;
    max-width: 720px;
    max-height: 720px;
    background: radial-gradient(circle, rgba(36, 159, 253, 0.45) 0%, rgba(36, 159, 253, 0.05) 70%, transparent 100%);
    animation: floatBlue 28s ease-in-out infinite alternate;
}

@keyframes floatBlue {
    0% {
        transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
    }
    50% {
        transform: translate3d(-90px, -70px, 0) scale(1.18) rotate(-40deg);
    }
    100% {
        transform: translate3d(50px, -100px, 0) scale(0.92) rotate(25deg);
    }
}

/* Blob 3: Purple (Center Accent) */
.blob-purple {
    top: 30%;
    left: 45%;
    width: 45vw;
    height: 45vw;
    max-width: 550px;
    max-height: 550px;
    background: radial-gradient(circle, rgba(168, 85, 247, 0.35) 0%, rgba(168, 85, 247, 0.04) 70%, transparent 100%);
    animation: floatPurple 32s ease-in-out infinite alternate;
}

@keyframes floatPurple {
    0% {
        transform: translate3d(-30px, 40px, 0) scale(1);
    }
    50% {
        transform: translate3d(60px, -50px, 0) scale(1.25);
    }
    100% {
        transform: translate3d(-70px, 20px, 0) scale(0.9);
    }
}

/* Blob 4: Teal (Bottom-Left Ambient) */
.blob-teal {
    bottom: 5%;
    left: 5%;
    width: 40vw;
    height: 40vw;
    max-width: 480px;
    max-height: 480px;
    background: radial-gradient(circle, rgba(45, 212, 191, 0.32) 0%, rgba(45, 212, 191, 0.03) 70%, transparent 100%);
    animation: floatTeal 26s ease-in-out infinite alternate;
}

@keyframes floatTeal {
    0% {
        transform: translate3d(0, 0, 0) scale(0.95);
    }
    50% {
        transform: translate3d(70px, -60px, 0) scale(1.15);
    }
    100% {
        transform: translate3d(-40px, -40px, 0) scale(1.02);
    }
}

/* 3. Twinkling Stars Canvas */
.aurora-canvas-stars {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    opacity: 0.7;
}

/* Accessibility: Respect Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .aurora-radial-pulse,
    .aurora-blob {
        animation: none !important;
    }
}

/* ==========================================================================
   TRANSLUCENT / GLASSMORPHIC SECTIONS (Make Aurora Shine Through)
   ========================================================================== */
html, body {
    background-color: transparent !important;
}

.hero-carousel-wrapper,
.skj-spotlight-section,
.skj-group-section {
    background: transparent !important;
}

/* ปรับ Sections ต่างๆ ให้โปร่งแสงเพื่อแสดงมิติของอนิเมชั่นพื้นหลัง */
.welcome-section,
.stdio-section,
.news-section,
.spotlight-carousel,
.board-container {
    background-color: rgba(255, 255, 255, 0.45) !important;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    transition: background-color 0.4s ease, backdrop-filter 0.4s ease;
}

.recommend-section {
    background: linear-gradient(rgba(255, 255, 255, 0.72), rgba(255, 255, 255, 0.80)), url('<?= base_url('uploads/background/campus_view_16.jpg') ?>') !important;
    background-attachment: fixed !important;
    background-position: center !important;
    background-size: cover !important;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.news-section {
    background-color: rgba(255, 250, 250, 0.45) !important;
}

.stdio-section {
    background: rgba(255, 255, 255, 0.42) !important;
}

.spotlight-carousel {
    background-color: rgba(248, 249, 250, 0.40) !important;
}

.board-container {
    background-color: rgba(248, 250, 255, 0.48) !important;
}

/* การ์ดเนื้อหาคงความคมชัดและอ่านง่ายด้วย Glassmorphic Effect */
.skj-news-card,
.stat-box-modern {
    background-color: rgba(255, 255, 255, 0.90) !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}
</style>

<script>
(function() {
    'use strict';

    // Canvas Twinkling Particles
    function initAuroraStars() {
        const canvas = document.getElementById('auroraStarCanvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        let width = 0;
        let height = 0;
        let animationFrameId = null;
        let isPageVisible = true;

        const STAR_COUNT = window.innerWidth < 768 ? 35 : 65;
        const stars = [];

        // Colors for twinkling stars (white, soft pink, soft blue)
        const starColors = [
            '255, 255, 255',
            '251, 126, 156',
            '36, 159, 253',
            '168, 85, 247'
        ];

        function resizeCanvas() {
            width = window.innerWidth;
            height = window.innerHeight;
            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            canvas.width = width * dpr;
            canvas.height = height * dpr;
            ctx.scale(dpr, dpr);
        }

        class Star {
            constructor() {
                this.reset(true);
            }

            reset(initial = false) {
                this.x = Math.random() * width;
                this.y = initial ? Math.random() * height : height + 10;
                this.size = Math.random() * 1.8 + 0.8;
                this.maxAlpha = Math.random() * 0.65 + 0.25;
                this.alpha = initial ? Math.random() * this.maxAlpha : 0;
                this.speedY = Math.random() * 0.25 + 0.08;
                this.speedX = (Math.random() - 0.5) * 0.15;
                this.pulseSpeed = Math.random() * 0.02 + 0.008;
                this.pulseFactor = Math.random() * Math.PI * 2;
                this.color = starColors[Math.floor(Math.random() * starColors.length)];
            }

            update() {
                this.y -= this.speedY;
                this.x += this.speedX;
                this.pulseFactor += this.pulseSpeed;
                this.alpha = ((Math.sin(this.pulseFactor) + 1) / 2) * this.maxAlpha;

                // Reset when drifted out of viewport
                if (this.y < -10 || this.x < -10 || this.x > width + 10) {
                    this.reset(false);
                }
            }

            draw() {
                ctx.save();
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${this.color}, ${this.alpha})`;
                ctx.shadowColor = `rgba(${this.color}, 0.5)`;
                ctx.shadowBlur = this.size * 3;
                ctx.fill();
                ctx.restore();
            }
        }

        function createStars() {
            stars.length = 0;
            for (let i = 0; i < STAR_COUNT; i++) {
                stars.push(new Star());
            }
        }

        function animate() {
            if (!isPageVisible) return;

            ctx.clearRect(0, 0, width, height);

            for (let i = 0; i < stars.length; i++) {
                stars[i].update();
                stars[i].draw();
            }

            animationFrameId = requestAnimationFrame(animate);
        }

        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                resizeCanvas();
            }, 200);
        });

        // Pause animation when tab is inactive to save battery and CPU
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                isPageVisible = false;
                if (animationFrameId) cancelAnimationFrame(animationFrameId);
            } else {
                isPageVisible = true;
                animate();
            }
        });

        resizeCanvas();
        createStars();
        animate();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAuroraStars);
    } else {
        initAuroraStars();
    }
})();
</script>
