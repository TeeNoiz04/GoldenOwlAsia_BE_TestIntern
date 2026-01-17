<?php

namespace App\Domain\Statistics;

final class ScienceGroupStatisticsCalculator extends AbstractGroupStatisticsCalculator
{
    public function getSubjects(): array
    {
        return ['vat_li', 'hoa_hoc', 'sinh_hoc'];
    }
}
