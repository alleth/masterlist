<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cube Dot Network</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            overflow: hidden;
            background: #ffffff;
            position: relative;
        }
        .network {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .dot-grid {
            position: absolute;
            width: 100%;
            height: 100%;
            background:
                    radial-gradient(circle, #000000 0.1px, transparent 0.1px);
            background-size: 2px 2px; /* Dense grid for millions of dots */
            opacity: 0.7;
            z-index: 1;
        }
        svg {
            width: 100%;
            height: 100%;
            opacity: 0.8;
            z-index: 2;
        }
        .dot {
            fill: #000000;
            r: 1px;
        }
        .line {
            stroke: #666666;
            stroke-width: 0.1;
        }
    </style>
</head>
<body>
<div class="network">
    <div class="dot-grid"></div>
    <svg>
        <!-- Base cube vertices to suggest cubic form -->
        <circle class="dot" cx="40%" cy="40%" /> <!-- A: Bottom-left front -->
        <circle class="dot" cx="60%" cy="40%" /> <!-- B: Bottom-right front -->
        <circle class="dot" cx="60%" cy="20%" /> <!-- C: Top-right front -->
        <circle class="dot" cx="40%" cy="20%" /> <!-- D: Top-left front -->
        <circle class="dot" cx="70%" cy="50%" /> <!-- E: Bottom-left back -->
        <circle class="dot" cx="90%" cy="50%" /> <!-- F: Bottom-right back -->
        <circle class="dot" cx="90%" cy="30%" /> <!-- G: Top-right back -->
        <circle class="dot" cx="70%" cy="30%" /> <!-- H: Top-left back -->
        <!-- Additional points to enhance cubic shape -->
        <circle class="dot" cx="45%" cy="30%" /> <!-- I -->
        <circle class="dot" cx="55%" cy="30%" /> <!-- J -->
        <circle class="dot" cx="50%" cy="35%" /> <!-- K -->
        <circle class="dot" cx="65%" cy="45%" /> <!-- L -->
        <circle class="dot" cx="75%" cy="40%" /> <!-- M -->
        <circle class="dot" cx="85%" cy="40%" /> <!-- N -->
        <circle class="dot" cx="80%" cy="45%" /> <!-- O -->
        <circle class="dot" cx="50%" cy="45%" /> <!-- P -->
        <circle class="dot" cx="60%" cy="50%" /> <!-- Q -->
        <circle class="dot" cx="70%" cy="55%" /> <!-- R -->
        <circle class="dot" cx="80%" cy="55%" /> <!-- S -->
        <circle class="dot" cx="90%" cy="45%" /> <!-- T -->

        <!-- Cube edges to define the cubic form -->
        <line class="line" x1="40%" y1="40%" x2="60%" y2="40%" /> <!-- AB -->
        <line class="line" x1="60%" y1="40%" x2="60%" y2="20%" /> <!-- BC -->
        <line class="line" x1="60%" y1="20%" x2="40%" y2="20%" /> <!-- CD -->
        <line class="line" x1="40%" y1="20%" x2="40%" y2="40%" /> <!-- DA -->
        <line class="line" x1="70%" y1="50%" x2="90%" y2="50%" /> <!-- EF -->
        <line class="line" x1="90%" y1="50%" x2="90%" y2="30%" /> <!-- FG -->
        <line class="line" x1="90%" y1="30%" x2="70%" y2="30%" /> <!-- GH -->
        <line class="line" x1="70%" y1 "30%" y2="50%" /> <!-- HE -->
        <line class="line" x1="40%" y1="40%" x2="70%" y2="50%" /> <!-- AE -->
        <line class="line" x1="60%" y1="40%" x2="90%" y2="50%" /> <!-- BF -->
        <line class="line" x1="60%" y1="20%" x2="90%" y2="30%" /> <!-- CG -->
        <line class="line" x1="40%" y1="20%" x2="70%" y2="30%" /> <!-- DH -->
        <line class="line" x1="45%" y1="30%" x2="55%" y2="30%" /> <!-- IJ -->
        <line class="line" x1="50%" y1="35%" x2="55%" y2="30%" /> <!-- KJ -->
        <line class="line" x1="50%" y1="35%" x2="45%" y2="30%" /> <!-- KI -->
        <line class="line" x1="65%" y1="45%" x2="75%" y2="40%" /> <!-- LN -->
        <line class="line" x1="75%" y1="40%" x2="85%" y2="40%" /> <!-- NM -->
        <line class="line" x1="80%" y1="45%" x2="85%" y2="40%" /> <!-- ON -->
        <line class="line" x1="50%" y1="45%" x2="60%" y2="50%" /> <!-- PQ -->
        <line class="line" x1="60%" y1="50%" x2="70%" y2="55%" /> <!-- QR -->
        <line class="line" x1="70%" y1="55%" x2="80%" y2="55%" /> <!-- RS -->
        <line class="line" x1="80%" y1="55%" x2="90%" y2="45%" /> <!-- ST -->
    </svg>
</div>


<script>
    window.addEventListener('load', () => {
        const canvas = document.createElement('canvas');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        document.querySelector('.network').appendChild(canvas);
        const ctx = canvas.getContext('2d');

        // Generate millions of dots within a cubic volume
        const dotCount = 2000000; // Approx. 2 million
        const dots = [];
        const cubeSize = 0.6; // 60% of viewport
        const cubeCenterX = canvas.width * 0.5;
        const cubeCenterY = canvas.height * 0.5;
        for (let i = 0; i < dotCount; i++) {
            const x = cubeCenterX + (Math.random() - 0.5) * cubeSize * canvas.width;
            const y = cubeCenterY + (Math.random() - 0.5) * cubeSize * canvas.height;
            const z = Math.random() * cubeSize * canvas.height; // Simulate 3D depth
            dots.push({ x, y, z });
        }

        // Draw dots and connect nearby ones
        ctx.fillStyle = '#000000';
        dots.forEach(dot => {
            const scale = 1 - dot.z / (cubeSize * canvas.height); // Perspective
            const size = 1 * scale;
            ctx.beginPath();
            ctx.arc(dot.x, dot.y, size, 0, Math.PI * 2);
            ctx.fill();
            // Connect to nearby dots (simplified)
            dots.forEach(other => {
                const dx = other.x - dot.x;
                const dy = other.y - dot.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                if (distance < 20 * scale) {
                    ctx.beginPath();
                    ctx.moveTo(dot.x, dot.y);
                    ctx.lineTo(other.x, other.y);
                    ctx.strokeStyle = '#666666';
                    ctx.lineWidth = 0.1 * scale;
                    ctx.stroke();
                }
            });
        });
    });

</script>
</body>
</html>