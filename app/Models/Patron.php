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
}
