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
                                <li><span class="bread-blod">Shift Type</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="product-payment-inner-st">
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <h4>Shift Management</h4>
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="review-content-section">
                                            <form action="{{ route('leave.shift-type-save') }}" method="post"
                                                class="dropzone dropzone-custom needsclick add-professors"
                                                id="demo1-upload">
                                                @csrf
                                                @if (isset($editable))
                                                    <input type="hidden" name="id" value="{{ $editable->id }}">
                                                @endif
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input name="name" type="text" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->name }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">In Time</label>
                                                            <input name="in_time" type="time" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->in_time }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="gender">Out Time</label>
                                                            <input name="out_time" type="time" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->out_time }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">First Half Out Time</label>
                                                            <input name="f_half_out_time" type="time"
                                                                class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->f_half_out_time }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="gender">Second Half In Time</label>
                                                            <input name="s_half_in_time" type="time" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->s_half_in_time }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">In Buffer Time</label>
                                                            <input name="in_buffer_time" type="time" class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->in_buffer_time }}" @endif
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Out Buffer Time</label>
                                                            <input name="out_buffer_time" type="time"
                                                                class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->out_buffer_time }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <div class="form-group">
                                                            <label for="name">First <br> Saturday Off</label>
                                                            <input type="checkbox" id="fir_sat_off" name="fir_sat_off"
                                                                value="yes"
                                                                @if (isset($editable)) {{ $editable->fir_sat_off == 'yes' ? 'checked' : '' }} @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <div class="form-group">
                                                            <label for="name">Second<br> Saturday Off</label>
                                                            <input type="checkbox" id="sec_sat_off" name="sec_sat_off"
                                                                value="yes"
                                                                @if (isset($editable)) {{ $editable->sec_sat_off == 'yes' ? 'checked' : '' }} @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <div class="form-group">
                                                            <label for="name">Third<br> Saturday Off</label>
                                                            <input type="checkbox" id="thir_sat_off" name="thir_sat_off"
                                                                value="yes"
                                                                @if (isset($editable)) {{ $editable->thir_sat_off == 'yes' ? 'checked' : '' }} @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <div class="form-group">
                                                            <label for="name">Fourth<br> Saturday Off</label>
                                                            <input type="checkbox" id="for_sat_off" name="for_sat_off"
                                                                value="yes"
                                                                @if (isset($editable)) {{ $editable->for_sat_off == 'yes' ? 'checked' : '' }} @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <div class="form-group">
                                                            <label for="name">Fifth<br> Saturday Off</label>
                                                            <input type="checkbox" id="fif_sat_off" name="fif_sat_off"
                                                                value="yes"
                                                                @if (isset($editable)) {{ $editable->fif_sat_off == 'yes' ? 'checked' : '' }} @endif>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Working Hours</label>
                                                            <input name="working_hour" type="time"
                                                                class="form-control"
                                                                @if (isset($editable)) value="{{ $editable->working_hour }}" @endif
                                                                required>
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
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h6>Shift Type</h6>
                                                    <a href="{{ route('leave.shift-master') }}"
                                                        class="btn btn-primary btn-xs">Add New</a>
                                                </div>
                                            </div>
                                            <div class="sparkline8-graph">
                                                <div class="static-table-list">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>In Time</th>
                                                                <th>Out Time</th>
                                                                <th>Working Hour</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($shifts as $key => $sift)
                                                                <tr>
                                                                    <td>{{ ++$key }}</td>
                                                                    <td>{{ $sift->name }}</td>
                                                                    <td>{{ $sift->in_time }}</td>
                                                                    <td>{{ $sift->out_time }}</td>
                                                                    <td>{{ $sift->working_hour }}</td>
                                                                    <td><a
                                                                            href="{{ route('leave.shift-master', ['editable' => Crypt::encrypt($sift->id)]) }}">Edit</a>
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
