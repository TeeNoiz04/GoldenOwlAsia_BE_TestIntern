<?php

namespace App\Domain\Statistics;

use Illuminate\Support\Facades\DB;

class SubjectStatisticsCalculator
{
    /**
     * Calculate statistics for one subject.
     *
     * @param  string  $subject  Column name in students table (e.g. toan, vat_ly)
     * @return array<string, int>
     */
    public function calculate(string $subject): array
    {
        // IMPORTANT:
        // $subject must be a valid column name (controlled internally)
        $row = DB::table('students')
            ->selectRaw("
                SUM(CASE WHEN {$subject} >= 8 THEN 1 ELSE 0 END) AS excellent,
                SUM(CASE WHEN {$subject} < 8 AND {$subject} >= 6 THEN 1 ELSE 0 END) AS good,
                SUM(CASE WHEN {$subject} < 6 AND {$subject} >= 4 THEN 1 ELSE 0 END) AS average,
                SUM(CASE WHEN {$subject} < 4 THEN 1 ELSE 0 END) AS poor
            ")
            ->first();

        return [
            'excellent' => (int) ($row->excellent ?? 0),
            'good'      => (int) ($row->good ?? 0),
            'average'   => (int) ($row->average ?? 0),
            'poor'      => (int) ($row->poor ?? 0),
        ];
    }
}
