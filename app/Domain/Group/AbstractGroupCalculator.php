<?php

namespace App\Domain\Group;

use App\Domain\Group\Contracts\GroupCalculatorInterface;
use App\Models\Student;

abstract class AbstractGroupCalculator implements GroupCalculatorInterface
{
    /**
     * Get the subjects for this group.
     *
     * @return array
     */
    abstract protected function subjects(): array;

    /**
     * Get the group name.
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Calculate total score for this group.
     *
     * @param Student $student
     * @return float|null
     */
    public function calculate(Student $student): ?float
    {
        if (!$this->hasRequiredSubjects($student)) {
            return null;
        }

        $total = 0;
        foreach ($this->subjects() as $subject) {
            $total += $student->$subject ?? 0;
        }

        return (float) $total;
    }

    /**
     * Get the subjects required for this group.
     *
     * @return array
     */
    public function getRequiredSubjects(): array
    {
        return $this->subjects();
    }

    /**
     * Check if student has all required subjects.
     *
     * @param Student $student
     * @return bool
     */
    public function hasRequiredSubjects(Student $student): bool
    {
        foreach ($this->subjects() as $subject) {
            if ($student->$subject === null) {
                return false;
            }
        }

        return true;
    }
}
