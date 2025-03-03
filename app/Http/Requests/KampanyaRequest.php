<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KampanyaRequest extends FormRequest
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
            'etkinlik_turleri_id'   => 'required',
            'isletmeler_id'         => 'required',
            'etkinlikBaslamaTarihi' => 'required|date',
            'etkinlikBitisTarihi'   => 'required|date|after_or_equal:etkinlikBaslamaTarihi',
            'baslik'                => 'required|string|max:255',
            'aciklama'              => 'nullable|string',
            'sosyalMedyadaPaylas'   => 'nullable',
            'yorumDurumu'           => 'nullable',
            'dosyalar'              => 'nullable',
            'dosyalar.*'            => 'file|mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'isletmeler_id.required' => 'Kampanya işletmesi zorunludur.',
            'baslik.required'        => 'Kampanya başlığı zorunludur.',
            'baslik.string'          => 'Kampanya başlığı geçerli bir metin olmalıdır.',

            'etkinlik_turleri_id.required'       => 'Kampanya türü zorunludur.',
            'etkinlikBaslamaTarihi.required'     => 'Kampanya başlama tarihi zorunludur.',

            'etkinlikBitisTarihi.required'       => 'Kampanya bitiş tarihi zorunludur.',
            'etkinlikBitisTarihi.after_or_equal' => 'Kampanya bitiş tarihi, başlama tarihinden ileri bir tarih olmalıdır.',

            'baslik.max'                         => 'Kampanya başlığı en fazla 255 karakter olabilir.',

            'aciklama.string'                    => 'Kampanya açıklaması geçerli bir metin olmalıdır.',

            'dosyalar.*.mimes'                   => 'Dosya alanı sadece jpg, jpeg, png, webp, pdf, doc, docx, xls, xlsx dosya türlerini kabul eder.',
            'dosyalar.*.max'                     => 'Dosya alanı en fazla 4096 KB olabilir.',
        ];
    }
}
