<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'target_lecturer_id',
        'title',
        'type',
        'status',
        'file_path',
        'stamped_file_path',
        'signed_file_path',
        'current_step',
        'sla_deadline',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function targetLecturer()
    {
        return $this->belongsTo(User::class, 'target_lecturer_id');
    }

    public function logs()
    {
        return $this->hasMany(DocumentLog::class);
    }

    public function isOverdue()
    {
        if (in_array($this->status, ['signed', 'rejected'])) {
            return false;
        }

        // Check if last activity (or creation) is more than 2 days ago
        $lastActivity = $this->logs()->latest()->first()?->created_at ?? $this->created_at;
        return $lastActivity->diffInDays(now()) >= 2;
    }
}
