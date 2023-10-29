@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
    <style>
        .chart-wrapper {
            height: 60vh;
        }
    </style>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $kandidat }}</h3>
                    <p>Kandidat</p>
                </div>
                <div class="icon">
                    <i class="ri-user-2-line"></i>
                </div>
                <a href="/kandidat" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $peserta }}</h3>
                    <p>Peserta</p>
                </div>
                <div class="icon">
                    <i class="ri-group-line"></i>
                </div>
                <a href="/peserta" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pemilihan }}</h3>
                    <p>Pemilih</p>
                </div>
                <div class="icon">
                    <i class="ri-signal-tower-line"></i>
                </div>
                <a href="/pemilih" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $kelas }}</h3>
                    <p>Kelas</p>
                </div>
                <div class="icon">
                    <i class="ri-bank-line"></i>
                </div>
                <a href="/kelas" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Diagram Hasil Pemilihan</div>
        </div>
        <div class="card-body">
            <div class="chart-wrapper">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <script>
        const ctx = document.querySelector("#myChart");

        $.ajax({
            type: "GET",
            url: "dashboard",
            dataType: "json",
            success: function(response) {
                console.log(response);

                let labels = [];
                let votes = [];

                response.forEach((val, i) => {
                    labels.push(`Paslon ${i+1}`);
                });

                response.forEach((val, i) => {
                    votes.push(val.total_suara);
                });

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Suara',
                            data: votes,
                            borderWidth: 1,
                            backgroundColor: "#59ADEC"
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>

@endsection
