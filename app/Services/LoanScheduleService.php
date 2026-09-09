<?php

namespace App\Services;

use Carbon\CarbonImmutable;

class LoanScheduleService
{
    /**
     * Determine whether a schedule has started or already passed.
     */
    public function hasStarted(string $tanggal, string $jamMulai): bool
    {
        $timezone = config('app.timezone');
        $jadwalMulai = CarbonImmutable::parse("{$tanggal} {$jamMulai}", $timezone);

        return $jadwalMulai->lessThanOrEqualTo(CarbonImmutable::now($timezone));
    }
}
