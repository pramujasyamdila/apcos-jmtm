
document.getElementById("showPass").addEventListener("change", function() {
    const pwd = document.getElementById("password");
    pwd.type = this.checked ? "text" : "password";
});

document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const btn = document.querySelector(".btn-login");
    btn.innerHTML = "Processing...";
    btn.disabled = true;

    setTimeout(() => {
        alert("Login berhasil (contoh)");
        btn.innerHTML = "Login";
        btn.disabled = false;
    }, 1200);
});

// ===== PARALLAX CINEMATIC (FINAL CLEAN VERSION) =====

let targetX = 0,
    targetY = 0;
let currentX = 0,
    currentY = 0;

document.addEventListener("mousemove", (e) => {
    targetX = (e.clientX / window.innerWidth - 0.5) * 14;
    targetY = (e.clientY / window.innerHeight - 0.5) * 14;
});

function animateParallax() {
    currentX += (targetX - currentX) * 0.07;
    currentY += (targetY - currentY) * 0.07;

    document.querySelector(".left-bg").style.transform =
        `translate(${currentX}px, ${currentY}px) scale(1.06)`;

    requestAnimationFrame(animateParallax);
}
animateParallax();


// ===== WATER RIPPLE SOFT EFFECT (FINAL FIXED) =====
const canvas = document.getElementById("ripple-canvas");
const ctx = canvas.getContext("2d");

let width, height;

function resizeCanvas() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
}
resizeCanvas();
window.addEventListener("resize", resizeCanvas);

let rippleRadius = 0;
let rippleX = 0;
let rippleY = 0;
let lastTime = 0;

function drawRipple() {
    ctx.clearRect(0, 0, width, height);

    ctx.beginPath();
    ctx.arc(rippleX, rippleY, rippleRadius, 0, Math.PI * 2);
    ctx.strokeStyle = "rgba(255,255,255,0.18)";
    ctx.lineWidth = 2;
    ctx.stroke();

    rippleRadius += 0.9;
    if (rippleRadius > 160) rippleRadius = 0;
}

function animateRipple(time) {
    if (time - lastTime > 30) {
        drawRipple();
        lastTime = time;
    }
    requestAnimationFrame(animateRipple);
}

setInterval(() => {
    rippleX = Math.random() * width;
    rippleY = Math.random() * height;
    rippleRadius = 8;
}, 2200);

requestAnimationFrame(animateRipple);