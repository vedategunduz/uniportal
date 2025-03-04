<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DosyaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dosya' => 'required|file|mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'dosya.required' => 'Dosya yüklemek zorunludur.',
            'dosya.file'     => 'Yüklenen dosya geçerli bir dosya olmalıdır.',
            'dosya.mimes'    => 'Yüklenen dosya sadece jpg, jpeg, png, webp, pdf, doc, docx, xls, xlsx formatında olabilir.',
            'dosya.max'      => 'Yüklenen dosya en fazla 4 MB olabilir.',
        ];
    }
}
