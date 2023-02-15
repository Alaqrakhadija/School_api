<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $students = [];
        $i = 0;
        foreach ($this->student as $student) {
            $students[$i++] = new StudentTeacherResource($student->user);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'students' => $students,
            'material' => $this->material,

        ];
    }
}
