<?php

namespace App\Domain\Statistics;

use App\Domain\Statistics\Contracts\GroupStatisticsCalculatorInterface;
use App\Models\SubjectStatistic;
use App\Models\Student;

abstract class AbstractGroupStatisticsCalculator implements GroupStatisticsCalculatorInterface
{
    /**
     * Get the subjects for this group.
     *
     * @return array<int, string>
     */
    abstract public function getSubjects(): array;

    /**
     * Get total students.
     *
     * @return int
     */
    public function getTotalStudent(): int
    {
        return Student::count();
    }

    /**
     * Calculate percentage of students who can register for this group.
     *
     * @return float
     */
    public function calculatePercent(): float
    {
        $totalStudents = $this->getTotalStudent();

        if ($totalStudents === 0) {
            return 0;
        }

        $arrayTotalSubject = SubjectStatistic::whereIn('subject', $this->getSubjects())
            ->selectRaw('subject, SUM(excellent + good + average) as total')
            ->groupBy('subject')
            ->get();

        if ($arrayTotalSubject->isEmpty()) {
            return 0;
        }

        $maxTotal = $arrayTotalSubject->max('total');

        return round(($maxTotal / $totalStudents) * 100, 2);
    }
}
