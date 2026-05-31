@extends('layout.index')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard <small>Metamedia Collaboration Day</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color:#018FD7;">Beranda</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; color: white;">
                    <i class="fas fa-check-circle mr-2"></i><strong>Sukses!</strong> {{ session('success') }}
                    <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif

            <div class="user-info-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5><i class="fas fa-user-circle mr-2"></i> Selamat datang, {{ Auth::user()->name }}!</h5>
                        <p class="mb-2"><i class="fas fa-envelope mr-2"></i> Email: <strong>{{ Auth::user()->email }}</strong></p>
                        <p class="mb-0"><i class="fas fa-calendar-alt mr-2"></i> Bergabung sejak: <strong>{{ Auth::user()->created_at->translatedFormat('d F Y') }}</strong></p>
                    </div>
                    <div class="col-md-4 text-md-right text-center mt-3 mt-md-0">
                        <a href="{{ route('invitation.index') }}" class="btn btn-logout"><i class="fas fa-inbox mr-2"></i> Lihat Undangan</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box" style="background: white; border-top: 3px solid #C9A03D;">
                        <div class="inner"><h3>{{ $totalInvitations }}</h3><p>Total Peserta</p></div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box" style="background: white; border-top: 3px solid #C9A03D;">
                        <div class="inner"><h3>{{ $presencesCount }}</h3><p>Kehadiran Tercatat</p></div>
                        <div class="icon"><i class="fas fa-check-square"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box" style="background: white; border-top: 3px solid #C9A03D;">
                        <div class="inner"><h3>{{ $mahasiswaCount }}</h3><p>Mahasiswa</p></div>
                        <div class="icon"><i class="fas fa-user-graduate"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box" style="background: white; border-top: 3px solid #C9A03D;">
                        <div class="inner"><h3>{{ $alumniCount }}</h3><p>Alumni</p></div>
                        <div class="icon"><i class="fas fa-handshake"></i></div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-pie-chart mr-2"></i> Distribusi Peserta</h5></div>
                        <div class="card-body"><canvas id="statusChart" style="height: 250px;"></canvas></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-activity mr-2"></i> Aktivitas Terbaru</h5></div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between"><span><i class="fas fa-user-plus text-success mr-2"></i> Peserta Baru Hari Ini</span><span class="badge badge-info">{{ $todayInvitations }}</span></li>
                                <li class="list-group-item d-flex justify-content-between"><span><i class="fas fa-check-circle text-primary mr-2"></i> Check-in Hari Ini</span><span class="badge badge-success">{{ $todayPresences }}</span></li>
                                <li class="list-group-item d-flex justify-content-between"><span><i class="fas fa-database text-warning mr-2"></i> Total Peserta</span><span class="badge badge-warning">{{ $totalInvitations }}</span></li>
                                <li class="list-group-item d-flex justify-content-between"><span><i class="fas fa-calendar-check text-info mr-2"></i> Tanggal Acara</span><span class="badge badge-info">14 Juni 2025</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-table mr-2"></i> Daftar Peserta Terkini</h5>
                    <button class="btn btn-sm btn-light" onclick="alert('Export fitur sedang dikembangkan')"><i class="fas fa-download mr-1"></i> Export</button>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Mahasiswa</th>
                                <th>Nama Ortu</th>
                                <th>Status</th>
                                <th>WhatsApp</th>
                                <th>Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestInvitations as $invitation)
                                <tr>
                                    <td><strong>#{{ $invitation->id }}</strong></td>
                                    <td>{{ $invitation->nama_mhs }}</td>
                                    <td>{{ $invitation->nama_ortu }}</td>
                                    <td><span class="badge" style="background: {{ $invitation->status === 'mahasiswa' ? '#018FD7' : '#C9A03D' }}; color: white;">{{ ucfirst($invitation->status) }}</span></td>
                                    <td>{{ $invitation->wa_mhs }}</td>
                                    <td><small class="text-muted">{{ $invitation->created_at->diffForHumans() }}</small></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4 text-muted"><i class="fas fa-inbox"></i> Belum ada peserta terdaftar</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const ctx = document.getElementById('statusChart');
        if (ctx) {
            const mahasiswa = {{ $mahasiswaCount }};
            const alumni = {{ $alumniCount }};
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Mahasiswa', 'Alumni'],
                    datasets: [{
                        label: 'Jumlah Peserta',
                        data: [mahasiswa, alumni],
                        backgroundColor: ['#018FD7', '#C9A03D'],
                        borderColor: ['#016aa3', '#A0823D'],
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: { size: 13, weight: '600' }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
