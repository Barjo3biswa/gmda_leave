<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApplicationTrans extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    use SoftDeletes;

    public function FromUser(){
        return $this->hasOne(User::class,'id','from_user');
    }

    public function ToUser(){
        return $this->hasOne(User::class,'id','to_user');
    }

}
