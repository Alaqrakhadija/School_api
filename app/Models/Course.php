<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'material',
        'teacher',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
        return $this->belongsToMany(Student::class)
                        ->withPivot(['first_mark', 'mid_mark', 'final_mark']);
    }

    public function material()
    {
        return $this->hasMany(Material::class);
    }
}
