<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $primaryKey = 'course_id';
    public $timestamps = false; 
    
    protected $fillable = [
        'course_name'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'course_id', 'course_id');
    }
}
