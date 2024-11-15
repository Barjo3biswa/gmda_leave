@extends('layouts.app')
@section('css')
<style>
    /* body{margin-top:20px;} */
    .timeline-steps {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
        padding: 0 15px;
    }

    .timeline-steps .timeline-step {
        align-items: center;
        display: flex;
        flex-direction: column;
        position: relative;
        margin: 0.5rem;
    }

    @media (min-width:768px) {
        .timeline-steps .timeline-step:not(:last-child):after {
            content: "";
            display: block;
            border-top: .25rem solid gray;
            width: 6rem;
            position: absolute;
            left: 5rem;
            top: .3125rem;
        }
        .timeline-steps .timeline-step:not(:first-child):before {
            content: "";
            display: block;
            border-top: .25rem solid gray;
            width: 2.5rem;
            position: absolute;
            right: 5rem;
            top: .3125rem;
        }

         /* Green solid line for steps within the "applied" class */
         .timeline-steps .timeline-step.applied:not(:last-child):after,
        .timeline-steps .timeline-step.applied:not(:first-child):before {
            border-top: .25rem solid rgb(120, 161, 120); /* Green dotted line */
        }
    }


    /* General gray styling for all steps */
    .timeline-steps .timeline-content {
        width: 8rem;
        text-align: center;
        color: gray;
    }
    .timeline-steps .timeline-content .inner-circle {
        border-radius: 1.5rem;
        height: 1rem;
        width: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: gray;
    }
    .timeline-steps .timeline-content .inner-circle:before {
        content: "";
        background-color: gray;
        display: inline-block;
        height: 1.5rem;
        width: 1.5rem;
        min-width: 1.5rem;
        border-radius: 4.25rem;
        opacity: .5;
    }



    /* Green styling for the "Applied" step */
    .timeline-steps .timeline-step.applied .timeline-content {
        color: green;
    }
    .timeline-steps .timeline-step.applied .inner-circle,
    .timeline-steps .timeline-step.applied .inner-circle:before {
        background-color: green;
    }

