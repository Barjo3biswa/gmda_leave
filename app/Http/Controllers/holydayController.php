<?php

namespace App\Http\Controllers;

use App\Imports\HolidaysImport;
use App\Models\LeaveHolyday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class holydayController extends Controller
{
    public function holydayIndex(Request $request)
    {
        $currentYear = date('Y');
        $holyday_list = LeaveHolyday::whereYear('date', $currentYear)
            ->orderBy('date')
            ->get();
        if ($request->id) {
            try {
                $decrypted = Crypt::decrypt($request->id);
            } catch (\Exception $e) {
                dd($e);
            }
            $editable = LeaveHolyday::where('id', $decrypted)->first();
            return view('holyday.index', compact('editable', 'holyday_list'));
        }
        return view('holyday.index', compact('holyday_list'));
    }

    public function holydaySave(Request $request)
    {
        $data = [
            'date' => $request->date,
            'name' => $request->name,
            'type' => $request->type
        ];
        if ($request->id) {
            LeaveHolyday::where('id', $request->id)->update($data);
            return redirect()->back()->with('success', 'Updated');
        }
        LeaveHolyday::create($data);
        return redirect()->back()->with('success', 'Saved');
    }

    public function holydayDelete(Request $request)
    {

        try {
            $decrypted = Crypt::decrypt($request->id);
        } catch (\Exception $e) {
            dd($e);
        }
        $editable = LeaveHolyday::where('id', $decrypted)->delete();
        return redirect()->back()->with('success', 'deleted');

    }

    public function sampleHolyday(Request $request)
    {
        $excel = [
            0 => [
                'date' => '31-01-2022',
                'name' => 'Test Day 1',
                'type' => 'full',
            ],
            1 => [
                'date' => '31-01-2022',
                'name' => 'Test Day 2',
                'type' => 'half',
            ],
        ];
        $fileName = 'Sample-Holiday.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );
        $columns = array(
            'SL',
            'date',
            'name',
            'type',
        );
        $callback = function () use ($excel, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            $count = 0;
            foreach ($excel as $key => $task) {
                $row['SL'] = ++$key;
                $row['date'] = $task['date'];
                $row['name'] = $task['name'];
                $row['type'] = $task['type'];
                fputcsv($file, array(
                    $row['SL'],
                    $row['date'],
                    $row['name'],
                    $row['type'],
                ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }


    public function holydayImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new HolidaysImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Holidays imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import holidays: ' . $e->getMessage());
        }
    }

}
