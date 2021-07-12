<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];
    protected $casts = [
        'issued_on' => 'date'
    ];

    public function payments()
    {
        return $this->hasMany(LoanPayment::class);
    }

    public function patron()
    {
        return $this->belongsTo(Patron::class);
    }

    public function getInterestAmountAttribute()
    {
        return round($this->amount * ($this->interest / 100), 2);
    }

    public function getDueAttribute()
    {
        return $this->payments()->where('due', '>',0)->sum('due');
    }

    public function getCurrentTermAttribute()
    {
        $term = now()->diffInMonths($this->issued_on) + 1;
        if ($term > config('app.default_loan_term')) {
            if($this->getDueAttribute()) {
                return $term;
            } else {
                return config('app.default_loan_term');
            }
        }
        return $term;
    }
}
