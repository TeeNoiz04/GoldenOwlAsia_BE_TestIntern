<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Jobs\RecalculateSubjectStatistics;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $file = database_path('data/diem_thi_thpt_2024.csv');
        if (!file_exists($file) || !is_readable($file)) {
            $this->command->error('❌ CSV file not found or not readable: ' . $file);
            return;
        }

        $this->command->info('✅ Starting to seed students from CSV...');
        $header = null;
        $batchSize = 1000;
        $data = [];
        $totalRows = 0;

        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                    continue;
                }

                $data[] = array_map(function ($value) {
                    return $value === '' ? null : $value;
                }, array_combine($header, $row));

                $totalRows++;

                if (count($data) >= $batchSize) {
                    Student::insert($data);
                    $this->command->info("✅ Inserted {$batchSize} rows...");
                    $data = [];
                }
            }

            if ($data) {
                Student::insert($data);
            }

            fclose($handle);
        }

        $this->command->info("✅ Successfully seeded {$totalRows} students!");
        RecalculateSubjectStatistics::dispatch();
    }

}
