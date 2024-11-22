@extends('layouts.app')
@section('css')
    <style>
        .circle {
            display: inline-flex;
            width: 20px;
            height: 20px;
            border-radius: 10% !important;
            align-items: center;
            margin-top: 4px;
            margin-right: 4px;
            justify-content: center;
        }

        .present {
            background-color: rgba(124, 185, 124, .4);
            color: rgb(20, 49, 20);
            padding: 2px 2px;
            border-radius: 3px;
            font-size: 11px;
        }

        .not_in_time {
            background-color: rgba(185, 202, 90, .4);
            color: rgb(168, 21, 21);
            padding: 2px 2px;
            border-radius: 3px;
            font-size: 11px;
        }

        .by_admin {
            background-color: rgba(124, 185, 124, .4);
            color: rgb(168, 21, 21);
            padding: 2px 2px;
            border-radius: 3px;
            font-size: 11px;
        }

        .one_punch {
            background-color: rgba(211, 159, 159, .4);
            color: rgb(117, 36, 36);
            padding: 2px 2px;
            border-radius: 3px;
            font-size: 11px;
        }

        .half_day,
        .on_leave {
            background-color: rgba(210, 193, 233, .4);
            color: rgb(50, 30, 77);
            padding: 2px 2px;
            border-radius: 3px;
            font-size: 11px;
        }

        .absent {
            background-color: rgba(223, 176, 176, .4);
            color: rgb(168, 21, 21);
            padding: 2px 2px;
            border-radius: 3px;
            font-size: 11px;
        }

        .holiday {
            background-color: rgba(160, 157, 157, .4);
            padding: 2px 2px;
            border-radius: 3px;
            font-size: 10px;
        }

        /* .on_leave {
                                                            background-color: rgb(210, 193, 233);
                                                            color: rgb(53, 33, 78);
                                                            padding: 2px 2px;
                                                            border-radius: 3px;
                                                        } */
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
            top: 100%;
            /* Position it below the cell */
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
    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="sparkline8-hd">
                                                        <div class="main-sparkline8-hd">
                                                            <form action="">
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                        <div class="form-group">
                                                                            <label for="month">Month</label>
                                                                            <select name="month" class="form-control"
                                                                                required>
                                                                                <option value="">Select Month</option>
                                                                                @foreach (range(1, 12) as $month)
                                                                                    <option
                                                                                        value="{{ sprintf('%02d', $month) }}"
                                                                                        {{ Request()->get('month') == sprintf('%02d', $month) ? 'selected' : '' }}>
                                                                                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                        <div class="form-group">
                                                                            <label for="year">Year</label>
                                                                            <select name="year" class="form-control"
                                                                                required>
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
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                        <div style="margin-top: 26px;">
                                                                            <input type="hidden" name="type"
                                                                                value={{ $type }}>
                                                                            {{-- <label for="name">.</label> --}}
                                                                            <input type="submit" name="button"
                                                                                value="Filter" class="btn btn-primary">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="legend">
                                                        <span class="present circle">P</span>Present<br>
                                                        <span class="by_admin circle">P</span>Marked Present By Admin<br>
                                                        <span class="one_punch circle">P</span>Out Punch Not Available<br>
                                                        <span class="not_in_time circle">ab</span>Late (Absent)<br>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="legend">
                                                        <span class="absent circle">ab</span>Absent<br>
                                                        <span class="on_leave circle">L</span>On Leave<br>
                                                        <span class="half_day circle">hd</span> <span
                                                            class="half_day circle">P</span>Half Day <br>
                                                        <span class="holiday circle">H</span>Holiday <br>
                                                        <span class="holiday circle">WE</span>Week End<br>
                                                    </div>
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
                                                                <th style="padding-top: 12px;">Emp Name </th>
                                                                @php

                                                                    $currentMonth =
                                                                        Request()->get('month', date('m')) ?? date('m');
                                                                    $currentYear =
                                                                        Request()->get('year', date('Y')) ?? date('Y');
                                                                    $monthName = date(
                                                                        'M',
                                                                        strtotime("{$currentYear}-{$currentMonth}-01"),
                                                                    );
                                                                    $daysInMonth = cal_days_in_month(
                                                                        CAL_GREGORIAN,
                                                                        $currentMonth,
                                                                        $currentYear,
                                                                    );
                                                                @endphp

                                                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                                                    @php
                                                                        $date = strtotime(
                                                                            "{$currentYear}-{$currentMonth}-{$day}",
                                                                        );
                                                                        $weekday = date('D', $date);
                                                                        $dayOfMonth = date('d', $date);
                                                                    @endphp
                                                                    <th style="padding: 2px;line-height: 12px;">
                                                                        <span
                                                                            style="font-size: 0.7em;color: #6a6a6a;font-weight: 600;">{{ $monthName }}</span><br>
                                                                        <span
                                                                            style="font-size: 0.8em; color: #202020;font-weight: 700;">{{ $dayOfMonth }}</span><br>
                                                                        <span
                                                                            style="font-size: 0.7em; color: #6a6a6a;font-weight: 600;">{{ $weekday }}</span>
                                                                    </th>
                                                                @endfor
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($employees as $emp)
                                                                <tr>
                                                                    <td class="attendance-cell">{{ $emp->name }}
                                                                        <div class="tooltip-container">
                                                                            <i class="fa-solid fa-clock"></i>
                                                                            <div class="tooltip">
                                                                                <strong>Tot Working Hr:
                                                                                    {{ $emp->getTotalWorkingHours($current_month, $current_year) }}</strong><br>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                                                        @php
                                                                            $date = sprintf(
                                                                                '%04d-%02d-%02d',
                                                                                $currentYear,
                                                                                $currentMonth,
                                                                                $day,
                                                                            );
                                                                            $attendance = $emp->attendance
                                                                                ->where('punch_date', $date)
                                                                                ->first();
                                                                            $dayOfWeek = date('w', strtotime($date));
                                                                            $isSaturdayOff = false;
                                                                            // $isSecondSaturday = ($dayOfWeek == 6 && $day >= 8 && $day <= 14);
                                                                            // $isFourthSaturday = ($dayOfWeek == 6 && $day >= 22 && $day <= 28);
                                                                            // $isSunday = ($dayOfWeek == 0);
                                                                            // $isHoliday = in_array($date,$holiday);
                                                                            if ($emp->roster) {
                                                                                $roster = \App\Models\attendanceRoaster::where(
                                                                                    'id',
                                                                                    $emp->roster,
                                                                                )->first();
                                                                                $date_new = new DateTime($date);
                                                                                $dayName = strtolower(
                                                                                    $date_new->format('l'),
                                                                                );
                                                                                $shift = \App\Models\attendanceShift::where(
                                                                                    'id',
                                                                                    $roster->$dayName,
                                                                                )->first();

                                                                                $isHoliday = false;
                                                                                // $isSecondSaturday = false;
                                                                                // $isFourthSaturday = false;
                                                                                $isSaturdayOff = false;
                                                                                $isSunday = is_null($roster->$dayName);
                                                                            } else {
                                                                                $weekArray = \App\Helpers\commonHelper::weekArray(
                                                                                    $emp->shift_id,
                                                                                );
                                                                                $weekOfMonth = ceil($day / 7);
                                                                                if (
                                                                                    $dayOfWeek == 6 &&
                                                                                    in_array($weekOfMonth, $weekArray)
                                                                                ) {
                                                                                    $isSaturdayOff = true;
                                                                                }
                                                                                $isSunday = $dayOfWeek == 0;
                                                                                $isHoliday = in_array($date, $holiday);
                                                                            }
                                                                        @endphp
                                                                        @if ($attendance)
                                                                            @if ($attendance->status == 'on_leave')
                                                                                <td
                                                                                    class="{{ $attendance->status }} attendance-cell">
                                                                                    <div class="tooltip-container">
                                                                                        <span>{{ $attendance->attendance }}</span>
                                                                                        <div class="tooltip">
                                                                                            <strong>On
                                                                                                {{ $attendance->leaveType->name }}</strong>
                                                                                        </div>
                                                                                    </div>
                                                                                @elseif($attendance->status == 'by_admin')
                                                                                <td
                                                                                    class="{{ $attendance->status }} attendance-cell">
                                                                                    <div class="tooltip-container">
                                                                                        <span>{{ $attendance->attendance }}</span>
                                                                                        <div class="tooltip">
                                                                                            <strong>IN:</strong>
                                                                                            {{ $attendance->in_time ?? 'NA' }}
                                                                                            <br>
                                                                                            <strong>OUT:</strong>
                                                                                            {{ $attendance->out_time ?? 'NA' }}
                                                                                            <br>
                                                                                            <strong>Tot Working Hr:</strong>
                                                                                            {{ $attendance->working_hour ?? 'NA' }}<br>
                                                                                            <strong>Remarks:</strong>
                                                                                            {{ $attendance->remarks }}
                                                                                        </div>
                                                                                    </div>
                                                                                @elseif($attendance->status == 'absent' || $attendance->status == 'not_in_time')
                                                                                <td
                                                                                    class="{{ $attendance->status }} attendance-cell">
                                                                                    <div class="tooltip-container">
                                                                                        <span>{{ $attendance->attendance }}</span>
                                                                                        <div class="tooltip">
                                                                                            <strong>IN:</strong>
                                                                                            {{ $attendance->in_time }} <br>
                                                                                            <strong>OUT:</strong>
                                                                                            {{ $attendance->out_time }}
                                                                                            <br>
                                                                                            <strong>Tot Working Hr:</strong>
                                                                                            {{ $attendance->working_hour }}<br>
                                                                                            <strong>Remarks:</strong>
                                                                                            {{ $attendance->remarks }}<br>
                                                                                            @if (\App\Helpers\commonHelper::isPermissionExist('attendance_management') && $type != 'user')
                                                                                                <strong data-toggle="modal"
                                                                                                    data-target="#exampleModalCenter"
                                                                                                    onclick="appendId({{ strtotime($date) }}, {{ $emp->id }},'P')">Make
                                                                                                    Present</strong>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @elseif($attendance->status == 'half_day')
                                                                                <td
                                                                                    class="{{ $attendance->status }} attendance-cell">
                                                                                    <div class="tooltip-container">
                                                                                        <span>{{ $attendance->attendance }}</span>
                                                                                        <div class="tooltip">
                                                                                            <strong>Half Day</strong><br>
                                                                                            <strong>IN:</strong>
                                                                                            {{ $attendance->in_time }} <br>
                                                                                            <strong>OUT:</strong>
                                                                                            {{ $attendance->out_time }}
                                                                                            <br>
                                                                                            <strong>Tot Working Hr:</strong>
                                                                                            {{ $attendance->working_hour }}
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    {{-- <td class="{{$attendance->status}} attendance-cell">
                                                                                <div class="tooltip-container"> --}}
                                                                                    @if (!$attendance->out_time)
                                                                                <td class="one_punch attendance-cell">
                                                                                    <div class="tooltip-container">
                                                                                        <span>{{ $attendance->attendance }}</span>
                                                                                        <div class="tooltip">
                                                                                            <strong>IN:</strong>
                                                                                            {{ $attendance->in_time }} <br>
                                                                                            <strong>OUT:</strong> Not
                                                                                            Available <br>
                                                                                            <strong>Tot Working Hr:</strong>
                                                                                            Not Available<br>
                                                                                            @if (\App\Helpers\commonHelper::isPermissionExist('attendance_management') && $type != 'user')
                                                                                                <strong data-toggle="modal"
                                                                                                    data-target="#exampleModalCenter"
                                                                                                    onclick="appendId({{ strtotime($date) }}, {{ $emp->id }},'P')">Make
                                                                                                    Present</strong>
                                                                                            @endif
                                                                                        </div>
                                                                                    @else
                                                                                <td
                                                                                    class="{{ $attendance->status }} attendance-cell">
                                                                                    <div class="tooltip-container">
                                                                                        <span>{{ $attendance->attendance }}</span>
                                                                                        <div class="tooltip">
                                                                                            <strong>IN:</strong>
                                                                                            {{ $attendance->in_time }} <br>
                                                                                            <strong>OUT:</strong>
                                                                                            {{ $attendance->out_time }}
                                                                                            <br>
                                                                                            <strong>Tot Working Hr:</strong>
                                                                                            {{ $attendance->working_hour }}<br>
                                                                                            @if (
                                                                                                \App\Helpers\commonHelper::isPermissionExist('attendance_management') &&
                                                                                                    $type != 'user' &&
                                                                                                    $attendance->status != 'present')
                                                                                                <strong data-toggle="modal"
                                                                                                    data-target="#exampleModalCenter"
                                                                                                    onclick="appendId({{ strtotime($date) }}, {{ $emp->id }},'A')">Make
                                                                                                    Absent</strong>
                                                                                            @endif
                                                                                        </div>
                                                                            @endif
                                                </div>
                                                @endif
                                            @elseif ($isHoliday)
                                                <td class="holiday attendance-cell">
                                                    <span>H</span>
                                                @elseif ($isSaturdayOff || $isSunday /* || $isFourthSaturday */)
                                                <td class="holiday attendance-cell">
                                                    <span>WE</span>
                                                @elseif (strtotime($date) <= strtotime(date('Y-m-d')))
                                                <td class="absent attendance-cell">
                                                    <div class="tooltip-container">
                                                        <span>ab</span>
                                                        @if (\App\Helpers\commonHelper::isPermissionExist('attendance_management') && $type != 'user')
                                                            <div class="tooltip">
                                                                <strong data-toggle="modal"
                                                                    data-target="#exampleModalCenter"
                                                                    onclick="appendId({{ strtotime($date) }}, {{ $emp->id }},'P')">Make
                                                                    Present</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                <td>
                                                    @endif
                                                </td>
                                                @endfor
                                                </tr>
                                                @endforeach
                                                </tbody>
                                                </table>
                                            </div>


                                            <div class="modal fade" id="exampleModalCenter" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Change to
                                                                Present</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('leave.attendance-update') }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="emp_id" id="emp_id">
                                                                    <input type="hidden" name="date" id="date">
                                                                    <input type="hidden" name="type" id="type">
                                                                    <label for="">Remark</label>
                                                                    <textarea name="remarks" id="remarks" cols="5" rows="5" class="form-control" required></textarea>
                                                                </div>
                                                                <input type="submit" class="btn btn-primary"
                                                                    value="Submit"
                                                                    onclick="return confirm('Are you sure?')">
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

    @if ($type == 'user')
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30 table-mg-t-pro dk-res-t-pro-30">
                            <div class="analytics-content">
                                <h5>Prsent Rate</h5>
                                <h2><span class="counter">{{ round($presentRate, 0) }}%</span> <span
                                        class="tuition-fees">{{ round($presentRate - $last_presentRate, 0) }}% <br> From
                                        Previous month</span></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30">
                            <div class="analytics-content">
                                <h5>Late Rate</h5>
                                <h2><span class="counter">{{ round($lateRate, 0) }}%</span> <span
                                        class="tuition-fees">{{ round($lateRate - $last_lateRate, 0) }}% <br> From
                                        Previous
                                        month</span></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line table-mg-t-pro dk-res-t-pro-30">
                            <div class="analytics-content">
                                <h5>Absent Rate</h5>
                                <h2><span class="counter">{{ round($absentRate, 0) }}%</span> <span
                                        class="tuition-fees">{{ round($absentRate - $last_absentRate, 0) }}% <br> From
                                        Previous month</span></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30">
                            <div class="analytics-content">
                                <h5>Leave Rate</h5>
                                <h2><span class="counter">{{ round($leaveRate, 0) }}%</span> <span
                                        class="tuition-fees">{{ round($leaveRate - $last_leaveRate, 0) }}% <br> From
                                        Previous month</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    </div>






@endsection

@section('js')
    <script>
        function appendId(date, emp_id, status) {
            var html = '';
            if (status == 'P') {
                html = 'Change to Present';
            } else {
                html = 'Change to Absent';
            }
            $("#emp_id").val(emp_id);
            $("#date").val(date);
            $("#type").val(status);
            $("#exampleModalLongTitle").empty().append(html);
        }
    </script>
@endsection
