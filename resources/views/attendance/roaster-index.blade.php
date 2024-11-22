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
                                <li><span class="bread-blod">Roaster</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="product-payment-inner-st">
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <h4>Roster Management</h4>
                            <div class="product-tab-list tab-pane fade active in" id="description">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                        <div class="review-content-section">
                                            <form action="{{ route('leave.roaster-save') }}" method="post"
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
                                                @php
                                                    $days = [
                                                        'Monday',
                                                        'Tuesday',
                                                        'Wednesday',
                                                        'Thursday',
                                                        'Friday',
                                                        'Saturday',
                                                        'Sunday',
                                                    ];
                                                @endphp
                                                <div class="row">
                                                    @foreach ($days as $day)
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label
                                                                    for="{{ strtolower($day) }}">{{ $day }}</label>
                                                                <select name="{{ strtolower($day) }}"
                                                                    id="{{ strtolower($day) }}" class="form-control"
                                                                    required>
                                                                    <option value="off">OFF</option>
                                                                    @foreach ($shifts as $sif)
                                                                        <option value="{{ $sif->id }}"
                                                                            @if (isset($editable) && $editable->{strtolower($day)} == $sif->id) selected @endif>
                                                                            {{ $sif->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endforeach
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
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    {{-- <h1>Roster</h1> --}}
                                                    {{-- <a href="{{route('leave.shift-roaster')}}" class="btn btn-primary">Add New</a> --}}
                                                </div>
                                            </div>
                                            <div class="sparkline8-graph">
                                                <div class="static-table-list">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Monday</th>
                                                                <th>Tuesday</th>
                                                                <th>Wednesday</th>
                                                                <th>Thursday</th>
                                                                <th>Friday</th>
                                                                <th>Saturday</th>
                                                                <th>Sunday</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($roaster as $rst)
                                                                <tr>
                                                                    <td>{{ $rst->name }}</td>
                                                                    <td>{{ $rst->mondaySift->name ?? 'Off' }}</td>
                                                                    <td>{{ $rst->tuesdaySift->name ?? 'Off' }}</td>
                                                                    <td>{{ $rst->wednesdaySift->name ?? 'Off' }}</td>
                                                                    <td>{{ $rst->thursdaySift->name ?? 'Off' }}</td>
                                                                    <td>{{ $rst->fridaySift->name ?? 'Off' }}</td>
                                                                    <td>{{ $rst->saturdaySift->name ?? 'Off' }}</td>
                                                                    <td>{{ $rst->sundaySift->name ?? 'Off' }}</td>
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
                                        <div class="sparkline8-list">
                                            <div class="sparkline8-hd">
                                                <div class="main-sparkline8-hd">
                                                    <h6>Assign Roster</h6>
                                                </div>
                                            </div>
                                            <div class="sparkline8-graph">
                                                <div class="static-table-list">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Emp Name</th>
                                                                <th>Emp Code</th>
                                                                <th>Roster</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($users as $key => $usr)
                                                                <form
                                                                    action="{{ route('leave.roster-change', Crypt::encrypt($usr->id)) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <tr>
                                                                        <td>{{ ++$key }}</td>
                                                                        <td>{{ $usr->name }}</td>
                                                                        <td>{{ $usr->emp_code }}</td>
                                                                        <td>
                                                                            <select name="assigned_roster"
                                                                                id="assigned_roster" class="form-control">
                                                                                <option value="">Office Duty</option>
                                                                                @foreach ($roaster as $rst)
                                                                                    <option value="{{ $rst->id }}"
                                                                                        {{ $usr->roster == $rst->id ? 'selected' : '' }}>
                                                                                        {{ $rst->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="submit"
                                                                                class="btn btn-primary btn-xs"
                                                                                value="Change"></td>
                                                                    </tr>
                                                                </form>
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
