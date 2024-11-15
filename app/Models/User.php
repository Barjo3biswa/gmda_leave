<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject // Add implements JWTSubject here
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'permission_ids',
        'role_ids'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function permissions()
    {
        $permissionIds = json_decode($this->permission_ids, true)??[];
        return AuthPermission::whereIn('id', $permissionIds)->get();
    }

    public function roles()
    {
        $roleIds = json_decode($this->role_ids, true)??[];
        return AuthRole::whereIn('id', $roleIds)->get();
    }

    public function attendance(){
        return $this->hasMany(Attendance::class,'emp_id','id');
    }

    public function getTotalWorkingHours($currentMonth, $currentYear)
    {
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "$currentYear-$currentMonth-01");
        $endDate = $startDate->copy()->endOfMonth();
        $attendances = $this->attendance()->whereBetween('punch_date', [$startDate, $endDate])->get();
        $totalSeconds = $attendances->reduce(function ($carry, $attendance) {
            if ($attendance->working_hour) {
                $timeParts = explode(':', $attendance->working_hour);
                $seconds = ($timeParts[0] * 3600) + ($timeParts[1] * 60) + $timeParts[2];
                return $carry + $seconds;
            }
            return $carry;
        }, 0);
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

}
