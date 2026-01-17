<?php

namespace App\Domain\Score;

final class ScoreClassifier
{
    public const LEVEL_EXCELLENT = '>=8';
    public const LEVEL_GOOD      = '6-8';
    public const LEVEL_AVERAGE   = '4-6';
    public const LEVEL_WEAK      = '<4';

    public static function classify(?float $score): ?string
    {
        if ($score === null) {
            return null;
        }

        return match (true) {
            $score >= 8 => self::LEVEL_EXCELLENT,
            $score >= 6 => self::LEVEL_GOOD,
            $score >= 4 => self::LEVEL_AVERAGE,
            default     => self::LEVEL_WEAK,
        };
    }
}
