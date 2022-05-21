@extends('layouts.base')

@section('style')
    <link href="/css/pages/dashboard.css" rel="stylesheet">
@endsection

@section('content')

<h1>@lang('Session :id',['id'=>$id])</h1>

<main class="box">

    <canvas id="myChart" width="400" height="200"></canvas>

</main>
    <a class="btn" href="{{ route('dashboard.sessions') }}">@lang('Back')</a>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"
        integrity="sha256-ErZ09KkZnzjpqcane4SCyyHsKAXMvID9/xwbl/Aq1pc="
        crossorigin="anonymous"></script>

<script>
    const ctx = document.getElementById("myChart").getContext("2d");

    const data = {
        labels: {!! json_encode($labels,0) !!},
        datasets: [
            @if($distances)
            {
                label: "Distance (cm)",
                data: {!! json_encode($distances) !!},
                fill: false,
                borderColor: "#4BC0C0",
                tension: 0.1
            },
            @endif
            @if($speed)
            {
                label: "Speed (cm/s)",
                data: {!! json_encode($speed) !!},
                fill: false,
                borderColor: "#4bc086",
                tension: 0.1
            },
            @endif
            @if($acceleration)
            {
                label: "Acceleration (m/s²)",
                data: {!! json_encode($acceleration) !!},
                fill: false,
                borderColor: "#674ea7",
                tension: 0.1
            },
            @endif
            @if($force)
            {
                label: "Force (Newtons)",
                data: {!! json_encode($force) !!},
                fill: false,
                borderColor: "#f1c232",
                tension: 0.1
            },
            @endif
            @if($power)
            {
                label: "Power (Watts)",
                data: {!! json_encode($power) !!},
                fill: false,
                borderColor: "#cc0000",
                tension: 0.1
            },
            @endif
        ]
    };

    const myChart = new Chart(ctx, {
        type: "line",
        data: data,
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