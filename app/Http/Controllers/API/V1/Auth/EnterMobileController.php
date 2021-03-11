<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Events\AttempLogin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MobileValidation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EnterMobileController extends Controller
{

    public function getMobile(Request $request )
    {
        $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
        $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
        $request->mobile = str_replace($eastern_arabic,$western_arabic,$request->mobile);
        $validated = $request->validate([
            'mobile' => ['required',new MobileValidation],
        ]);
        try{
            $user = User::firstOrCreate(   
                ['mobile' => $request->mobile],
            );

            event(new AttempLogin($user));

            return response([],201);


        }catch(Exception $e){
            return response(['errors'=> $e->getMessage()],500);
        }
    }
}
