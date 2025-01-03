<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtkinlikRequest extends FormRequest
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
            'etkinlikTur'                => 'required',
            'etkinlikIsletme'            => 'required',
            'etkinlikIl'                 => 'required',
            'etkinlikKontenjan'          => 'required|integer|min:1',
            'etkinlikBasvuru'            => 'required|date',
            'etkinlikBasvuruBitis'       => 'required|date|after_or_equal:etkinlikBasvuru',
            'etkinlikBaslangic'          => 'required|date',
            'etkinlikBitis'              => 'required|date|after_or_equal:etkinlikBaslangic',
            'etkinlikBaslik'             => 'required|string|max:255',
            'etkinlikAciklama'           => 'required|string',

            'etkinlikSosyalMedyadaPaylas' => 'nullable',
            'etkinlikYorumDurumu'        => 'nullable',

            // Kapak resmi
            'etkinlikKapakResmi'         => 'nullable|file|mimes:jpg,jpeg,png,webp|max:4096',

            // Diğer resimler (array)
            'etkinlikDigerResimler'      => 'nullable|array',
            'etkinlikDigerResimler.*'    => 'file|mimes:jpg,jpeg,png,webp|max:4096',

            // Katılım sınırlama
            'katilimSinirlama'           => 'nullable|array',
            'katilimSinirlama.*'         => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'etkinlikTur.required' => 'Etkinlik türü zorunludur.',

            'etkinlikIsletme.required' => 'Etkinlik işletmesi zorunludur.',

            'etkinlikIl.required' => 'Etkinlik ili zorunludur.',

            'etkinlikKontenjan.required' => 'Etkinlik kontenjanı zorunludur.',
            'etkinlikKontenjan.integer' => 'Etkinlik kontenjanı bir sayı olmalıdır.',
            'etkinlikKontenjan.min' => 'Etkinlik kontenjanı en az 1 olmalıdır.',

            'etkinlikBasvuru.required' => 'Etkinlik başvuru tarihi zorunludur.',
            'etkinlikBasvuru.date' => 'Etkinlik başvuru tarihi geçerli bir tarih olmalıdır.',

            'etkinlikBasvuruBitis.required' => 'Etkinlik başvuru bitiş tarihi zorunludur.',
            'etkinlikBasvuruBitis.date' => 'Etkinlik başvuru bitiş tarihi geçerli bir tarih olmalıdır.',
            'etkinlikBasvuruBitis.after_or_equal' => 'Etkinlik başvuru bitiş tarihi, etkinlik başvuru tarihinden sonra veya ona eşit olmalıdır.',

            'etkinlikBaslangic.required' => 'Etkinlik başlangıç tarihi zorunludur.',
            'etkinlikBaslangic.date' => 'Etkinlik başlangıç tarihi geçerli bir tarih olmalıdır.',

            'etkinlikBitis.required' => 'Etkinlik bitiş tarihi zorunludur.',
            'etkinlikBitis.date' => 'Etkinlik bitiş tarihi geçerli bir tarih olmalıdır.',
            'etkinlikBitis.after_or_equal' => 'Etkinlik bitiş tarihi, etkinlik başlangıç tarihinden sonra veya ona eşit olmalıdır.',

            'etkinlikBaslik.required' => 'Etkinlik başlığı zorunludur.',
            'etkinlikBaslik.string' => 'Etkinlik başlığı geçerli bir metin olmalıdır.',
            'etkinlikBaslik.max' => 'Etkinlik başlığı en fazla 255 karakter olabilir.',

            'etkinlikAciklama.required' => 'Etkinlik açıklaması zorunludur.',
            'etkinlikAciklama.string' => 'Etkinlik açıklaması geçerli bir metin olmalıdır.',

            'etkinlikKapakResmi.file' => 'Etkinlik kapak resmi geçerli bir dosya olmalıdır.',
            'etkinlikKapakResmi.mimes' => 'Etkinlik kapak resmi jpg, jpeg, png veya webp formatında olmalıdır.',
            'etkinlikKapakResmi.max' => 'Etkinlik kapak resmi en fazla 4096 kilobyte olabilir.',

            'etkinlikDigerResimler.array' => 'Diğer resimler geçerli bir dizi olmalıdır.',
            'etkinlikDigerResimler.*.file' => 'Diğer resimler geçerli bir dosya olmalıdır.',
            'etkinlikDigerResimler.*.mimes' => 'Diğer resimler jpg, jpeg, png veya webp formatında olmalıdır.',
            'etkinlikDigerResimler.*.max' => 'Diğer resimler en fazla 4096 kilobyte olabilir.',

            'katilimSinirlama.array' => 'Katılım sınırlama geçerli bir dizi olmalıdır.',
            'katilimSinirlama.*.required' => 'Katılım sınırlama öğeleri zorunludur.',
        ];
    }
}
