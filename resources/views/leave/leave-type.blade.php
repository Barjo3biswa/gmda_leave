@extends('layouts.app')

@section('content')
    {{-- <div class="breadcome-area">
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
                                <li><span class="bread-blod">Leave Type</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

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
                                <li><span class="bread-blod">Leave Type</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-payment-inner-st">
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <h4>Leave Type</h4>
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                                        <div class="review-content-section">
                                            <form action="{{ route('leave.leave-type-save') }}" method="post"
                                                class="dropzone dropzone-custom needsclick add-professors"
                                                id="demo1-upload">
                                                @csrf
                                                @if (isset($editable))
                                                    <input type="hidden" name="id" value="{{ $editable->id }}">
                                                @endif
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Leave Name</label>
                                                            <input name="name" type="text" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->name }}"  readonly @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="gender">Gender Criteria</label>
                                                            <select name="gender" id="gender" class="form-control"
                                                                required>
                                                                <option value="">--select--</option>
                                                                <option value="all"
                                                                    @if (isset($editable)) {{ $editable->gender == 'all' ? 'selected' : '' }} @endif>
                                                                    All</option>
                                                                <option value="female"
                                                                    @if (isset($editable)) {{ $editable->gender == 'female' ? 'selected' : '' }} @endif>
                                                                    Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="max_leave">Maximum Leave Accumulate</label>
                                                            <input name="max_leave" type="number" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->max_leave }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="accommodation_period">Accumulation Period</label>
                                                            <select name="accommodation_period" id="accommodation_period"
                                                                class="form-control">
                                                                <option value="">--select--</option>
                                                                {{-- <option value="one_month">One Month</option> --}}
                                                                <option value="one_year"
                                                                    @if (isset($editable)) {{ $editable->accommodation_period == 'one_year' ? 'selected' : '' }} @endif>
                                                                    One Year</option>
                                                                <option value="service_life"
                                                                    @if (isset($editable)) {{ $editable->accommodation_period == 'service_life' ? 'selected' : '' }} @endif>
                                                                    Service Life</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="max_limit">Maximum Leave Apply Limit</label>
                                                            <input name="max_limit" type="number" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->max_limit }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="limit_period">Apply Limit Reset Period </label>
                                                            <select name="limit_period" id="limit_period"
                                                                class="form-control">
                                                                <option value="">--select--</option>
                                                                {{-- <option value="one_month">One Month</option> --}}
                                                                <option value="one_year"
                                                                    @if (isset($editable)) {{ $editable->limit_period == 'one_year' ? 'selected' : '' }} @endif>
                                                                    One Year</option>
                                                                <option value="service_life"
                                                                    @if (isset($editable)) {{ $editable->limit_period == 'service_life' ? 'selected' : '' }} @endif>
                                                                    Service Life</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="can_apply">Applicable For</label>
                                                            <select name="can_apply" id="can_apply" class="form-control">
                                                                <option value="">--select--</option>
                                                                <option value="all"
                                                                    @if (isset($editable)) {{ $editable->can_apply == 'all' ? 'selected' : '' }} @endif>
                                                                    All</option>
                                                                <option value="regular"
                                                                    @if (isset($editable)) {{ $editable->can_apply == 'regular' ? 'selected' : '' }} @endif>
                                                                    Regular Employee</option>
                                                                <option value="temporary"
                                                                    @if (isset($editable)) {{ $editable->can_apply == 'temporary' ? 'selected' : '' }} @endif>
                                                                    Temporary Employee</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="can_apply_at">When Can Apply</label>
                                                            <select name="can_apply_at" id="can_apply_at"
                                                                class="form-control">
                                                                <option value="">--select--</option>
                                                                <option value="all"
                                                                    @if (isset($editable)) {{ $editable->can_apply_at == 'all' ? 'selected' : '' }} @endif>
                                                                    All</option>
                                                                <option value="after_six_months"
                                                                    @if (isset($editable)) {{ $editable->can_apply_at == 'after_six_months' ? 'selected' : '' }} @endif>
                                                                    After Six Months of Service</option>
                                                                <option value="after_one_year"
                                                                    @if (isset($editable)) {{ $editable->can_apply_at == 'after_one_year' ? 'selected' : '' }} @endif>
                                                                    After One Year of Service</option>
                                                                <option value="after_three_year"
                                                                    @if (isset($editable)) {{ $editable->can_apply_at == 'after_three_year' ? 'selected' : '' }} @endif>
                                                                    After Three Years of Service</option>
                                                                <option value="after_five_year"
                                                                    @if (isset($editable)) {{ $editable->can_apply_at == 'after_five_year' ? 'selected' : '' }} @endif>
                                                                    After Five Years of Service</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="min_allowed">Minimum Allowed (Apply Limit)</label>
                                                            <input name="min_allowed" type="number" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->min_allowed }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="max_allowed">Maximum Allowed (Apply Limit)</label>
                                                            <input name="max_allowed" type="number" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->max_allowed }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="pay_type">Pay Type(During Leave)</label>
                                                            <select name="pay_type" id="pay_type" class="form-control">
                                                                <option value="">--select--</option>
                                                                <option value="full_pay"
                                                                    @if (isset($editable)) {{ $editable->pay_type == 'full_pay' ? 'selected' : '' }} @endif>
                                                                    Full Pay</option>
                                                                <option value="half_pay"
                                                                    @if (isset($editable)) {{ $editable->pay_type == 'half_pay' ? 'selected' : '' }} @endif>
                                                                    Half Pay</option>
                                                                <option value="no_pay"
                                                                    @if (isset($editable)) {{ $editable->pay_type == 'no_pay' ? 'selected' : '' }} @endif>
                                                                    No Pay</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="credit_count">Leave Credit Count</label>
                                                            <input name="credit_count" type="number"
                                                                class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->credit_count }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="credit_intervel">Credit Intervel</label>
                                                            <select name="credit_intervel" id="credit_intervel"
                                                                class="form-control">
                                                                <option value="">--select--</option>
                                                                <option value="monthly"
                                                                    @if (isset($editable)) {{ $editable->credit_intervel == 'monthly' ? 'selected' : '' }} @endif>
                                                                    Monthly</option>
                                                                <option value="half_yearly"
                                                                    @if (isset($editable)) {{ $editable->credit_intervel == 'half_yearly' ? 'selected' : '' }} @endif>
                                                                    Half Yearly</option>
                                                                <option value="yearly"
                                                                    @if (isset($editable)) {{ $editable->credit_intervel == 'yearly' ? 'selected' : '' }} @endif>
                                                                    Yearly</option>
                                                                <option value="service_life"
                                                                    @if (isset($editable)) {{ $editable->credit_intervel == 'service_life' ? 'selected' : '' }} @endif>
                                                                    Service Life</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="credit_time">Credit Time</label>
                                                            <select name="credit_time" id="credit_time"
                                                                class="form-control">
                                                                <option value="">--select--</option>
                                                                <option value="begening"
                                                                    @if (isset($editable)) {{ $editable->credit_time == 'begening' ? 'selected' : '' }} @endif>
                                                                    At the begining of intervel</option>
                                                                <option value="end"
                                                                    @if (isset($editable)) {{ $editable->credit_time == 'end' ? 'selected' : '' }} @endif>
                                                                    At the end of intervel</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="min_allowed">Leave Sandwich Policy</label>
                                                            <input type="checkbox" id="is_sandwich" name="is_sandwich"
                                                                value="yes"
                                                                @if (isset($editable)) {{ $editable->is_sandwich == 'yes' ? 'checked' : '' }} @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="max_allowed">Linked With Half Pay Leave</label>
                                                            <input type="checkbox" id="is_half_pay_link"
                                                                name="is_half_pay_link" value="yes"
                                                                @if (isset($editable)) {{ $editable->is_half_pay_link == 'yes' ? 'checked' : '' }} @endif>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="payment-adress">
                                                            <button type="submit"
                                                                class="btn btn-primary waves-effect waves-light btn-xs">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h6>Leave List</h6>
                                                    <a href="{{ route('leave.leave-type') }}"
                                                        class="btn btn-primary btn-xs">Add
                                                        New Leave </a>
                                                </div>
                                            </div>
                                            <div class="sparkline8-graph">
                                                <div class="static-table-list">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($leave_types as $key => $type)
                                                                <tr>
                                                                    <td>{{ ++$key }}</td>
                                                                    <th>{{ $type->name }}</th>
                                                                    <th><a
                                                                            href="{{ route('leave.leave-type', ['id' => Crypt::encrypt($type->id)]) }}">Edit</a>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
