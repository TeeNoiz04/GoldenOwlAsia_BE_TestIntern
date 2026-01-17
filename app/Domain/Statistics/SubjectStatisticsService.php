<?php

namespace App\Domain\Statistics;

use App\Models\SubjectStatistic;

class SubjectStatisticsService
{
    protected SubjectStatisticsCalculator $calculator;

    public function __construct(SubjectStatisticsCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Recalculate and store statistics for a subject.
     *
     * @param  string  $subject
     * @return void
     */
    public function update(string $subject): void
    {
        $data = $this->calculator->calculate($subject);

        SubjectStatistic::updateOrCreate(
            ['subject' => $subject],
            $data
        );
    }

    /**
     * Recalculate statistics for multiple subjects.
     *
     * @param  array<int, string>  $subjects
     * @return void
     */
    public function updateMany(array $subjects): void
    {
        foreach ($subjects as $subject) {
            $this->update($subject);
        }
    }
}
