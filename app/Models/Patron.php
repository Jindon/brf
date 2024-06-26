<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];

    protected $casts = [
        'joined_on' => 'date'
    ];

    public function startingBalance()
    {
        return $this->hasOne(StartingBalance::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function duePayments()
    {
        return $this->payments()->where('due', '>', 0);
    }

    public function loanPayments()
    {
        return $this->hasMany(LoanPayment::class);
    }

    public function dueLoanPayments($dueDate = null)
    {
        return $this->loanPayments()
            ->when($dueDate, function($query, $dueDate) {
                $query->whereDate('due_date', '<=', $dueDate);
            })
            ->where('due', '>', 0);
    }

    public function getLoanPaidTotalAttribute()
    {
        return (float) $this->loanPayments()->where('due', 0)->sum('paid');
    }

    public function getLoanInterestPaidTotalAttribute()
    {
        return (float) $this->loanPayments()->where('due', 0)->sum('interest');
    }

    public function getLoanFinePaidTotalAttribute()
    {
        return (float) $this->loanPayments()->where('due', 0)->sum('fine');
    }

    public function getLoanTotalAttribute()
    {
        return (float) $this->loans()->sum('amount');
    }

    public function getMonthPayment($month, $year)
    {
        return $this->payments()
            ->where('month', $month)
            ->where('year', $year)
            ->first();
    }

    public function monthPaymentExists($month, $year)
    {
        return $this->payments()
            ->where('month', $month)
            ->where('year', $year)
            ->count();
    }
}
