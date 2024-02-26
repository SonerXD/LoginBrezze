<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use Session;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
            $secretKey = "6LddkF4pAAAAAIYS4TGMJhNNbQtwsKIAz_pmfdbN";
            $response = $value;
            $userIP = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIP";
            $response = \file_get_contents($url);
            $response = json_decode($response);
            if(!$response->success){
                Session::flash('g-recaptcha-response' , 'Marcar el racaptcha');
                Session::flash('alert-class' , 'alert-danger');
                $fail($attribute.' debe completarse');
        }
    }
}
