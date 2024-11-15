<?php

namespace App\Imports;

use App\Models\LeaveHolyday;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class HolidaysImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        DB::beginTransaction();
        try {
            $holiday = new LeaveHolyday([
                'name' => $row['name'],
                'date' => \Carbon\Carbon::createFromFormat('d-m-Y', $row['date'])->format('Y-m-d'),
                'type' => $row['type'],
            ]);
            $holiday->save();
            DB::commit();
            return $holiday;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
