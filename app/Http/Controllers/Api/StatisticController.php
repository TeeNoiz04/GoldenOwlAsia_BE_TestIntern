<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Domain\Statistics\ScienceGroupStatisticsCalculator;
use App\Domain\Statistics\SocialGroupStatisticsCalculator;
use Illuminate\Http\Request;
use App\Models\SubjectStatistic;
use App\Domain\Statistics\SubjectConfig;
use App\Helpers\ApiResponse;

class StatisticController extends Controller
{
    public function studentSummary()
    {
        $totalStudents = Student::count();

        $scienceCalculator = new ScienceGroupStatisticsCalculator();
        $socialCalculator  = new SocialGroupStatisticsCalculator();

        $percentScience = $scienceCalculator->calculatePercent();
        $percentSocial  = $socialCalculator->calculatePercent();

        return ApiResponse::success(
            [
                'total_students' => $totalStudents,
                'science_group' => [
                    'percent_no_subject_below_4' => $percentScience
                ],
                'social_group' => [
                    'percent_no_subject_below_4' => $percentSocial
                ]
            ],
            'Student summary statistics fetched successfully'
        );
    }
    public function subjectStatisticsBar(Request $request)
    {
        $query = SubjectStatistic::query();

        if ($request->has('subject')) {
            $query->where('subject', $request->subject);
        }

        $stats = $query->get()->map(function ($stat) {
            return [
                'subject' => SubjectConfig::getDisplayName($stat->subject),
                'excellent' => $stat->excellent,
                'good' => $stat->good,
                'average' => $stat->average,
                'poor' => $stat->poor,
            ];
        });

        return ApiResponse::success(
            $stats,
            'Subject statistics fetched successfully'
        );
    }
    public function subjectStatisticsLine()
    {
        // 1. Get subject order from config
        $subjects = SubjectConfig::getAllKeys();

        // 2. Query statistics in correct subject order
        $stats = SubjectStatistic::whereIn('subject', $subjects)
            ->orderByRaw(
                "FIELD(subject, '" . implode("','", $subjects) . "')"
            )
            ->get();

        // 3. Return data for chart
        return ApiResponse::success(
            [
                'labels' => $stats->pluck('subject')
                    ->map(fn($s) => SubjectConfig::getDisplayName($s))
                    ->values(),

                'datasets' => [
                    [
                        'label' => 'Excellent',
                        'data' => $stats->pluck('excellent')->values(),
                    ],
                    [
                        'label' => 'Good',
                        'data' => $stats->pluck('good')->values(),
                    ],
                    [
                        'label' => 'Average',
                        'data' => $stats->pluck('average')->values(),
                    ],
                    [
                        'label' => 'Poor',
                        'data' => $stats->pluck('poor')->values(),
                    ],
                ],
            ],
            'Subject statistics line chart data fetched successfully'
        );
    }
}
