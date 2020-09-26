<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "firstName" => ["required", "regex:/^[A-ZŠĐŽČĆ][a-zšđžčć]{2,13}(\s[A-ZŠĐŽČĆ][a-zšđžčć]{2,13})*$/"],
            "lastName" => ["required", "regex:/^[A-ZŠĐŽČĆ][a-žćčžš]{2,13}(\s[A-ZŠĐŽČĆ][a-žćčžš]{2,13})*$/"],
            "username" => ["required", "regex:/(?=.*[a-z])(?=.*[0-9])(?=.{8,})/"],
            "password" => ["required", "regex:/(?=.*[a-z])(?=.*[0-9])(?=.{8,})/"],
            "email" => "required|email"
        ];
    }
    public function messages(){
        return [
            "firstName.required" => "Ime je obavezno polje.",
            "lastName.required" => "Prezime je obavezno polje.",
            "username.required" => "Korisničko ime je obavezno polje.",
            "password.required" => "Lozinka je obavezno polje.",
            "email.required" => "Email je obavezno polje.",
            "email.email" => "Email nije u ispravnom formatu."
        ];
    }
}
