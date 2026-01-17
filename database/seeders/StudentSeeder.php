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
            $this->command->info('CSV file not found or not readable.');
            return;
        }

        $header = null;
        $batchSize = 1000;
        $data = [];

        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                    continue;
                }

                $data[] = array_map(function ($value) {
                    return $value === '' ? null : $value;
                }, array_combine($header, $row));


                if (count($data) >= $batchSize) {
                    Student::insert($data);
                    $data = [];
                }
            }

            if ($data) {
                Student::insert($data);
            }

            fclose($handle);
        }

        $this->command->info('Students CSV imported successfully!');
        RecalculateSubjectStatistics::dispatch();
    }

}
