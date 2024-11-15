<?php

namespace App\Http\Controllers;

use App\Helpers\commonHelper;
use App\Models\Attendance;
use App\Models\attendanceRoaster;
use App\Models\attendanceShift;
use App\Models\LeaveApplication;
use App\Models\LeaveApplicationTrans;
use App\Models\LeaveAvailability;
use App\Models\LeaveHolyday;
use App\Models\LeaveTransaction;
use App\Models\LeaveTypeMaster;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class leaveController extends Controller
{
    public function leaveType(Request $request){
        $leave_types = LeaveTypeMaster::get();
        if($request->id){
            try {
                $decrypted = Crypt::decrypt($request->id);
            } catch (\Exception $e) {
                dd("ok");
            }
            $editable = LeaveTypeMaster::where('id',$decrypted)->first();
            return view('leave.leave-type', compact('editable','leave_types'));
        }
        return view('leave.leave-type', compact('leave_types'));
    }

    public function leaveTypeSave(Request $request){


        $data = [
            "name" => $request->name,
            "gender" => $request->gender,
            "max_leave" => $request->max_leave,
            "accommodation_period" => $request->accommodation_period,
            "max_limit" => $request->max_limit ,
            "limit_period" => $request->limit_period,
            "can_apply" => $request->can_apply ,
            "can_apply_at" => $request->can_apply_at,
            "min_allowed" => $request->min_allowed,
            "max_allowed" => $request->max_allowed,
            "pay_type" => $request->pay_type,
            "credit_count" => $request->credit_count,
            "credit_intervel" => $request->credit_intervel,
            "credit_time" => $request->credit_time,
            'is_sandwich' => $request->is_sandwich??'no',
            'is_half_pay_link' => $request->is_half_pay_link??'no',
        ];

        if($request->id){
            LeaveTypeMaster::where('id',$request->id)->update($data);
            return redirect()->back()->with('success','Updated');
        }else{
            LeaveTypeMaster::create($data);
            return redirect()->back()->with('success','Saved');
        }

    }


    public function leaveApply(Request $request){
        $users = User::get();
        $leave_availability = LeaveAvailability::where('emp_id',Auth::user()->id)->get();
        $leave_ids = $leave_availability->pluck('leave_type_id');
        $leave_type = LeaveTypeMaster::whereIn('id',$leave_ids)->get();
        $my_applications = LeaveApplication::where('emp_id',Auth::user()->id)->whereYear('to_date', now()->year)->orwhereYear('from_date', now()->year)->orderBy('id','DESC')->get();
        $my_last_application = LeaveApplication::where('emp_id',Auth::user()->id)->where('to_date','>',Carbon::now()->format('Y-m-d'))->orderBy('id','DESC')->first();
        $othher_employee_applications = LeaveApplication::whereNotIn('emp_id',[Auth::user()->id])->where('to_date','>',Carbon::now()->format('Y-m-d'))->orderBy('id','DESC')->get();
        if ($request->expectsJson()) {
            return response()->json([
                'users' => $users,
                'leave_availability'=> $leave_availability ,
                'leave_ids'=>  $leave_ids ,
                'leave_type'=>  $leave_type ,
                'my_applications'=>  $my_applications ,
                'my_last_application'=> $my_last_application,
                'other_employee_applications'=> $othher_employee_applications ,
            ], 200);
        }
        return view('leave.apply',compact('users','leave_type','leave_availability','my_applications','my_last_application','othher_employee_applications'));
    }


    public function leaveSave(Request $request){

        // dd($request->all());
        $request->validate([
            'employee_id' => 'required',
            'leave_type' => 'required',
            'form_date' => 'required',
            'to_date' => 'required',
            'attachment' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            // 'reason' => 'required',
        ]);

        ////////// Leave validation//////

            $leave_type_master = LeaveTypeMaster::where('id',$request->leave_type)->first();
            if($leave_type_master->is_sandwich=='no'){
                $day_count = commonHelper::DaysCount($request->form_date,$request->to_date,$request->employee_id);
            }else{
                $fromDate = Carbon::parse($request->form_date);
                $toDate = Carbon::parse($request->to_date);
                $day_count = $fromDate->diffInDays($toDate) + 1;
            }
            if($leave_type_master->min_allowed){
                if($leave_type_master->min_allowed > $day_count){
                    return redirect()->back()->with('error','Minimum allowed leave is '.$leave_type_master->min_allowed);
                }
            }
            if($leave_type_master->max_allowed){
                if($leave_type_master->max_allowed < $day_count){
                    return redirect()->back()->with('error','Maximum allowed leave is '.$leave_type_master->min_allowed);
                }
            }
        /////////////////////////////////
        DB::beginTransaction();
        try{
            $filePath = null;
            if($request->attachment){
                $empCode = Auth::user()->emp_code;
                $date = now()->format('dmyHis');
                $uploadPath = public_path("uploads/{$empCode}/medical_certificate/");
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $file = $request->file('attachment');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = "{$date}.{$fileExtension}";
                $filePath = "uploads/{$empCode}/medical_certificate/{$fileName}";
                $file->move($uploadPath, $fileName);
            }


            $from_users = json_encode([Auth::user()->id]);
            $to_users = json_encode([2]);
            $data=[
                "applied_for" => $request->apply_for??'self',
                "emp_id" => $request->employee_id,
                "emp_code"=> User::where('id',$request->employee_id)->first()->emp_code,
                "leave_type_id" => $request->leave_type,
                "from_date" => $request->form_date,
                "to_date" => $request->to_date,
                "applied_from_date" => $request->form_date,
                "applied_to_date" => $request->to_date,
                "is_half_day" => $request->is_half_day??'no',
                "is_half_type" => $request->half_day_type??null,
                "half_day_on" => $request->half_day??null,
                "reason" => $request->reason,
                "attachments" => $filePath,
                "status" => 'Submited',
                'from_users'=> $from_users,
                'to_users'=> $to_users,
            ];
            $create = LeaveApplication::create($data);

            $trans = [
                'application_id' => $create->id,
                'from_user' => $request->employee_id,
                'to_user' => 2,
                'date' => Carbon::now(),
                'status' => 'Applied',
                'remarks' => 'Applied'
            ];
            LeaveApplicationTrans::create($trans);
            DB::commit();
        }catch(\Exception $ex){
            Log::error('Exception caught: ' . $ex->getMessage());
            DB::rollback();
            if($request->expectsJson()){
                return response()->json(['message'=>$ex->getMessage()],500);
            }
            return redirect()->back()->with('error',$ex->getMessage());
        }
        if($request->expectsJson()){
            return response()->json(['message'=>'Saved'],200);
        }
        return redirect()->back()->with('success','Saved');
    }

    public function leaveTrans(Request $request){
        $leave = LeaveTypeMaster::where('id',$request->leave_id)->first();
        $leave_trans = LeaveTransaction::where('emp_id',$request->emp_id)->where('leave_type_id',$request->leave_id)->orderBy('id','DESC')->get();
        return view('leave.leave-trans', compact('leave_trans','leave'));
    }

    public function empDetails(Request $request){
        $users = User::where('id',$request->emp_id)->first();
        $leave_availability = LeaveAvailability::with('LeaveType')->where('emp_id',$request->emp_id)->get();
        $leave_ids = $leave_availability->pluck('leave_type_id');
        $leave_type = LeaveTypeMaster::whereIn('id',$leave_ids)->get();

        return response()->json([
            'emp_details' => $users,
            'leave_availability' => $leave_availability,
            'leave_type' => $leave_type,
        ]);
    }


    public function leaveInbox(Request $request){
        $type = $request->type;
        if($type=='inbox'){
            $applications = LeaveApplication::whereNotIn('status',['Approved'])->get()->filter(function ($users) {
                $to_users = $users->setToUsers();
                return is_array($to_users) && in_array(Auth::user()->id, $to_users);
            });
        }else{
            $applications = LeaveApplication::get()->filter(function ($users) {
                $to_users = $users->setFromUsers();
                return is_array($to_users) && in_array(Auth::user()->id, $to_users);
            });
        }

        return view('leave.inbox', compact('applications','type'));
    }

    public function leaveUpdate($id){

        try {
            $decrypted = Crypt::decrypt($id);
        } catch (\Exception $e) {
            dd($e);
        }
        $applications = LeaveApplication::where('id',$decrypted)->first();
        $applicant_info = User::where('id',$applications->emp_id)->first();
        $leave_availability = LeaveAvailability::where('emp_id',$applications->emp_id)->get();
        $othher_employee_applications = LeaveApplication::whereNotIn('id',[$applications->id])->where(function($query) use($applications){
                                            $query->whereBetween('from_date', [$applications->from_date, $applications->to_date])
                                                ->orWhereBetween('to_date', [$applications->from_date, $applications->to_date])
                                                ->orWhere(function($q)  use($applications) {
                                                    $q->where('from_date', '<=', $applications->from_date)
                                                        ->where('to_date', '>=', $applications->to_date);
                                                });
                                        })->orderBy('id','DESC')->get();
        $users = User::get();
        $leave_availability = LeaveAvailability::where('emp_id',$applications->emp_id)->get();
        $leave_ids = $leave_availability->pluck('leave_type_id');
        $leave_type = LeaveTypeMaster::whereIn('id',$leave_ids)->get();
        return view('leave.update', compact('applications','leave_availability','applicant_info','othher_employee_applications','users','leave_type'));
    }

    public function storeUpdate(Request $request,$id){
        try {
            $decrypted = Crypt::decrypt($id);
        } catch (\Exception $e) {

        }

        DB::beginTransaction();
        try{


            $applications = LeaveApplication::where('id',$decrypted)->first();

            $last_from_users = json_decode($applications->from_users);
            $last_to_users = json_decode($applications->to_users);
            array_push($last_from_users, Auth::user()->id);
            array_push($last_to_users, $request->employee_id??Auth::user()->id);
            $last_from_users = array_unique($last_from_users);
            $last_to_users = array_unique($last_to_users);
            $from_users = json_encode($last_from_users);
            $to_users = json_encode($last_to_users);

            $data=[
                "status" => $request->status_type,
                'from_users'=> $from_users,
                'to_users'=> $to_users,
                "from_date"=> $request->updated_from_date,
                "to_date"=> $request->updated_to_date,
            ];
            $applications->update($data);

            $trans = [
                'application_id' => $decrypted,
                'from_user' => Auth::user()->id,
                'to_user' => $request->employee_id??Auth::user()->id,
                'date' => Carbon::now(),
                'status' => $request->status_type,
                'remarks' => $request->remarks
            ];
            LeaveApplicationTrans::create($trans);

            if($request->status_type=="Approved"){
                $leave_type_master = LeaveTypeMaster::where('id',$applications->leave_type_id)->first();
                if($leave_type_master->is_sandwich=='no'){
                    $day_count = commonHelper::DaysCount($applications->from_date,$applications->to_date,$applications->emp_id);
                }else{
                    $fromDate = Carbon::parse($applications->from_date);
                    $toDate = Carbon::parse($applications->to_date);
                    $day_count = $fromDate->diffInDays($toDate) + 1;
                }

                if($applications->is_half_day=='yes'){
                    $day_count = $day_count-0.5;
                }

                ///// here have to implement half pay Leave Concept //////
                if($leave_type_master->pay_type=='half_pay'){
                    $day_count = $day_count*2;
                }
                //////////////////////////////////////////////////////////



                $available_leave = LeaveAvailability::where('emp_id',$applications->emp_id)->where('leave_type_id',$applications->leave_type_id)->first();
                if($day_count > ($available_leave->available_count - $available_leave->used_count) && $day_count > $leave_type_master->max_limit){
                    return redirect()->back()->with('error','Leave cannot be applied as per leave rules.');
                }

                $used_count = $available_leave->used_count+$day_count;
                $used_count_as_on = $available_leave->used_count_as_on+$day_count;
                $available_count = $available_leave->available_count - $day_count;


                $data = [
                    'used_count'=> $used_count,
                    'used_count_as_on'=> $used_count_as_on,
                    'last_used_on'=>Carbon::now(),
                ];
                LeaveAvailability::where('id',$available_leave->id)->update($data);
                $trans = [
                    'emp_id'=>$available_leave->emp_id,
                    'emp_code'=>$available_leave->emp_code,
                    'transaction_type' => 'Debit',
                    'leave_type_id' => $available_leave->leave_type_id,
                    'available_count' => $available_count,
                    'used_count'=>$day_count,
                    'used_count_as_on' => $used_count_as_on,
                    'remarks' => 'Leave Debited From Employee',
                    'calander_year' =>Carbon::now()->year,
                ];
                LeaveTransaction::create($trans);


                ////////update in attendance/////////
                $startDate = Carbon::parse($applications->from_date);
                $endDate = Carbon::parse($applications->to_date);
                $holidays = LeaveHolyday::pluck('date')->toArray();

                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $formattedDate = $date->format('Y-m-d');

                    $dayOfWeek = $date->dayOfWeek;


                    $user = User::where('id',$available_leave->emp_id)->first();
                    if($user->roster){
                        $roster = attendanceRoaster::where('id',$user->roster)->first();
                        $date_new = new DateTime($formattedDate);
                        $dayName = strtolower($date_new->format('l'));
                        $shift = attendanceShift::where('id',$roster->$dayName)->first();

                        $isHoliday = false;
                        $is_sat_off = false;
                        // $isSecondSaturday = false;
                        // $isFourthSaturday = false;
                        $isSunday = is_null($roster->$dayName);
                    }else{
                        $shift = attendanceShift::where('id',$user->shift_id)->first();

                        $weekArray = commonHelper::weekArray($user->shift_id);
                        $weekOfMonth = ceil($date->day / 7);
                        $is_sat_off = ($dayOfWeek == 6 && (in_array($weekOfMonth,$weekArray)));
                        // $isHoliday = in_array($formattedDate, $holidays);
                        // $isSecondSaturday = ($dayOfWeek == 6 && $date->day >= 8 && $date->day <= 14);
                        // $isFourthSaturday = ($dayOfWeek == 6 && $date->day >= 22 && $date->day <= 28);
                        $isSunday = ($dayOfWeek == 0);
                    }

                    $record = Attendance::where('emp_id',$available_leave->emp_id)->where('punch_date', $formattedDate)->first();
                    $attendance = ($applications->is_half_day == 'yes' && $formattedDate == $applications->half_day_on) ? 'hd' : 'L';
                    if($record && $applications->is_half_day == 'yes'){
                        $working_hour = strtotime($record->working_hour);
                        $s_working_hour = strtotime($shift->h_d_working_hour);
                        // dump($working_hour, $s_working_hour);
                        if(gmdate('H:i:s', $working_hour) < gmdate('H:i:s', $s_working_hour)){
                            $attendance = "ab";
                        }else{
                            $attendance = "P";
                        }
                    }
                    $data = [
                        'emp_id' => $available_leave->emp_id,
                        'emp_code' => $available_leave->emp_code,
                        'punch_date' => $formattedDate,
                        'leave_type_id' => $available_leave->leave_type_id,
                        'leave_ref_id' => $applications->id,
                        'attendance' => $attendance,
                        'status' => ($applications->is_half_day == 'yes' && $formattedDate == $applications->half_day_on) ? 'half_day' : 'on_leave'
                    ];
                    // dd($data);
                    if ($leave_type_master->is_sandwich=="no" && !$isHoliday && !$is_sat_off/* !$isSecondSaturday && !$isFourthSaturday */ && !$isSunday) {
                        if($applications->is_half_day=='yes' && $formattedDate == $applications->half_day_on){
                            Attendance::updateOrCreate(
                                ['emp_id' => $available_leave->emp_id,
                                'punch_date' => $formattedDate,],
                                $data
                            );
                        }else{
                            Attendance::create($data);
                        }
                    }else if($leave_type_master->is_sandwich=="yes"){
                        if($applications->is_half_day=='yes' && $formattedDate == $applications->half_day_on){
                            Attendance::updateOrCreate(
                                ['emp_id' => $available_leave->emp_id,
                                'punch_date' => $formattedDate,],
                                $data
                            );
                        }else{
                            Attendance::create($data);
                        }
                    }
                }
                /////////////////////////////////////

                ///// here have to implement half pay Leave Concept //////
                ///////////other leaved linked with half pay leave will decremented//////
                if($leave_type_master->pay_type=='half_pay'){
                    $day_count = $day_count/2;
                    $half_pay_linkage_leave = LeaveTypeMaster::where('is_half_pay_link','yes')->first();
                    $linked_leave = LeaveAvailability::where('emp_id',$applications->emp_id)->where('leave_type_id',$half_pay_linkage_leave->id)->first();
                    $used_count = $linked_leave->used_count+$day_count;
                    $used_count_as_on = $linked_leave->used_count_as_on+$day_count;
                    $available_count = $linked_leave->available_count - $day_count;
                    $data = [
                        'used_count'=> $used_count,
                        'used_count_as_on'=> $used_count_as_on,
                        'last_used_on'=>Carbon::now(),
                    ];
                    // dd($data);
                    LeaveAvailability::where('id',$linked_leave->id)->update($data);
                    $trans = [
                        'emp_id'=>$linked_leave->emp_id,
                        'emp_code'=>$linked_leave->emp_code,
                        'transaction_type' => 'Debit',
                        'leave_type_id' => $linked_leave->leave_type_id,
                        'available_count' => $available_count,
                        'used_count'=>$day_count,
                        'used_count_as_on' => $used_count_as_on,
                        'remarks' => 'Leave Debited From Employee',
                        'calander_year' =>Carbon::now()->year,
                    ];
                    LeaveTransaction::create($trans);
                }
                //////////////////////////////////////////////////////////

                ///// here have to implement Commuted Leave Concept //////
                if($leave_type_master->is_half_pay_link=='yes'){
                    $day_count = $day_count*2;
                    $half_pay_leave = LeaveTypeMaster::where('pay_type','half_pay')->first();
                    $linked_leave = LeaveAvailability::where('emp_id',$applications->emp_id)->where('leave_type_id',$half_pay_leave->id)->first();
                    $used_count = $linked_leave->used_count+$day_count;
                    $used_count_as_on = $linked_leave->used_count_as_on+$day_count;
                    $available_count = $linked_leave->available_count - $day_count;
                    $data = [
                        'used_count'=> $used_count,
                        'used_count_as_on'=> $used_count_as_on,
                        'last_used_on'=>Carbon::now(),
                    ];
                    LeaveAvailability::where('id',$linked_leave->id)->update($data);
                    $trans = [
                        'emp_id'=>$linked_leave->emp_id,
                        'emp_code'=>$linked_leave->emp_code,
                        'transaction_type' => 'Debit',
                        'leave_type_id' => $linked_leave->leave_type_id,
                        'available_count' => $available_count,
                        'used_count'=>$day_count,
                        'used_count_as_on' => $used_count_as_on,
                        'remarks' => 'Leave Debited From Employee',
                        'calander_year' =>Carbon::now()->year,
                    ];
                    LeaveTransaction::create($trans);
                }
                //////////////////////////////////////////////////////////
            }
            // dd("ok");
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with('error',$ex->getMessage());
        }
        return redirect()->route('leave.leave-inbox',['type'=>'inbox'])->with('success','Updated');

    }
}
