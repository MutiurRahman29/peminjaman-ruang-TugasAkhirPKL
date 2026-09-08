<?php

namespace App\Http\Requests\Peminjam;

use App\Enums\StatusRuangan;
use App\Services\RoomAvailabilityService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePeminjamanRequest extends FormRequest
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
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'id_ruangan' => [
                'required',
                'integer',
                Rule::exists('ruangan', 'id_ruangan')->where(
                    fn ($query) => $query->where('status', StatusRuangan::Tersedia->value),
                ),
            ],
            'tanggal' => ['required', 'date', 'after_or_equal:'.now(config('app.timezone'))->toDateString()],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'keperluan' => ['required', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom validation messages for errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'id_ruangan.required' => 'Ruangan wajib dipilih.',
            'id_ruangan.integer' => 'Ruangan yang dipilih tidak valid atau tidak tersedia.',
            'id_ruangan.exists' => 'Ruangan yang dipilih tidak valid atau tidak tersedia.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.',
            'tanggal.after_or_equal' => 'Tanggal harus hari ini atau setelahnya.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'keperluan.required' => 'Keperluan wajib diisi.',
            'keperluan.string' => 'Keperluan harus berupa teks.',
            'keperluan.max' => 'Keperluan maksimal 1000 karakter.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'id_ruangan' => 'ruangan',
            'tanggal' => 'tanggal',
            'jam_mulai' => 'jam mulai',
            'jam_selesai' => 'jam selesai',
            'keperluan' => 'keperluan',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $hasConflict = app(RoomAvailabilityService::class)->hasConflict(
                (int) $this->input('id_ruangan'),
                (string) $this->input('tanggal'),
                (string) $this->input('jam_mulai'),
                (string) $this->input('jam_selesai'),
            );

            if ($hasConflict) {
                $validator->errors()->add(
                    'id_ruangan',
                    'Ruangan sudah digunakan pada jadwal yang dipilih.',
                );
            }
        });
    }
}
