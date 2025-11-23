/* ============================================
   CUSTOM CHART.JS THEME - PREMIUM UI
============================================ */
Chart.defaults.font.family = "Inter, sans-serif";
Chart.defaults.font.size = 13;

Chart.defaults.color = "#6c757d"; // text muted

/* GRID STYLE */
Chart.defaults.scale.grid.color = "rgba(200, 200, 200, 0.15)";
Chart.defaults.scale.grid.borderColor = "rgba(200, 200, 200, 0.25)";

/* AXIS TICKS STYLE */
Chart.defaults.scale.ticks.color = "#6c757d";

/* TOOLTIP PREMIUM */
Chart.defaults.plugins.tooltip.backgroundColor = "rgba(0,0,0,0.85)";
Chart.defaults.plugins.tooltip.borderWidth = 0;
Chart.defaults.plugins.tooltip.padding = 10;
Chart.defaults.plugins.tooltip.titleFont = { weight: "600" };
Chart.defaults.plugins.tooltip.bodyFont = { weight: "400" };

/* LEGEND STYLE */
Chart.defaults.plugins.legend.labels.usePointStyle = true;
Chart.defaults.plugins.legend.labels.pointStyle = "circle";
Chart.defaults.plugins.legend.labels.boxWidth = 10;

/* LINE CHART GLOW SHADOW */
const shadowGlow = {
    id: "shadowGlow",
    beforeDraw: (chart) => {
        const { ctx } = chart;
        ctx.save();
        ctx.shadowColor = chart.config._shadowColor || "rgba(13,110,253,0.35)";
        ctx.shadowBlur = 15;
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 8;
    },
    afterDraw: (chart) => {
        const { ctx } = chart;
        ctx.restore();
    }
};

Chart.register(shadowGlow);



/* ============================================================
   AREA CHART
============================================================ */
new Chart(document.getElementById("areaChart"), {
    type: "line",
    plugins: [{ id: "shadowGlow" }],
    _shadowColor: "rgba(13,110,253,0.35)", 
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        datasets: [{
            label: "Growth",
            data: [5, 12, 8, 15, 7, 20],
            fill: true,
            backgroundColor: function(ctx) {
                const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 350);
                g.addColorStop(0, "rgba(13,110,253,0.35)");
                g.addColorStop(1, "rgba(13,110,253,0)");
                return g;
            },
            borderColor: "#0d6efd",
            pointBackgroundColor: "#0d6efd",
            borderWidth: 3,
            tension: 0.4,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,  // Wajib biar tinggi ngikut CSS
    }
});



/* ============================================================
   BAR CHART
============================================================ */
new Chart(document.getElementById("barChart"), {
    type: "bar",
    plugins: [{ id: "shadowGlow" }],
    _shadowColor: "rgba(0,0,0,0.25)",
    data: {
        labels: ["Proyek A", "Proyek B", "Proyek C", "Proyek D"],
        datasets: [{
            label: "Proyek",
            data: [120, 90, 150, 80],
            backgroundColor: [
                "#0d6efd",
                "#198754",
                "#dc3545",
                "#0dcaf0"
            ],
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
    }

    
});


