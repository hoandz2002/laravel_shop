@extends('layout.master')
@section('title', 'Thống kê')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <div class="alert alert-default-info">
        <h3 class="text-center">Thống kê</h3>
    </div>
    <div class="d-flex">
        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
        <canvas id="myCharts" style="width:100%;max-width:600px"></canvas>
    </div>


    <script>
        // tạo mảng
        var xValues = [""];
        var yValues = [0,];
        var xValuess = ["",];
        var yValuess = [0,];
    </script>
    {{-- đếm số lượng snar phẩm bán theo ngày --}}
    @foreach ($stats as $item)
        <script>
            xValues.push("{{ $item->date }}");
            yValues.push("{{ $item->value }}");
            console.log(xValues);
            console.log(yValues);
        </script>
    @endforeach
    <script>
        var barColors = ["red", "green", "blue", "orange", "brown"];
        new Chart("myChart", {
            type: "line", //pie
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "Thống kê số lượng sản phẩm bán theo ngày"
                }
            }
        });
    </script>
    {{-- đếm số lượng sản phẩm theo danh mục --}}
    @foreach ($cates as $it)
        <script>
            xValuess.push("{{ $it->name }}");
            yValuess.push("{{ $it->value }}");
            console.log(xValuess);
            console.log(yValuess);
        </script>
    @endforeach
    <script>
        var barColors = ["", "red", "green", "blue", "orange", "brown", "lightblue", "lightseagreen"];
        new Chart("myCharts", {
            type: "bar",
            data: {
                labels: xValuess,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuess
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "Thống kê số lượng sản phẩm theo danh mục"
                }
            }
        });
    </script>
@endsection