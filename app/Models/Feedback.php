<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_code',
        'category',
        'subject',
        'message',
        'file_path',
        'assigned_department_id',
        'status',
        'anonymous'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'assigned_department_id');
    }

    public function comments()
    {
        return $this->hasMany(FeedbackComment::class);
    }
}
