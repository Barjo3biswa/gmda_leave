<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="header-top-menu tabl-d-n">
        <ul class="nav navbar-nav mai-top-nav">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item dropdown res-dis-nn">
                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                    class="nav-link dropdown-toggle">Attendance <span class="angle-down-topmenu"><i
                            class="fa fa-angle-down"></i></span></a>
                <div role="menu" class="dropdown-menu animated zoomIn">
                    <a href="{{ route('leave.attendance-view', ['type' => 'user']) }}" class="dropdown-item">View</a>

                    @if (\App\Helpers\commonHelper::isPermissionExist('attendance_management'))
                        <a href="{{ route('leave.attendance-view') }}" class="dropdown-item">View & Manage</a>

                        <a href="{{ route('leave.punch-data') }}" class="dropdown-item">Punch Data</a>
                    @endif
                </div>
            </li>

            @if (\App\Helpers\commonHelper::isPermissionExist('shift_management'))
                <li class="nav-item dropdown res-dis-nn">
                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                        class="nav-link dropdown-toggle">Shift Management <span class="angle-down-topmenu"><i
                                class="fa fa-angle-down"></i></span></a>
                    <div role="menu" class="dropdown-menu animated zoomIn">
                        <a href="{{ route('leave.shift-master') }}" class="dropdown-item">Shift Master</a>
                        <a href="{{ route('leave.shift-roaster') }}" class="dropdown-item">Roster</a>
                    </div>
                </li>
            @endif

            <li class="nav-item dropdown res-dis-nn">
                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                    class="nav-link dropdown-toggle">Leave<span class="angle-down-topmenu"><i
                            class="fa fa-angle-down"></i></span></a>
                <div role="menu" class="dropdown-menu animated zoomIn">
                    <a href="{{ route('leave.apply') }}" class="dropdown-item">Apply</a>
                    @if (\App\Helpers\commonHelper::isPermissionExist('leave_master'))
                        <a href="{{ route('leave.leave-type') }}" class="dropdown-item">Leave Type</a>
                    @endif
                    @if (
                        \App\Helpers\commonHelper::isPermissionExist('approve_leave') ||
                            \App\Helpers\commonHelper::isPermissionExist('recommand_leave'))
                        <a href="{{ route('leave.leave-inbox', ['type' => 'inbox']) }}" class="dropdown-item">Inbox</a>
                        <a href="{{ route('leave.leave-inbox', ['type' => 'outbox']) }}"
                            class="dropdown-item">Outbox</a>
                    @endif
                </div>
            </li>
            <li class="nav-item"><a href="{{ route('leave.holyday-index') }}" class="nav-link">Holiday</a>
            </li>
        </ul>
    </div>
</div>
