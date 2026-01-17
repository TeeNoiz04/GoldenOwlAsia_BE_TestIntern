<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Requests\CheckScoreRequest;
use App\Helpers\ApiResponse;
use App\Domain\Group\GroupCalculatorRegistry;

class StudentController extends Controller
{
    public function show(CheckScoreRequest $request)
    {
        $student = Student::where(
            'sbd',
            $request->registrationNumber
        )->first();

        if (!$student) {
            return ApiResponse::error('Student not found', 404);
        }

        $registry = new GroupCalculatorRegistry();
        
        // Calculate total score of all subjects
        $totalAllSubjects = ($student->toan ?? 0)
            + ($student->ngu_van ?? 0)
            + ($student->ngoai_ngu ?? 0)
            + ($student->vat_li ?? 0)
            + ($student->hoa_hoc ?? 0)
            + ($student->sinh_hoc ?? 0)
            + ($student->lich_su ?? 0)
            + ($student->dia_li ?? 0)
            + ($student->gdcd ?? 0);

        // Calculate score for each group
        $groupScores = [];
        foreach ($registry->all() as $groupName => $calculator) {
            $score = $calculator->calculate($student);
            if ($score !== null) {
                $groupScores[$groupName] = [
                    'group_name' => $groupName,
                    'total_score' => $score,
                ];
            }
        }

        return ApiResponse::success(
            [
                'registration_number' => $student->sbd,
                'subjects' => [
                    'toan' => $student->toan,
                    'ngu_van' => $student->ngu_van,
                    'ngoai_ngu' => $student->ngoai_ngu,
                    'vat_li' => $student->vat_li,
                    'hoa_hoc' => $student->hoa_hoc,
                    'sinh_hoc' => $student->sinh_hoc,
                    'lich_su' => $student->lich_su,
                    'dia_li' => $student->dia_li,
                    'gdcd' => $student->gdcd,
                ],
                'total_all_subjects' => $totalAllSubjects,
                'group_scores' => array_values($groupScores),
            ],
            'Student score fetched successfully'
        );
    }

    public function topStudents(Request $request)
    {
        $group = $request->query('group');
        if (!$group) {
            return response()->json([
                'message' => 'Group is required'
            ], 400);
        }

        $registry = new GroupCalculatorRegistry();
        $calculator = $registry->get($group);

        if (!$calculator) {
            return ApiResponse::error("Group $group calculator not found", 500);
        }

        $subjectsString = $registry->getSubjectsAsString($group);
        
        if (!$subjectsString) {
            return ApiResponse::error("No subjects found for group $group", 400);
        }

        $subjects = $registry->getSubjects($group);

        $students = Student::query()
            ->select(array_merge(['sbd'], $subjects))
            ->selectRaw("($subjectsString) as total_score")
            ->orderByDesc('total_score')
            ->limit(10)
            ->get()
            ->map(function ($student) use ($subjects) {
                $result = ['registration_number' => $student->sbd];
                
                // Add subjects in the group
                foreach ($subjects as $subject) {
                    $result[$subject] = $student->$subject;
                }
                
                $result['total_score'] = $student->total_score;
                
                return $result;
            });

    

        if ($students->isEmpty()) {
            return ApiResponse::error("No students found for Group $group", 404);
        }

        return ApiResponse::success(
            $students,
            "Top 10 students in Group $group fetched successfully"
        );
    }
}
