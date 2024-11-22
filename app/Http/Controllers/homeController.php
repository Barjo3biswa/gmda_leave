<?php

namespace App\Http\Controllers;

use App\Helpers\commonHelper;
use App\Models\Attendance;
use App\Models\LeaveHolyday;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        if (!commonHelper::isPermissionExist(permission_slug: 'attendance_management')) {
            return redirect()->route("leave.attendance-view", ['type' => 'user']);
        }
        $date = Carbon::now()->format('Y-m-d');
        // dd($date);
        $total_employee = User::count();
        $present = Attendance::where('punch_date', $date)->whereIn('attendance', ['P'])->get();
        $leave = Attendance::where('punch_date', $date)->whereIn('status', ['on_leave', 'half_day'])->get();
        $late = Attendance::where('punch_date', $date)->whereIn('status', ['not_in_time'])->get();
        $absent = $total_employee - ($present->count() + $leave->count());

        $absentees = User::whereDoesntHave('attendance', function ($query) use ($date) {
            $query->where('punch_date', $date);
        })
            ->get();
        // dd($absentees);

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $total_working_days = commonHelper::totalWorkingDays(Carbon::now()->startOfMonth(), Carbon::now(), false);
        $totalPresent = Attendance::whereMonth('punch_date', $currentMonth)
            ->whereYear('punch_date', $currentYear)
            ->whereIn('attendance', ['P'])
            ->count();
        $totalLate = Attendance::whereMonth('punch_date', $currentMonth)
            ->whereYear('punch_date', $currentYear)
            ->whereIn('status', ['not_in_time'])
            ->count();
        $totalPossibleAttendanceDays = $total_working_days * $total_employee;
        $presentRate = ($totalPresent / $totalPossibleAttendanceDays) * 100;
        $absentRate = (($totalPossibleAttendanceDays - $totalPresent) / $totalPossibleAttendanceDays) * 100;
        $lateRate = ($totalLate / $totalPossibleAttendanceDays) * 100;


        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subMonth()->year;
        $last_total_working_days = commonHelper::totalWorkingDays(Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth(), false);
        $last_totalPresent = Attendance::whereMonth('punch_date', $lastMonth)
            ->whereYear('punch_date', $lastYear)
            ->whereIn('attendance', ['P'])
            ->count();
        $last_totalLate = Attendance::whereMonth('punch_date', $lastMonth)
            ->whereYear('punch_date', $lastYear)
            ->whereIn('status', ['not_in_time'])
            ->count();
        $last_totalPossibleAttendanceDays = $last_total_working_days * $total_employee;
        $last_presentRate = ($last_totalPresent / $last_totalPossibleAttendanceDays) * 100;
        $last_absentRate = (($last_totalPossibleAttendanceDays - $last_totalPresent) / $last_totalPossibleAttendanceDays) * 100;
        $last_lateRate = ($last_totalLate / $last_totalPossibleAttendanceDays) * 100;

        return view('welcome', compact('date', 'total_employee', 'present', 'leave', 'late', 'absent', 'presentRate', 'absentRate', 'lateRate', 'last_presentRate', 'last_absentRate', 'last_lateRate', 'absentees'));
    }


    public function graphData(Request $request)
    {

        $data = $request->day;
        $present_array = [];
        $absent_array = [];
        $leave_array = [];
        $late_array = [];
        $holidays = LeaveHolyday::pluck('date')->toArray();

        $total_employee = User::count();

        $workingDays = [];
        ///////////// Check Limit //////////////
        $first_day = Attendance::orderBy('punch_date', 'ASC')->first();
        // dd($first_day);
        $fromDate = Carbon::parse($first_day->punch_date);
        $toDate = Carbon::now();
        $day_count = $fromDate->diffInDays($toDate) + 1;
        if ($day_count < $data) {
            $data = $day_count;
        }
        ////////////////////////////////////////
        // dd($data);
        $currentDate = Carbon::today();
        while (count($workingDays) < $data) {
            $dayOfWeek = $currentDate->dayOfWeek;
            $dayOfMonth = $currentDate->day;
            $isSecondSaturday = ($dayOfWeek === Carbon::SATURDAY && ceil($dayOfMonth / 7) == 2);
            $isFourthSaturday = ($dayOfWeek === Carbon::SATURDAY && ceil($dayOfMonth / 7) == 4);
            if (
                !in_array($currentDate->format('Y-m-d'), $holidays) && // Not a holiday
                $dayOfWeek !== Carbon::SUNDAY && // Not a Sunday
                !$isSecondSaturday && // Not a second Saturday
                !$isFourthSaturday // Not a fourth Saturday
            ) {
                $formattedDate = $currentDate->format('Y-m-d');
                $workingDays[] = $formattedDate;
                $present = Attendance::where('punch_date', $currentDate->format('Y-m-d'))->whereIn('attendance', ['P'])->count();
                $leave = Attendance::where('punch_date', $currentDate->format('Y-m-d'))->whereIn('status', ['on_leave', 'half_day'])->count();
                $late = Attendance::where('punch_date', $currentDate->format('Y-m-d'))->whereIn('status', ['not_in_time'])->count();
                $absent = $total_employee - ($present + $leave);

                // Populate the arrays
                $present_array[$formattedDate] = $present;
                $absent_array[$formattedDate] = $absent;
                $leave_array[$formattedDate] = $leave;
                $late_array[$formattedDate] = $late;
            }
            $currentDate->subDay();
        }

        return response()->json([
            'present' => $present_array,
            'absent' => $absent_array,
            'leave' => $leave_array,
            'late' => $late_array,
            'wd' => $workingDays
        ]);
    }
}
