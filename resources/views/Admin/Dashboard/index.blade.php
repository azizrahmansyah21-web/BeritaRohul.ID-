@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Dashboard') }}</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('admin.Total News') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $publishedNews }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('admin.Pending News') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $pendingNews }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('admin.Total Categories') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $Categories }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-language"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('admin.Total Languages') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $languages }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('admin.Total Roles') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $roles }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('admin.Total Permissions') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $permissions }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('admin.Total Socials') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $socials }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('admin.Total Subscribers') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $subscribers }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Dashboar Analytics -->
        <div class="section-header">
        <h1>Dashboard Analytics</h1>
        </div>

        
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary shadow-primary">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total News</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalNews ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
            </div>
        
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tren Publikasi Berita (Bulan Ini)</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="newsTrendChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Kategori Terpopuler</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" height="220"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Status Ads (Iklan)</h4>
                    </div>
                    <div class="card-body">
                        <div class="summary">
                            <div class="summary-info">
                                <h4>3 Iklan</h4>
                                <div class="text-muted">Sedang Berjalan Bulan Ini</div>
                            </div>
                            <div class="summary-item">
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-right"><div class="badge badge-success">Active</div></div>
                                            <div class="media-title">Banner Header (Pemkab)</div>
                                            <div class="text-small text-muted">Sisa 14 Hari</div>
                                        </div>
                                    </li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Berita Terbaru</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td><a href="#">Bupati Rokan Hulu Resmikan...</a></td>
                                    <td>Pemerintahan</td>
                                    <td><div class="badge badge-success">Publis</div></td>
                                </tr>
                                <tr>
                                    <td><a href="#">Harga Sawit Naik Pekan Ini...</a></td>
                                    <td>Ekonomi</td>
                                    <td><div class="badge badge-warning">Pending</div></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Top Penulis (Bulan Ini)</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border">
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50" src="{{ asset('frontend/assets/images/default-avatar.png') }}" alt="avatar">
                                <div class="media-body">
                                    <div class="float-right text-primary">42 Berita</div>
                                    <div class="media-title">Aziz Rahmansyah</div>
                                    <span class="text-small text-muted">Administrator</span>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50" src="{{ asset('frontend/assets/images/default-avatar.png') }}" alt="avatar">
                                <div class="media-body">
                                    <div class="float-right text-primary">28 Berita</div>
                                    <div class="media-title">Afyu</div>
                                    <span class="text-small text-muted">Editor</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // 1. Grafik Tren Berita (Line Chart)
    var ctxTrend = document.getElementById("newsTrendChart").getContext('2d');
    var newsTrendChart = new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"], // Nanti diganti data dinamis dari Controller
            datasets: [{
                label: 'Berita Dipublikasikan',
                data: [12, 19, 14, 25, 22, 10, 5],
                borderWidth: 2,
                backgroundColor: 'rgba(103, 119, 239, 0.2)', // Warna khas biru Stisla
                borderColor: 'rgba(103, 119, 239, 1)',
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: { display: false },
            scales: {
                yAxes: [{ gridLines: { display: false, drawBorder: false } }],
                xAxes: [{ gridLines: { color: '#fbfbfb', lineWidth: 2 } }]
            }
        }
    });

    // 2. Grafik Kategori (Doughnut Chart)
    var ctxCat = document.getElementById("categoryChart").getContext('2d');
    var categoryChart = new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: ["Pemerintahan", "Ekonomi", "Kriminal", "Olahraga"],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#6777ef', '#fc544b', '#ffa426', '#47c363'],
            }]
        },
        options: {
            responsive: true,
            legend: { position: 'bottom' }
        }
    });
});
</script>

    @endsection
