@extends('layouts.app')
@section('css')
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
                                <li><span class="bread-blod">
                                        @if ($type == 'inbox')
                                            Inbox
                                        @else
                                            Outbox
                                        @endif
                                        (Leave)
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="product-payment-inner-st">
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <div class="product-tab-list tab-pane fade active in" id="description">

                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                        <div class="review-content-section">
                                            <div class="sparkline8-list">
                                                <div class="sparkline8-hd">
                                                    <div class="main-sparkline8-hd">
                                                        <h4>Leave Applications
                                                            @if ($type == 'inbox')
                                                                (Inbox)
                                                            @else
                                                                (Outbox)
                                                            @endif
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="sparkline8-graph">
                                                    <div class="static-table-list">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Emp Code</th>
                                                                    <th>Emp Name</th>
                                                                    <th>Leave Type</th>
                                                                    <th>From Date</th>
                                                                    <th>To Date</th>
                                                                    <th>Half Day</th>
                                                                    <th>Total Applied Days</th>
                                                                    <th>Status</th>
                                                                    @if ($type == 'inbox')
                                                                        <th>Action</th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($applications as $key => $app)
                                                                    <tr>
                                                                        <td>{{ ++$key }}</td>
                                                                        <td>{{ $app->EmpInfo->emp_code }}</td>
                                                                        <td>{{ $app->EmpInfo->name }}</td>
                                                                        <td>{{ $app->LeaveType->name }}</td>
                                                                        <td>{{ date('d-m-Y', strtotime($app->from_date)) }}
                                                                        </td>
                                                                        <td>{{ date('d-m-Y', strtotime($app->to_date)) }}
                                                                        </td>
                                                                        <td>
                                                                            @if ($app->half_day_on)
                                                                                {{ date('d-m-Y', strtotime($app->half_day_on)) }}
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ \App\Helpers\commonHelper::DaysCountFromBlade($app->from_date, $app->to_date, $app->leave_type_id, $app->emp_id) }}
                                                                        </td>
                                                                        <td><span
                                                                                class="badge badge-success">{{ $app->status }}</span>
                                                                        </td>
                                                                        @if ($type == 'inbox')
                                                                            <td><a
                                                                                    href="{{ route('leave.leave-update', Crypt::encrypt($app->id)) }}">Update
                                                                                    Application Status</a></td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
