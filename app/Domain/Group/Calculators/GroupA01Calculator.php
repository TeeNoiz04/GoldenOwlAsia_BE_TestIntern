<?php

namespace App\Domain\Group\Calculators;

use App\Domain\Group\AbstractGroupCalculator;

final class GroupA01Calculator extends AbstractGroupCalculator
{
    protected function subjects(): array
    {
        return ['toan', 'vat_li', 'ngoai_ngu'];
    }

    public function getName(): string
    {
        return 'A01';
    }
}
