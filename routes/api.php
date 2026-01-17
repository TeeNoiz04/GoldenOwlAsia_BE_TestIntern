<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\StatisticController;
Route::get('/ping', function () {
    return response()->json(['message' => 'api ok']);
});

// Student Routes
Route::get('/students/top', [StudentController::class, 'topStudents']);
Route::get('/students/{registrationNumber}', [StudentController::class, 'show'])->whereNumber('registrationNumber');

// Statistic Routes
Route::get('/statistics/student-summary', [StatisticController::class, 'studentSummary']);
Route::get('/statistics/subject-statistics-bar', [StatisticController::class, 'subjectStatisticsBar']);
Route::get('/statistics/subject-statistics-line', [StatisticController::class, 'subjectStatisticsLine']);