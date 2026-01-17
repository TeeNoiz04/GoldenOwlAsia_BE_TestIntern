<?php

namespace App\Domain\Group;

use App\Domain\Group\Contracts\GroupCalculatorInterface;
use App\Domain\Group\Calculators\GroupA00Calculator;
use App\Domain\Group\Calculators\GroupA01Calculator;
use App\Domain\Group\Calculators\GroupB00Calculator;
use App\Domain\Group\Calculators\GroupC00Calculator;
use App\Domain\Group\Calculators\GroupD01Calculator;
use App\Domain\Group\Calculators\GroupD07Calculator;

class GroupCalculatorRegistry
{
    /**
     * @var array<string, GroupCalculatorInterface>
     */
    private array $calculators = [];

    public function __construct()
    {
        $this->register();
    }

    /**
     * Register all group calculators.
     *
     * @return void
     */
    private function register(): void
    {
        $this->calculators = [
            'A00' => new GroupA00Calculator(),
            'A01' => new GroupA01Calculator(),
            'B00' => new GroupB00Calculator(),
            'C00' => new GroupC00Calculator(),
            'D01' => new GroupD01Calculator(),
            'D07' => new GroupD07Calculator(),
        ];
    }

    /**
     * Get calculator by group name.
     *
     * @param string $groupName
     * @return GroupCalculatorInterface|null
     */
    public function get(string $groupName): ?GroupCalculatorInterface
    {
        return $this->calculators[$groupName] ?? null;
    }

    /**
     * Get all calculators.
     *
     * @return array<string, GroupCalculatorInterface>
     */
    public function all(): array
    {
        return $this->calculators;
    }

    /**
     * Get all group names.
     *
     * @return array<int, string>
     */
    public function getGroupNames(): array
    {
        return array_keys($this->calculators);
    }

    /**
     * Get subjects for a specific group.
     *
     * @param string $groupName
     * @return array|null
     */
    public function getSubjects(string $groupName): ?array
    {
        $calculator = $this->get($groupName);
        return $calculator?->getRequiredSubjects();
    }

    /**
     * Get subjects as SQL string (e.g., 'toan + vat_li + hoa_hoc').
     *
     * @param string $groupName
     * @return string|null
     */
    public function getSubjectsAsString(string $groupName): ?string
    {
        $subjects = $this->getSubjects($groupName);
        return $subjects ? implode(' + ', $subjects) : null;
    }
}
