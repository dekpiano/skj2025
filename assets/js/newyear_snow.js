document.addEventListener('DOMContentLoaded', () => {
    // 1. Containers
    const snowContainer = document.createElement('div');
    snowContainer.id = 'snow-container';
    document.body.appendChild(snowContainer);

    const festiveOverlay = document.createElement('div');
    festiveOverlay.className = 'festive-overlay';
    festiveOverlay.innerHTML = `
        <canvas id="firework-canvas"></canvas>
        <div class="new-year-greeting">
            <h1 class="greeting-text">🎊 สวัสดีปีใหม่ 2569 🎊</h1>
            <p class="blessing-text">🎄 ขอให้มีความสุข สุขภาพแข็งแรง ตลอดปีและตลอดไป 🎁</p>
            <p class="blessing-text-sub">และขอให้เดินทางด้วยสวัสดิภาพ</p>
            <p class="school-text">ด้วยความปรารถนาดีจาก<br>โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
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

    // 2. Fairy Lights
    const lightsContainer = document.createElement('ul');
    lightsContainer.className = 'fairy-lights';
    const lightColors = ['red', 'gold', 'blue', 'green'];
    const lightCount = Math.floor(window.innerWidth / 40);
    for (let i = 0; i < lightCount; i++) {
        const li = document.createElement('li');
        li.className = `light-bulb light-${lightColors[i % lightColors.length]}`;
        lightsContainer.appendChild(li);
    }
    document.body.appendChild(lightsContainer);

    // 3. OPTIMIZED BUT IMPRESSIVE FIREWORKS ENGINE
    const canvas = document.getElementById('firework-canvas');
    const ctx = canvas.getContext('2d');
    let particles = [];

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    // Optimized Particle class
    class Particle {
        constructor(x, y, color, size) {
            this.x = x;
            this.y = y;
            this.color = color;
            this.size = size;
            const angle = Math.random() * Math.PI * 2;
            const speed = Math.random() * 5 + 2;
            this.vx = Math.cos(angle) * speed;
            this.vy = Math.sin(angle) * speed;
            this.alpha = 1;
        }
        update() {
            this.vx *= 0.97;
            this.vy *= 0.97;
            this.vy += 0.04;
            this.x += this.vx;
            this.y += this.vy;
            this.alpha -= 0.012;
        }
        draw() {
            ctx.globalAlpha = this.alpha;
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    // Detect mobile for performance optimization
    const isMobile = window.innerWidth <= 768;

    function createFirework(x, y) {
        const colors = ['#ffd700', '#ff4d4d', '#00bfff', '#32cd32', '#ff69b4', '#ffffff', '#ff8c00'];
        const color = colors[Math.floor(Math.random() * colors.length)];
        // Reduce particles on mobile for smooth performance
        const count = isMobile ? 40 : 80;
        for (let i = 0; i < count; i++) {
            const size = Math.random() * 2 + 1;
            particles.push(new Particle(x, y, color, size));
        }
    }

    function launchFirework() {
        const x = Math.random() * canvas.width * 0.8 + canvas.width * 0.1;
        const y = Math.random() * canvas.height * 0.4 + canvas.height * 0.1;
        createFirework(x, y);
    }

    let animationId;
    function animate() {
        // Almost transparent clear for trail effect
        ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Update and draw particles
        ctx.globalAlpha = 1;
        particles = particles.filter(p => p.alpha > 0);
        particles.forEach(p => {
            p.update();
            p.draw();
        });
        ctx.globalAlpha = 1;

        animationId = requestAnimationFrame(animate);
    }

    // 4. Trigger Show
    setTimeout(() => {
        festiveOverlay.classList.add('show');
        animate();

        // Grand opening: 4 fireworks
        for (let i = 0; i < 4; i++) {
            setTimeout(() => launchFirework(), i * 350);
        }

        // Continuous fireworks (controlled)
        const fireworkTimer = setInterval(() => {
            if (particles.length < 400) {
                launchFirework();
                // Sometimes double burst
                if (Math.random() > 0.6) {
                    setTimeout(() => launchFirework(), 200);
                }
            }
        }, 900);

        // End show after 12 seconds with finale
        setTimeout(() => {
            clearInterval(fireworkTimer);
            // Grand finale: 5 rapid fireworks
            for (let i = 0; i < 5; i++) {
                setTimeout(() => launchFirework(), i * 150);
            }
            setTimeout(() => {
                cancelAnimationFrame(animationId);
                festiveOverlay.classList.remove('show');
                setTimeout(() => festiveOverlay.remove(), 1000);
            }, 1500);
        }, 12000);
    }, 800);

    // 5. Optimized Snow Spawning
    const snowflakeChars = ['❄', '❅', '❆'];
    let snowCount = 0;
    const maxSnow = isMobile ? 20 : 40;

    setInterval(() => {
        if (document.hidden || snowCount >= maxSnow) return;
        
        const snowflake = document.createElement('div');
        snowflake.classList.add('snowflake');
        snowflake.textContent = snowflakeChars[Math.floor(Math.random() * snowflakeChars.length)];
        snowflake.style.fontSize = (Math.random() * 8 + 12) + 'px';
        snowflake.style.left = (Math.random() * 100) + 'vw';
        snowflake.style.animationDuration = (Math.random() * 5 + 5) + 's';
        snowflake.style.opacity = Math.random() * 0.5 + 0.3;
        snowContainer.appendChild(snowflake);
        snowCount++;

        setTimeout(() => {
            snowflake.remove();
            snowCount--;
        }, 10000);
    }, isMobile ? 700 : 500);
});
