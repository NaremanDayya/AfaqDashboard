<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description'];

    public function dailyLogs()
    {
        return $this->hasMany(DailyLog::class);
    }
}
