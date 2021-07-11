<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PlanLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getMonthAttribute($value)
    {
        return Carbon::create()->month($value)->format('M');
    }
}
