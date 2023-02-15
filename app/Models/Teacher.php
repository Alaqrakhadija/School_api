<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

    ];

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function student()
    {
        return $this->belongsToMany(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
