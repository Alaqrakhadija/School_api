<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentCourseResource;
use App\Http\Resources\StudentTeacherResource;
use App\Models\Course;
use App\Models\Material;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        if (! $courses->isEmpty()) {
            $i = 0;
            foreach ($courses as $course) {
                $courses[$i++] = new CourseResource($course);
            }
        }

        return $courses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $course = Course::create([
            'name' => $request->input('name'),

        ]);

        return new CourseResource($course);
    }

    public function addStudent(Request $request, Course $course)
    {
        $student = Student::find($request->input('student_id'));
        if (! is_null($course) && ! is_null($student)) {
            $course->student()->sync($student, false);

            $course->save();

            $course->push();

            $i = 0;
            $st = [];
            foreach ($course->student as $student) {
                $st[$i++] = new StudentTeacherResource($student->user);
            }

            return $st;
        }

        return response()->json([
            'warning' => 'course or student not found',
        ]);
    }

    public function updateMark(Request $request, Course $course, Student $student)
    {
        if (! is_null($course) && ! is_null($student)) {
            $student = $course->student()->find($student->id);
            if (! is_null($student)) {
                if ($request->has('first_mark')) {
                    $course->student()
                        ->updateExistingPivot(
                            $student->id,
                            ['first_mark' => $request->input('first_mark')]
                        );
                } elseif ($request->has('mid_mark')) {
                    $course->student()
                        ->updateExistingPivot(
                            $student->id,
                            ['mid_mark' => $request->input('mid_mark')]
                        );
                } else {
                    $course->student()
                        ->updateExistingPivot(
                            $student->id,
                            ['final_mark' => $request->input('final_mark')]
                        );
                }

                $course->save();

                $course->push();

                return new StudentCourseResource($student->course()->find($course->id));
            }

            return [
                'warning' => 'student did not attend this class',
            ];
        }

        return response()->json([
            'warning' => 'course or student not found',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return new CourseResource($course);
    }

    public function addTeacher(Request $request, Course $course)
    {
        $teacher = Teacher::find($request->input('teacher_id'));
        if (! is_null($course) && ! is_null($teacher)) {
            $course->teacher()->associate($teacher);
            $course->save();

            return new CourseResource($course);
        }

        return response()->json([
            'warning' => 'course or teacher not found',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMaterialRequest $request, $course)
    {
        $path = '';
        if ($courseO = Course::find($course)) {
            $path = $request->file('file')->store(
                '/'.$course,
                ['disk' => 'materials']
            );
            $material = Material::create([
                'name' => $request->input('name'),
                'file_path' => $path,
                'course_id' => $course,

            ]);
            $material->course()->associate($courseO);

            return $path;
        }

        return $path;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