.review-content-section p {
    color: #303030;
    font-weight: 450;
    font-size: 10px;
    line-height: 10px;
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
                            <li><span class="bread-blod">Apply Leave</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-payment-inner-st">
                    <div id="myTabContent" class="tab-content custom-product-edit">
                        <div class="product-tab-list tab-pane fade active in" id="description">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="review-content-section">
                                        <form action="{{ route('leave.apply-save') }}" method="post" class="dropzone dropzone-custom needsclick add-professors" id="demo1-upload" enctype="multipart/form-data">
                                            @csrf
                                            @if (isset($editable))
                                                <input type="hidden" name="id" value="{{$editable->id}}">
                                            @endif
                                            {{-- <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="name">Applying For <span style="color: red;">*</span></label>  &nbsp;&nbsp;
                                                        <input type="radio" id="self" name="apply_for" value="self">
                                                        <label for="self">Self</label>
                                                        <input type="radio" id="other" name="apply_for" value="other">
                                                        <label for="other">Other</label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">Employee Name <span style="color: red;">*</span></label>
                                                        <select name="employee_id" id="employee_id" class="form-control" onchange="this.value='{{ Auth::user()->id }}'" required>
                                                            <option value="">--Select--</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{$user->id}}" {{Auth::user()->id==$user->id?'selected':''}}>{{$user->name}}({{$user->emp_code}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">Leave Type {{Request()->get('leave_type')}}<span style="color: red;">*</span></label>
                                                        <select name="leave_type" id="leave_type" class="form-control" required>
                                                            <option value="">--Select--</option>
                                                            @foreach ($leave_type as $type)
                                                                <option value="{{$type->id}}" {{Request()->old('leave_type')==$type->id?'selected':''}}>{{$type->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">From Date <span style="color: red;">*</span></label>
                                                        <input type="date" name="form_date" id="form_date" class="form-control" onchange="getDate()" value="{{Request()->old('form_date')}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">To Date <span style="color: red;">*</span></label>
                                                        <input type="date" name="to_date" id="to_date" class="form-control" onchange="getDate()" value="{{Request()->old('form_date')}}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <div class="form-group">
                                                        <label for="name">Half Day</label>
                                                        <input type="checkbox" id="is_half_day" name="is_half_day" value="yes" >
                                                        <select name="half_day" id="half_day" class="form-control" required>
                                                            <option value="">--Half Day On--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <div class="form-group">
                                                        <label for="name">First/Second Half</label>
                                                        <select name="half_day_type" id="half_day_type" class="form-control" required>
                                                            <option value="">--select--</option>
                                                            <option value="first_half">First half</option>
                                                            <option value="second_half">Second half</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="name">Medical Certificate/Other Document</label>
                                                        <input type="file" class="form-control" name="attachment">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="name">Reason</label>
                                                        <textarea id="reason" class="form-control" name="reason" rows="4" cols="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="payment-adress">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="review-content-section">
                                        <div class="row">
                                            <div class="col">
                                                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                                                    @if (isset($my_last_application))
                                                        @foreach ($my_last_application->leaveApplicationTrans as $key=>$app_trans)
                                                            <div class="timeline-step applied">
                                                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                                                                    <div class="inner-circle"></div>
                                                                    <p class="h6 mt-3 mb-1">{{date('d-m-Y', strtotime($app_trans->date))}} <br> {{$app_trans->status}}
                                                                    @if ($app_trans->status=='Applied')
                                                                        for {{$my_last_application->LeaveType->name}} ({{date('d-m-Y', strtotime($my_last_application->from_date))}} to
                                                                        {{date('d-m-Y', strtotime($my_last_application->to_date))}} )
                                                                    @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            @if($app_trans->status != 'Approved' && count($my_last_application->leaveApplicationTrans)==(++$key))
                                                            <div class="timeline-step ">
                                                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                                                                    <div class="inner-circle"></div>
                                                                    <p class="h6 mt-3 mb-1">Waiting for approvel at  {{$app_trans->ToUser->name}}</p>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sparkline8-list">
                                        <div class="sparkline8-hd">
                                            <div class="main-sparkline8-hd">
                                                <h1>Available Leave- <span id="leave_showing">{{Auth::user()->name}}({{Auth::user()->emp_code}})</span></h1>
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
                                                                <td>{{$availability->LeaveType->name}}</td>
                                                                <td>{{$availability->available_count - $availability->used_count}}</td>
                                                                <th><a href="{{route('leave.trans',['leave_id'=>$availability->leave_type_id,'emp_id'=>Auth::user()->id])}}">Trans</a></th>
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
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h4>Other Employee Applications</h4>
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
                                                            @foreach ($othher_employee_applications as $key=>$app)
                                                                <tr>
                                                                    <td>{{++$key}}</td>
                                                                    <td>{{$app->EmpInfo->emp_code}}</td>
                                                                    <td>{{$app->EmpInfo->name}}</td>
                                                                    <td>{{date('d-m-Y', strtotime($app->from_date))}} to
                                                                        {{date('d-m-Y', strtotime($app->to_date))}}</td>
                                                                    <td><span class="badge badge-primary">{{$app->status}}</span></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="review-content-section">
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h1>My Application</h1>
                                                </div>
                                            </div>
                                            <div class="sparkline8-graph">
                                                <div class="static-table-list">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Leave Period</th>
                                                                <th>In Days</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($my_applications as $key=>$app)
                                                                <tr>
                                                                    <td>{{++$key}}</td>
                                                                    <td>{{$app->from_date}} - {{$app->to_date}}</td>
                                                                    <td>{{\App\Helpers\commonHelper::DaysCountFromBlade($app->from_date,$app->to_date,$app->leave_type_id,$app->emp_id)}}</td>
                                                                    <td><span class="badge badge-primary">{{$app->status}}</span></td>
                                                                    <td>
                                                                        @if($app->from_date < \Carbon\Carbon::now())
                                                                            <a href="#">Withdraw</a>
                                                                        @endif
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
</div>
@endsection

@section('js')

<script>
    $("#half_day").prop("disabled", true);
    $("#half_day_type").prop("disabled", true);
    $("#is_half_day").change(function() {
        if ($(this).is(":checked")) {
            $("#half_day").prop("disabled", false);
            $("#half_day_type").prop("disabled", false);
        } else {
            $("#half_day").prop("disabled", true);
            $("#half_day_type").prop("disabled", true);
            $("#half_day").empty().append('<option value="">--Half Day On--</option>');
        }
    });
</script>
<script>
    function getDate() {
        var form_date = $("#form_date").val();
        var to_date = $("#to_date").val();
        var startDate = new Date(form_date);
        var endDate = new Date(to_date);
        $("#half_day").empty();
        $("#half_day").append('<option value="">--Half Day On--</option>');
        while (startDate <= endDate) {
            var formattedDate = startDate.toISOString().split('T')[0];
            $("#half_day").append(`<option value="${formattedDate}">${formattedDate}</option>`);
            startDate.setDate(startDate.getDate() + 1);
        }
    }
</script>

<script>
    $("#employee_id").change(function(){
        var emp_id = $("#employee_id").val();
        $.ajax({
            'url' : '{{route('leave.employee-details')}}',
            'type' : 'get',
            'data'  : {emp_id: emp_id},
            'dataType' : 'json',
            'success' : function(response) {
                var html = `${response.emp_details.name} (${response.emp_details.emp_code})`;
                $("#leave_showing").empty().append(html);
                var tbodyHtml = '';
                response.leave_availability.forEach(function(availability) {
                    const leaveTypeName = availability.leave_type ? availability.leave_type.name : 'N/A';
                    var transUrl = `{{ route('leave.trans', ['leave_id' => '__leave_id__', 'emp_id' => '__emp_id__']) }}`
                        .replace('__leave_id__', availability.leave_type_id)
                        .replace('__emp_id__', response.emp_details.id);

                    tbodyHtml += `
                        <tr>
                            <td>${leaveTypeName}</td>
                            <td>${availability.available_count - availability.used_count}</td>
                            <td><a href="${transUrl}">Trans</a></td>
                        </tr>
                    `;
                });

                console.log(response);
                $("#emp_availability").empty().append(tbodyHtml);
                var leaveTypeSelect = $('#leave_type');
                leaveTypeSelect.empty();
                leaveTypeSelect.append('<option value="">--Select--</option>');
                response.leave_type.forEach(function(type) {
                    leaveTypeSelect.append(`<option value="${type.id}">${type.name}</option>`);
                });

            },
            'error': function(response) {
                console.log(response)
            }
        });
    })
</script>
@endsection
