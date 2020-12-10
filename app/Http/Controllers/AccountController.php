<?php

namespace App\Http\Controllers;

//use App\Notifications\Admin\VerifyEmail;
use App\Notifications\VerifyEmail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
//use GrahamCampbell\Throttle\Facades\Throttle;

class AccountController extends Controller
{
    //
    public function settings(Request $request){

        return view('account.setting');
    }

    public function settingsUpdate(Request $request){


        $this->validate($request, [

            'name' => 'required|max:255',
            'username' => 'required|integer|min:1000|max:100000|unique:users,username,'.$request->user()->id,
            'email' => 'required|email|max:255|unique:users,email,'.$request->user()->id,
            //'mobile' => 'required|digits:9|unique:users,mobile,'.$request->user()->id,
            'password' => 'confirmed'
        ]);

        try{
            \DB::beginTransaction();

            $inputs = [];

            if( trim($request->input('name')) != $request->user()->name){
                $inputs['name'] = trim($request->name);
            }
            if( trim($request->input('username')) != $request->user()->name){
                $inputs['username'] = trim($request->username);
            }

            if( $request->input('password') != ''){
                $inputs['password'] = bcrypt($request->password);
            }

            if( trim($request->input('email')) != $request->user()->email){
                $inputs['email'] = trim($request->email);
                $inputs['email_confirmed'] = 0;
                //$request->user()->generateTokens(['email']);
            }

            /*if( trim($request->input('mobile')) != $request->user()->mobile){
                $inputs['mobile'] = trim($request->mobile);
                $inputs['mobile_confirmed'] = 0;
                //$request->user()->generateTokens(['mobile']);
            }*/

            if(count($inputs)){

                $request->user()->update($inputs);
            }


            \DB::commit();

        }catch(\Exception $e){

            \DB::rollback();

            return back();

        }

        //dd($this->sendCode());

        flash('Data edit saved successfully!','success');

        return back();
    }

    public function verifyEmailToken(){

        if( \request()->has('token') ) {

            if( auth()->user()->verifyEmailToken( request()->token) ){

                flash('Email successfully confirmed, thank you!');

            }else{

                flash('Email confirmation failed!')->error();
            }

            return redirect()->route('account.settings');
        }

        return abort(404);
    }

    public function verifyMobileToken(){

        if ( request()->ajax() ) {

            if( auth()->user()->verifyMobileToken( request()->code) ){

                return response()->json(true,200);
            }

            return response()->json(false,400);
        }

    }


    public function sendMobileToken(){

        if (request()->ajax() ) {

            //$request = \request()->instance();

            //$throttler = Throttle::get($request, 1, 10);

            //check if limit gone
            //if(!$throttler->check()){

            //    return response()->json( ['message'=> ' تجاوزت الحد الاقصي لأستخدام خدمات الرسائل, يرجي التأكد من صحة الرقم و المحاولة في وقت ﻻحق.'] , 429);
            //}

            $mobile_token = DB::table('confirmation_tokens')
                ->where('identification_code', auth()->user()->identification_code)
                ->first()->mobile_confirmation_token;

            $message = " Your verification code is: {$mobile_token} ";
            $numbers = '966'.auth()->user()->mobile;
            //$numbers = '00201111747790';

            // add hit to counter
            $send= sendSms($numbers, $message);

            /*if ($send){

                $throttler->hit();
            }*/

            return response()->json($send ? true : false,200);
        }
    }

    public function sendEmailToken(){

        if (request()->ajax() ) {

            //$request = \request()->instance();

            //$throttler = Throttle::get($request, 3, 10);

            //check if limit gone
            /*if(!$throttler->check()){

                return response()->json( ['message'=> ' تجاوزت الحد الاقصي لأستخدام خدمات البريد, يرجي التأكد من صحة البريد و المحاولة في وقت ﻻحق.'] , 429);
            }*/


            $email_token = DB::table('confirmation_tokens')
                ->where('identification_code', auth()->user()->identification_code)
                ->first()->email_confirmation_token;

            try {
                auth()->user()->notify(new VerifyEmail($email_token));
                //Mail::to(auth()->user())->send(new EmailVerify($email_token));

            } catch (HttpException $re) {

                return response()->json( ['message'=> $re->getMessage()], $re->getCode());
            }

            //$throttler->hit();

        }

    }
}
