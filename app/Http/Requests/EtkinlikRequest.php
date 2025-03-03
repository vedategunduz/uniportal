<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EtkinlikRequest extends FormRequest
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
            'etkinlik_turleri_id'        => 'required',
            'isletmeler_id'              => 'required',
            'iller_id'                   => 'required',
            'kontenjan'                  => 'required|integer|min:1',
            'etkinlikBasvuruTarihi'      => 'required|date',
            'etkinlikBasvuruBitisTarihi' => 'required|date|after_or_equal:etkinlikBasvuruTarihi',
            'etkinlikBaslamaTarihi'      => 'required|date',
            'etkinlikBitisTarihi'        => 'required|date|after_or_equal:etkinlikBaslamaTarihi',
            'baslik'                     => 'required|string|max:255',
            'aciklama'                   => 'nullable|string',

            'sosyalMedyadaPaylas' => 'nullable',
            'yorumDurumu'         => 'nullable',

            // Kapak resmi
            'kapakResmiYolu' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:4096',

            // Diğer resimler (array)
            'resimYolu'   => 'nullable|array',
            'resimYolu.*' => 'file|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'isletmeler_id.required' => 'Etkinlik işletmesi zorunludur.',

            'baslik.required' => 'Etkinlik başlığı zorunludur.',
            'baslik.string'   => 'Etkinlik başlığı geçerli bir metin olmalıdır.',
            'baslik.max'      => 'Etkinlik başlığı en fazla 255 karakter olabilir.',

            'etkinlik_turleri_id.required' => 'Etkinlik türü zorunludur.',

            'iller_id.required' => 'Etkinlik ili zorunludur.',

            // Başlama tarihi
            'etkinlikBaslamaTarihi.required' => 'Etkinlik başlangıç tarihi zorunludur.',
            'etkinlikBaslamaTarihi.date'     => 'Etkinlik başlangıç tarihi geçerli bir tarih olmalıdır.',

            'etkinlikBitisTarihi.required'       => 'Etkinlik bitiş tarihi zorunludur.',
            'etkinlikBitisTarihi.date'           => 'Etkinlik bitiş tarihi geçerli bir tarih olmalıdır.',
            'etkinlikBitisTarihi.after_or_equal' => 'Etkinlik bitiş tarihi, etkinlik başlangıç tarihinden sonra veya ona eşit olmalıdır.',

            // Başvuru tarihi
            'etkinlikBasvuruTarihi.required' => 'Etkinlik başvuru tarihi zorunludur.',
            'etkinlikBasvuruTarihi.date'     => 'Etkinlik başvuru tarihi geçerli bir tarih olmalıdır.',

            'etkinlikBasvuruBitisTarihi.required'       => 'Etkinlik başvuru bitiş tarihi zorunludur.',
            'etkinlikBasvuruBitisTarihi.date'           => 'Etkinlik başvuru bitiş tarihi geçerli bir tarih olmalıdır.',
            'etkinlikBasvuruBitisTarihi.after_or_equal' => 'Etkinlik başvuru bitiş tarihi, etkinlik başvuru tarihinden sonra veya ona eşit olmalıdır.',

            'aciklama.string'   => 'Etkinlik açıklaması geçerli bir metin olmalıdır.',

            'kontenjan.min'      => 'Etkinlik kontenjanı en az 1 olmalıdır.',
            'kontenjan.required' => 'Etkinlik kontenjanı zorunludur.',
            'kontenjan.integer'  => 'Etkinlik kontenjanı bir sayı olmalıdır.',

            'kapakResmiYolu.file'  => 'Etkinlik kapak resmi geçerli bir dosya olmalıdır.',
            'kapakResmiYolu.mimes' => 'Etkinlik kapak resmi jpg, jpeg, png veya webp formatında olmalıdır.',
            'kapakResmiYolu.max'   => 'Etkinlik kapak resmi en fazla 4096 kilobyte olabilir.',

            'resimYolu.array'   => 'Diğer resimler geçerli bir dizi olmalıdır.',
            'resimYolu.*.file'  => 'Diğer resimler geçerli bir dosya olmalıdır.',
            'resimYolu.*.mimes' => 'Diğer resimler jpg, jpeg, png veya webp formatında olmalıdır.',
            'resimYolu.*.max'   => 'Diğer resimler en fazla 4096 kilobyte olabilir.',
        ];
    }
}
