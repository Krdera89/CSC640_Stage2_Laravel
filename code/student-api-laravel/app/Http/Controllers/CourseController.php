<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // GET /api/courses
    public function index()
    {
        return response()->json(Course::orderBy('id')->get());
    }

    // GET /api/courses/{id}
    public function show(int $id)
    {
        $course = Course::find($id);

        if (! $course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        return response()->json($course);
    }

    // POST /api/courses
    public function store(Request $request)
    {
        $data = $request->validate([
            'code'  => 'required|string|max:50|unique:courses,code',
            'title' => 'required|string|max:255',
        ]);

        $course = Course::create($data);

        return response()->json($course, 201);
    }

    // PUT /api/courses/{id}
    public function update(Request $request, int $id)
    {
        $course = Course::find($id);

        if (! $course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        $data = $request->validate([
            'code'  => 'sometimes|required|string|max:50|unique:courses,code,' . $course->id,
            'title' => 'sometimes|required|string|max:255',
        ]);

        $course->update($data);

        return response()->json($course);
    }

    // DELETE /api/courses/{id}
    public function destroy(int $id)
    {
        $course = Course::find($id);

        if (! $course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        $course->delete();

        return response()->json(['deleted' => true]);
    }
}
