<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VerifyCodeValidation implements Rule
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
        
        $code = str_replace($eastern_persian,$western_latin,$value);
        $code = str_replace($eastern_arabic,$western_latin,$code);

        if(preg_match('/^([0-9]){4}$/',$code)){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کد اعتبار سنجی معتبر نیست';
    }
}
