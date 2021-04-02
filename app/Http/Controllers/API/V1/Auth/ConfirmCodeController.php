<?php

namespace App\Http\Controllers\API\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MobileValidation;
use App\Rules\VerifyCodeValidation;
use Illuminate\Support\Facades\Route;

class ConfirmCodeController extends Controller
{
    public function confirmCode(Request $request){

        //Get Refresh Token
        if($request->grant_type === "refresh_token"){
            request()->request->add([
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->refresh_token,
                'client_id' => $request->client_id,
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            ]);

            $response = Route::dispatch(Request::create('/oauth/token', 'POST'));

            $data = json_decode($response->getContent(), true);
            if (!$response->isOk()) {
                return response()->json($data, 400);
            }
            return $data;
        }

        $validated = $request->validate([
            'username' => ['required',new MobileValidation],
            'password' => ['required', new VerifyCodeValidation],
        ]);
        //Get Token
        $user = User::where(['mobile'=> $request->username, 'active_code'=> $request->password])->get();
        if (isset($user[0])) {
            request()->request->add([
                'grant_type' => 'password',
                'client_id' => $request->client_id,
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'username' => $request->username,
                'password' => $request->password,
                'scope' => '',
            ]);

            $response = Route::dispatch(Request::create('/oauth/token', 'POST'));

            $data = json_decode($response->getContent(), true);
            if (!$response->isOk()) {
                return response()->json($data, 400);
            }
            $user[0]->active_code = null;
            $user[0]->verified = true;
            $user[0]->save();
            return $data;
        }
        $data = [
            'message' =>'کد وارد شده صحیح نیست',
            'errors' => [
                'password' => ['کد وارد شده صحیح نیست']
            ]
        ];
        return response($data, 422);
    }
}
