<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

    ];

    public function course()
    {
        return $this->belongsToMany(Course::class)
                        ->withPivot(['first_mark', 'mid_mark', 'final_mark']);
    }

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
