<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $id = $this->id;
        if ($this->role == 'student') {
            $id = $this->student->id;
        } elseif ($this->role == 'teacher') {
            $id = $this->teacher->id;
        }

        return [
            'id' => $id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'role' => $this->role,
            'phoneNumber' => $this->phoneNumber,

        ];
    }
}
