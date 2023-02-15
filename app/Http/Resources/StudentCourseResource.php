<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'teacher' => new StudentTeacherResource($this->teacher->user),
            'first_mark' => $this->pivot->first_mark,
            'mid_mark' => $this->pivot->mid_mark,
            'final_mark' => $this->pivot->final_mark,

        ];
    }
}
