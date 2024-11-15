<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class attendanceRoaster extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    use SoftDeletes;

    public function mondaySift(){
        return $this->hasOne(attendanceShift::class,'id','monday');
    }
    public function tuesdaySift(){
        return $this->hasOne(attendanceShift::class,'id','tuesday');
    }
    public function wednesdaySift(){
        return $this->hasOne(attendanceShift::class,'id','wednesday');
    }
    public function thursdaySift(){
        return $this->hasOne(attendanceShift::class,'id','thursday');
    }
    public function fridaySift(){
        return $this->hasOne(attendanceShift::class,'id','friday');
    }
    public function saturdaySift(){
        return $this->hasOne(attendanceShift::class,'id','saturday');
    }
    public function sundaySift(){
        return $this->hasOne(attendanceShift::class,'id','sunday');
    }
}
