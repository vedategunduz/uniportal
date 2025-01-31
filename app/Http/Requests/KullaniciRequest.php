<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KullaniciRequest extends FormRequest
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
        return [
            'ad'                    => 'required|string|max:155',
            'soyad'                 => 'required|string|max:155',
            'email'                 => 'required|string|email|max:255|unique:kullanicilar',
            'password'              => 'required|string|min:8',
            'password_confirmation' => 'required|string|same:password',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'ad.required' => 'Ad alanı zorunludur.',
            'ad.string'   => 'Ad alanı geçerli bir metin olmalıdır.',
            'ad.max'      => 'Ad alanı en fazla 155 karakter olabilir.',

            'soyad.required' => 'Soyad alanı zorunludur.',
            'soyad.string'   => 'Soyad alanı geçerli bir metin olmalıdır.',
            'soyad.max'      => 'Soyad alanı en fazla 155 karakter olabilir.',

            'email.required' => 'E-posta adresi zorunludur.',
            'email.string'   => 'E-posta adresi geçerli bir metin olmalıdır.',
            'email.email'    => 'E-posta adresi geçerli bir e-posta adresi olmalıdır.',
            'email.max'      => 'E-posta adresi en fazla 255 karakter olabilir.',
            'email.unique'   => 'Bu e-posta adresi zaten kullanılmaktadır.',

            'password.required' => 'Şifre alanı zorunludur.',
            'password.string'   => 'Şifre alanı geçerli bir metin olmalıdır.',
            'password.min'      => 'Şifre alanı en az 8 karakter olmalıdır.',

            'password_confirmation.required' => 'Şifre tekrarı alanı zorunludur.',
            'password_confirmation.string'   => 'Şifre tekrarı alanı geçerli bir metin olmalıdır.',
            'password_confirmation.same'     => 'Şifre ve şifre tekrarı alanları eşleşmiyor.',
        ];
    }
}
