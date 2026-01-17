<?php

namespace App\Domain\Group\Calculators;

use App\Domain\Group\AbstractGroupCalculator;

final class GroupD01Calculator extends AbstractGroupCalculator
{
    protected function subjects(): array
    {
        return ['toan', 'ngu_van', 'ngoai_ngu'];
    }

    public function getName(): string
    {
        return 'D01';
    }
}
