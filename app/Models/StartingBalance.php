<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartingBalance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function patron()
    {
        return $this->belongsTo(Patron::class);
    }
}
