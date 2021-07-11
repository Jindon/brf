<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];

    public function logs()
    {
        return $this->hasMany(PlanLog::class);
    }

    public function getLastGeneratedOnAttribute()
    {
        if($latest = $this->logs()->latest()->first()) {
            return $latest->created_at;
        }
        return null;
    }

    public function getFirstGeneratedOnAttribute()
    {
        if($latest = $this->logs()->oldest()->first()) {
            return $latest->created_at;
        }
        return null;
    }
}
