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
                                <li><span class="bread-blod">Punch Data</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-payment-inner-st">
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <h4>Punch Data Management</h4>
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="review-content-section">
                                            <form action="{{ route('leave.punch-upload') }}" method="post"
                                                class="dropzone dropzone-custom needsclick add-professors" id="demo1-upload"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @if (isset($editable))
                                                    <input type="hidden" name="id" value="{{ $editable->id }}">
                                                @endif
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="name">Upload CSV File</label>
                                                            <input name="excel_file" type="file" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-group">
                                                            <a href="{{ route('leave.sample-punch') }}">Click here for csv
                                                                sample </a>
                                                            <div class="payment-adress">
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect waves-light btn-xs">Upload</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="payment-adress">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h6>Filter</h6>
                                                </div>
                                            </div>
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <form action="">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <label for="name">From Date</label>
                                                                    <input name="from_date" type="date"
                                                                        class="form-control"
                                                                        value="{{ Request()->get('from_date') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <label for="name">To Date</label>
                                                                    <input name="to_date" type="date"
                                                                        class="form-control"
                                                                        value="{{ Request()->get('to_date') }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <label for="name">Status</label>
                                                                    <select name="status" id="status"
                                                                        class="form-control">
                                                                        <option value="">--select--</option>
                                                                        <option value="processed"
                                                                            {{ Request()->get('status') == 'processed' ? 'selected' : '' }}>
                                                                            Processed</option>
                                                                        <option value="fresh"
                                                                            {{ Request()->get('status') == 'fresh' ? 'selected' : '' }}>
                                                                            Fresh Data</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                                                <div class="form-group">
                                                                    <input type="submit" name="button" value="Filter"
                                                                        class="btn btn-primary btn-xs"
                                                                        style="margin-top: 25px;">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                                                <div class="form-group">
                                                                    <input type="submit" name="button" value="Process"
                                                                        class="btn btn-warning btn-xs"
                                                                        style="margin-top: 25px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h6>Punch data</h6>
                                                </div>
                                            </div>
                                            <div class="sparkline8-graph">
                                                <div class="static-table-list">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Emp Code</th>
                                                                <th>Emp Name</th>
                                                                <th>Punch Date</th>
                                                                <th>Punch Time</th>
                                                                <th>Terminal</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($punch_data as $data)
                                                                <tr>
                                                                    <td>{{ $data->emp_code }}</td>
                                                                    <td>{{ $data->empInfo->name }}</td>
                                                                    <td>{{ $data->punch_date }}</td>
                                                                    <td>{{ $data->punch_time }}</td>
                                                                    <td>{{ $data->terminal_id }}</td>
                                                                    <td></td>
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
