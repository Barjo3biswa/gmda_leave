@extends('layouts.app')
@section('css')
<style>
.present {
    background-color: rgb(78, 189, 78);
    padding: 2px 2px;
    border-radius: 3px;
}
.not_in_time {
    background-color: rgb(255, 242, 60);
    padding: 2px 2px;
    border-radius: 3px;
}
.by_admin{
    background-color: rgb(251, 129, 255);
    padding: 2px 2px;
    border-radius: 3px;
}
.one_punch{
    background-color: rgb(255, 81, 81);
    padding: 2px 2px;
    border-radius: 3px;
}
.half_day{
    background-color: rgb(166, 98, 255);
    padding: 2px 2px;
    border-radius: 3px;
}
.absent {
    background-color: rgb(168, 21, 21);
    padding: 2px 2px;
    border-radius: 3px;
}
.holiday {
    background-color: rgb(168, 168, 168);
    padding: 2px 2px;
    border-radius: 3px;
}
.leave {
    background-color: rgb(166, 98, 255);
    padding: 2px 2px;
    border-radius: 3px;
}
.attendance-cell {
    position: relative;
}
.tooltip-container {
    position: relative;
    display: inline-block;
}
.tooltip {
    visibility: hidden;
    width: 180px;
    background-color: #1a1919;
    color: #f9f7f7;
    text-align: left;
    padding: 10px;
    border-radius: 5px;
    position: absolute;
    z-index: 1;
    top: 100%; /* Position it below the cell */
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}
.tooltip-container:hover .tooltip {
    visibility: visible;
    opacity: 1;
    transition: opacity 0.3s;
}
.modal-content {
    margin-top: 100px !important;
}

