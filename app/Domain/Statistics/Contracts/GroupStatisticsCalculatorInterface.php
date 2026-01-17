<?php

namespace App\Domain\Statistics\Contracts;

interface GroupStatisticsCalculatorInterface
{
    /**
     * Get total students.
     *
     * @return int
     */
    public function getTotalStudent(): int;

    /**
     * Calculate percentage of students who can register for this group.
     *
     * @return float
     */
    public function calculatePercent(): float;

    /**
     * Get the subjects for this group.
     *
     * @return array<int, string>
     */
    public function getSubjects(): array;
}
