<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApplication extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function leaveApplicationTrans(){
        return $this->hasMany(LeaveApplicationTrans::class,'application_id','id');
    }

    public function LeaveType(){
        return $this->hasOne(LeaveTypeMaster::class,'id','leave_type_id');
    }

    public function EmpInfo(){
        return $this->hasOne(User::class,'id','emp_id');
    }

    public function setFromUsers()
    {
        return json_decode($this->from_users, true);
    }

    public function setToUsers()
    {
        return json_decode($this->to_users, true);
    }
}
