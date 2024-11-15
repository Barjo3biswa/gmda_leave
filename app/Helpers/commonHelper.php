<?php

namespace App\Helpers;

use App\Models\Attendance;
use App\Models\attendanceRoaster;
use App\Models\attendanceShift;
use App\Models\AuthPermission;
use App\Models\LeaveHolyday;
use App\Models\LeaveTypeMaster;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class commonHelper
{
    public static function formatDate()
    {

        return "okkkkk";
    }


    public static function isPermissionExist($permission_slug)
    {
        $permission_id = AuthPermission::where('slug',$permission_slug)->first();
        if(!$permission_id){
            return false;
        }else{
            $permission_id = $permission_id->id;
        }
        $user_id = Auth::user()->id;
        $user = User::where('id',$user_id)->first();
        $extra_permission = json_decode($user->permission_ids);
        if(in_array($permission_id,$extra_permission)){
            return true;
        }
        foreach($user->roles() as $role){
            $permissions = json_decode($role->permission_ids);
            if(in_array($permission_id,$permissions)){
                return true;
            }
        }
        return false;
    }

    public static function isLeaveApplicable($emp_id, $leave_type_id){
        return true;
    }

    public static function weekArray($shift_id){
        $shift = attendanceShift::where('id',$shift_id)->first();
        $weekArray = [];
        if ($shift->fir_sat_off == "yes") {
            $weekArray[] = 1;
        }
        if ($shift->sec_sat_off == "yes") {
            $weekArray[] = 2;
        }
        if ( $shift->thir_sat_off == "yes") {
            $weekArray[] = 3;
        }
        if ($shift->for_sat_off == "yes") {
            $weekArray[] = 4;
        }
        if ($shift->fif_sat_off == "yes") {
            $weekArray[] = 5;
        }

        return $weekArray;
    }

    public static function DaysCount($from_date, $to_date,$emp_id){
        $from_date = Carbon::parse($from_date);
        $to_date = Carbon::parse($to_date);
        $user = User::where('id',$emp_id)->first();
        $daysCount = 0;
        if($user->roster){
            $roster = attendanceRoaster::where('id',$user->roster)->first();
            for ($date = $from_date; $date->lte($to_date); $date->addDay()) {
                $date_new = new DateTime($date);
                $dayName = strtolower($date_new->format('l'));
                $isSunday = is_null($roster->$dayName);
                if(!$isSunday){
                    $daysCount++;
                }
            }
            return $daysCount;
        }
        $holidays = LeaveHolyday::pluck('date')->toArray();

        $shift = attendanceShift::where('id',$user->shift_id)->first();
        $weekArray = self::weekArray($user->shift_id);

        for ($date = $from_date; $date->lte($to_date); $date->addDay()) {
            if (!in_array($date->toDateString(), $holidays)) {
                $dayOfWeek = $date->dayOfWeek;
                $weekOfMonth = ceil($date->day / 7);
                if (!($dayOfWeek == 0 || ($dayOfWeek == 6 && (in_array($weekOfMonth,$weekArray))))) {
                    $daysCount++;
                }
            }
        }
        return $daysCount;
    }


    public static function DaysCountFromBlade($from_date, $to_date, $type_id,$emp_id){
        $leave_type_master = LeaveTypeMaster::where('id',$type_id)->first();

        if($leave_type_master->is_sandwich=='no'){
            return self::DaysCount($from_date, $to_date,$emp_id);
        }else{
            $fromDate = Carbon::parse($from_date);
            $toDate = Carbon::parse($to_date);
            $day_count = $fromDate->diffInDays($toDate) + 1;
            return $day_count;
        }

    }

    public static function ProcessAttendance($punch_data){
        foreach($punch_data as $punch){

            $user = User::where('id',$punch->emp_id)->first();
            if($user->roster){
                $roster = attendanceRoaster::where('id',$user->roster)->first();
                $dayName = strtolower(date('l'));
                $shift = attendanceShift::where('id',$roster->$dayName)->first();
            }else{
                $shift = attendanceShift::where('id',$user->shift_id)->first();
            }

            $record = Attendance::where('emp_id',$punch->emp_id)->where('punch_date', $punch->punch_date)->first();
            // dd($record);
            if(isset($record)){
                if($record->is_processed==1){
                    continue;
                }

                if(date('H:i', strtotime($record->in_time)) == date('H:i', strtotime($punch->punch_time)) || date('H:i', strtotime($record->out_time)) == date('H:i', strtotime($punch->punch_time))){
                    continue;
                }

                if(!$record->out_time && $record->in_time < $punch->punch_time){
                    $in_time = $record->in_time;
                    $out_time = $punch->punch_time;
                }else if(!$record->out_time && $record->in_time > $punch->punch_time){ // this may execute in case of excel data
                    $in_time = $punch->punch_time;
                    $out_time = $record->in_time;
                }


                if($record->out_time && $record->out_time < $punch->punch_time){
                    $in_time = $record->in_time;
                    $out_time = $punch->punch_time;
                }else if($record->out_time && $record->out_time > $punch->punch_time){ // this may execute in case of excel data
                    $in_time = $record->in_time;
                    $out_time = $record->out_time;
                }


                if(!$record->in_time){
                    $in_time = $punch->punch_time;
                    $out_time = null;
                }


                $shift_in_time = strtotime($shift->in_time);
                $shift_out_time = strtotime($shift->out_time);
                $shift_working_hour = strtotime($shift->working_hour);

                if($record->status == 'half_day'){
                    if($record->leaveApplication->is_half_type=="first_half"){
                        $shift_in_time = strtotime($shift->s_half_in_time);
                        $shift_out_time = strtotime($shift->out_time);
                        $shift_working_hour = strtotime($shift->h_d_working_hour);

                    }else{
                        $shift_in_time = strtotime($shift->in_time);
                        $shift_out_time = strtotime($shift->f_half_out_time);
                        $shift_working_hour = strtotime($shift->h_d_working_hour);
                    }
                }


                $in_time_obj = strtotime($in_time);
                $out_time_obj = strtotime($out_time);
                $late_by = ($shift_in_time < $in_time_obj) ? $in_time_obj - $shift_in_time : 0;
                $early_going_by = ($shift_out_time > $out_time_obj) ? $shift_out_time - $out_time_obj : 0;
                $overtime = ($shift_out_time < $out_time_obj) ? $out_time_obj - $shift_out_time : 0;
                // dd($out_time_obj);
                $attendance = $record->attendance;
                $status = $record->status;
                $out_buffer = strtotime($shift->out_buffer_time);
                $in_buffer = strtotime($shift->in_buffer_time);


                if(gmdate('H:i:s', $out_buffer) < gmdate('H:i:s', $early_going_by)){
                    if($record->status != 'half_day'){
                        $attendance = 'ab';
                        $status = 'not_in_time';
                    }else{
                        $attendance = 'ab';
                    }
                }else{
                    $attendance = 'P';
                }

                // dump(gmdate('H:i:s', $in_buffer) , gmdate('H:i:s', $late_by));

                if(gmdate('H:i:s', $in_buffer) < gmdate('H:i:s', $late_by)){
                    // dd("ok");
                    if($record->status != 'half_day'){
                        $attendance = 'ab';
                        $status = 'not_in_time';
                    }else{
                        $attendance = 'ab';
                    }
                }else{
                    $attendance = 'P';
                }
                // dd("not");
                $late_by = gmdate('H:i:s', $late_by);
                $early_going_by = gmdate('H:i:s', $early_going_by);
                $overtime = gmdate('H:i:s', $overtime);
                $working_hour = gmdate('H:i:s', $out_time_obj-$in_time_obj);

                if($shift_working_hour > strtotime($working_hour)){
                    $overtime = 0;
                }

                $data=[
                    'in_time' => $in_time,
                    'out_time' => $out_time,
                    'late_by' => $late_by,
                    'early_going_by' => $early_going_by,
                    'overtime' => $overtime,
                    'working_hour' => $working_hour,
                    'attendance' => $attendance,
                    'status' => $status
                    ];
                // dd($data);
                $record->update($data);
            }else{

                $shift_in_time = strtotime($shift->in_time);
                $punch_time_obj = strtotime($punch->punch_time);
                $in_buffer = strtotime($shift->in_buffer_time);
                $late_by = ($shift_in_time < $punch_time_obj) ? $punch_time_obj - $shift_in_time : 0;
                $attendance = 'P';
                $status = 'present';
                if(gmdate('H:i:s', $in_buffer) < gmdate('H:i:s', $late_by)){
                    $status = 'not_in_time';
                    $attendance = 'ab';
                }
                $late_by = gmdate('H:i:s', $late_by);

                $data=[
                    'emp_id' => $punch->emp_id,
                    'emp_code' => $punch->emp_code,
                    'punch_date' => $punch->punch_date,
                    'in_time' => $punch->punch_time,
                    's_in_time' => $shift->in_time,
                    's_out_time' => $shift->out_time,
                    'late_by' => $late_by,
                    'attendance' => $attendance,
                    'status' => $status
                    ];

                Attendance::create($data);
            }
            $punch->update(['status'=>'processed']);
        }
    }


    public static function totalWorkingDays($startDate, $endDate, $type){
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $holidays = LeaveHolyday::whereBetween('date', [$startDate, $endDate])
                                ->pluck('date')
                                ->toArray();
        $workingDaysCount = 0;
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek;
            $dayOfMonth = $date->day;
            $weekOfMonth = ceil($dayOfMonth / 7);
            if ($dayOfWeek == Carbon::SUNDAY ||
                ($dayOfWeek == Carbon::SATURDAY && ($weekOfMonth == 2 || $weekOfMonth == 4))) {
                continue;
            }
            if (in_array($date->toDateString(), $holidays)) {
                continue;
            }
            $workingDaysCount++;
        }
        return $workingDaysCount;
    }
}

