<?php

namespace App\Http\Controllers;

use App\Helpers\commonHelper;
use App\Imports\PunchImport;
use App\Models\Attendance;
use App\Models\attendancePunchData;
use App\Models\attendanceRoaster;
use App\Models\attendanceShift;
use App\Models\LeaveHolyday;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class attendanceController extends Controller
{



    public function punchIndex(Request $request){
        $fromDate = $request->from_date? Carbon::parse($request->from_date)->startOfDay(): Carbon::now()->startOfMonth();
        $toDate = $request->to_date? Carbon::parse($request->to_date)->endOfDay() : Carbon::now()->endOfMonth();

        $punch_data = attendancePunchData::when($fromDate && $toDate, function($q) use($fromDate,$toDate) {
                                                    return $q->whereBetween('punch_date', [$fromDate, $toDate]);
                                                })
                                            ->when($request->status, function($q) use($request){
                                                $status = $request->status=='processed'?$request->status:null;
                                                return $q->where('status',$status);
                                            })
                                            ->orderBy('punch_date')
                                            ->get();
        if(isset($request->button) && $request->button=="Process"){
          commonHelper::ProcessAttendance($punch_data);
           return redirect()->back()->with('success','Processed');
        }
        return view('attendance.punch-index',compact('punch_data'));
    }




    public function samplePunch(Request $request){
        $excel    = [
            0=>[
                'emp_code' => '1000A',
                'punch_date' => '06-11-2024',
                'punch_time' =>  '10:39',
                'terminal_id' => 'Ter1',

            ],
            1=>[
                'emp_code' => '1000B',
                'punch_date' => '06-11-2024',
                'punch_time' =>  '10:39',
                'terminal_id' => 'Ter1',

            ],
        ];
        $fileName = 'Sample-Punch.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        );
        $columns = array('SL',
                        'emp_code',
                        'punch_date',
                        'punch_time',
                        'terminal_id',
                    	);
        $callback = function () use ($excel, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            $count = 0;
            foreach ($excel as $key=>$task) {
                $row['SL']     = ++$key;
                $row['emp_code']   = $task['emp_code'];
                $row['punch_date']   = $task['punch_date'];
                $row['punch_time']   = $task['punch_time'];
                $row['terminal_id']   = $task['terminal_id'];
                fputcsv($file, array(
                                                $row['SL'],
                                                $row['emp_code'],
                                                $row['punch_date'],
                                                $row['punch_time'],
                                                $row['terminal_id'],
                        ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }


    public function uploadPunch(Request $request){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new PunchImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Punch data imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import punch data: ' . $e->getMessage());
        }
    }


    public function attendanceIndex(Request $request){
        $current_month = $request->month ?? date('m');
        $current_year = $request->year ?? date('Y');
        $holiday = LeaveHolyday::whereMonth('date', $current_month)->whereYear('date', $current_year)->get()->pluck('date')->toArray();
        // dd($holiday);
        $employees = User::with(['attendance' => function ($query) use ($current_month, $current_year) {
                                $query->whereMonth('punch_date', $current_month)
                                        ->whereYear('punch_date', $current_year);
                            }]);
        $type = $request->type;
        if($request->type == 'user' || $request->expectsJson()){
            $employees= $employees->where('id',Auth::user()->id)->get();

            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $total_working_days = commonHelper::DaysCount(Carbon::now()->startOfMonth(),Carbon::now(),Auth::user()->id);
            $totalPresent = Attendance::whereMonth('punch_date', $currentMonth)
                                ->where('emp_id',Auth::user()->id)
                                ->whereYear('punch_date', $currentYear)
                                ->whereIn('attendance', ['P'])
                                ->count();
            $totalLate = Attendance::whereMonth('punch_date', $currentMonth)
                                ->where('emp_id',Auth::user()->id)
                                ->whereYear('punch_date', $currentYear)
                                ->whereIn('status',['not_in_time'])
                                ->count();
            $totalleave = Attendance::whereMonth('punch_date', $currentMonth)
                                ->where('emp_id',Auth::user()->id)
                                ->whereYear('punch_date', $currentYear)
                                ->whereIn('status',['on_leave','half_day'])->count();
            $totalAbsent = $total_working_days - $totalPresent;
            $totalPossibleAttendanceDays = $total_working_days;
            $presentRate = ($totalPresent / $totalPossibleAttendanceDays) * 100;
            $absentRate = ($totalAbsent/$totalPossibleAttendanceDays)*100;
            $lateRate = ($totalLate / $totalPossibleAttendanceDays) * 100;
            $total_working_days_full_month = commonHelper::DaysCount(Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth(),Auth::user()->id);
            $leaveRate = ($totalleave / $total_working_days_full_month) * 100;



            $lastMonth = Carbon::now()->subMonth()->month;
            $lastYear = Carbon::now()->subMonth()->year;
            $last_total_working_days = commonHelper::DaysCount(Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth(),Auth::user()->id);
            $last_totalPresent = Attendance::whereMonth('punch_date', $lastMonth)
                                    ->whereYear('punch_date', $lastYear)
                                    ->whereIn('attendance', ['P'])
                                    ->count();
            $last_totalLate = Attendance::whereMonth('punch_date', $lastMonth)
                                ->whereYear('punch_date', $lastYear)
                                ->whereIn('status', ['not_in_time'])
                                ->count();
            $last_leave = Attendance::whereMonth('punch_date', $lastMonth)
                                ->whereYear('punch_date', $lastYear)
                                ->whereIn('status',['on_leave','half_day'])->count();
            $last_totalPossibleAttendanceDays = $last_total_working_days;
            $last_presentRate = ($last_totalPresent / $last_totalPossibleAttendanceDays) * 100;
            $last_absentRate = (($last_totalPossibleAttendanceDays - $last_totalPresent) / $last_totalPossibleAttendanceDays) * 100;
            $last_lateRate = ($last_totalLate / $last_totalPossibleAttendanceDays) * 100;
            $last_leaveRate = ($last_leave / $totalPossibleAttendanceDays) * 100;

            if($request->expectsJson()){
                $roster = attendanceRoaster::where('id',$employees[0]->roster)->first();
                if(isset($roster)){
                    $rosterArray = $roster->toArray();
                    $weekend = null;

                    foreach ($rosterArray as $day => $value) {
                        if (in_array($day, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']) && $value === null) {
                            $weekend = ucfirst($day);
                            break;
                        }
                    }
                }else{
                    $roster = null;
                    $weekend = "Sunday";
                }

                return response()->json([
                    'attendence'=>$employees[0]->attendance,
                    'holiday' =>$holiday,
                    'roster' => $roster,
                    'weekend' => $weekend,
                ],200);
            }

            return view('attendance.view-attendance', compact('employees','holiday','type','current_month','current_year',
                                     'totalPresent', 'totalLate', 'totalleave', 'totalAbsent',
                        'presentRate', 'absentRate', 'lateRate', 'leaveRate', 'last_presentRate', 'last_absentRate', 'last_lateRate', 'last_leaveRate'));
        }else if(commonHelper::isPermissionExist('attendance_view_manage')){
            $employees= $employees->get();
        }else{
            $employees= $employees->where('id',Auth::user()->id)->get();
        }

        return view('attendance.view-attendance', compact('employees','holiday','type','current_month','current_year'));
    }


    public function attendanceUpdate(Request $request){

        $date = date('Y-m-d', $request->date);
        $emp_info = User::where('id',$request->emp_id)->first();
        if($request->type=='P'){
            $status = 'by_admin';
            $data=[
                'emp_id' => $emp_info->id,
                'emp_code' => $emp_info->emp_code,
                'punch_date' => $date,
                'attendance'  => "P",
                'status' => $status,
                'remarks' => $request->remarks
                ];

                Attendance::updateOrCreate(
                    [
                        'emp_id' => $emp_info->id,
                        'punch_date' => $date
                    ],
                    $data
                );
        }else{
            $status = 'absent';
            Attendance::where('emp_id',$emp_info->id)->where('punch_date',$date)->update(['attendance'  => 'ab', 'status' => $status,'remarks' => $request->remarks]);
        }
        return redirect()->back()->with('success','Successfully Updated');
    }
}
