<?php

namespace App\Console\Commands;

use App\Helpers\commonHelper;
use App\Models\LeaveAvailability;
use App\Models\LeaveTransaction;
use App\Models\LeaveTypeMaster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class leaveGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:leave-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::get();
        foreach($users as $uesr){
            $leave_types = LeaveTypeMaster::get();
            foreach($leave_types as $types){
                DB::beginTransaction();
                try{
                    $availabile = LeaveAvailability::where('leave_type_id',$types->id)->where('emp_id',$uesr->id)->first();
                    $available_count = $types->credit_count;
                    if(!$availabile && commonHelper::isLeaveApplicable($uesr->id, $types->id)){

                        // is leave apply for employee Male/female
                        // Permanent or Temporara
                        // is he eligible by exp

                        $data = [
                            'emp_id'=>$uesr->id,
                            'emp_code'=>$uesr->emp_code,
                            'leave_type_id'=>$types->id,
                            'available_count'=>$available_count,
                            'last_credited_on'=>Carbon::now(),
                            'used_count_as_on' =>0,
                            'calander_year'=>Carbon::now()->year,
                        ];
                        LeaveAvailability::create($data);
                        $trans = [
                            'emp_id'=>$uesr->id,
                            'emp_code'=>$uesr->emp_code,
                            'transaction_type' => 'Credit',
                            'leave_type_id' => $types->id,
                            'available_count' => $available_count,
                            'credited_count' => $available_count,
                            'credited_on' => Carbon::now(),
                            'remarks' => 'Leave Credited To Employee',
                            'calander_year' =>Carbon::now()->year,
                        ];
                        LeaveTransaction::create($trans);
                    }else if($types->credit_intervel != 'service_life' ){  //if levae is already added to his account

                        /* Check Date Start*/
                        if($types->credit_intervel=='half_yearly'){
                            if($types->credit_time=='begening'){
                                $date = ['01-01','01-07'/* ,'30-10' */];//DD-MM
                            }else{
                                $date = ['30-06','31-12'];//DD-MM
                            }
                        }else if($types->credit_intervel=='yearly'){
                            if($types->credit_time=='begening'){
                                $date = ['01-01'];//DD-MM
                            }else{
                                $date = ['31-12'];//DD-MM
                            }
                        }
                        $dayMonth = Carbon::now()->format('d-m');
                        if(!in_array($dayMonth,$date)){
                            continue;
                        }
                        /* Check Date End*/

                        $current_available_count = $availabile->available_count;
                        if($types->limit_period != 'service_life'){
                            $used_count = 0;
                            $current_available_count = 0;
                        }else{
                            $used_count = $availabile->used_count;
                        }

                        /*handle not allowing more then limit*/
                        $current_bal = $current_available_count+$available_count;
                        if($current_bal > $types->max_leave){
                            if($current_available_count<=300){
                                $current_bal = $types->max_leave;
                            }else{
                                continue;
                            }
                        }
                        /*allowing more then limit Ends*/
                        $data = [
                            'available_count'=>$current_bal,
                            'last_credited_on'=>Carbon::now(),
                            'calander_year'=>Carbon::now()->year,
                            'used_count'=>$used_count,
                        ];
                        LeaveAvailability::where('id',$availabile->id)->update($data);
                        $trans = [
                            'emp_id'=>$uesr->id,
                            'emp_code'=>$uesr->emp_code,
                            'transaction_type' => 'Credit',
                            'leave_type_id' => $types->id,
                            'available_count' => $current_bal,
                            'used_count'=>$used_count,
                            'credited_count' => $available_count,
                            'credited_on' => Carbon::now(),
                            'used_count_as_on' => $availabile->used_count_as_on,
                            'remarks' => 'Leave Credited To Employee',
                            'calander_year' =>Carbon::now()->year,
                        ];
                        LeaveTransaction::create($trans);
                    }
                    DB::commit();
                }catch(\Exception $e){
                    // Log::error($e->getMessage(), ['exception' => $e]);
                    DB::rollback();
                }
            }
        }
    }
}
