@extends('layouts.app')
@section('css')
<style>
    .custom-scrollbar {
        max-height: 277px;
        overflow-y: auto;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background-color: #f1f1f1;
    }
    .sparkline8-list{
        height:325px;
    }
</style>
@endsection
@section('content')
<div class="analytics-sparkle-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="breadcome-heading">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <ul class="breadcome-menu">
                    <li><a href="#">Home</a> <span class="bread-slash">/</span>
                    </li>
                    <li><span class="bread-blod">Dashboard V.1</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="analytics-sparkle-line reso-mg-b-30">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="analytics-content">
                                <h5>OVERVIEW</h5>
                                <h2><span class="tuition-fees">({{ $date }}) <br> Total Employees <br> {{$total_employee}}</span></h2>
                            </div>
                        </div>
                        @php
                            $present_percentage = round(($present->count()/$total_employee)*100,2);
                            $leave_percentage = round(($leave->count()/$total_employee)*100,0);
                            $late_percentage = round(($late->count()/$total_employee)*100,2);
                            $absent_percentage = round(($absent/$total_employee)*100,2);
                        @endphp
                        <input type="hidden" id="present" name="present" value="{{$present_percentage}}">
                        <input type="hidden" id="leave" name="leave" value="{{$leave_percentage}}">
                        <input type="hidden" id="late" name="late" value="{{$late_percentage}}">
                        <input type="hidden" id="absent" name="absent" value="{{$absent_percentage}}">

                        <div class="col-md-2">
                            <div class="analytics-content">
                                <h5>Present</h5>
                                <h2><span class="counter">{{$present->count()}}</span> <span class="tuition-fees"></span></h2>
                                <span class="text-info">{{$present_percentage}}%</span>
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:{{$present_percentage}}%;"> <span class="sr-only">{{$present_percentage}}</span> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="analytics-content">
                                <h5>Absent</h5>
                                <h2><span class="counter">{{$absent}}</span> <span class="tuition-fees"></span></h2>
                                <span class="text-inverse">{{$absent_percentage}}%</span>
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:{{$absent_percentage}}%;"> <span class="sr-only">{{$absent_percentage}}%</span> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="analytics-content">
                                <h5>Late</h5>
                                <h2><span class="counter">{{$late->count()}}</span> <span class="tuition-fees"></span></h2>
                                <span class="text-success">{{$late_percentage}}%</span>
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:{{$late_percentage}}%;"> <span class="sr-only">{{$late_percentage}}%</span> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="analytics-content">
                                <h5>On Leave</h5>
                                <h2><span class="counter">{{$leave->count()}}</span> <span class="tuition-fees"></span></h2>
                                <span class="text-danger">{{$leave_percentage}}%</span>
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:{{$leave_percentage}}%;"> <span class="sr-only">{{$leave_percentage}}%</span> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="analytics-sparkle-line reso-mg-b-30" style="height: 126px;">
                            <div class="analytics-content">
                                <h5>Prsent Rate</h5>
                                <h2><span class="counter">{{round($presentRate, 0)}}%</span> <span class="tuition-fees">{{round($presentRate - $last_presentRate,0)}}% <br> From Previous month</span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="analytics-sparkle-line reso-mg-b-30" style="height: 126px;">
                            <div class="analytics-content">
                                <h5>Absence Rate</h5>
                                <h2><span class="counter">{{round($absentRate, 0)}}%</span> <span class="tuition-fees">{{round($absentRate - $last_absentRate,0)}}% <br> From Previous month</span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="analytics-sparkle-line reso-mg-b-30" style="height: 126px;">
                            <div class="analytics-content">
                                <h5>Latecomer Rate</h5>
                                <h2><span class="counter">{{round($lateRate, 0)}}%</span> <span class="tuition-fees">{{round($lateRate - $last_lateRate,0)}}% <br> From Previous month</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-sales-area mg-tb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="product-sales-chart">
                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>

                    <div class="row" style="justify-content: center;display: flex;">
                        <button class="btn btn-primary" onclick="loadGraph(7)">One Week</button> &nbsp;
                        <button class="btn btn-primary" onclick="loadGraph(30)">One Month</button> &nbsp;
                        <button class="btn btn-primary" onclick="loadGraph(365)">One Year</button> &nbsp;
                        {{-- <button class="btn btn-primary" onclick="loadGraph(365)">All</button> --}}
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="sparkline8-list">
                            <div class="sparkline8-hd">
                                <div class="main-sparkline8-hd">
                                    <h6>On Leave ({{ $date }})</h6>
                                </div>
                            </div>
                            <div class="sparkline8-graph">
                                <div class="static-table-list custom-scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Emp name</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($leave as $lv)
                                            <tr>
                                                <td>{{$lv->user->name}}</td>
                                                <td>{{$lv->leaveApplication->from_date}}</td>
                                                <td>{{$lv->leaveApplication->to_date}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">
                                                    No record found..
                                                </td>
                                            </tr>

                                            {{-- @for ($i=0; $i<30; $i++)
                                            <tr>
                                                <th>Emp name</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                            </tr>
                                            @endfor --}}
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="sparkline8-list">
                            <div class="sparkline8-hd">
                                <div class="main-sparkline8-hd">
                                    <h6>Latecomer ({{ $date }})</h6>
                                </div>
                            </div>
                            <div class="sparkline8-graph">
                                <div class="static-table-list custom-scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Emp name</th>
                                                <th>In Time</th>
                                                <th>Out Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($late as $lt)
                                                <tr>
                                                    <td>{{$lt->user->name}}</td>
                                                    <td>{{$lt->in_time}}</td>
                                                    <td>{{$lt->out_time}}</td>
                                                </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">
                                                    No record found..
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="product-sales-chart">
                    <div id="piechart" style="width: 550px; height: 300px;"></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="sparkline8-list">
                            <div class="sparkline8-hd">
                                <div class="main-sparkline8-hd">
                                    <h6>Absent ({{ $date }})</h6>
                                </div>
                            </div>
                            <div class="sparkline8-graph">
                                <div class="static-table-list custom-scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Emp Name</th>
                                                <th>Emp Code</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($absentees as $ab)
                                                <tr>
                                                    <td>{{$ab->name}}</td>
                                                    <td>{{$ab->emp_code}}</td>
                                                </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">
                                                    No record found..
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var present = Number($("#present").val());
        var leave = Number($("#leave").val());
        var late = Number($("#late").val());
        var absent = Number($("#absent").val());

    // alert(present);


      var data = google.visualization.arrayToDataTable([
        ['Task', 'Employee per Day'],
        ['Present',     present],
        ['Absent',      absent],
        ['Late',  late],
        ['On Leave', leave],
      ]);

      var options = {
        title: 'Attendance Overview'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
</script>

<script>

function loadGraph(int){
    ajaxcall(int);
}

window.onload = function () {
    ajaxcall(7);
};

function ajaxcall(days){
    $.ajax({
        url: '{{route('leave.graph-data')}}',
        type: 'get',
        dataType: 'json',
        data: {day:days},
        success: function(response) {
            console.log(response);
            let presentDataPoints = [];
            let absentDataPoints = [];
            let leaveDataPoints = [];
            let lateDataPoints = [];

            response.wd.forEach(dateString => {
                let date = new Date(dateString);

                presentDataPoints.push({
                    x: date,
                    y: response.present[dateString] || 0
                });
                absentDataPoints.push({
                    x: date,
                    y: response.absent[dateString] || 0
                });
                leaveDataPoints.push({
                    x: date,
                    y: response.leave[dateString] || 0
                });
                lateDataPoints.push({
                    x: date,
                    y: response.late[dateString] || 0
                });
            });

            // Create the chart
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Attendance Trends"
                },
                axisX: {
                    valueFormatString: "DD MMM Y"
                },
                axisY: {
                    title: "Count",
                    suffix: ""
                },
                legend: {
                    cursor: "pointer",
                    fontSize: 12,
                    itemclick: toggleDataSeries
                },
                toolTip: {
                    shared: true
                },
                data: [
                    {
                        name: "Present",
                        type: "spline",
                        showInLegend: true,
                        dataPoints: presentDataPoints
                    },
                    {
                        name: "Absent",
                        type: "spline",
                        showInLegend: true,
                        dataPoints: absentDataPoints
                    },
                    {
                        name: "Leave",
                        type: "spline",
                        showInLegend: true,
                        dataPoints: leaveDataPoints
                    },
                    {
                        name: "Latecomer",
                        type: "spline",
                        showInLegend: true,
                        dataPoints: lateDataPoints
                    }
                ]
            });

            chart.render();

            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        },
        error: function(response) {
            console.log("Error:", response);
        }
    });
}


</script>
@section('js')
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
@endsection
