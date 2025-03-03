<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IletisimFormRequest extends FormRequest
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
            'ad'    => 'required|string|max:155',
            'email' => 'required|string|email|max:255',
            'konu'  => 'required|string|max:255',
            'mesaj' => 'required|string',
            'dosyalar' => 'nullable',
            'dosyalar.*' => 'file|mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'ad.required' => 'Ad alanı zorunludur.',
            'ad.string'   => 'Ad alanı geçerli bir metin olmalıdır.',
            'ad.max'      => 'Ad alanı en fazla 155 karakter olabilir.',

            'email.required' => 'E-posta alanı zorunludur.',
            'email.string'   => 'E-posta alanı geçerli bir metin olmalıdır.',
            'email.email'    => 'E-posta alanı geçerli bir e-posta adresi olmalıdır.',
            'email.max'      => 'E-posta alanı en fazla 255 karakter olabilir.',

            'konu.required' => 'Konu alanı zorunludur.',
            'konu.string'   => 'Konu alanı geçerli bir metin olmalıdır.',
            'konu.max'      => 'Konu alanı en fazla 255 karakter olabilir.',

            'mesaj.required' => 'Mesaj alanı zorunludur.',
            'mesaj.string'   => 'Mesaj alanı geçerli bir metin olmalıdır.',

            'dosyalar.*.mimes' => 'Dosya alanı sadece jpg, jpeg, png, webp, pdf, doc, docx, xls, xlsx dosya türlerini kabul eder.',
            'dosyalar.*.max'   => 'Dosya alanı en fazla 4096 KB olabilir.',
        ];
    }
}
