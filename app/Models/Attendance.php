<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    use SoftDeletes;

    /////////status/////
            //present
            //not_in_time
            //by_admin
            //absent
            //half_day
            //on_leave
    ///////////////////
    public function leaveType(){
        return $this->hasOne(LeaveTypeMaster::class,'id','leave_type_id');
    }

    public function leaveApplication(){
        return $this->hasOne(LeaveApplication::class,'id','leave_ref_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','emp_id');
    }



    // In the User model


}
