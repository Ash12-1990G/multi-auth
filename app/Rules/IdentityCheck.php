<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IdentityCheck implements Rule
{
    private $referredField = null;
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct(string $referredField)
    {
        $this->referredField = $referredField;
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
        if(request()->input($this->referredField)!=''){
            switch(request()->input($this->referredField)){
                
                case 'aadhar' : return preg_match('/^\d{4}\s\d{4}\s\d{4}$/',$value);break;
                                
                case 'pan' : return preg_match('/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/',$value);break;
                                
                case 'voter' : return preg_match('/^([a-zA-Z]){3}([0-9]){7}?$/',$value);break;
                                
                case 'drive' : return preg_match('/^(([A-Z]{2}[0-9]{2})( )|([A-Z]{2}-[0-9]{2}))((19|20)[0-9][0-9])[0-9]{7}$/',$value);break;
                            
                case 'passport' : return preg_match('/^(?!^0+$)[a-zA-Z0-9]{6,9}$/',$value);break;
                                
            }
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
        switch(request()->input($this->referredField)){
            case 'aadhar' : return 'The :attribute has invalid aadhar card number';break;
                            
            case 'pan' : return 'The :attribute has invalid pancard number';break;
                            
            case 'voter' : return 'The :attribute has invalid voter card number';break;
                            
            case 'drive' : return 'The :attribute has invalid driving license number';break;
                           
            case 'passport' : return 'The :attribute has invalid passport number';break;
                            


        }
        
    }
}