</style>
@endsection
@section('content')
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="#">Dashboard</a> <span class="bread-slash">/</span>
                                </li>
                                <li><span class="bread-blod">Attendance</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-payment-inner-st">
                    <div id="myTabContent" class="tab-content custom-product-edit">
                        <div class="product-tab-list tab-pane fade active in" id="description">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="sparkline8-list">
                                        <div class="sparkline8-hd">
                                            <div class="main-sparkline8-hd">
                                                <h1>Filter</h1>
                                            </div>
                                        </div>
                                        <div class="sparkline8-hd">
                                            <div class="main-sparkline8-hd">
                                            <form action="">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <div class="form-group">
                                                            <label for="month">Month</label>
                                                            <select name="month" class="form-control" required>
                                                                <option value="">Select Month</option>
                                                                @foreach (range(1, 12) as $month)
                                                                    <option value="{{ sprintf('%02d', $month) }}"
                                                                        {{ Request()->get('month') == sprintf('%02d', $month) ? 'selected' : '' }}>
                                                                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <div class="form-group">
                                                            <label for="year">Year</label>
                                                            <select name="year" class="form-control" required>
                                                                <option value="">Select Year</option>
                                                                @foreach (range(2024, date('Y') + 10) as $year)
                                                                    <option value="{{ $year }}"
                                                                        {{ Request()->get('year') == $year ? 'selected' : '' }}>
                                                                        {{ $year }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                                        <div class="form-group">
                                                            <input type="hidden" name="type" value={{$type}}>
                                                            <label for="name">.</label>
                                                            <input type="submit" name="button"  value="Filter" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>

                                        <div class="sparkline8-hd">
                                            <div class="main-sparkline8-hd">
                                                <h1>Attendance</h1>
                                            </div>
                                        </div>
                                        <div class="sparkline8-graph">
                                            <div class="static-table-list">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Emp Name </th>
                                                            @php

                                                                $currentMonth = Request()->get('month', date('m'))??date('m');
                                                                $currentYear = Request()->get('year', date('Y'))??date('Y');
                                                                $monthName = date('M', strtotime("{$currentYear}-{$currentMonth}-01"));
                                                                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                                                            @endphp

                                                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                                                @php
                                                                    $date = strtotime("{$currentYear}-{$currentMonth}-{$day}");
                                                                    $weekday = date('D', $date);
                                                                    $dayOfMonth = date('d', $date);
                                                                @endphp
                                                                <th>
                                                                    <span style="font-size: 0.6em; color: #888;">{{ $monthName }}</span><br>
                                                                    <span style="font-size: 0.8em; color: #575353;">{{ $dayOfMonth }}</span><br>
                                                                    <span style="font-size: 0.6em; color: #888;">{{ $weekday }}</span>
                                                                </th>
                                                            @endfor
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($employees as $emp)
                                                            <tr>
                                                                <td class="attendance-cell">{{$emp->name}}
                                                                    <div class="tooltip-container">
                                                                        <i class="fa-solid fa-clock"></i>
                                                                        <div class="tooltip">
                                                                            <strong>Tot Working Hr: {{ $emp->getTotalWorkingHours($current_month, $current_year) }}</strong><br>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                                                    @php
                                                                        $date = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                                                                        $attendance = $emp->attendance->where('punch_date', $date)->first();
                                                                        $dayOfWeek = date('w', strtotime($date));
                                                                        $isSecondSaturday = ($dayOfWeek == 6 && $day >= 8 && $day <= 14);
                                                                        $isFourthSaturday = ($dayOfWeek == 6 && $day >= 22 && $day <= 28);
                                                                        $isSunday = ($dayOfWeek == 0);
                                                                    @endphp
                                                                    <td class="attendance-cell">
                                                                        @if ($attendance)
                                                                            @if($attendance->status=='on_leave')
                                                                                <div class="tooltip-container">
                                                                                    <span class="leave">L</span>
                                                                                    <div class="tooltip">
                                                                                        <strong>On {{$attendance->leaveType->name}}</strong>
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($attendance->status=='by_admin')
                                                                                <div class="tooltip-container">
                                                                                    <span class="{{$attendance->status}}">P</span>
                                                                                    <div class="tooltip">
                                                                                        <strong>Remarks:</strong> {{$attendance->remarks}}
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($attendance->status=='absent')
                                                                                <div class="tooltip-container">
                                                                                    <span class="{{$attendance->status}}">ab</span>
                                                                                    <div class="tooltip">
                                                                                        <strong>IN:</strong> {{$attendance->in_time}} <br>
                                                                                        <strong>OUT:</strong> {{$attendance->out_time}} <br>
                                                                                        <strong>Tot Working Hr:</strong> {{$attendance->working_hour}}
                                                                                        <strong>Remarks:</strong> {{$attendance->remarks}}
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($attendance->status=='half_day')
                                                                                <div class="tooltip-container">
                                                                                    <span class="{{$attendance->status}}">hd</span>
                                                                                    <div class="tooltip">
                                                                                        <strong>Half Day</strong><br>
                                                                                        <strong>IN:</strong> {{$attendance->in_time}} <br>
                                                                                        <strong>OUT:</strong> {{$attendance->out_time}} <br>
                                                                                        <strong>Tot Working Hr:</strong> {{$attendance->working_hour}}
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="tooltip-container">
                                                                                    @if (!$attendance->out_time)
                                                                                        <span class="one_punch">P</span>
                                                                                        <div class="tooltip">
                                                                                            <strong>IN:</strong> {{$attendance->in_time}} <br>
                                                                                            <strong>OUT:</strong> Not Available <br>
                                                                                            <strong>Tot Working Hr:</strong> Not Available
                                                                                            @if (\App\Helpers\commonHelper::isPermissionExist('attendance_view_manage') && $type != 'user')
                                                                                                <strong data-toggle="modal" data-target="#exampleModalCenter" onclick="appendId({{strtotime($date)}}, {{$emp->id}},'A')">Make Absent</strong>
                                                                                            @endif
                                                                                        </div>
                                                                                    @else
                                                                                        <span class="{{$attendance->status}}">P</span>
                                                                                        <div class="tooltip">
                                                                                            <strong>IN:</strong> {{$attendance->in_time}} <br>
                                                                                            <strong>OUT:</strong> {{$attendance->out_time}} <br>
                                                                                            <strong>Tot Working Hr:</strong> {{$attendance->working_hour}}
                                                                                            @if (\App\Helpers\commonHelper::isPermissionExist('attendance_view_manage') && $type != 'user' && $attendance->status != 'present')
                                                                                                <strong data-toggle="modal" data-target="#exampleModalCenter" onclick="appendId({{strtotime($date)}}, {{$emp->id}},'A')">Make Absent</strong>
                                                                                            @endif
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                        @elseif (in_array($date,$holiday))
                                                                            <span class="holiday">H</span>
                                                                        @elseif ($isSecondSaturday || $isSunday || $isFourthSaturday)
                                                                            <span class="holiday">S</span>
                                                                        @elseif (strtotime($date) <= strtotime(date('Y-m-d')))
                                                                            <div class="tooltip-container">
                                                                                <span class="absent">ab</span>
                                                                                @if (\App\Helpers\commonHelper::isPermissionExist('attendance_view_manage') && $type != 'user')
                                                                                <div class="tooltip">
                                                                                    <strong data-toggle="modal" data-target="#exampleModalCenter" onclick="appendId({{strtotime($date)}}, {{$emp->id}},'P')">Make Present</strong>
                                                                                </div>
                                                                                @endif
                                                                            </div>
                                                                        @else

                                                                        @endif
                                                                    </td>
                                                                @endfor
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>


                                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLongTitle">Change to Present</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        <div class="modal-body">
                                                          <form action="{{route('leave.attendance-update')}}" method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <input type="hidden" name="emp_id" id="emp_id">
                                                                <input type="hidden" name="date" id="date">
                                                                <input type="hidden" name="type" id="type">
                                                                <label for="">Remark</label>
                                                                <textarea name="remarks" id="remarks" cols="5" rows="5" class="form-control" required></textarea>
                                                            </div>
                                                            <input type="submit" class="btn btn-primary" value="Submit" onclick="return confirm('Are you sure?')">
                                                          </form>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
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

@section('js')
<script>
    function appendId(date, emp_id,status){
        var html='';
        if(status=='P'){
           html = 'Change to Present';
        }else{
            html = 'Change to Absent';
        }
        $("#emp_id").val(emp_id);
        $("#date").val(date);
        $("#type").val(status);
        $("#exampleModalLongTitle").empty().append(html);
    }
</script>
@endsection
