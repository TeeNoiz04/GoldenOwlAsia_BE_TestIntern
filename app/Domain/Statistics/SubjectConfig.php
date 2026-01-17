<?php

namespace App\Domain\Statistics;

final class SubjectConfig
{
    /**
     * All available subjects with their display names.
     */
    public const ALL = [
        'toan'     => 'Math',
        'vat_li'   => 'Physics',
        'hoa_hoc'  => 'Chemistry',
        'sinh_hoc' => 'Biology',
        'lich_su'  => 'History',
        'dia_li'   => 'Geography',
        'gdcd'     => 'Civic Education',
        'ngu_van'  => 'Literature',
        'ngoai_ngu'=> 'Foreign Language',
    ];

    /**
     * Get all subject keys.
     *
     * @return array<int, string>
     */
    public static function getAllKeys(): array
    {
        return array_keys(self::ALL);
    }

    /**
     * Get display name for a subject.
     *
     * @param string $key
     * @return string
     */
    public static function getDisplayName(string $key): string
    {
        return self::ALL[$key] ?? $key;
    }

    /**
     * Check if a subject exists.
     *
     * @param string $key
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return array_key_exists($key, self::ALL);
    }
}
