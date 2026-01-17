<?php

namespace App\Domain\Group\Calculators;

use App\Domain\Group\AbstractGroupCalculator;

final class GroupB00Calculator extends AbstractGroupCalculator
{
    protected function subjects(): array
    {
        return ['toan', 'hoa_hoc', 'sinh_hoc'];
    }

    public function getName(): string
    {
        return 'B00';
    }
}
