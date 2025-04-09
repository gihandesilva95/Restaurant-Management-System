<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderConcession extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'concession_id',
    ];

}
