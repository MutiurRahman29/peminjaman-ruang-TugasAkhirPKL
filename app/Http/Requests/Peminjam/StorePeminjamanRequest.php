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
