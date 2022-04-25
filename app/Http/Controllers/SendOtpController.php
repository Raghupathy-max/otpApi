<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SendOtpController extends Controller
{
    public function genOtp(Request $request){
        $request->validate([
            'phone_number' => 'required|min:10|max:10',
        ]);

        $SixDigitRandomNumber = rand(100000,999999);
        $todayDate = Carbon::now();

        DB::table('users_session')->insert([
           'number' => $request->input('phone_number'),
            'otp' => $SixDigitRandomNumber,
            'created_at'=>$todayDate,

        ]);

        return response([
           'success'=>true,
        ]);
    }
}
