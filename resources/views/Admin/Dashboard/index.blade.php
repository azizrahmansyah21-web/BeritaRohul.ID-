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
                        <h4 class="text-[#267538] font-bold">Top Penulis (Bulan Ini)</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border">
                            <li class="media flex items-center mb-4">
                                <img class="mr-3 rounded-full shadow-md object-cover" width="50" height="50" src="{{ asset('frontend/assets/images/default-avatar.png') }}" alt="avatar">
                                <div class="media-body w-full">
                                    <div class="float-right text-[#2b76ab] font-bold text-sm">42 Berita</div>
                                    <div class="font-bold text-gray-800">Aziz Rahmansyah</div>
                                    <span class="text-xs text-gray-500">Administrator</span>
                                </div>
                            </li>
                            <li class="media flex items-center">
                                <img class="mr-3 rounded-full shadow-md object-cover" width="50" height="50" src="{{ asset('frontend/assets/images/default-avatar.png') }}" alt="avatar">
                                <div class="media-body w-full">
                                    <div class="float-right text-[#2b76ab] font-bold text-sm">28 Berita</div>
                                    <div class="font-bold text-gray-800">Afyu</div>
                                    <span class="text-xs text-gray-500">Editor</span>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // 1. Grafik Tren Berita (Warna Biru Sungai)
    var ctxTrend = document.getElementById("newsTrendChart").getContext('2d');
    var newsTrendChart = new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"], 
            datasets: [{
                label: 'Berita Dipublikasikan',
                data: [12, 19, 14, 25, 22, 10, 5],
                borderWidth: 3,
                backgroundColor: 'rgba(43, 118, 171, 0.1)', // Biru transparan
                borderColor: '#2b76ab', // Biru solid
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2b76ab',
                pointRadius: 5,
                pointHoverRadius: 7, 
                lineTension: 0.4 
            }]
        },
        options: {
            legend: { display: false },
            scales: {
                yAxes: [{ gridLines: { display: false, drawBorder: false } }],
                xAxes: [{ gridLines: { color: '#fbfbfb', lineWidth: 2 } }]
            },
            tooltips: {
                backgroundColor: '#2b76ab',
                titleFontColor: '#fff',
                bodyFontColor: '#fff',
                displayColors: false
            }
        }
    });

    // 2. Grafik Kategori (Warna Brand Logo)
    var ctxCat = document.getElementById("categoryChart").getContext('2d');
    var categoryChart = new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: ["Pemerintahan", "Ekonomi", "Kriminal", "Olahraga"],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#2b76ab', '#267538', '#c5a33c', '#4a4a4a'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverBorderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            legend: { position: 'bottom' },
            cutoutPercentage: 75,
            animation: { animateScale: true, animateRotate: true }
        }
    });
});
</script>
@endpush