<?php

namespace App\Domain\Group\Calculators;

use App\Domain\Group\AbstractGroupCalculator;

final class GroupA00Calculator extends AbstractGroupCalculator
{
    protected function subjects(): array
    {
        return ['toan', 'vat_li', 'hoa_hoc'];
    }

    public function getName(): string
    {
        return 'A00';
    }
}
