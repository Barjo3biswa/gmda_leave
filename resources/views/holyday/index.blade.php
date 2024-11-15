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
                            <li><span class="bread-blod">Holiday</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-payment-inner-st">
                    <div id="myTabContent" class="tab-content custom-product-edit">
                        <div class="product-tab-list tab-pane fade active in" id="description">
                            <div class="row">
                                @if (\App\Helpers\commonHelper::isPermissionExist('holiday_create'))
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="review-content-section">
                                        <form action="{{route('leave.holyday-import')}}" method="post" class="dropzone dropzone-custom needsclick add-professors" id="demo1-upload" enctype="multipart/form-data">
                                            @csrf
                                            @if (isset($editable))
                                                <input type="hidden" name="id" value="{{$editable->id}}">
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="date">CSV Upload</label>
                                                        <input type="file" name="excel_file" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="form-group">
                                                        <a href="{{route('leave.sample-holyday')}}">Click here for csv sample </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="payment-adress">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Import</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="review-content-section">
                                        <form action="{{route('leave.holyday-save')}}" method="post" class="dropzone dropzone-custom needsclick add-professors" id="demo1-upload">
                                            @csrf
                                            @if (isset($editable))
                                                <input type="hidden" name="id" value="{{$editable->id}}">
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input name="date" type="date" class="form-control"
                                                        @if (isset($editable))
                                                            value="{{$editable->date}}"
                                                        @endif
                                                        required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="name">Holiday Name</label>
                                                        <input name="name" type="text" class="form-control" placeholder="Holyday Name"
                                                        @if (isset($editable))
                                                            value="{{$editable->name}}"
                                                        @endif required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="type">Half/Full Day</label>
                                                        <select name="type" id="type" class="form-control" required>
                                                            <option value="">--Select--</option>
                                                            <option value="full" @if (isset($editable)){{$editable->type=='full'?'selected':''}}@endif>Full Day</option>
                                                            <option value="half" @if (isset($editable)){{$editable->type=='half'?'selected':''}}@endif>Half Day</option>
                                                        </select>
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
                                @endif
                                @php
                                    $span = \App\Helpers\commonHelper::isPermissionExist('holiday_create')?'6':12;
                                @endphp
                                <div class="col-lg-{{$span}} col-md-{{$span}} col-sm-{{$span}} col-xs-12">
                                    <div class="sparkline8-list">
                                        <div class="sparkline8-hd">
                                            <div class="main-sparkline8-hd">
                                                <h1>Holiday List</h1>
                                            </div>
                                        </div>
                                        <div class="sparkline8-graph">
                                            <div class="static-table-list">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Holiday Name</th>
                                                            <th>Type</th>
                                                            @if (\App\Helpers\commonHelper::isPermissionExist('holiday_create'))
                                                                <th>Action</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($holyday_list as $key=>$day)
                                                            <tr>
                                                                <td>{{++$key}}</td>
                                                                <td>{{$day->date}}</td>
                                                                <td>{{$day->name}}</td>
                                                                <td>{{$day->type}}</td>
                                                                @if (\App\Helpers\commonHelper::isPermissionExist('holiday_create'))
                                                                <td>
                                                                    <a href="{{route('leave.holyday-index',['id'=>Crypt::encrypt($day->id)])}}"><i class="fa fa-edit"></i></a>
                                                                    <a href="{{route('leave.holyday-delete',['id'=>Crypt::encrypt($day->id)])}}"
                                                                    onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i></a>
                                                                </td>
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
@endsection
