<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class attendancePunchData extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    use SoftDeletes;

    public function empInfo(){
        return $this->hasOne(User::class,'id','emp_id');
    }
}
