<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MobileValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
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

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'فرمت تلفن همراه معتبر نیست';
    }
}
