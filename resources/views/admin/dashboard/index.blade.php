@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Dashboard') }} Analytics</h1>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 group rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_10px_25px_rgba(43,118,171,0.15)] hover:-translate-y-1">
                    <div class="card-icon flex justify-center items-center rounded-xl bg-[#2b76ab] shadow-[0_4px_8px_rgba(43,118,171,0.3)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-newspaper text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header pb-0">
                            <h4 class="text-[#267538] font-bold text-xs truncate leading-tight tracking-wide">{{ __('admin.Total News') }}</h4>
                        </div>
                        <div class="card-body">{{ $publishedNews }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 group rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_10px_25px_rgba(197,163,60,0.15)] hover:-translate-y-1">
                    <div class="card-icon flex justify-center items-center rounded-xl bg-[#c5a33c] shadow-[0_4px_8px_rgba(197,163,60,0.3)] transition-transform duration-300 group-hover:scale-110">
                        <i class="far fa-clock text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header pb-0">
                            <h4 class="text-[#267538] font-bold text-xs truncate leading-tight tracking-wide">{{ __('admin.Pending News') }}</h4>
                        </div>
                        <div class="card-body">{{ $pendingNews }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 group rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_10px_25px_rgba(38,117,56,0.15)] hover:-translate-y-1">
                    <div class="card-icon flex justify-center items-center rounded-xl bg-[#267538] shadow-[0_4px_8px_rgba(38,117,56,0.3)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-tags text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header pb-0">
                            <h4 class="text-[#267538] font-bold text-xs truncate leading-tight tracking-wide">{{ __('admin.Total Categories') }}</h4>
                        </div>
                        <div class="card-body">{{ $Categories }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 group rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_10px_25px_rgba(74,74,74,0.15)] hover:-translate-y-1">
                    <div class="card-icon flex justify-center items-center rounded-xl bg-[#4a4a4a] shadow-[0_4px_8px_rgba(74,74,74,0.3)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-language text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header pb-0">
                            <h4 class="text-[#267538] font-bold text-xs truncate leading-tight tracking-wide">{{ __('admin.Total Languages') }}</h4>
                        </div>
                        <div class="card-body">{{ $languages }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 group rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_10px_25px_rgba(43,118,171,0.15)] hover:-translate-y-1">
                    <div class="card-icon flex justify-center items-center rounded-xl bg-[#2b76ab] shadow-[0_4px_8px_rgba(43,118,171,0.3)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-user-shield text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header pb-0">
                            <h4 class="text-[#267538] font-bold text-xs truncate leading-tight tracking-wide">{{ __('admin.Total Roles') }}</h4>
                        </div>
                        <div class="card-body">{{ $roles }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 group rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_10px_25px_rgba(38,117,56,0.15)] hover:-translate-y-1">
                    <div class="card-icon flex justify-center items-center rounded-xl bg-[#267538] shadow-[0_4px_8px_rgba(38,117,56,0.3)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-key text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header pb-0">
                            <h4 class="text-[#267538] font-bold text-xs truncate leading-tight tracking-wide">{{ __('admin.Total Permissions') }}</h4>
                        </div>
                        <div class="card-body">{{ $permissions }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 group rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_10px_25px_rgba(74,74,74,0.15)] hover:-translate-y-1">
                    <div class="card-icon flex justify-center items-center rounded-xl bg-[#4a4a4a] shadow-[0_4px_8px_rgba(74,74,74,0.3)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-share-alt text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header pb-0">
                            <h4 class="text-[#267538] font-bold text-xs truncate leading-tight tracking-wide">{{ __('admin.Total Socials') }}</h4>
                        </div>
                        <div class="card-body">{{ $socials }}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 group rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_10px_25px_rgba(197,163,60,0.15)] hover:-translate-y-1">
                    <div class="card-icon flex justify-center items-center rounded-xl bg-[#c5a33c] shadow-[0_4px_8px_rgba(197,163,60,0.3)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header pb-0">
                            <h4 class="text-[#267538] font-bold text-xs truncate leading-tight tracking-wide">{{ __('admin.Total Subscribers') }}</h4>
                        </div>
                        <div class="card-body">{{ $subscribers }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)]">
                    <div class="card-header">
                        <h4 class="text-[#267538] font-bold">Tren Publikasi Berita (Bulan Ini)</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="newsTrendChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                <div class="card rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)]">
                    <div class="card-header">
                        <h4 class="text-[#267538] font-bold">Kategori Terpopuler</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" height="220"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)]">
                    <div class="card-header">
                        <h4 class="text-[#267538] font-bold">Status Ads (Iklan)</h4>
                    </div>
                    <div class="card-body">
                        <div class="summary">
                            <div class="summary-info mb-4">
                                <h4 class="text-[#2b76ab] font-bold text-2xl">3 Iklan</h4>
                                <div class="text-gray-500 text-sm">Sedang Berjalan Bulan Ini</div>
                            </div>
                            <div class="summary-item">
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media flex items-start">
                                        <div class="media-body w-full">
                                            <div class="float-right"><div class="px-2 py-1 bg-[#267538] text-white text-xs rounded-md">Active</div></div>
                                            <div class="font-bold text-[#2b76ab]">Banner Header (Pemkab)</div>
                                            <div class="text-xs text-gray-500 mt-1">Sisa 14 Hari</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)]">
                    <div class="card-header">
                        <h4 class="text-[#267538] font-bold">Berita Terbaru</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover w-full text-sm">
                                <tr>
                                    <th class="p-3 text-left">Judul</th>
                                    <th class="p-3 text-left">Kategori</th>
                                    <th class="p-3 text-left">Status</th>
                                </tr>
                                <tr class="border-b">
                                    <td class="p-3"><a href="#" class="text-[#2b76ab] font-semibold hover:underline">Bupati Rokan Hulu Resmikan...</a></td>
                                    <td class="p-3">Pemerintahan</td>
                                    <td class="p-3"><div class="px-2 py-1 bg-[#267538] text-white text-xs rounded-md inline-block">Publis</div></td>
                                </tr>
                                <tr class="border-b">
                                    <td class="p-3"><a href="#" class="text-[#2b76ab] font-semibold hover:underline">Harga Sawit Naik Pekan Ini...</a></td>
                                    <td class="p-3">Ekonomi</td>
                                    <td class="p-3"><div class="px-2 py-1 bg-[#c5a33c] text-white text-xs rounded-md inline-block">Pending</div></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card rounded-xl border-none shadow-[0_4px_15px_rgba(0,0,0,0.03)]">
                    <div class="card-header">
    <h4 class="text-[#267538] font-bold">
        <i class="fas fa-pen-nib mr-2"></i>
        Top Penulis (Bulan Ini)
    </h4>
