<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login()
{
    if (Auth::attempt(['email' => request('username'), 'password' => request('password')])) {
        $token = auth()->user()->createToken('NewToken')->accessToken;
        return response()->json([
            'access_token' => $token,
            'expires_in' => 31536000,
            'refresh_token'=>"def5020034c46d46ecb7fed9013e0303e9ab3c1fea2a2adbf7867fc4bf99bdb7219f493bab9fc62466fc43f9f973e9f92483f68fe2f20a342f8063176b467265c7505ed2a2406169006fcbcb75002669dbb85831a3ac9e890e62af512531ca9d3b2c630c803d1fcfcc97eb5f75542dd3ceef7c21fe18de29390192ff2d3d2cff59ad058bdd5a83832d39986a939004c873ab5539aae292112506a0814edbf1c7349204a6112323f6cccefe52f3a0b4ae70e37346cd9f65ae420e1ff8ca9c57da5be31bb65b9bac2e88f23f0b9252ce1bb8c7b49015dd6e857b721f7f6df1237d7e3a52b773e20ee6793734a73cc4b965515d6cee5d2f38c38fa914cb1cc0a221d7eebff25021b9561dbc59f3131c068cac550b22f236ba36ae06ce6e87ff5befadb2281058af48c07cb78e54b999a4014f0aca21cb19065572651b7dc58a760d5e43043a512ea287d2f7dd2f0ffd2de59cdf696ab37857342fcdb0833de8274ca98550754fb88a7c7864a6f2dcbd7ba30ea99ddeaa65b2e83054eac2e8a978b4b48e87b7",
            'token_type'=> "Bearer"

        ]);
    }else{
        return response()->json(['error'=>'Unauthorized']);
    }
}
}
