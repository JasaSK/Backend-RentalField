    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weeklyOrders = @json($weeklyOrders);
            const weeklyIncome = @json($weeklyIncome);
            const searchInput = document.getElementById('searchCustomer');
            const tableRows = document.querySelectorAll('#customerTableBody tr');

            // Search functionality
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    tableRows.forEach(row => {
                        const customerName = row.getAttribute('data-customer-name') || '';
                        if (customerName.includes(searchTerm)) {
                            row.classList.remove('hidden');
                        } else {
                            row.classList.add('hidden');
                        }
                    });
                });
            }

            // Chart 1: Pemesanan
            const ctx1 = document.getElementById('chartPesanan').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: Object.keys(weeklyOrders),
                    datasets: [{
                        label: 'Jumlah Pemesanan',
                        data: Object.values(weeklyOrders),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#3b82f6',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return `Pemesanan: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: '#6b7280'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: '#6b7280'
                            }
                        }
                    }
                }
            });

            // Chart 2: Pendapatan
            const ctx2 = document.getElementById('chartPendapatan').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: Object.keys(weeklyIncome),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: Object.values(weeklyIncome),
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderColor: '#10b981',
                        borderWidth: 1,
                        borderRadius: 6,
                        hoverBackgroundColor: '#10b981'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#10b981',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return `Pendapatan: Rp ${context.raw.toLocaleString('id-ID')}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: '#6b7280',
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: '#6b7280'
                            }
                        }
                    }
                }
            });
        });
    </script>
