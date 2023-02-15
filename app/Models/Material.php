<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
        'course_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
