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

    public function payments()
    {
        return $this->hasMany(Payment::class);
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
