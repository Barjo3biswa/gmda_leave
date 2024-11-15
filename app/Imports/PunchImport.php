<?php

namespace App\Imports;

use App\Models\attendancePunchData;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PunchImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        DB::beginTransaction();
        try {
            $punch_data = new attendancePunchData([

                'emp_id' => User::where('emp_code',$row['emp_code'])->first()->id,
                'emp_code'  => $row['emp_code'],
                'punch_date' => \Carbon\Carbon::createFromFormat('d-m-Y', $row['punch_date'])->format('Y-m-d'),
                'punch_time' => $row['punch_time'],
                'terminal_id' => $row['terminal_id'],

            ]);
            $punch_data->save();
            DB::commit();
            return $punch_data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
