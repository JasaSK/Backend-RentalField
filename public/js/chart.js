document.addEventListener("DOMContentLoaded", function () {
  // === Chart Pemesanan ===
  const ctxPesanan = document.getElementById("chartPesanan");
  if (ctxPesanan) {
    new Chart(ctxPesanan, {
      type: "bar",
      data: {
        labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"],
        datasets: [
          {
            label: "Jumlah Pemesanan",
            data: [40, 65, 52, 70],
            backgroundColor: "#13810A",
            borderRadius: 6,
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
        plugins: {
          legend: { display: false },
        },
      },
    });
  }

  // === Chart Pendapatan ===
  const ctxPendapatan = document.getElementById("chartPendapatan");
  if (ctxPendapatan) {
    new Chart(ctxPendapatan, {
      type: "line",
      data: {
        labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"],
        datasets: [
          {
            label: "Pendapatan Per Minggu (Rp)",
            data: [5000000, 6200000, 5800000, 7300000],
            borderColor: "#13810A",
            backgroundColor: "rgba(19,129,10,0.2)",
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: "#13810A",
          },
        ],
      },
      options: {
        responsive: true,
      },
    });
  }
});
