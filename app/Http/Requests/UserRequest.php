<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        $password = [];
        $user_id = null;
        if($this->method() == 'PUT'){

            if(!empty($this->request->get('password'))){
                $password = [
                    'password' => $this->passwordRules(),
                ];
            }
            $user_id = (int)$this->request->get('id');

        }else{
            $password = [
                'password' => $this->passwordRules(),
            ];
        }

        return [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user_id)],
            'role_id' => ['nullable', 'numeric'],
            'status' => ['required', 'numeric'],
            'company_id' => ['nullable', 'numeric'],
            'type' => ['required', 'string']
        ]+$password;
    }
}
