<?php

namespace App\Models;

use App\Rules\VerifyCodeValidation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($username)
    {
        // if(!$this->mobileValidation($username)){
        //     throw new OAuthServerException('فرمت تلفن همراه معتبر نیست',422,'wrong_format_mobile',400);
        // }

        return $this->where('mobile', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        // if(!isset($password) || !$this->passwordValidation($password) || $this->active_code !== $password){
        //     throw new OAuthServerException('کد اعتبار سنجی معتبر نیست',422,'wrong_confrim_code',400);
        // }
        return $this->active_code === $password;
    }

    private function passwordValidation($value)
    {
        $western_latin = array('0','1','2','3','4','5','6','7','8','9');
        $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
        $eastern_persian = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');

        $code = str_replace($eastern_persian,$western_latin,$value);
        $code = str_replace($eastern_arabic,$western_latin,$code);

        if(preg_match('/^([0-9]){4}$/',$code)){
            return true;
        }
        return false;
    }

    private function mobileValidation($value)
    {
        $western_latin = array('0','1','2','3','4','5','6','7','8','9');
        $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
        $eastern_persian = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');

        $mobile = str_replace($eastern_persian,$western_latin,$value);
        $mobile = str_replace($eastern_arabic,$western_latin,$mobile);



        if(!preg_match('/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/',$mobile)){
            return false;
        }
        return true;
    }


}
