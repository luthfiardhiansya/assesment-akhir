@extends('layouts.dasboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            </div>
        </div>
    </div>

    {{-- GRAFIK STOK BARANG --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Grafik Stok Barang
                </div>
                <div class="card-body">
                    <canvas id="stokChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('stokChart').getContext('2d');

    const labels = {!! json_encode(
        $barang->map(function($brg){
            return $brg->nama_barang . ' (' . $brg->kategori->nama_kategori . ')';
        })
    ) !!};

    const data = {!! json_encode($barang->pluck('stok')) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Stok Barang',
                data: data,
                fill: false,
                tension: 0.3,
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection