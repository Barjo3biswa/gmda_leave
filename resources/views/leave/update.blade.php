@extends('layouts.app')
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
                                <li><a href="{{ route('leave.leave-inbox', ['type' => 'inbox']) }}">Inbox(Leave)</a> <span
                                        class="bread-slash">/</span>
                                </li>
                                <li><span class="bread-blod">Approve(Leave)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-payment-inner-st">
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <h4>Leave Inbox</h4>
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="review-content-section">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">Employee Name</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="{{ $applicant_info->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">Leave Type</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="{{ $applications->LeaveType->name }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">From Date</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="{{ date('d-m-Y', strtotime($applications->from_date)) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">To Date</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="{{ date('d-m-Y', strtotime($applications->to_date)) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">Half Day</label>
                                                        <input type="checkbox" disabled
                                                            @if ($applications->is_half_day == 'yes') checked @endif>
                                                        <input type="text" readonly class="form-control"
                                                            @if ($applications->half_day_on) value="{{ date('d-m-Y', strtotime($applications->half_day_on)) }}" @endif>
                                                    </div>
                                                </div>
                                                @if ($applications->attachments)
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Medical Certificate/Other Document</label>
                                                            <br>
                                                            <a href="{{ asset($applications->attachments) }}"
                                                                target="_blank">Click here to view medical Certificate</a>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="name">Reason</label>
                                                        <textarea id="reason" class="form-control" name="reason" rows="4" cols="5" readonly>{{ $applications->reason }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h6>Available Leave- <span
                                                            id="leave_showing">{{ $applicant_info->name }}({{ $applicant_info->emp_code }})</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="sparkline8-graph">
                                                <div class="static-table-list">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Leave Name</th>
                                                                <th>Available Leave</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="emp_availability">
                                                            @foreach ($leave_availability as $availability)
                                                                <tr>
                                                                    <td>{{ $availability->LeaveType->name }}</td>
                                                                    <td>{{ $availability->available_count - $availability->used_count }}
                                                                    </td>
                                                                    <th><a
                                                                            href="{{ route('leave.trans', ['leave_id' => $availability->leave_type_id, 'emp_id' => Auth::user()->id]) }}">Transactions</a>
                                                                    </th>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="review-content-section">
                                            <form
                                                action="{{ route('leave.update-store', Crypt::encrypt($applications->id)) }}"
                                                method="post">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Change Leave Type <span
                                                                    style="color: red;">(if required)</span></label>
                                                            <select name="leave_type" id="leave_type" class="form-control">
                                                                <option value="">--Select--</option>
                                                                @foreach ($leave_type as $type)
                                                                    <option value="{{ $type->id }}"
                                                                        {{ $type->id == $applications->leave_type_id ? 'selected' : '' }}>
                                                                        {{ $type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Applied Leave Duration In Days </label>
                                                            <input type="text" readonly class="form-control"
                                                                value="{{ \App\Helpers\commonHelper::DaysCountFromBlade($applications->from_date, $applications->to_date, $applications->leave_type_id, $applications->emp_id) }}">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Change From Date <span
                                                                    style="color: red;">(if required)</span></label>
                                                            <input type="date" class="form-control"
                                                                name="updated_from_date"
                                                                value="{{ $applications->from_date }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Change To Date <span
                                                                    style="color: red;">(if required)</span></label>
                                                            <input type="date" class="form-control"
                                                                name="updated_to_date"
                                                                value="{{ $applications->to_date }}">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Select Update Status</label>
                                                            <select name="status_type" id="status_type"
                                                                class="form-control" onchange="ToUser()">
                                                                <option value="">--select--</option>
                                                                <option value="Approved">Approve</option>
                                                                <option value="Recommand">Recommand</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group" id="show_hide">
                                                            <label for="name">To User</label>
                                                            <select name="employee_id" id="employee_id"
                                                                class="form-control">
                                                                <option value="">--Select--</option>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        {{ Auth::user()->id == $user->id ? 'selected' : '' }}>
                                                                        {{ $user->name }}({{ $user->emp_code }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="name">Remarks</label>
                                                            <textarea id="remarks" class="form-control" name="remarks" rows="4" cols="5"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="payment-adress">
                                                            <button type="submit"
                                                                class="btn btn-primary waves-effect waves-light btn-xs">Save</button>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h6>Other Applications ( from
                                                        {{ date('d-m-Y', strtotime($applications->from_date)) }} to
                                                        {{ date('d-m-Y', strtotime($applications->to_date)) }})</h6>
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
                                                                <th>Period</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($othher_employee_applications as $key => $app)
                                                                <tr>
                                                                    <td>{{ ++$key }}</td>
                                                                    <td>{{ $app->EmpInfo->emp_code }}</td>
                                                                    <td>{{ $app->EmpInfo->name }}</td>
                                                                    <td>{{ date('d-m-Y', strtotime($app->from_date)) }} to
                                                                        {{ date('d-m-Y', strtotime($app->to_date)) }}</td>
                                                                    <td><span
                                                                            class="badge badge-primary">{{ $app->status }}</span>
                                                                    </td>
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
@endsection
@section('js')
    <script>
        $('#employee_id').prop('disabled', true);
        $("#show_hide").hide();

        function ToUser() {
            var type = $("#status_type").val();
            if (type == "Approved") {
                $('#employee_id').prop('disabled', true);
                $("#show_hide").hide();
            } else {
                $('#employee_id').prop('disabled', false);
                $("#show_hide").show();
            }
        }
    </script>
@endsection
