<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // GET /api/enrollments
    public function index()
    {
        // include student & course info like a join
        return response()->json(
            Enrollment::with(['student', 'course'])->orderBy('id')->get()
        );
    }

    // POST /api/enrollments
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_id'  => 'required|integer|exists:courses,id',
        ]);

        // Optional: enforce uniqueness like old DB logic
        $exists = Enrollment::where('student_id', $data['student_id'])
            ->where('course_id', $data['course_id'])
            ->exists();

        if ($exists) {
            return response()->json(
                ['error' => 'Enrollment already exists'],
                422
            );
        }

        $enrollment = Enrollment::create($data);

        return response()->json(
            $enrollment->load(['student', 'course']),
            201
        );
    }

    // DELETE /api/enrollments/{id}
    public function destroy(int $id)
    {
        $enrollment = Enrollment::find($id);

        if (! $enrollment) {
            return response()->json(['error' => 'Enrollment not found'], 404);
        }

        $enrollment->delete();

        return response()->json(['deleted' => true]);
    }
}