</div>
                    <div class="card-body">
<ul class="list-unstyled list-unstyled-border">
    <li class="media flex items-center mb-4">
        <img 
            class="mr-3 rounded-full shadow-md object-cover" 
            width="50" 
            height="50" 
            src="https://ui-avatars.com/api/?name=User&background=e5e7eb&color=374151&size=128&bold=true" 
            alt="User Avatar"
        >

        <div class="media-body w-full">
            <div class="float-right text-[#64748b] font-bold text-sm">
                <i class="fas fa-newspaper mr-1"></i>
                42 Berita
            </div>

            <div class="font-bold text-gray-800">
                <i class="fas fa-crown mr-1 text-[#b7a16a]"></i>
                Aziz Rahmansyah
            </div>

            <span class="text-xs text-gray-500">
                <i class="fas fa-user-shield mr-1"></i>
                Administrator
            </span>
        </div>
    </li>

    <li class="media flex items-center">
        <img 
            class="mr-3 rounded-full shadow-md object-cover" 
            width="50" 
            height="50" 
            src="https://ui-avatars.com/api/?name=User&background=e5e7eb&color=374151&size=128&bold=true" 
            alt="User Avatar"
        >

        <div class="media-body w-full">
            <div class="float-right text-[#64748b] font-bold text-sm">
                <i class="fas fa-newspaper mr-1"></i>
                28 Berita
            </div>

            <div class="font-bold text-gray-800">
                <i class="fas fa-medal mr-1 text-[#94a3b8]"></i>
                Afyu
            </div>

            <span class="text-xs text-gray-500">
                <i class="fas fa-user-edit mr-1"></i>
                Editor
            </span>
        </div>
    </li>
</ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
$(document).ready(function() {
    const trendCanvas = document.getElementById('newsTrendChart');
    const categoryCanvas = document.getElementById('categoryChart');

    if (trendCanvas) {
        const trendCtx = trendCanvas.getContext('2d');

        const trendGradient = trendCtx.createLinearGradient(0, 0, 0, 260);
        trendGradient.addColorStop(0, 'rgba(100, 116, 139, 0.18)');
        trendGradient.addColorStop(1, 'rgba(100, 116, 139, 0.02)');

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Berita Dipublikasikan',
                    data: [12, 19, 14, 25, 22, 10, 5],
                    fill: true,
                    backgroundColor: trendGradient,
                    borderColor: '#64748b',
                    borderWidth: 2.5,
                    tension: 0.42,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#64748b',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8'
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8',
                            precision: 0
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    if (categoryCanvas) {
        const categoryCtx = categoryCanvas.getContext('2d');

        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pemerintahan', 'Ekonomi', 'Kriminal', 'Olahraga'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: ['#64748b', '#94a3b8', '#cbd5e1', '#e5e7eb'],
                    borderColor: '#ffffff',
                    borderWidth: 4,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#64748b',
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 18,
                            boxWidth: 8,
                            boxHeight: 8,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        cornerRadius: 10
                    }
                }
            }
        });
    }
});
</script>
@endpush