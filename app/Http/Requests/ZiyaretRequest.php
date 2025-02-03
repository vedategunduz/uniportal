<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZiyaretRequest extends FormRequest
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
            'etkinlikBaslamaTarihi' => 'required|date',
            'etkinlikBitisTarihi'   => 'required|date|after_or_equal:etkinlikBaslamaTarihi',
            'baslik'                => 'required|string|max:255',
            'aciklama'              => 'nullable|string',
            'kullanicilar_id'       => 'required|array',
            'davet_kullanicilar_id' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'baslik.required' => 'Ziyaret başlığı zorunludur.',
            'baslik.string'   => 'Ziyaret başlığı geçerli bir metin olmalıdır.',
            'baslik.max'      => 'Ziyaret başlığı en fazla 255 karakter olabilir.',

              // Başlama tarihi
            'etkinlikBaslamaTarihi.required' => 'Ziyaret başlangıç tarihi zorunludur.',
            'etkinlikBaslamaTarihi.date'     => 'Ziyaret başlangıç tarihi geçerli bir tarih olmalıdır.',

            'etkinlikBitisTarihi.required'       => 'Ziyaret bitiş tarihi zorunludur.',
            'etkinlikBitisTarihi.date'           => 'Ziyaret bitiş tarihi geçerli bir tarih olmalıdır.',
            'etkinlikBitisTarihi.after_or_equal' => 'Ziyaret bitiş tarihi, etkinlik başlangıç tarihinden sonra veya ona eşit olmalıdır.',

            'aciklama.string' => 'Ziyaret açıklaması geçerli bir metin olmalıdır.',
        ];
    }
}
