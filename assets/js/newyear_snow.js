document.addEventListener('DOMContentLoaded', () => {
    // 1. Containers
    const snowContainer = document.createElement('div');
    snowContainer.id = 'snow-container';
    document.body.appendChild(snowContainer);

    // Snow Accumulation at Bottom
    const snowGround = document.createElement('div');
    snowGround.className = 'snow-ground';
    const snowPileTop = document.createElement('div');
    snowPileTop.className = 'snow-pile-top';
    snowGround.appendChild(snowPileTop);
    document.body.appendChild(snowGround);

    // Detect mobile for performance optimization
    const isMobile = window.innerWidth <= 768;

    // Check for session storage to show greeting only once per session
    const sessionKey = 'skj_newyear_2569_intro';
    const showIntro = !sessionStorage.getItem(sessionKey);

    if (showIntro) {
        const festiveOverlay = document.createElement('div');
        festiveOverlay.className = 'festive-overlay';
        festiveOverlay.innerHTML = `
            <canvas id="firework-canvas"></canvas>
            <div class="new-year-greeting">
                <h1 class="greeting-text">🎊 สวัสดีปีใหม่ 2569 🎊</h1>
                <p class="blessing-text">🎄 ขอให้มีความสุข สุขภาพแข็งแรง ตลอดปีและตลอดไป 🎁</p>
                <p class="blessing-text-sub">และขอให้เดินทางโดยสวัสดิภาพ</p>
                <p class="school-text">ด้วยความปรารถนาดีจาก<br>โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
            </div>
            <div class="intro-close-countdown text-secondary">หน้านี้จะปิดอัตโนมัติในอีก <span id="intro-cd-value">10</span> วินาที...</div>
            <div class="festive-intro-snow">
                <div class="intro-snow-heap"></div>
                <div class="intro-snow-heap-2"></div>
            </div>
        `;
        document.body.appendChild(festiveOverlay);

        // Add floating festive decorations
        const festiveIcons = ['⛄', '🎄', '🎁', '🎅', '❄️', '🦌', '🔔', '⭐'];
        const positions = [
            { left: '5%', top: '15%' },
            { left: '90%', top: '20%' },
            { left: '8%', top: '70%' },
            { left: '88%', top: '75%' },
            { left: '15%', top: '40%' },
            { left: '85%', top: '45%' },
            { left: '50%', top: '85%' },
            { left: '3%', top: '90%' }
        ];
        
        festiveIcons.forEach((icon, i) => {
            const el = document.createElement('span');
            el.className = 'festive-float';
            el.textContent = icon;
            el.style.left = positions[i].left;
            el.style.top = positions[i].top;
            el.style.animationDelay = `${i * 0.5}s`;
            festiveOverlay.appendChild(el);
        });

        // 3. FIREWORKS ENGINE DEF
        const canvas = document.getElementById('firework-canvas');
        const ctx = canvas.getContext('2d');
        let fire_particles = [];

        function resize_canvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize_canvas);
        resize_canvas();

        class FireworkParticle {
            constructor(x, y, color, size) {
                this.x = x;
                this.y = y;
                this.color = color;
                this.size = size;
                const angle = Math.random() * Math.PI * 2;
                const speed = Math.random() * (isMobile ? 3.5 : 5) + 2;
                this.vx = Math.cos(angle) * speed;
                this.vy = Math.sin(angle) * speed;
                this.alpha = 1;
            }
            update() {
                this.vx *= 0.96;
                this.vy *= 0.96;
                this.vy += 0.05;
                this.x += this.vx;
                this.y += this.vy;
                this.alpha -= isMobile ? 0.02 : 0.012; 
            }
            draw() {
                ctx.globalAlpha = this.alpha;
                ctx.fillStyle = this.color;
                if (isMobile) {
                    ctx.fillRect(this.x, this.y, this.size, this.size);
                } else {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
        }

        function createFirework(x, y) {
            const colors = ['#ffd700', '#ff4d4d', '#00bfff', '#32cd32', '#ff69b4', '#ffffff', '#ff8c00'];
            const color = colors[Math.floor(Math.random() * colors.length)];
            // PC: 100 particles, Mobile: 35 for "Big" look
            const count = isMobile ? 35 : 100;
            for (let i = 0; i < count; i++) {
                // Slightly larger particles on mobile for impact
                const size = Math.random() * (isMobile ? 2.5 : 2) + 1;
                fire_particles.push(new FireworkParticle(x, y, color, size));
            }
        }

        function launchFirework() {
            const x = Math.random() * canvas.width * 0.8 + canvas.width * 0.1;
            const y = Math.random() * canvas.height * 0.4 + canvas.height * 0.1;
            createFirework(x, y);
        }

        let animationId;
        function animate_fireworks() {
            if (!document.querySelector('.festive-overlay')) {
                cancelAnimationFrame(animationId);
                return;
            }

            ctx.globalCompositeOperation = 'destination-out';
            ctx.fillStyle = isMobile ? 'rgba(0, 0, 0, 0.4)' : 'rgba(0, 0, 0, 0.25)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.globalCompositeOperation = 'source-over';

            fire_particles = fire_particles.filter(p => p.alpha > 0.1);
            fire_particles.forEach(p => {
                p.update();
                p.draw();
            });

            animationId = requestAnimationFrame(animate_fireworks);
        }

        // Trigger Show
        setTimeout(() => {
            festiveOverlay.classList.add('show');
            animate_fireworks();

            // PC: Fast (600ms), Mobile: Slower (3000ms) to allow big bursts
            const launchInterval = isMobile ? 3000 : 600;
            const showDuration = 7000; // Close after 7 seconds 
            const maxParticlesLimit = isMobile ? 120 : 800; 

            // Initial burst: 3 big ones for mobile
            const introBurstCount = isMobile ? 3 : 5;
            for (let i = 0; i < introBurstCount; i++) {
                setTimeout(() => launchFirework(), i * 600);
            }

            const fireworkTimer = setInterval(() => {
                if (fire_particles.length < maxParticlesLimit) {
                    launchFirework();
                    // Double burst for PC
                    if (!isMobile && Math.random() > 0.5) {
                        setTimeout(() => launchFirework(), 200);
                    }
                }
            }, launchInterval);

            const introCdValue = document.getElementById('intro-cd-value');
            let timeLeft = Math.floor(showDuration / 1000);
            if (introCdValue) introCdValue.textContent = timeLeft;

            const closeSubTimer = setInterval(() => {
                timeLeft--;
                if (introCdValue) introCdValue.textContent = Math.max(0, timeLeft);
            }, 1000);

            setTimeout(() => {
                clearInterval(fireworkTimer);
                clearInterval(closeSubTimer);
                if (!isMobile) {
                    // Grand finale for PC
                    for (let i = 0; i < 10; i++) {
                        setTimeout(() => launchFirework(), i * 150);
                    }
                }
                setTimeout(() => {
                    cancelAnimationFrame(animationId);
                    festiveOverlay.classList.remove('show');
                    setTimeout(() => festiveOverlay.remove(), 1000);
                }, 2000);
            }, showDuration);

            sessionStorage.setItem(sessionKey, 'true');
        }, 800);
    }

    // 2. Fairy Lights
    const lightsContainer = document.createElement('ul');
    lightsContainer.className = 'fairy-lights';
    const lightColors = ['red', 'gold', 'blue', 'green'];
    const lightCount = Math.floor(window.innerWidth / (isMobile ? 60 : 40));
    for (let i = 0; i < lightCount; i++) {
        const li = document.createElement('li');
        li.className = `light-bulb light-${lightColors[i % lightColors.length]}`;
        lightsContainer.appendChild(li);
    }
    document.body.appendChild(lightsContainer);

    // 5. Snow Spawning
    const snowflakeChars = ['❄', '❅', '❆', '•'];
    let snowCount = 0;
    const maxFallingSnow = isMobile ? 15 : 100; // PC: more snow
    const landedSnowLimit = isMobile ? 60 : 1000; // PC: huge pile

    setInterval(() => {
        if (document.hidden || snowCount >= maxFallingSnow) return;
        
        const snowflake = document.createElement('div');
        snowflake.classList.add('snowflake');
        snowflake.textContent = snowflakeChars[Math.floor(Math.random() * snowflakeChars.length)];
        
        const durationSec = Math.random() * 5 + 5;
        const leftPos = Math.random() * 100;
        
        snowflake.style.fontSize = (Math.random() * 10 + 12) + 'px';
        snowflake.style.left = leftPos + 'vw';
        snowflake.style.animationDuration = durationSec + 's';
        snowflake.style.opacity = Math.random() * 0.6 + 0.3;
        
        snowContainer.appendChild(snowflake);
        snowCount++;

        setTimeout(() => {
            if (snowGround.children.length < landedSnowLimit) {
                snowflake.classList.add('landed');
                snowflake.style.left = leftPos + 'vw';
                snowflake.style.bottom = (Math.random() * (isMobile ? 20 : 35)) + 'px';
                snowflake.style.transform = `rotate(${Math.random() * 360}deg)`;
                
                snowGround.appendChild(snowflake);
                snowCount--;

                setTimeout(() => {
                    snowflake.style.opacity = '0';
                    setTimeout(() => {
                        snowflake.remove();
                    }, 5000);
                }, (isMobile ? 10000 : 40000) + (Math.random() * 20000));
            } else {
                snowflake.remove();
                snowCount--;
            }
        }, durationSec * 950); 
    }, isMobile ? 1200 : 200); 

    // 6. Navbar Countdown Logic
    const countdownDate = new Date("January 1, 2026 00:00:00").getTime();
    const updateCountdown = () => {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        if (distance < 0) {
            const navCd = document.getElementById("nav-countdown");
            if (navCd) {
                navCd.innerHTML = "<span class='cd-label fw-bold'>🎊 HAPPY NEW YEAR 2026 🎊</span>";
                navCd.style.background = "linear-gradient(45deg, #ffd700, #ff4d4d)";
            }
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const elDays = document.getElementById("cd-days");
        const elHours = document.getElementById("cd-hours");
        const elMins = document.getElementById("cd-mins");
        const elSecs = document.getElementById("cd-secs");

        if (elDays) elDays.innerText = String(days).padStart(2, '0');
        if (elHours) elHours.innerText = String(hours).padStart(2, '0');
        if (elMins) elMins.innerText = String(minutes).padStart(2, '0');
        if (elSecs) elSecs.innerText = String(seconds).padStart(2, '0');
    };

    if (document.getElementById("nav-countdown")) {
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
});
