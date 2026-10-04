<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $primaryKey = 'student_id';
    
    // Disable Laravel's automatic updated_at timestamp management
    const UPDATED_AT = null;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'year_level', 
        'course_id'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
