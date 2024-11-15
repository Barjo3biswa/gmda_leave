<?php

namespace App\Http\Controllers;

use App\Models\attendanceRoaster;
use App\Models\attendanceShift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class shiftController extends Controller
{
    public function shiftMaster(Request $request){
        $shifts = attendanceShift::get();
        if($request->editable){
            try {
                $decrypted = Crypt::decrypt($request->editable);
                $editable = attendanceShift::where('id',$decrypted)->first();
                return view('attendance.shift-index',compact('shifts','editable'));
            } catch (\Exception $e) {
                dd($e);
            }
        }
        return view('attendance.shift-index',compact('shifts'));
    }

    public function shiftMasterStore(Request $request){
        $data = [
            "name" => $request->name,
            "in_time" => $request->in_time,
            "out_time" => $request->out_time,
            "in_buffer_time" => $request->in_buffer_time,
            "out_buffer_time" => $request->out_buffer_time,
            'f_half_out_time' => $request->f_half_out_time,
            's_half_in_time' => $request->s_half_in_time,
            "working_hour" => $request->working_hour,
            'fir_sat_off' => $request->fir_sat_off??"no",
            "sec_sat_off" => $request->sec_sat_off??"no",
            "thir_sat_off" => $request->thir_sat_off??"no",
            "for_sat_off" => $request->for_sat_off??"no",
            "fif_sat_off" => $request->fif_sat_off??"no",
        ];
        if($request->id){
            attendanceShift::where('id',$request->id)->update($data);
            return redirect()->back()->with('success','Updated');
        }else{
            attendanceShift::create($data);
            return redirect()->back()->with('success','Saved');
        }

    }

    public function roasterIndex(Request $request){

        $shifts = attendanceShift::get();
        $roaster = attendanceRoaster::get();
        $users = User::get();
        return view('attendance.roaster-index',compact('shifts','roaster','users'));
    }

    public function roasterSave(Request $request){
        $data = [
            "name" => $request->name,
            "monday" => $request->monday=="off"?null:$request->monday,
            "tuesday" => $request->tuesday=="off"?null:$request->tuesday,
            "wednesday" => $request->wednesday=="off"?null:$request->wednesday,
            "thursday" => $request->thursday=="off"?null:$request->thursday,
            "friday" => $request->friday=="off"?null:$request->friday,
            "saturday" => $request->saturday=="off"?null:$request->saturday,
            "sunday" => $request->sunday=="off"?null:$request->sunday,
        ];
        attendanceRoaster::create($data);
        return redirect()->back()->with('success','success');
    }

    public function roasterChange(Request $request, $id){
        try {
            $decrypted = Crypt::decrypt($id);
        } catch (\Exception $e) {
            dd($e);
        }
        User::where('id',$decrypted)->update(['roster'=>$request->assigned_roster,'last_roster_reset_dt'=>Carbon::now()]);
        return redirect()->back()->with('success','Updated');
    }
}
