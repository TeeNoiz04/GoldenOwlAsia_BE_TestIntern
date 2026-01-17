<?php

namespace App\Domain\Group\Contracts;

use App\Models\Student;

interface GroupCalculatorInterface
{
    /**
     * Calculate total score for this group.
     *
     * @param Student $student
     * @return float|null
     */
    public function calculate(Student $student): ?float;

    /**
     * Get the group name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the subjects required for this group.
     *
     * @return array
     */
    public function getRequiredSubjects(): array;

    /**
     * Check if student has all required subjects.
     *
     * @param Student $student
     * @return bool
     */
    public function hasRequiredSubjects(Student $student): bool;
}
