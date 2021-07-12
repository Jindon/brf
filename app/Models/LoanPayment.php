<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LoanPayment extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];
    protected $casts = [
        'due_date' => 'date'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function patron()
    {
        return $this->belongsTo(Patron::class);
    }

    public function getMonthAttribute($value)
    {
        return Carbon::create()->month($value)->format('M');
    }
}
