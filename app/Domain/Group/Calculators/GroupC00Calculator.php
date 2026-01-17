<?php

namespace App\Domain\Group\Calculators;

use App\Domain\Group\AbstractGroupCalculator;

final class GroupC00Calculator extends AbstractGroupCalculator
{
    protected function subjects(): array
    {
        return ['ngu_van', 'lich_su', 'dia_li'];
    }

    public function getName(): string
    {
        return 'C00';
    }
}
