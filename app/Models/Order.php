<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concession;
use App\Models\OrderConcession;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'send_to_kitchen_time',
        'status',
    ];


    public function concessions()
    {
        return $this->belongsToMany(Concession::class, 'order_concession');
    }
    

}


