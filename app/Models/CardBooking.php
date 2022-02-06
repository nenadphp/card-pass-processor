<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'object_id',
        'card_id',
        'created_at'
    ];

    public $timestamps = '';
}
