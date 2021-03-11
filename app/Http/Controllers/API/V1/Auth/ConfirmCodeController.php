<?php

namespace App\Http\Controllers\API\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MobileValidation;
use App\Rules\VerifyCodeValidation;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class ConfirmCodeController extends AccessTokenController
{
    
    public function confirmCode(ServerRequestInterface $request){

        dd($request);
        $request->validate([
            'mobile' => ['required',new MobileValidation],
            'active_code' => ['required', new VerifyCodeValidation],
        ]);
        
        $user = User::where(['mobile'=> $request->mobile, 'active_code'=> $request->active_code])->get();
        if (isset($user[0])) {
            // Authentication passed...
            //return $user->createToken($request->device_name)->plainTextToken;
            Auth::loginUsingId($user[0]->id);

            $user[0]->active_code = null;
            $user[0]->save();
            
            return response(['mobile'=>$user[0]->mobile],200);
        }
        $data = [
            'message' =>'کد وارد شده صحیح نیست',
            'errors' => [
                'active_code' => ['کد وارد شده صحیح نیست']
            ]
        ];
        return response($data, 401);
    }
}
