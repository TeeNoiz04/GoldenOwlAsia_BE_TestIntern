<?php

namespace App\Domain\Group\Calculators;

use App\Domain\Group\AbstractGroupCalculator;

final class GroupD07Calculator extends AbstractGroupCalculator
{
    protected function subjects(): array
    {
        return ['toan', 'hoa_hoc', 'ngoai_ngu'];
    }

    public function getName(): string
    {
        return 'D07';
    }
}
