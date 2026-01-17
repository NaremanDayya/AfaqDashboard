<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['daily_log_id', 'admin_id', 'comment'];

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
