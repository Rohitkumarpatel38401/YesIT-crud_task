<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user ? $this->user->id:null;
        return [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email,'.$userId,
            'mobile'=> 'required|numeric|digits:10',
            'profile_pic'=> 'nullable|image|mimes:jpeg,png,jpg',
            'password' => $this->isMethod('post')? 'required|min:6':'nullable|min:6',
        ];
    }
}
