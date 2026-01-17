<?php

namespace App\Domain\Statistics;

final class SocialGroupStatisticsCalculator extends AbstractGroupStatisticsCalculator
{
    public function getSubjects(): array
    {
        return ['lich_su', 'dia_li', 'gdcd'];
    }
}
