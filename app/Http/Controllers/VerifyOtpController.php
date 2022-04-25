<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerifyOtpController extends Controller
{
    public function verifyOtp(Request $request){
        $request->validate([
            'otp' => 'required|min:6|max:6',
        ]);

    $verify  =    DB::table('users_session')
            ->where('otp','=',$request->input('otp'))
            ->latest('created_at')
            ->first();

        if($verify == null){
            return response([
                'status'=>false,
                'message'=>'Please enter a valid otp'
            ]);
        }else{
            $randomString = Str::random(30);
            $todayDate = Carbon::now();
            DB::table('users_session')
                ->where('otp','=',$request->input('otp'))
                ->orderBy('id','desc')
                ->update([
                    'session'=> $randomString,
                    'updated_at'=>$todayDate
                ]);

            return response([
                'success'=>true,
                'Number'=>$verify->number,
                'session'=>$randomString,
                'validity'=>"T-25"

            ]);
        }

    }

}
