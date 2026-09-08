<?php

namespace App\Http\Requests\Admin;

use App\Enums\StatusPeminjaman;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class FilterPeminjamanRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
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
            'status' => ['nullable', new Enum(StatusPeminjaman::class)],
            'id_ruangan' => ['nullable', 'integer', Rule::exists('ruangan', 'id_ruangan')],
            'id_user' => ['nullable', 'integer', Rule::exists('users', 'id_user')],
            'tanggal_mulai' => ['nullable', 'date_format:Y-m-d'],
            'tanggal_selesai' => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    /**
     * Configure validation for the inclusive date range.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $tanggalMulai = $this->input('tanggal_mulai');
            $tanggalSelesai = $this->input('tanggal_selesai');

            if (! is_string($tanggalMulai)
                || ! is_string($tanggalSelesai)
                || $validator->errors()->has('tanggal_mulai')
                || $validator->errors()->has('tanggal_selesai')
                || $tanggalSelesai >= $tanggalMulai) {
                return;
            }

            $validator->errors()->add('tanggal_selesai', 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
        });
    }

    /**
     * Get the validated filters without empty values.
     *
     * @return array<string, mixed>
     */
    public function filters(): array
    {
        return array_filter(
            $this->validated(),
            fn (mixed $value): bool => $value !== null && $value !== '',
        );
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'status.enum' => 'Status peminjaman tidak valid.',
            'id_ruangan.integer' => 'Ruangan tidak valid.',
            'id_ruangan.exists' => 'Ruangan tidak ditemukan.',
            'id_user.integer' => 'Peminjam tidak valid.',
            'id_user.exists' => 'Peminjam tidak ditemukan.',
            'tanggal_mulai.date_format' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'tanggal_selesai.date_format' => 'Tanggal selesai harus berupa tanggal yang valid.',
        ];
    }
}
