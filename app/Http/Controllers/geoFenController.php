<?php

namespace App\Http\Controllers;

use App\Helpers\commonHelper;
use App\Models\AttendanceLocation;
use App\Models\attendancePunchData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class geoFenController extends Controller
{
    public function getAllZone(){
        $zones = AttendanceLocation::where('status','Active')->get();
        return response()->json([
            'zones' => $zones
        ],200);
    }

    public function store(Request $request){

        // Log::info('Request data:', $request->all());
        DB::beginTransaction();
        try{
            $timestamp = Carbon::parse($request->timestamp);
            $filePath = null;
                if($request->image){
                    $empCode = Auth::user()->emp_code;
                    $date = now()->format('dmyHis');
                    $uploadPath = public_path("uploads/{$empCode}/punch_image/");
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    $file = $request->file('image');
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = "{$date}.{$fileExtension}";
                    $filePath = "uploads/{$empCode}/punch_image/{$fileName}";
                    $file->move($uploadPath, $fileName);
                }
            $data=[
                'emp_id'=> Auth::user()->id,
                'emp_code'=> Auth::user()->emp_code,
                'punch_date' => $timestamp->format('Y-m-d'),
                'punch_time' => $timestamp->format('H:i:s'),
                'terminal_id'=> $request->zone_id,
                'image'=> $filePath,
            ];
            $create = attendancePunchData::create($data);
            $punch_data = attendancePunchData::where('id',$create->id)->get();
            // Log::info('success:', "okkkk");
            commonHelper::ProcessAttendance($punch_data);
            // Log::info('Request data:', $request->all());
            DB::commit();
            return response()->json([
                'message' => "success"
            ],200);


        }catch(\Exception $e){
            Log::error('Exception caught: ' . $e->getMessage());
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ],400);
        }
    }
}
